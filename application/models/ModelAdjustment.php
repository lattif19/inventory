<?php
/**
* 
*/
class ModelAdjustment extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->dbInventory 	= $this->load->database('default', TRUE);
        $this->dbTrx 		= $this->load->database('trx', TRUE);
        $this->dbMaximo 	= $this->load->database('maximo', TRUE);
        $this->dbSo 		= $this->load->database('trxSo', TRUE);
	}

	function getDataAdjustment()
	{
		//We Need Column Index for Ordering
        $columns = array(
                0 =>'item_number',
                1 =>'location_id',
                2 =>'condition_code',
                3 =>'qty_so',
                4 =>'qty_system',
                5 =>'qty_diff',

        );

        $totalData  = $this->dbSo->count_all('so_detail_summary');
        $totalFiltered =  $totalData; 

        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->dbSo->start_cache();
        $this->dbSo->select($columns);
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value'];
                // $search_value1 = $this->searchDes($search_value);

                $this->dbSo->like('item_number', $search_value);
                $this->dbSo->or_like('location_id',$search_value);
                $this->dbSo->or_like('condition_code', $search_value);
                $this->dbSo->or_like('qty_so', $search_value);
                $this->dbSo->or_like('qty_system', $search_value);
                $this->dbSo->or_like('qty_diff', $search_value);
                $this->dbSo->stop_cache();

                $totalFiltered  = $this->dbSo->get('so_detail_summary')->num_rows();
        }

        $this->dbSo->stop_cache();
        
        $this->dbSo->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
        $this->dbSo->limit($_REQUEST['length'], $_REQUEST['start']);

        $query = $this->dbSo->get('so_detail_summary');


        // var_dump($query->result());
        //Reset Key Array
        $data = array();
        foreach ($query->result_array() as $val) {
                $action[0] = $val['item_number'];
                $action[1] = $this->getLocationDesc($val['location_id']);
                $action[2] = $val['condition_code'];
                $action[3] = $val['qty_so'];
                $action[4] = $val['qty_system'];
                $action[5] = $val['qty_diff'];
                $action[6] = '<form method="post" action="'.base_url().'transaction/adjustment/save/'.$val["item_number"].'/'.$val["location_id"].'"><input class="form-control" name="qty_diff" id="qty_diff">&nbsp;&nbsp;<button type="submit" class="btn btn-info btn-sm><i class="fa fa-save"> Save</i></button></form>';
                // $action[6] = '<a href="" class="btn btn-info btn-sm"><span class="fa fa-save"> Save</span></a>';
                // unset($val["location_id"]);
                // unset($val["condition_code"]);
                // unset($val["binnum"]);

                $val = array_merge($action);
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

	function getLocationDesc($location_id){
        $dataLocation=$this->dbInventory->query("select * from location where location_id='$location_id'")->result();
        return $dataLocation[0]->name;
    }

	// function getDataAdjustment(){
	// 	$getDataAdjustment = $this->dbSo->query("select * from stock_opname.so_detail_summary, inventory.location where location.location_id = so_detail_summary.location_id")->result();
	
	// 	return $getDataAdjustment;
	// }

	function getDetailAdjustment($trx_id){
		$query = $this->dbTrx->query("select * from trx_adjustment as a, trx_adjustment_detail as b where a.trx_id = b.trx_id and a.trx_id='$trx_id'")->result();
		return $query;
	}

	function getItemAdjustment($trx_id){
		return $this->dbTrx->query("select a.*, b.* from trx_adjustment as a, trx_adjustment_detail as b where a.trx_id = b.trx_id and a.trx_id='$trx_id'")->result();
	}
}