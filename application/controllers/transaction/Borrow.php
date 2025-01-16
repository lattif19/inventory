<?php
/**
* 
*/
class Borrow extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged')) {
			redirect('login');
		}

	}

	// function index()
	// {
	// 	$data['content'] 	= 'borrow/v_borrow';
	// 	$data['judul'] 		= 'Dashboard';
	// 	$data['sub_judul'] 	= 'Borrow';
	// 	$data['class'] 		= 'transaction';
	// 	$data['class'] 		= 'borrow';
	// 	$data['query'] 		= '';
	// 	$this->load->view('v_home', $data);
	// }

	function tools()
	{
		$data['content'] 	= 'borrow/v_borrow_tools';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Tools';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'borrow';
		$data['class'] 		= 'b_tools';
		$data['query'] 		= '';
		$this->load->view('v_home', $data);
		
	}

	function add_tools()
	{
		$data['content'] 	= 'borrow/add_borrow_tools';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Add Borrow Item';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'borrow';
		$data['class'] 		= 'b_tools';
		$data['query'] 		= '';
		$this->load->view('v_home', $data);
	}

	function items()
	{
		$data['content'] 	= 'borrow/v_borrow_items';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Items';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'borrow';
		$data['class'] 		= 'b_items';
		$data['query'] 		= '';
		$this->load->view('v_home', $data);
		
	}

	function add_items()
	{
		$data['content'] 	= 'borrow/add_borrow_items';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Add Borrow Item';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'borrow';
		$data['class'] 		= 'b_items';
		$data['query'] 		= '';
		$this->load->view('v_home', $data);
	}

	function services()
	{
		$data['content'] 	= 'borrow/v_borrow_services';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Services';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'borrow';
		$data['class'] 		= 'b_services';
		$data['query'] 		= '';
		$this->load->view('v_home', $data);
		
	}

	function add_services()
	{
		$data['content'] 	= 'borrow/add_borrow_services';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Add Borrow Item';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'borrow';
		$data['class'] 		= 'b_services';
		$data['query'] 		= '';
		$this->load->view('v_home', $data);
	}

	function return_tools()
	{
		$data['content'] 	= 'borrow/v_return_tools';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Tools';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'borrow';
		$data['class'] 		= 'r_tools';
		$data['query'] 		= '';
		$this->load->view('v_home', $data);
		
	}

	function return_items()
	{
		$data['content'] 	= 'borrow/v_return_items';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Items';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'borrow';
		$data['class'] 		= 'r_items';
		$data['query'] 		= '';
		$this->load->view('v_home', $data);
		
	}

	function return_services()
	{
		$data['content'] 	= 'borrow/v_return_services';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Services';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'borrow';
		$data['class'] 		= 'r_services';
		$data['query'] 		= '';
		$this->load->view('v_home', $data);
		
	}
}