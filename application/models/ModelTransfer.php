<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelTransfer extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->dbSo = $this->load->database('trxSo', TRUE);
		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
	}


	public function getDataTransferList()
	{
		
        //We Need Column Index for Ordering
        $columns = array(
                0 =>'TRANSDATE', 
                1 => 'ITEMNUM',
                2 => 'QUANTITY',
                3 => 'FROMSTORELOC',
                4 => 'TOSTORELOC',
                5 => 'FROMBIN',
                6 => 'TOBIN',
        );

        $totalData  = $this->dbTrx->count_all('trx_trf_location');
        $totalFiltered =  $totalData; 

        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->dbTrx->start_cache();
        $this->dbTrx->select($columns);
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value'];

                $this->dbTrx->like('TRANSDATE', $search_value);
                $this->dbTrx->or_like('ITEMNUM', $search_value);
                $this->dbTrx->or_like('QUANTITY', $search_value);
                $this->dbTrx->or_like('FROMSTORELOC', $search_value);
                $this->dbTrx->or_like('TOSTORELOC', $search_value);
                $this->dbTrx->or_like('FROMBIN', $search_value);
                $this->dbTrx->or_like('TOBIN', $search_value);
                $this->dbTrx->stop_cache();

                $totalFiltered  = $this->dbTrx->get('trx_trf_location')->num_rows();
        }

        $this->dbTrx->stop_cache();
        
        $this->dbTrx->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
        $this->dbTrx->limit($_REQUEST['length'], $_REQUEST['start']);

        $query = $this->dbTrx->get('trx_trf_location');

        // $barcodeOptions = $this->dbMaximo->query("select * from VIEWITEM where ITEMNUM ='$item_number'")->result();

        //Reset Key Array
        $i=0;
        $data = array();
        foreach ($query->result_array() as $val) {
                // unset($val["RNUM"]);
                // $action[0] = '<a href="#" onclick="myFunctionPrint('.$val["ITEMNUM"].')" class="btn btn-primary btn-sm"><span class="fa fa-print"> Print</span></a>';
                // $val = array_merge($val);       
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

}

/* End of file ModelTransfer.php */
/* Location: .//C/Users/asus/AppData/Local/Temp/fz3temp-2/ModelTransfer.php */