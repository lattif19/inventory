<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('logged')) {
			redirect('login');
		}

		$this->load->model('ModelTransfer');
		$this->load->library('ajax');
		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
	}

	public function index()
	{
		$data['content'] 			= 'transfer/v_transfer';
		$data['judul'] 				= 'Dashboard';
		$data['sub_judul'] 			= 'Transfer';
		$data['class'] 				= '';
		// $data['getDataTransfer'] 	= $this->ModelTransfer->getDataTransfer();
		$this->load->view('v_home', $data);
	}

	function getDataTransfer()
	{
		$data = $this->ModelTransfer->getDataTransferList();
		$this->ajax->send($data);
	}

	function add(){
		$data['content'] 			= 'transfer/add_transfer';
		$data['judul'] 				= 'Dashboard';
		$data['sub_judul'] 			= 'Transfer';
		$data['class'] 				= '';
		$this->load->view('v_home', $data);
	}

}

/* End of file Transfer.php */
/* Location: .//C/Users/asus/AppData/Local/Temp/fz3temp-2/Transfer.php */