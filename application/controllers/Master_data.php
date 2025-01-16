<?php
/**
* 
*/
class Master_data extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged')) {
			redirect('login');
		}

		$this->load->model('ModelMaster');
		$this->load->library('ajax');
		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
	}

	function infophp(){
		echo phpinfo();
	}

		private function set_barcodee($code)
		{
			// ob_clean();
			$this->load->library('Zend');
			$this->zend->load('Zend/Barcode');
			
			try {
				// echo $code;
				//header('Content-Type: image/png');
				Zend_Barcode::render('code128', 'image', ['text' => $code],[]);
			} catch (Exception $e) {
				echo 'Error: ' . $e->getMessage();
				exit;
			}
		
			exit;
		}

		public function get_barcodee($code)
		{
			$this->set_barcodee($code);
		}

	function barcode()
	{
		$data['content'] 	= 'master/v_barcode';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Barcode';
		$data['class'] 		= '';
		$this->load->view('v_home', $data);
	}

	function barcodelist()
	{
		$data = $this->ModelMaster->getDatatableBarcode();
		$this->ajax->send($data);
	}


    function get_barcode($item_number)
    {
        $barcodeItem = $this->dbMaximo->query("select * from VIEWITEM where ITEMNUM='$item_number'")->result();
        foreach ($barcodeItem as $value){
            $data['description']=$value->DESCRIPTION;
        }    
		
        $data['item_number']=$item_number;
		$this->load->view('master/print_barcode', $data);
    }

   

	function items()
	{
		$data['content'] 	= 'master/v_items';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Items';
		$data['class'] 		= '';
		$data['location'] 	= $this->dbInventory->query("select * from location");
		$this->load->view('v_home', $data);
	}

	function itemlist()
	{
		$data = $this->ModelMaster->getDatatableItem();
		$this->ajax->send($data);
	}

	function detail_item($item_number,$location_id,$condition_code,$binnum=NULL){
		$data['content'] 	= 'master/detail_item';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Items';
		$data['class'] 		= '';
		$binnum = urldecode($binnum);
		if($binnum==NULL){
			$detItem 			= $this->dbInventory->query("select * from item_balances where item_number = '$item_number' and  location_id = '$location_id' and conditioncode = '$condition_code' and binnum is NULL")->result();
		}else{
			$detItem 			= $this->dbInventory->query("select * from item_balances where item_number = '$item_number' and  location_id = '$location_id' and conditioncode = '$condition_code' and binnum='$binnum'")->result();
		}

		foreach ($detItem as $key => $value) {
			$data['condition_code'] = $value->conditioncode;
			$data['binnum'] = $value->binnum;
			$data['qty'] = $value->qty;
			$data['siteid'] = $value->siteid;
			$data['date'] = $value->date;
			$data['photo'] = $this->getItemPhoto($value->item_number);
			$data['location'] = $this->getLocationDesc($value->location_id);
			$data['item_number'] = $value->item_number;
			$data['location_id'] = $value->location_id;
		}

		// $data['listTransaction'] = $this->dbTrx->query("select * from trx_item_log, trx_item_code_data where trx_item_log.trx_code=trx_item_code_data.trx_code and trx_item_log.item_number = '$item_number' AND trx_item_log.location='$location_id' AND trx_item_log.conditioncode='$condition_code'  AND trx_item_log.binnum='$binnum'")->result();
		$data['listTransaction'] = $this->dbTrx->query("select * from trx_item_log, trx_item_code_data where trx_item_log.trx_code=trx_item_code_data.trx_code and trx_item_log.item_number = '$item_number' and  trx_item_log.location = '$location_id' and  trx_item_log.conditioncode = '$condition_code'")->result();
		$this->load->view('v_home', $data);

	}

    function getLocationDesc($location_id){
        $dataLocation=$this->dbInventory->query("select * from location where location_id='$location_id'")->result();
        return $dataLocation[0]->name;
    }


    function getItemPhoto($item_number){
        $dataPhoto=$this->dbInventory->query("select * from item_photo where item_number='$item_number'")->result();
        return $dataPhoto[0]->photo;
    }


    function makePhoto(){

        $datax=$this->dbInventory->query("select * from item_balances")->result();
        foreach ($datax as $value) {
        	$datay['item_number']=$value->item_number;
        	$datay['photo']=$value->item_number.".JPG";
        	$this->dbInventory->insert('item_photo',$datay);
        }

    }

	function getItemNumberMaximo($item_number){
		$detItemLog = $this->dbMaximo->query("select * from VIEWITEM where ITEMNUM = '$item_number'")->result();
		return $detItemLog[0];
	}

	function upload_items(){
		if($this->input->post('userSubmit')){
            
            //Check whether user upload picture
            if(!empty($_FILES['filefoto']['name'])){
                $config['upload_path'] = 'assets/uploads/items/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] =  $this->input->post('item_number');
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('filefoto')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];

				$session = array(
					'photo' 			=> $picture
					);
				$this->session->set_userdata($session);
                } else {
                    $picture = '';
                }
            } else {
                $picture = '';
            }

            $item_number = $this->input->post('item_number');
            $data['item_number'] =$this->input->post('item_number');
            $data['photo'] =$picture;

            $query = $this->dbInventory->query("select * from item_photo where item_number='$item_number'");
            if ($query->num_rows()>0) {
           	    $this->ModelMaster->uploadPhoto($item_number, $data);
            } else {
           		$this->ModelMaster->insert($data);
           	    // var_dump($data);
            }
            redirect('master-data/items/','refresh');
        }
	}

	
	function export_excel($item_number, $location_id, $conditioncode, $binnum){
		$query = $this->dbInventory->query("select * from item_balances where item_number = '$item_number' and  location_id = '$location_id' and  conditioncode = '$conditioncode' and binnum = '$binnum'")->result();
		foreach ($query as $row) {
			$data['item_number'] = $row->item_number;
			$data['photo'] = $this->getItemPhoto($row->item_number);
			$data['name'] =  $this->getLocationDesc($row->location_id);
			$data['conditioncode'] = $row->conditioncode;
			$data['binnum'] = $row->binnum;
			$data['site_id'] = $row->siteid;
			$data['qty'] = $row->qty;
		}

		$data['detailItemBook'] = $this->dbTrx->query("select * from trx_item_log, trx_item_code_data where trx_item_log.trx_code=trx_item_code_data.trx_code and trx_item_log.item_number = '$item_number' and  trx_item_log.location = '$location_id' and  trx_item_log.conditioncode = '$conditioncode'")->result();

		$this->load->view('master/r_detail_item', $data);
	}

	
	

	function commodity()
	{
		$data['content'] 	= 'master/v_commodity';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Commodity';
		$data['class'] 		= '';
		$data['query'] 		= $this->ModelMaster->getdatacommodity();
		$this->load->view('v_home', $data);
	}

	function location()
	{
		$data['content'] 	= 'master/v_location';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Location';
		$data['class'] 		= '';
		$this->load->view('v_home', $data);
	}

	function locationlist()
	{
		$data = $this->ModelMaster->getDatatableLocation();
		$this->ajax->send($data);
	}

	function measureunit()
	{
		$data['content'] 	= 'master/v_measureunit';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Measureunit';
		$data['class'] 		= '';
		$this->load->view('v_home', $data);
	}

	function measureunitlist()
	{
		$data = $this->ModelMaster->getDatatableMeasureunit();
		$this->ajax->send($data);
	}

	function companies()
	{
		$data['content'] 	= 'master/v_companies';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Companies';
		$data['class'] 		= '';
		$this->load->view('v_home', $data);
	}

	function companieslist()
	{
		$data = $this->ModelMaster->getDatatableCompanies();
		$this->ajax->send($data);
	}

	function test(){
		$data=$this->dbMaximo->query("SELECT * FROM VIEWITEM")->result();
		echo json_decode($data);
	}
	
}