<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelReceiving extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
        $this->dbMaster = $this->load->database('default', TRUE);
        $this->dbTrx = $this->load->database('trx', TRUE);
        $this->dbMaximo = $this->load->database('maximo', TRUE);
    }

    function getDataTableReceiving(){
        //We Need Column Index for Ordering
        $columns = array(
                0 =>'trx_timestamp',
                1 =>'trx_code',
                2 =>'enterby',
                3 =>'ponum',
                4 =>'trx_id',
                // 3 =>'trx_timestamp'

        );

        $totalData  = $this->dbTrx->count_all('trx_po');
        $totalFiltered =  $totalData; 

        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->dbTrx->start_cache();
        $this->dbTrx->select($columns);
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value'];
                // $search_value1 = $this->searchDes($search_value);
                $this->dbTrx->like('trx_id', $search_value);
                $this->dbTrx->or_like('trx_timestamp', $search_value);
                $this->dbTrx->or_like('trx_code',$search_value);
                $this->dbTrx->or_like('enterby', $search_value);
                $this->dbTrx->or_like('ponum', $search_value);
                $this->dbTrx->stop_cache();

                $totalFiltered  = $this->dbTrx->get('trx_po')->num_rows();
                // $query = $this->dbTrx->query("SELECT * FROM trx_po ORDER BY trx_code DESC")->num_rows();

        }

        $this->dbTrx->stop_cache();
        
        $this->dbTrx->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
        $this->dbTrx->limit($_REQUEST['length'], $_REQUEST['start']);

        $query = $this->dbTrx->get('trx_po');
        // $query = $this->dbTrx->query("SELECT * FROM trx_po ORDER BY trx_code DESC");
        // var_dump($query->result());
        //Reset Key Array
        $data = array();
        foreach ($query->result_array() as $val) {
                $action[0] = '<a href="'.base_url().'transaction/receiving/detail/'.$val["trx_id"].'" class="btn btn-info btn-sm"><span class="fa fa-info"> Detail</span></a> <a href="#" onclick="myFunctionPrint('.$val["trx_id"].')" class="btn btn-warning btn-sm"><span class="fa fa-print">Print</span></a>';
                unset($val["trx_id"]);

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
        // echo "<pre>";
        // var_dump($return);
    }

	function getdatatrx()
	{
        return $this->dbTrx->query("select date(trx_timestamp) as date, trx_code, trx_id, trx_status, enterby from trx_po where trx_status = 1");
	}

	function getdatacompanies()
	{
		$this->dbMaximo->select ('*');
		$this->dbMaximo->from ('VIEWCOMPANIES');
		$result = $this->dbMaximo->get();
		return $result;
	}

    function getCompanyName($companyId)
    {
        $result = $this->dbMaximo->query("SELECT * FROM VIEWCOMPANIES WHERE COMPANY=$companyId")->result();
        return $result[0]->NAME;
    }

    function getdataitems()
    {
        $query = $this->dbMaster->query('select * from item order by item_number ASC');
        return $query->result();
    }

    function getdatabarcode($item_barcode)
    {
        $query =  $this->dbMaster->query("SELECT a.*, b.* FROM item_barcode as a, item as b WHERE a.item_barcode = b.item_number AND a.item_barcode LIKE '%$item_barcode%'");
            return $query;
        //return $this->dbMaster->query("SELECT * FROM item_barcode WHERE item_barcode LIKE '%$item_barcode%'");
        
    }

    function seek($keyword)
    {
        $this->dbMaster->select('shipper_id')->from('shipper');
        $this->dbMaster->like('name',$keyword,'after');
        $query = $this->dbMaster->get();
 
        return $query->result();
    }

    function get_po() {
        $this->dbMaster->from('po');
        $query = $this->dbMaster->get();
 
        //cek apakah ada item
        if ($query->num_rows() > 0) { //jika ada maka jalankan
            return $query->result();
        }
    }

    function getinsertdata($data)
    {
        //$item = $this->dbTrx->query('SELECT MONTH(trx_timestamp) FROM trx_po ');
        $this->dbTrx->insert('trx_po', $data);
    }


    function getDataReceiving($trx_id)
    {
        $query = $this->dbTrx->query("SELECT a.*, b.* FROM trx_po as a, trx_po_detail as b WHERE a.trx_id = b.trx_id AND a.trx_id = '$trx_id'");
        return $query->result();
    }

    function getDetailReceiving($trx_id)
    {
        $query = $this->dbTrx->query("SELECT a.*, b.* FROM trx_po as a, trx_po_detail as b WHERE a.trx_id = b.trx_id AND a.trx_id = '$trx_id' ORDER BY b.item_number ASC");
        return $query->result();
    }

    function getItemDetailFromMaximo($trx_id){
        $itemDetailFromMaximo=$this->dbMaximo->query("select * from VIEWITEM where ITEMNUM = '$trx_id'")->result();
        return $itemDetailFromMaximo[0];
    }

    function getDataTableReceivingNonPo(){
        //We Need Column Index for Ordering
        $columns = array(
                0 =>'trx_timestamp',
                1 =>'trx_code',
                2 =>'item_number',
                3 =>'qty',
                4 =>'NAME',
                // 3 =>'trx_timestamp'

        );

        $totalData  = $this->dbTrx->count_all('trx_po_detail');
        $totalFiltered =  $totalData; 

        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->dbTrx->start_cache();
        $this->dbTrx->select($columns);
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value'];
                // $search_value1 = $this->searchDes($search_value);
                // $this->dbTrx->like('trx_id', $search_value);
                $this->dbTrx->or_like('trx_timestamp', $search_value);
                $this->dbTrx->or_like('trx_code',$search_value);
                $this->dbTrx->or_like('item_number',$search_value);
                $this->dbTrx->or_like('qty', $search_value);
                $this->dbTrx->or_like('NAME', $search_value);
                $this->dbTrx->stop_cache();

                $totalFiltered  = $this->dbTrx->get("SELECT * FROM trx_po_detail where trx_status!=1")->num_rows();
        }

        $this->dbTrx->stop_cache();
        
        $this->dbTrx->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
        $this->dbTrx->limit($_REQUEST['length'], $_REQUEST['start']);

        $query = $this->dbTrx->query("SELECT * FROM trx_po_detail where trx_status!=1");


        // var_dump($query->result());
        //Reset Key Array
        $data = array();
        foreach ($query->result_array() as $val) {
                $action[0] = $val['timestamp'];
                $action[1] = $val['item_number'];
                $action[2] = $val['conditioncode'];
                $action[3] = '<a href="'.base_url().'transaction/receiving-non-po/detail/'.$val["trx_detail_id"].'" class="btn btn-info btn-sm"><span class="fa fa-info"> Detail</span></a> <a href="#" onclick="myFunctionPrint('.$val["trx_detail_id"].')" class="btn btn-warning btn-sm"><span class="fa fa-print">Print</span></a>';

                unset($val["trx_detail_id"]);
                unset($val["trx_id"]);
                unset($val["description"]);
                // unset($val["conditioncode"]);
                // unset($val["enterby"]);
                // unset($val["ip_address"]);

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
        // echo "<pre>";
        // var_dump($data);
    }

    function getCompanyInventory($trx_id){
        $company=$this->dbMaximo->query("select * from VIEWCOMPANIES where COMPANY = '$trx_id'")->result();
        return $company[0]->NAME;
    }

    function gerTrxTimestamp($trx_id){
        $dataItemTiemstamp=$this->dbTrx->query("select * from trx_po,trx_po_detail where trx_po.trx_id=trx_po_detail.trx_id and trx_po.trx_id='$trx_id'")->result();
        return $dataItemTiemstamp[0]->trx_timestamp;
        // return $dataItem[0]->DESCRIPTION;
    }

    function gerTrxCode($trx_id){
        $dataItemTiemstamp=$this->dbTrx->query("select * from trx_po,trx_po_detail where trx_po.trx_id=trx_po_detail.trx_id and trx_po.trx_id='$trx_id'")->result();
        return $dataItemTiemstamp[0]->trx_timestamp;
        // return $dataItem[0]->DESCRIPTION;
    }

    function addArrayItemDetailMaximoToArrayItem($dataItemDescription){
        $i=0;
        foreach ($dataItemDescription as $key){
            $j=$i++;
            $dataItemDescription[$j]->NAME = $this->getCompanyInventory($key->company_id)->NAME;
        }
        return $dataItemDescription;
    }






}