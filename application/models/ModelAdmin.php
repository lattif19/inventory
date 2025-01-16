<?php
/**
* 
*/
class ModelAdmin extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
	}

    function getdata($key)
    {
        $this->dbInventory->where('user_id', $key);
        $hasil=$this->dbInventory->get('user');
        return $hasil;
    }

	function getdatauser()
	{
		$this->dbInventory->select('*');
		$this->dbInventory->from('user');
		$query = $this->dbInventory->get();
		return $query;
	}

	function insertdatauser($data)
	{
		$this->dbInventory->insert('user', $data);
	}

    function insertShipper($data){
        $this->dbInventory->insert('shipper', $data);
    }

    public function editDataUser($id)
    {
        $this->dbInventory->select ( '*' );
        $this->dbInventory->from ('user' );
        $this->dbInventory->where ('user.user_id', $id);
        $query = $this->dbInventory->get();
        return $query->result();
    }


	function updatedatauser($id, $displayname, $employetype, $email, $location, $status_date, $status,$username,$password,$level)
	{
		$data = array(
            'user_id' => $id,
            'displayname' => $displayname,
            'employetype' => $employetype,
            'email' => $email,
            'location_site' => $location,
            'status_date' => $status_date,
            'status' => $status,
            'username' => $username,
            'password' => $password,
            'level' => $level
            );
        $this->dbInventory->where('user_id', $id);
        $this->dbInventory->update('user', $data);
	}

    function updatepassword($id, $password)
    {
        $data = array(
            'user_id' => $id,
            'password' => $password
            );
        $this->dbInventory->where('user_id', $id);
        $this->dbInventory->update('user', $data);
    }

    function updateprofil($id, $name,$location, $employetype,$status_date, $department)
    {
        $data = array(
            'user_id' => $id,
            'displayname' => $name,
            'location_site' => $location, 
            'employetype' => $employetype,
            'status_date' => $status_date, 
            'department' => $department
            );
        $this->dbInventory->where('user_id', $id);
        $this->dbInventory->update('user', $data);
    }

	function deleteDataUser($key)
	{
		$this->dbInventory->where('user_id', $key);
        $this->dbInventory->delete('user');
	}

    function deleteDataShipper($key)
    {

        $this->dbInventory->where('shipper_id', $key);
        $this->dbInventory->delete('shipper');
    }

    function uploadfoto($id, $foto)
    {
        $data = array(
            'user_id' => $id,
            'foto' => $foto
            );
        $this->dbInventory->where('user_id', $id);
        $this->dbInventory->update('user', $data);
    }

    function updatePhotoShipper($shipper_id,$shipper_photo,$shipper_barcode,$name,$phone,$type,$company_id,$gender)
    {
        $data = array(
            'shipper_id' => $shipper_id,
            'shipper_photo' => $shipper_photo,
            'name' => $name,
            'phone' => $phone,
            'type' => $type,
            'company_id' => $company_id,
            'shipper_barcode' => $shipper_barcode,
            'gender' => $gender,
            );
        $this->dbInventory->where('shipper_id', $shipper_id);
        $this->dbInventory->update('shipper', $data);
    }

    function shipper()
    {
        $this->dbInventory->select('*');
        $this->dbInventory->from('shipper');
        $this->dbInventory->order_by('shipper_id');
        $query =$this->dbInventory->get();
        return $query->result();
    }

	function getDatatablePerson(){

        //We Need Column Index for Ordering
        $columns = array(
                0 =>'PERSONID', 
                1 => 'FIRSTNAME',
                2 =>'LASTNAME'
        );

        $totalData  = $this->dbMaximo->count_all('VIEWPERSON');
        $totalFiltered =  $totalData; 

        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->dbMaximo->start_cache();
        $this->dbMaximo->select($columns);
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value'];

                $this->dbMaximo->like('PERSONID', $search_value);
                $this->dbMaximo->or_like('FIRSTNAME', $search_value);
                $this->dbMaximo->or_like('LASTNAME', $search_value);
                $this->dbMaximo->stop_cache();

                $totalFiltered  = $this->dbMaximo->get('VIEWPERSON')->num_rows();
        }

        $this->dbMaximo->stop_cache();
        
        $this->dbMaximo->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
        $this->dbMaximo->limit($_REQUEST['length'], $_REQUEST['start']);

        $query = $this->dbMaximo->get('VIEWPERSON');

        //Reset Key Array
        $data = array();
        foreach ($query->result_array() as $val) {
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

    public function save_log($param)
    {
        $sql        = $this->db->insert_string('activity_log',$param);
        $ex         = $this->db->query($sql);
        return $this->db->affected_rows($sql);
    }
}