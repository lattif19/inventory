<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoringpr extends CI_Controller {


	
	function __construct()
	{
		parent::__construct();

		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
		$this->dbMaximodummy = $this->load->database('maximodummy', TRUE);
		$this->load->model('ModelCoreTrx', '', TRUE);
	}


	public function index()
	{
		$this->load->view('monitoringpr/front');
	}

	public function listData()
	{
		$data['dataList']=$this->dbMaximo->query("SELECT  * FROM (SELECT  * FROM VIEWPR ORDER BY ISSUEDATE DESC) WHERE ROWNUM<'100'")->result();
		$this->load->view('monitoringpr/list',$data);
	}

	public function detail($pr)
	{
		$data['detailPr']=$this->dbMaximo->query("SELECT  * FROM VIEWPRLINE WHERE PRNUM='$pr'")->result();
		$this->load->view('monitoringpr/detail',$data);
	}



//NUMPANG MONITORING PR
	public function getDataPr(){
		$response=$this->dbMaximo->query("SELECT  * FROM (SELECT  * FROM VIEWPO ORDER BY ORDERDATE DESC) WHERE ROWNUM<'100'")->result();
		echo json_encode($response);
	}

	public function getDetailPr($pr){
		$data=$this->dbMaximo->query("SELECT  * FROM VIEWPRLINE WHERE PRNUM='$pr'")->result();
		echo json_encode($data);
	}

}