<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelStockopname extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->dbSo = $this->load->database('trxSo', TRUE);
		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
	}


	function insert_csv($data)
	{
		$this->dbSo->insert('trx_so_detail', $data);
	}


	function insert($data)
	{
		$this->dbSo->insert('so', $data);
	}

	function listPeriode($id_so)
	{		
		
		return $this->dbInventory->query("select * from inventory.location as a, stock_opname.so as b, stock_opname.trx_so as c where a.location_id = b.so_location and b.id_so = c.id_so and c.id_so ='$id_so'")->result();
	}


	function getLocation()
	{
		$this->dbInventory->select('*');
		$this->dbInventory->from('location');
		$this->dbInventory->order_by('name', 'ASC');
		$location = $this->dbInventory->get();
		return $location->result();
	}

	function listStockopname()
	{
		return $this->dbSo->query("SELECT a.*, b.*, c.* FROM inventory.location a, stock_opname.trx_so b, stock_opname.so as c WHERE a.location_id = b.location_id AND c.id_so = b.id_so")->result();
		// $this->dbSo->select('*');
		// $this->dbSo->from('trx_so');
		// $this->dbSo->join('so', 'so.id_so = trx_so.id_so', 'left');
		// $this->dbSo->order_by('trx_so.trx_so_code', 'ASC');
		// $listStockopname = $this->dbSo->get();
		// return $listStockopname->result();
	}

	function detailStockopname($trx_so_id)
	{		
		return $this->dbSo->query("select a.*, b.*, c.* from trx_so as a, trx_so_detail as b, so as c where a.trx_so_id = b.trx_so_id and c.id_so = a.id_so and a.trx_so_id = '$trx_so_id'");
	}

	function itemStockopname($trx_so_id)
	{		
		return $this->dbSo->query("select a.*, b.*, c.* from trx_so as a, trx_so_detail as b, so as c where a.trx_so_id = b.trx_so_id and c.id_so = a.id_so and a.trx_so_id = '$trx_so_id'")->result();
	}

	function insertCSV()
	{
		$count=0;
        $fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
        // echo count(fgetcsv($fp));
        // echo count(fgetcsv($fp));

		// var_dump(fgetcsv($fp,1024));
        while($csv_line = fgetcsv($fp,1024))
        {
            $count++;
            if($count == 1)
            {    
                //remove if you want to have primary key,
                $insert_detailSo['trx_so_date'] = $this->parseDate($csv_line[1]);
                $insert_detailSo['trx_so_month'] = date('m');
                $insert_detailSo['trx_so_year'] = date('Y');
                $insert_detailSo['trx_so_user'] = $csv_line[2];
                $insert_detailSo['trx_so_user_login'] = $csv_line[2];
                $insert_detailSo['trx_so_type'] = 0;
                continue;
            }//keep this if condition if you want to remove the first row
            for($i = 0, $j = count($csv_line); $i < $j; $i++)
            {
                $insert_csv = array();
				$insert_csv['trx_so_id'] 		= $this->getLastTrxSoId($csv_line[1]);
                $insert_csv['item_number'] 		= $csv_line[0];//remove if you want to have primary key,
                $insert_csv['location_id'] 		= $this->whNameToId($csv_line[1]);
                $insert_csv['condition_code'] 	= $csv_line[2];
                $insert_csv['qty'] 				= $csv_line[3];
            }
            $i++;
            $checkDetailSo=$this->check_detail_so(ltrim($insert_csv['item_number'], '0'), $insert_csv['location_id'], $insert_csv['trx_so_id']);
            var_dump($checkDetailSo);
            if ($checkDetailSo === NULL) {
            	$data = array(
	                'trx_so_id'  		=> $insert_csv['trx_so_id'],
	                'item_number'  		=> ltrim($insert_csv['item_number'], '0'),
	                'location_id'       => $insert_csv['location_id'],
	                'condition_code'   	=> $insert_csv['condition_code'],
	                'qty'       		=> $insert_csv['qty'],
	                );
	            $this->dbSo->insert('trx_so_detail', $data);
            } else {
	            $data = array(
	                'qty'     => $insert_csv['qty']+$checkDetailSo['qty'],
	                );
	            $this->dbSo->where('trx_so_id_detail', $checkDetailSo['trx_so_id_detail']);
	            $this->dbSo->update('trx_so_detail', $data);

	            // var_dump($data);
        	}
        }

       	$insert_detailSo['location_id'] = $insert_csv['location_id'];
        $insert_detailSo['id_so'] 		= $this->searchIdSo($insert_detailSo['trx_so_date'],$insert_detailSo['location_id']);
        $insert_detailSo['trx_so_code'] = "SO".date('Y').date('m').date('d').$this->getLastTrxSoRtrnId();
        $insert_detailSo['trx_so_file'] = "SO"."-".$insert_detailSo['location_id']."-".date('Y').date('m').date('d');

        $this->dbSo->insert('trx_so', $insert_detailSo);

        // echo "<pre>";
        // var_dump($insert_detailSo);
        // echo "<pre>";
        // var_dump($data);

        fclose($fp) or die("can't close file");
        $data['success']="success";
        return $data;
	}

	function check_detail_so($item_number, $location_id, $so_id){
		$result = $this->dbSo->query("select * from trx_so_detail where item_number ='$item_number' and location_id='$location_id' and trx_so_id='$so_id'")->row();
		$data=[];
		echo count($result);
		if (count($result)>0) {
			$data['qty']=$result->qty;
			$data['trx_so_id_detail']=$result->trx_so_id_detail;
			return $data;
		} else {
			return NULL;
		}
	}

	function getLastTrxSoId($trx_so_id){
		$query = $this->dbSo->query("select * from trx_so order by trx_so_id DESC")->result();
		return $query[0]->trx_so_id+1;

		// var_dump($query);
	}

	function parseDate($date)
	{
		$year=substr($date,0,4);
		$month=substr($date,4,2);
		$day=substr($date,6,2);
		return  $year."-".$month."-".$day;
	}

	function whNameToId($whName){
		$query=$this->dbInventory->query("Select * From location where name='$whName'")->result();
		return $query[0]->location_id;
	}

	function searchIdSo($date,$location){
		echo $date;
		echo $location;
		$query =$this->dbSo->query("select * from so where so_location='$location' and so_start_date<='$date' and so_end_date>='$date'")->result();
		return $query[0]->id_so;
	}

	function getLastTrxSoRtrnId(){
		$getTrxId=$this->dbSo->query("select count(*) as jml from trx_so where trx_so_month='".date('m')."'")->result();
		$trxId=(int)$getTrxId[0]->jml;
		$trxId=$trxId+1;
		return sprintf("%'.07d", $trxId);
	}

	function updateDetailPeriode($id_so, $so_status){
		$data = array(
            'id_so' => $id_so,
            'so_status' => $so_status
            );
        $this->dbSo->where('id_so', $id_so);
        $this->dbSo->update('so', $data);
	}

	function insertItemSo(){
		$dataQtyItemBlc = $this->dbInventory->query("select * from item_balances")->result();
		$dataSo=$this->dbSo->query("select * from trx_so_detail")->result();
		foreach ($dataSo as $key) {
			 foreach ($dataQtyItemBlc as $value) {
				$data['id_so']=$key->id_so;
				$data['item_number']=$key->item_number;
				$data['issue_unit']=$key->issue_unit;
				$data['location_id']=$key->location_id;
				$data['condition_code']=$key->condition_code;
				$data['qty_so']=$key->qty;
			 	$data['qty_system']=$value->qty;
			 	$data['updated_by']=$this->session->userdata('username');

			 $this->dbSo->insert('so_detail_summary',$data);

			}
		}

		// echo "<pre>";
		// var_dump($dataSo);
		// echo "<pre>";
		// var_dump($dataQtyItemBlc);
	}

}

/* End of file ModelStockopname.php */
/* Location: .//C/Users/asus/AppData/Local/Temp/fz3temp-2/ModelStockopname.php */