<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbtrxSo = $this->load->database('trxSo', TRUE);

	}

	public function index($location="WH")
	{
		$data['title'] = 'Management Stockopname';
		if($location=='WH'){
			$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring where status=1 and location='$location'")->result(); // INI QUERY UNTUK MENDAPATKAN ITEM YANG TERSCAN 
			$data['result3'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring where status=3 and location='$location'")->result(); 
			// INI QUERY UNTUK ITEM YANG BELUM TERSCAN
		}else if($location=='WH2'){
				$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring2 where status=1 and location='$location'")->result(); // INI QUERY UNTUK MENDAPATKAN ITEM YANG TERSCAN 
				$data['result3'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring2 where status=3 and location='$location'")->result(); 
				// INI QUERY UNTUK ITEM YANG BELUM TERSCAN
		}else if($location=='WH3'){
			$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring3 where status=1 and location='$location'")->result(); // INI QUERY UNTUK MENDAPATKAN ITEM YANG TERSCAN 
			$data['result3'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring3 where status=3 and location='$location'")->result(); 
			// INI QUERY UNTUK ITEM YANG BELUM TERSCAN
		}else if($location=='CHEM'){
			$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring_chem where status=1 and location='$location'")->result(); // INI QUERY UNTUK MENDAPATKAN ITEM YANG TERSCAN 
			$data['result3'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring_chem where status=3 and location='$location'")->result(); 
			// INI QUERY UNTUK ITEM YANG BELUM TERSCAN
		}else if($location=='WHSP3'){
			$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoringsp3 where status=1 and location='$location'")->result(); // INI QUERY UNTUK MENDAPATKAN ITEM YANG TERSCAN 
			$data['result3'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoringsp3 where status=3 and location='$location'")->result(); 
			// INI QUERY UNTUK ITEM YANG BELUM TERSCAN
		}else if($location=='WHSP3A'){
			$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoringsp3a where status=1 and location='$location'")->result(); // INI QUERY UNTUK MENDAPATKAN ITEM YANG TERSCAN 
			$data['result3'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoringsp3a where status=3 and location='$location'")->result(); 
			// INI QUERY UNTUK ITEM YANG BELUM TERSCAN
		}
		$data['location'] = $location;
		$this->load->view('monitoring/admin/index',$data);
	}

	public function view($item_number,$location)
	{
		$data['title'] = 'Management Stockopname';
		$data['location'] = $location;
		if ($location=='WH') {
          $location_id = 1203;
        } else if ($location=='WH2') {
          $location_id = 2201;
        } else if ($location=='WH3') {
          $location_id = 2301;
        }else if ($location=='WHSP3') {
          $location_id = 3341;
        }else if ($location=='WHSP3A') {
          $location_id = 3818;
        }
		$data['result'] = $this->dbtrxSo->query("SELECT * FROM trx_so_detail WHERE item_number=$item_number and location_id=$location_id and trx_so_id>739")->result();
		$this->load->view('monitoring/admin/view',$data);
		// echo json_encode($data);
	}


	public function ajax_edit($trx_so_id_detail,$location_id)
	{
		$data= $this->dbtrxSo->query("SELECT * FROM trx_so_detail WHERE trx_so_id_detail=$trx_so_id_detail and location_id=$location_id")->row();
		echo json_encode($data);
	}

	public function ajax_update()
	{
		$data = array(
				'trx_so_id_detail' => $this->input->post('trx_so_id_detail'),
				'location_id' => $this->input->post('location_id'),
				'item_number' => $this->input->post('item_number'),
				'qty' => $this->input->post('qty'),
				'note' => $this->input->post('note'),
			);
		// $this->person->update(array('id' => $this->input->post('id')), $data);
		// $this->dbInventory->where('trx_so_id_detail',$this->input->post('trx_so_id_detail'));
		// $this->dbInventory->where('location_id',$this->input->post('location_id'));
		// $this->dbInventory->where('item_number',$this->input->post('item_number'));

		$this->dbtrxSo->where('trx_so_id_detail',$this->input->post('trx_so_id_detail'));
		$this->dbtrxSo->where('location_id',$this->input->post('location_id'));
		$this->dbtrxSo->where('item_number',$this->input->post('item_number'));

		// $this->dbInventory->update('trx_so_detail',$data);
		$this->dbtrxSo->update('trx_so_detail',$data);
		echo json_encode(array("status" => TRUE));
		// echo json_encode(array("status" => TRUE,"data"=>$data));
	}

	public function ajax_delete($trx_so_id_detail)
    {
        // $this->person->delete_by_id($id);
		$this->dbtrxSo->where('trx_so_id_detail',$trx_so_id_detail);
		$this->dbtrxSo->delete('trx_so_detail');

        echo json_encode(array("status" => TRUE));
    }

}

/* End of file Admin.php */
/* Location: .//private/var/folders/yp/xfvdyfld3t1_9svqjkx0lgh80000gn/T/fz3temp-2/Admin.php */