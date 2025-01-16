<?php
/**
* 
*/
class Location extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged')) {
			redirect('login');
		}

	}

	function index()
	{
		$data['content'] 	= 'location/v_location';;
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Location';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'location';
		$data['query'] 		= '';
		$this->load->view('v_home', $data);
	}
	
	function add()
	{
		$data['content'] 	= 'Receiving/add_receiving';;
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Add Receiving PO';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'receiving';
		$data['query'] 		= '';
		$this->load->view('v_home', $data);
	}
}