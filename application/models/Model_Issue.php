<?php
/**
* 
*/
class Model_Issue extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->dbInventory = $this->load->database('default', TRUE);
        $this->dbTrx    = $this->load->database('trx', TRUE);
        $this->dbMaximo = $this->load->database('maximo', TRUE);
    }

    function getDatatableIssue(){

        //We Need Column Index for Ordering
        $columns = array(
                0 =>'trx_timestamp', 
                1 => 'trx_code',
                2 => 'enterby',
                3 => 'wonum',
                4 => 'trx_id',
        //         4 => 'month',
        //         5 => 'year',
        //         6 => 'shipper_id',
        //         7 => 'issuetype',
        //         8 => 'ip_address',
        //         9 => 'note',
        //         10 => 'wonum',
        //         11 => 'issueto',
        );

        $totalData  = $this->dbTrx->count_all('trx_wo');
        $totalFiltered =  $totalData; 

        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->dbTrx->start_cache();
        $this->dbTrx->select($columns);
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value'];

                $this->dbTrx->like('trx_timestamp', $search_value);
                $this->dbTrx->or_like('trx_code', $search_value);
                $this->dbTrx->or_like('enterby', $search_value);
                $this->dbTrx->or_like('wonum', $search_value);
                $this->dbTrx->stop_cache();

                $totalFiltered  = $this->dbTrx->get('trx_wo')->num_rows();
        }

        $this->dbTrx->stop_cache();
        
        $this->dbTrx->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
        $this->dbTrx->limit($_REQUEST['length'], $_REQUEST['start']);

        $query = $this->dbTrx->get('trx_wo');
        // $query = $this->dbTrx->query("SELECT * FROM trx_wo ORDER BY trx_code DESC");
        //Reset Key Array
        $data = array();
        foreach ($query->result_array() as $val) {
                // $action[0]=$val["trx_timestamp"];
                // $action[1]=$val["trx_code"];
                // $action[2]=$val["enterby"];
                $action[0] = '<a href="'.base_url().'transaction/issue/detail/'.$val["trx_id"].'" class="btn btn-info btn-sm"><span class="fa fa-info"> Detail</span></a> <a href="#" onclick="myFunctionPrint('.$val["trx_id"].')" class="btn btn-warning btn-sm"><span class="fa fa-print">Print</span></a>';
                unset($val["trx_id"]);
                // unset($val["trx_timestamp"]);
                // unset($val["trx_code"]);
                // unset($val["enterby"]);
                // unset($val["month"]);
                // unset($val["year"]);
                // unset($val["shipper_id"]);
                // unset($val["issuetype"]);
                // unset($val["ip_address"]);
                // unset($val["note"]);
                // unset($val["wonum"]);
                // unset($val["issueto"]);
                
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
        // print_r($data);

    }

    function getDataWO($trx_id)
    {
        $query = $this->dbTrx->query("SELECT a.*, b.* FROM trx_wo as a, trx_wo_detail as b WHERE a.trx_id = b.trx_id AND a.trx_id = '$trx_id'");
        return $query->result();
    }

    function getDetailWO($trx_id)
    {
        $query = $this->dbTrx->query("SELECT a.*, b.* FROM trx_wo as a, trx_wo_detail as b WHERE a.trx_id = b.trx_id AND a.trx_id = '$trx_id' ORDER BY b.item_number ASC");
        return $query->result();
    }

    function getDataDesc($trx_id)
    {
        $query = $this->dbMaximo->query("select * from VIEWITEM where ITEMNUM ='$trx_id'");
        return $query->result();
    }
}