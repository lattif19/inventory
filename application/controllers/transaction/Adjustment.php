<?php
/**
* 
*/
class Adjustment extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged')) {
			redirect('login');
		}
		$this->dbSo 		= $this->load->database('trxSo', TRUE);
		$this->dbInventory 	= $this->load->database('default', TRUE);
		$this->dbTrx 		= $this->load->database('trx', TRUE);
		$this->dbMaximo 	= $this->load->database('maximo', TRUE);
		$this->load->library('ajax');
		$this->load->model('ModelAdjustment');
	}

	function index()
	{
		$data['content'] 	= 'adjustment/v_adjustment';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Adjustment Stock';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'adjustment';
		$data['class'] 		= '';
		$this->load->view('v_home', $data);
	}

	function getData(){
		$data = $this->ModelAdjustment->getDataAdjustment();
		$this->ajax->send($data);
		// echo "<pre>";
		// var_dump($data);
	}

	function getDataAdjustment(){
		$getDataAdjustment = $this->dbSo->query("select * from stock_opname.so_detail_summary, inventory.location where location.location_id = so_detail_summary.location_id and so_detail_summary.status_adjus = '0'")->result();
	}

	function add()
	{
		$data['content'] 	= 'adjustment/add_adjustment';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Adjustment';
		// $data['class'] 		= 'transaction';
		// $data['class'] 		= 'adjustment';
		$data['class'] 		= 'Add Adjustment';
		$data['query'] 		= '';
		$this->load->view('v_home', $data);
	}

	function detail($trx_id){
		$data = array(
			'content' 	=> 'adjustment/detail_adjustment',
			'judul' 	=> 'Dashboard',
			'sub_judul' => 'Adjustment',
			'class' 	=> 'transaction',
			'class' 	=> 'adjustment',
			'class' 	=> 'Detail Adjustment'
			);

		$detAdj 	= $this->dbTrx->query("select * from trx_adjustment where trx_id ='$trx_id'")->result();
		foreach ($detAdj as $detail) {
			$data['trx_code'] 		= $detail->trx_code;
			$data['trx_timestamp'] 	= $detail->trx_timestamp;
			$data['enterby'] 		= $detail->enterby;
			$data['ip_address'] 	= $detail->ip_address;
		}

		$itemAdj = $this->ModelAdjustment->getItemAdjustment($trx_id);
		$data['itemAdj'] = $this->addDetailItemMaximo($itemAdj);
		$this->load->view('v_home', $data);
	}

	// function save($item_number,$qty_so,$qty_system,$location_id){
	function save($item_number,$location_id){
		$data['item_number'] = $item_number;
		$data['location_id'] = $location_id;		
		$data['qty_diff'] = $this->input->post('qty_diff');
		$data['status_adjus'] = 1;
		
		// var_dump($data);
		$this->dbSo->where('item_number', $item_number);
		$this->dbSo->update('so_detail_summary', $data);

		$getData = $this->getStatusAdjustMAnual();
		if ($data['status_adjus']==1) {
			$data1['id_so_detail']=$item_number;
			$data1['item_number']=$item_number;
			$data1['location_id']=$location_id;
			$data1['condition_code']="NEW-MATERIAL";
			$data1['note']="MANUAL-ADJUSTMENT";
			$data1['system_qty']=$getData[0]->qty_system;
			$data1['actual_qty']=$getData[0]->qty_so;
			$data1['adjustment_qty']=$getData[0]->qty_system;
			$data1['ip_address'] = $this->input->ip_address();
			$data1['enterby'] = $this->session->userdata('username');
			$this->dbTrx->insert('trx_adjustment_detail',$data1);
			// var_dump($data1);
		}
		
		$this->session->set_flashdata('info', 'Data success to Adjustment Manual');
		redirect('transaction/adjustment');
	}

	function getStatusAdjustMAnual(){
		$AdjustmentManual=$this->dbSo->query("SELECT * FROM stock_opname.so_detail_summary WHERE status_adjus=1")->result();
		return $AdjustmentManual;
	}

	function getItemMaximo($trx_id){
		$itemMaximo = $this->dbMaximo->query("select * from VIEWITEM where ITEMNUM ='$trx_id'")->result();
		return $itemMaximo[0]; 
	}

	function addDetailItemMaximo($getDescItemMaximo){
		$i= 0;
		foreach ($getDescItemMaximo as $key) {
			$j=$i++;
			$getDescItemMaximo[$j]->DESCRIPTION = $this->getItemMaximo($key->item_number)->DESCRIPTION;
			$getDescItemMaximo[$j]->COMMODITYGROUP = $this->getItemMaximo($key->item_number)->COMMODITYGROUP;
		}

		return $getDescItemMaximo;
	}

	function getImport(){
		$location = $this->input->post('location');
		if($location=='WH'){
			$finalSo=$this->dbInventory->query("SELECT * FROM inventory.item_balances_monitoring where item_balances_monitoring.status=1 AND location='$location'")->result();
			foreach ($finalSo as $finalData) {
				$data['id_so']=$finalData->item_number;
				$data['item_number']=$finalData->item_number;
				$data['location_id']=$this->getLocationIdFromName($finalData->location);
				$data['condition_code']="NEW-MATERIAL";
				$data['qty_so']=$finalData->qtySo;
				$data['qty_system']=$finalData->qty;
				$data['qty_diff']=($finalData->qty)-($finalData->qtySo);
				$data['updated_by']='system';
				$data['status_adjus']=0;
				$this->dbSo->insert('so_detail_summary',$data);
				// var_dump($data);
			}	
		}else if($location=='WH2'){
			$finalSo=$this->dbInventory->query("SELECT * FROM inventory.item_balances_monitoring2 where item_balances_monitoring2.status=1 AND location='$location'")->result();
			foreach ($finalSo as $finalData) {
				$data['id_so']=$finalData->item_number;
				$data['item_number']=$finalData->item_number;
				$data['location_id']=$this->getLocationIdFromName($finalData->location);
				$data['condition_code']="NEW-MATERIAL";
				$data['qty_so']=$finalData->qtySo;
				$data['qty_system']=$finalData->qty;
				$data['qty_diff']=($finalData->qty)-($finalData->qtySo);
				$data['updated_by']='system';
				$data['status_adjus']=0;
				$this->dbSo->insert('so_detail_summary',$data);
				// var_dump($data);
			}
		}else if($location=='WH3'){
			$finalSo=$this->dbInventory->query("SELECT * FROM inventory.item_balances_monitoring3 where item_balances_monitoring3.status=1 AND location='$location'")->result();
			foreach ($finalSo as $finalData) {
				$data['id_so']=$finalData->item_number;
				$data['item_number']=$finalData->item_number;
				$data['location_id']=$this->getLocationIdFromName($finalData->location);
				$data['condition_code']="NEW-MATERIAL";
				$data['qty_so']=$finalData->qtySo;
				$data['qty_system']=$finalData->qty;
				$data['qty_diff']=($finalData->qty)-($finalData->qtySo);
				$data['updated_by']='system';
				$data['status_adjus']=0;
				$this->dbSo->insert('so_detail_summary',$data);
				// var_dump($data);
			}
		}
		$data['location'] = $location;
		$this->session->set_flashdata('info', 'import data so success');
		redirect("transaction/adjustment");

	}


	public function importFromSO(){
		$finalSo=$this->dbInventory->query("SELECT * FROM inventory.item_balances_monitoring where item_balances_monitoring.status=1")->result();
		foreach ($finalSo as $finalData) {
			$data['id_so']=$finalData->item_number;
			$data['item_number']=$finalData->item_number;
			$data['location_id']=$this->getLocationIdFromName($finalData->location);
			$data['condition_code']="NEW-MATERIAL";
			$data['qty_so']=$finalData->qtySo;
			$data['qty_system']=$finalData->qty;
			$data['qty_diff']=($finalData->qty)-($finalData->qtySo);
			$data['updated_by']='system';
			$data['status_adjus']=0;
			$this->dbSo->insert('so_detail_summary',$data);
			// var_dump($data);
		}
		$this->session->set_flashdata('info', 'import data so success');
		redirect('transaction/adjustment');
	}


	function getLocationIdFromName($location_name){
		$getLocationId=$this->dbInventory->query("select location_id from location where name='$location_name'")->result();
		return $getLocationId[0]->location_id;
	}

	function emptyTableSummary(){
		$this->dbSo->from('so_detail_summary');
		$this->dbSo->truncate();

		$this->session->set_flashdata('info', 'delete data');
		redirect('transaction/adjustment');
	}

	function importToAdjustment(){
		$importToAdjustment=$this->dbSo->query("SELECT * FROM stock_opname.so_detail_summary")->result();
		foreach ($importToAdjustment as $finalData) {
			if ($finalData->status_adjus==0) {
				$data['id_so_detail']=$finalData->item_number;
				$data['item_number']=$finalData->item_number;
				$data['location_id']=$finalData->location_id;
				$data['condition_code']="NEW-MATERIAL";
				$data['note']="AUTO-ADJUSTMENT";
				$data['system_qty']=$finalData->qty_system;
				$data['actual_qty']=$finalData->qty_so;
				$data['adjustment_qty']=$finalData->qty_so;
				$data['ip_address'] = $this->input->ip_address();
				$data['enterby'] = $this->session->userdata('username');
				$this->dbTrx->insert('trx_adjustment_detail',$data);
				// var_dump($data);
			}
		}
		$this->session->set_flashdata('info', 'Auto Adjustment Complate');
		redirect('transaction/adjustment');
	}

	function list_adjustment(){
		$data['content'] 	= 'adjustment/list_adjustment';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Adjustment Stock';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'adjustment';
		$data['class'] 		= '';
		$data['DataAdjustment'] = $this->db->query("SELECT * FROM trx.trx_adjustment_detail, inventory.location WHERE location.location_id=trx_adjustment_detail.location_id")->result();
		$this->load->view('v_home', $data);
	}



}