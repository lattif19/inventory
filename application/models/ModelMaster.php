<?php
/**
* 
*/
class ModelMaster extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->dbMaster = $this->load->database('default', TRUE);
        $this->dbTrx 	= $this->load->database('trx', TRUE);
        $this->dbMaximo = $this->load->database('maximo', TRUE);
    }

    function getDatatableBarcode(){

        //We Need Column Index for Ordering
        $columns = array(
                0 =>'ITEMNUM', 
                1 => 'DESCRIPTION'
        );

        $totalData  = $this->dbMaximo->count_all('VIEWITEM');
        $totalFiltered =  $totalData; 

        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->dbMaximo->start_cache();
        $this->dbMaximo->select($columns);
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value'];

                $this->dbMaximo->like('ITEMNUM', $search_value);
                $this->dbMaximo->or_like('DESCRIPTION', $search_value);
                $this->dbMaximo->stop_cache();

                $totalFiltered  = $this->dbMaximo->get('VIEWITEM')->num_rows();
        }

        $this->dbMaximo->stop_cache();
        
        $this->dbMaximo->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
        $this->dbMaximo->limit($_REQUEST['length'], $_REQUEST['start']);

        $query = $this->dbMaximo->get('VIEWITEM');

        // $barcodeOptions = $this->dbMaximo->query("select * from VIEWITEM where ITEMNUM ='$item_number'")->result();

        //Reset Key Array
        $i=0;
        $data = array();
        foreach ($query->result_array() as $val) {
                unset($val["RNUM"]);
                // $function = '<script>function myFunctionPrint(){
                // 	window.print
                // }</script>';
                // $action[0] = '<form><input type="text" ng-init="qtyPrint['.$i.']=2" ng-model="qtyPrint['.$i.']" class="form-control id="print" name="print"></form>{{qtyPrint[$i]}}';
                $action[0] = '<a href="#" onclick="myFunctionPrint('.$val["ITEMNUM"].')" class="btn btn-primary btn-sm"><span class="fa fa-print"> Print</span></a>';
                $val = array_merge($val, $action);       
                $data[] = array_values($val);
        }

        //Prepare Return Data
        $return = array(
                "draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                "recordsTotal"    => $totalData,  // total number of records
                "recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data  // total data array
        );

        return $return;

    }

    function getDatatableItem(){

        //We Need Column Index for Ordering
        $columns = array(
                0 =>'item_number',
                1 =>'location_id',
                2 =>'conditioncode',
                3 =>'binnum'

        );

        $totalData  = $this->dbMaster->count_all('item_balances');
        $totalFiltered =  $totalData; 

        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->dbMaster->start_cache();
        $this->dbMaster->select($columns);
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value'];
                // $search_value1 = $this->searchDes($search_value);

                $this->dbMaster->like('item_number', $search_value);
                $this->dbMaster->or_like('description',$search_value);
                $this->dbMaster->or_like('location_id', $search_value);
                $this->dbMaster->or_like('conditioncode', $search_value);
                $this->dbMaster->or_like('binnum', $search_value);
                $this->dbMaster->stop_cache();

                $totalFiltered  = $this->dbMaster->get('item_balances')->num_rows();
        }

        $this->dbMaster->stop_cache();
        
        $this->dbMaster->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
        $this->dbMaster->limit($_REQUEST['length'], $_REQUEST['start']);

        $query = $this->dbMaster->get('item_balances');


        // var_dump($query->result());
        //Reset Key Array
        $data = array();
        foreach ($query->result_array() as $val) {
                $action[0] = $this->getItemDesc($val['item_number']);
                $action[1] = $this->getLocationDesc($val['location_id']);
                $action[2] = $val['conditioncode'];
                $action[3] = $val['binnum'];
                $action[4] = '<a href="'.base_url().'master-data/detail-item/'.$val["item_number"].'/'.$val["location_id"].'/'.$val["conditioncode"].'/'.str_replace('/','-',$val["binnum"]).'" class="btn btn-info btn-sm"><span class="fa fa-info"> Detail</span></a>';
                unset($val["location_id"]);
                unset($val["conditioncode"]);
                unset($val["binnum"]);

                $val = array_merge($val, $action);
                $data[] = array_values($val);


        }

        //Prepare Return Data
        $return = array(
                "draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                "recordsTotal"    => $totalData,  // total number of records
                "recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data  // total data array
        );

        return $return;


    }

    function getItemDesc($itemNumber){
        $dbMaximo=$this->load->database('maximo',TRUE);
        $dataItem=$dbMaximo->query("select * from VIEWITEM where ITEMNUM='$itemNumber'")->result();
        if (isset($dataItem[0]->DESCRIPTION)) {
            return $dataItem[0]->DESCRIPTION;
        } else {
            return "";
        }
        // return $dataItem[0]->DESCRIPTION;
    }


    function getLocationDesc($location_id){
        $dataLocation=$this->dbMaster->query("select * from location where location_id='$location_id'")->result();
        return $dataLocation[0]->name;
    }

    function searchDes($search_value1){
        $dbMaximo=$this->load->database('maximo',TRUE);
        $dataItem=$dbMaximo->query("SELECT * FROM VIEWITEM WHERE DESCRIPTION LIKE '%$search_value1%'")->result();
        return $dataItem[0]->DESCRIPTION;
    }

    function uploadPhoto($item_number, $data)
    {
        // $data = array(
        //     'item_number' => $item_number,
        //     'photo' => $data
        //     );
        $this->dbInventory->where('item_number', $item_number);
        $this->dbInventory->update('item_photo', $data);
    }

    function insert($data){
        $this->dbInventory->insert('item_photo', $data);
    }

	function getdatacommodity()
	{
		$query = $this->dbMaster->query('select * from commodity order by commodity_id ASC');
		return $query;
	}

	function getDatatableLocation(){

        //We Need Column Index for Ordering
        $columns = array(
                0 => 'LOCATION', 
                1 => 'DESCRIPTION',
                2 => 'TYPE', 
                3 => 'STATUS'
        );

        $totalData  = $this->dbMaximo->count_all('VIEWLOCATIONS');
        $totalFiltered =  $totalData; 

        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->dbMaximo->start_cache();
        $this->dbMaximo->select($columns);
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value'];

                $this->dbMaximo->like('LOCATION', $search_value);
                $this->dbMaximo->or_like('DESCRIPTION', $search_value);
                $this->dbMaximo->or_like('TYPE', $search_value);
                $this->dbMaximo->or_like('STATUS', $search_value);
                $this->dbMaximo->stop_cache();

                $totalFiltered  = $this->dbMaximo->get('VIEWLOCATIONS')->num_rows();
        }

        $this->dbMaximo->stop_cache();
        
        $this->dbMaximo->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
        $this->dbMaximo->limit($_REQUEST['length'], $_REQUEST['start']);

        $query = $this->dbMaximo->get('VIEWLOCATIONS');

        //Reset Key Array
        $data = array();
        foreach ($query->result_array() as $val) {
                $data[] = array_values($val);
        }

        //Prepare Return Data
        $return = array(
                "draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                "recordsTotal"    => $totalData,  // total number of records
                "recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data  // total data array
        );

        return $return;

    }

	function getDatatableMeasureunit(){

        //We Need Column Index for Ordering
        $columns = array(
                0 =>'MEASUREUNITID', 
                1 => 'ABBREVIATION'
        );

        $totalData  = $this->dbMaximo->count_all('VIEWMEASUREUNIT');
        $totalFiltered =  $totalData; 

        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->dbMaximo->start_cache();
        $this->dbMaximo->select($columns);
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value'];

                $this->dbMaximo->like('MEASUREUNITID', $search_value);
                $this->dbMaximo->or_like('ABBREVIATION', $search_value);
                $this->dbMaximo->stop_cache();

                $totalFiltered  = $this->dbMaximo->get('VIEWMEASUREUNIT')->num_rows();
        }

        $this->dbMaximo->stop_cache();
        
        $this->dbMaximo->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
        $this->dbMaximo->limit($_REQUEST['length'], $_REQUEST['start']);

        $query = $this->dbMaximo->get('VIEWMEASUREUNIT');

        //Reset Key Array
        $data = array();
        foreach ($query->result_array() as $val) {
                $data[] = array_values($val);
        }

        //Prepare Return Data
        $return = array(
                "draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                "recordsTotal"    => $totalData,  // total number of records
                "recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data  // total data array
        );

        return $return;

    }

	function getDatatableCompanies(){

        //We Need Column Index for Ordering
        $columns = array(
                0 => 'COMPANY', 
                1 => 'NAME',
                2 => 'ADDRESS1', 
                3 => 'ADDRESS2',
                4 => 'ADDRESS3', 
                5 => 'ADDRESS4',
                6 => 'CONTACT', 
                7 => 'PHONE',
                7 => 'FAX'
        );

        $totalData  = $this->dbMaximo->count_all('VIEWCOMPANIES');
        $totalFiltered =  $totalData; 

        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->dbMaximo->start_cache();
        $this->dbMaximo->select($columns);
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value'];

                $this->dbMaximo->like('COMPANY', $search_value);
                $this->dbMaximo->or_like('NAME', $search_value);
                $this->dbMaximo->or_like('ADDRESS1', $search_value);
                $this->dbMaximo->or_like('ADDRESS2', $search_value);
                $this->dbMaximo->or_like('ADDRESS3', $search_value);
                $this->dbMaximo->or_like('ADDRESS4', $search_value);
                $this->dbMaximo->or_like('CONTACT', $search_value);
                $this->dbMaximo->or_like('PHONE', $search_value);
                $this->dbMaximo->or_like('FAX', $search_value);
                $this->dbMaximo->stop_cache();

                $totalFiltered  = $this->dbMaximo->get('VIEWCOMPANIES')->num_rows();
        }

        $this->dbMaximo->stop_cache();
        
        $this->dbMaximo->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
        $this->dbMaximo->limit($_REQUEST['length'], $_REQUEST['start']);

        $query = $this->dbMaximo->get('VIEWCOMPANIES');

        //Reset Key Array
        $data = array();
        foreach ($query->result_array() as $val) {
                $data[] = array_values($val);
        }

        //Prepare Return Data
        $return = array(
                "draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                "recordsTotal"    => $totalData,  // total number of records
                "recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data  // total data array
        );

        return $return;

    }

    function chart(){
        $this->dbMaster->select('*');
        $query = $this->dbMaster->get('item_type');
        return $query->result_array();
    }

    function bookRekening(){
        $query = $this->dbTrx->query("select * from trx_item_log, trx_item_code_data where trx_item_log.trx_code=trx_item_code_data.trx_code and trx_item_log.item_number = '$item_number' and  trx_item_log.location = '$location_id' and  trx_item_log.conditioncode = '$conditioncode'");
        if ($query->result()>0) {
            return $query;
        } else {
            echo "Data Not Found";
        }
    }

	
}