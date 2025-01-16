<?php
/**
* 
*/
class Home extends CI_Controller
{
	
	function __construct()
	{

		parent::__construct();
		if (!$this->session->userdata('logged')) {
			redirect('login');
		}

		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
		$this->dbSo = $this->load->database('trxSo', TRUE);
		$this->load->model('ModelMaster');
	}

	function index() 
	{

		$data['content'] 		= 'view_content';
		$data['judul'] 			= 'Dashboard';
		$data['sub_judul'] 		= 'home';
		$data['class'] 			= '';
		// item last trx
		$data['lastReceive'] 	= $this->dbTrx->query("select * from trx_po order by trx_code DESC limit 5");
		$data['lastIssue'] 		= $this->dbTrx->query("select * from trx_wo order by trx_code DESC limit 5");
		$data['lastVendor'] 	= $this->dbTrx->query("select * from trx_po_return order by trx_code DESC limit 5");
		$data['lastWarehouse'] 	= $this->dbTrx->query("select * from trx_wo_return order by trx_code DESC limit 5");
		// master data
		$data['VIEWPO']			= $this->dbMaximo->query("select COUNT(*) as TOTAL_PO from VIEWPO")->result();
		$data['VIEWWORKORDER']	= $this->dbMaximo->query("select COUNT(*) as TOTAL_WO from VIEWWORKORDER")->result();
		$data['item']			= $this->dbInventory->query("select COUNT(*) as total_item from item_balances")->result();

		// alert transaction
		$data['alertPO'] 		= $this->dbTrx->query("select a.*, b.* from trx_po as a, trx_po_detail as b where a.trx_id = b.trx_id and b.trx_status=2 order by trx_code DESC limit 5");
		$data['alertWO'] 		= $this->dbTrx->query("select a.*, b.* from trx_wo as a, trx_wo_detail as b where a.trx_id = b.trx_id and b.trx_status=2 order by trx_code DESC limit 5");
		// Rekening Item
		$data['dataItem']		= $this->dbTrx->query("select a.*, b.* from trx_item_log as a, trx_item_code_data as b where  b.trx_code = a.trx_code order by a.id DESC limit 50")->result();

		$data['INVmaximo']	=$this->dbMaximo->query("select count(*) as total_item from VIEWINVBALANCES")->result();

		$data['withoutPO'] = $this->dbTrx->query("select count(*) as total_without_po from trx_po,trx_po_detail where trx_po.trx_id=trx_po_detail.trx_id and trx_po_detail.trx_status!=1");
		$data['withoutWO'] = $this->dbTrx->query("select count(*) as total_without_wo from trx_wo,trx_wo_detail where trx_wo.trx_id=trx_wo_detail.trx_id and trx_wo_detail.trx_status!=1");

		// echo "<pre>";
		// var_dump($data['INVmaximo']);

		$this->load->view('v_home', $data);
	}

	function getdata(){
		// $data  = $this->ModelMaster->chart();
		$data=$this->dbMaximo->query("select COUNT(*) as TOTAL_PO from VIEWPO")->result();
		print_r(json_encode($data, true));
	}


	function logout()
	{
		$this->session->sess_destroy();
		helper_log('logout', 'logout system inventory');
        redirect('login');
	}

	function cek_session()
	{
		$session_data = $this->session->userdata();

		echo '<pre>';
		print_r($session_data);
		echo '</pre>';
	}

	// function a() 
	// {

	// 	$data['content'] 		= 'view_content';
	// 	$data['judul'] 			= 'Dashboard';
	// 	$data['sub_judul'] 		= 'home';
	// 	$data['class'] 			= 'home';
	// 	$data['lastReceive'] 	= $this->dbTrx->query("select a.trx_code, a.trx_id, a.trx_timestamp, b.trx_id, b.item_number, b.orderunit from trx_po as a, trx_po_detail as b where a.trx_id = b.trx_id limit 5");
	// 	$data['lastIssue'] 		= $this->dbTrx->query("select a.trx_code, a.trx_id, a.trx_timestamp, b.item_number, b.issueunit from trx_wo as a, trx_wo_detail as b where a.trx_id = b.trx_id limit 5");
	// 	$data['lastVendor'] 	= $this->dbTrx->query("select * from trx_po_return limit 5");
	// 	$data['lastWarehouse'] 	= $this->dbTrx->query("select * from trx_wo_return limit 5");


	// 	$this->load->view('v_home', $data);

	// 	// var_dump($lastIssue);
	// }

}