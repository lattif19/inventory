<?php
class Login extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelLogin');
	}

	function index()
	{
		$this->load->view('v_login');
	}

	function check_login()
	{	
		$u= $this->input->post('username');
		$p= $this->input->post('password');
		$this->ModelLogin->getlogin($u,$p);		
	}

	function getdataitem(){
		$dbMaximo = $this->load->database('maximo', TRUE);
		$query= $dbMaximo->query("select * from VIEWITEM");
		print_r(json_encode($query, true));
	}
}