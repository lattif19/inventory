<?php 
/**
* 
*/
class Admin extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged')) {
			redirect('login');
		}

		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->load->model('ModelAdmin');
		$this->load->library(array('ajax','upload', 'excel'));
	}

	function index ()
	{
		$data['content'] =  'admin/v_data';
		$data['judul'] =  'Dashboard';
		$data['sub_judul'] =  'Admin';
		$data['class'] =  'admin';
		$data['class'] =  'right';
		$data['data']	= $this->dbInventory->query("select * from user order by user_id ASC")->result();
		// var_dump($data['data']);
		$this->load->view('v_home', $data);
	}

	function add()
	{
		$data['content'] =  'admin/add_data';
		$data['judul'] =  'Dashboard';
		$data['sub_judul'] =  'Add User';
		$data['class'] =  'admin';
		$data['class'] =  'right';
		///$data['data']	= $this->ModelAdmin->getdataadmin();

		helper_log('add', 'menambahkan data user');
		$this->load->view('v_home', $data);
	}

	function save()
	{
	
		$data = array(
			'user_id' 		=> $this->input->post('id'),
			'displayname' 	=> $this->input->post('displayname'),
			'employetype' 	=> $this->input->post('employetype'),
			'email' 		=> $this->input->post('email'),
			'location_site' => $this->input->post('location'),
			'status'		=> $this->input->post('status'),
			'status_date'	=> $this->input->post('status_date'),
			'username' 		=> $this->input->post('username'),
			'password' 		=> md5($this->input->post('password')),
			'level' 		=> $this->input->post('level')
		);
		$this->session->set_flashdata('info', 'Data Succes To Create User');
		$this->ModelAdmin->insertdatauser($data);
		redirect('admin');
		
	}

	public function edit($id = NULL)
	{
		if ($id != NULL) {
			$data['content'] 	= 'admin/edit_data';
			$data['judul']	 	= 'Dashboard';
			$data['sub_judul'] 	= 'Edit Data';
			$data['class'] 		= 'admin';
			$data['class']		= 'right';
			$data['data'] 		= $this->ModelAdmin->editDataUser($id);
			$this->load->view('v_home', $data);
		}
		else {
			redirect ('home');
		}
	}

	function update()
	{
		$key = $this->uri->segment(3);
		$this->dbInventory->where('user_id', $key);
		$query = $this->dbInventory->get('user');
		$data = $this->input->post();
		if(isset($data)) {
			$id 		= $data['id'];
			$displayname = $data['displayname'];
			$employetype = $data['employetype'];
			$email 		= $data['email'];
			$location 	= $data['location'];
			$status_date = $data['status_date'];
			$status 	= $data['status'];
			$username 	= $data['username'];
			$password 	= md5($data['password']);
			$level 		= $data['level'];
		$this->ModelAdmin->updatedatauser($id, $displayname, $employetype, $email, $location, $status_date, $status,$username,$password,$level);
		redirect('admin');
		}
	}

	function delete()
	{
		$key = $this->uri->segment(3);
		$this->dbInventory->where('user_id', $key);
		$query = $this->dbInventory->get('user');
		if($query->num_rows()>0)
		{
			$this->ModelAdmin->deleteDataUser($key);
		}
		redirect('admin');
	}

	function shipper()
	{
		$data['content'] 	=  'admin/v_shipper';
		$data['judul'] 		=  'Dashboard';
		$data['sub_judul'] 	=  'Admin';
		$data['class'] 		=  'admin';
		$data['class'] 		=  'Shipper';

		$dataShipper = $this->dbInventory->query("select * from shipper")->result();
		$data['dataShipper']=  $this->addArrayCompanyMaximo($dataShipper);

		// echo "<pre>";
		// var_dump($data['dataShipper']);
		$this->load->view('v_home', $data);
	}

	function getCompanyMaximo($dataShipper){
		$getCompany = $this->dbMaximo->query("select * from VIEWCOMPANIES where COMPANY = '$dataShipper'")->result();
		return $getCompany[0];

		// var_dump($getCompany);
	}

	function addArrayCompanyMaximo($dataShipper){
		$i =0;
		foreach ($dataShipper as $row) {
			$j = $i++;
			$dataShipper[$j]->NAME = $this->getCompanyMaximo($row->company_id)->NAME;
			$dataShipper[$j]->PHONE = $this->getCompanyMaximo($row->company_id)->PHONE;
			$dataShipper[$j]->COMPANY = $this->getCompanyMaximo($row->company_id)->COMPANY; 
		}
		return $dataShipper;

		// var_dump($dataShipper);
	}

	function shipper_add(){
		$data['content'] 	=  'admin/add_shipper';
		$data['judul'] 		=  'Dashboard';
		$data['sub_judul'] 	=  'Shipper';
		$data['class'] 		=  'admin';
		$data['class'] 		=  'Add Shipper';
		$data['datacompany']= $this->dbMaximo->query("select * from VIEWCOMPANIES");
		$this->load->view('v_home', $data);
	}

	function generate_barcodeShipper($type){
		if ($type==1) {
			return "1".str_pad($type, 0, 5, STR_PAD_LEFT).$this->lastShipperId();
		}
	}

	function lastShipperId(){
		$query = $this->dbInventory->query("select * from shipper order by shipper_id DESC")->result();
		// return $query[0]->shipper_id+1;
		echo $query[0]->shipper_id+1;
	}

	function shipper_save($type=NULL){
		if ($type==1) {
			return "1";
		} elseif ($type==2) {
			return "2";
		}


		$nmfile = "_".time(); //nama file saya beri nama langsung dan diikuti fungsi time
	    $config['upload_path'] = './assets/uploads/shipper/'; //path folder
	    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
	    $config['max_size'] = '2048'; //maksimum besar file 2M
	    $config['max_width']  = '1288'; //lebar maksimum 1288 px
	    $config['max_height']  = '768'; //tinggi maksimu 768 px
	    $config['file_name'] = $nmfile; //nama yang terupload nantinya


		$this->load->library('upload');
	    $this->upload->initialize($config);
		if ($this->upload->do_upload('shipper_photo'))
		{
			$data = $this->upload->data();
		    $data = array(
				'shipper_photo' => $data['file_name'],
				'name' 			=> $this->input->post('name'),
				'gender' 		=> $this->input->post('gender'),
				'type' 			=> $this->input->post('shippertype'),
				'company_id' 	=> $this->input->post('company'),
				'phone' 		=> $this->input->post('phone'),
				'shipper_barcode' => $this->input->post('shippertype').str_pad($type, 5, '0', STR_PAD_LEFT).$this->input->post('company').$this->lastShipperId()
		    );
		    $this->session->set_flashdata('info', 'data success to insert');
		    $this->ModelAdmin->insertShipper($data);
		  	// redirect('admin/shipper');
		 } else {
		 	$data = $this->upload->data();
		    $data = array(
				'name' 			=> $this->input->post('name'),
				'gender' 		=> $this->input->post('gender'),
				'type' 			=> $this->input->post('shippertype'),
				'company_id' 	=> $this->input->post('company'),
				'phone' 		=> $this->input->post('phone'),
				'shipper_barcode' => $this->input->post('shippertype').str_pad($type, 5, '0', STR_PAD_LEFT).$this->input->post('company').$this->lastShipperId()
		    );
		    $this->session->set_flashdata('info', 'data success to insert'); 
		    $this->ModelAdmin->insertShipper($data);

		}
		redirect('admin/shipper');
		// echo "<pre>";
		// var_dump($data);
		// echo "<br>";
		// var_dump($config);
	}

	function shipper_edit($shipper_id = NULL){
		if ($shipper_id != NULL) {
			$data['content'] 	= 'admin/edit_shipper';
			$data['judul']	 	= 'Dashboard';
			$data['sub_judul'] 	= 'Shipper';
			// $data['class'] 		= 'admin';
			// $data['class']		= 'right';
			$data['class'] 		= 'Edit Data Shipper';
			$data['dataShipper']= $this->dbInventory->query("select * from shipper where shipper_id = '$shipper_id'")->result();
			$data['tableCompany']= $this->dbMaximo->query("select * from VIEWCOMPANIES");

			$dataShipper = $this->dbInventory->query("select * from shipper where shipper_id = '$shipper_id'")->result();
			$data['company']=  $this->addArrayCompanyMaximo($dataShipper);			
			$this->load->view('v_home', $data);
		}
		else {
			redirect ('admin/shipper');
		}

		// var_dump($dataShipper);
	}

	function delete_shipper(){
		$key = $this->uri->segment(3);
		$this->dbInventory->where('shipper_id', $key);
		$query = $this->dbInventory->get('shipper');
		if($query->num_rows()>0)
		{
			$this->session->set_flashdata('info', 'Data success to delete');
			$this->ModelAdmin->deleteDataShipper($key);
		}
		redirect('admin/shipper');
	}

	function shipperUpdate(){
		$query = $this->dbInventory->query("select * from shipper order by shipper_id DESC")->result();
		return $query[0]->shipper_id;
	}

	function shipper_update(){
		if ($type==1) {
			return "1";
		} elseif ($type==2) {
			return "2";
		}

		if(!empty($_FILES['filefoto']['name'])){
            $config['upload_path'] = 'assets/uploads/shipper/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = $_FILES['filefoto']['name'];
                
            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
                
            if($this->upload->do_upload('filefoto')){
            	$uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];

			$session = array(
				'shipper_photo' 			=> $picture
				);
				// $this->session->set_userdata($session);
            } else {
            	$picture = '';
            	}
            } else {
                $picture = '';
            }
            $key = $this->uri->segment(3);
			$this->dbInventory->where('shipper_id', $key);
			$query = $this->dbInventory->get('shipper');
			$data = $this->input->post();
			if(isset($data)) {
				$shipper_id 	= $data['shipper_id'];
				$shipper_photo = $picture;
				$name 		= $data['name'];
				$phone 		= $data['phone'];
				$type 		= $data['type'];
				$shipper_barcode 		= $data['type'].str_pad($type, 5, '0', STR_PAD_LEFT).$data['company_id'].$this->shipperUpdate();
				$company_id	= $data['company_id'];
				$gender 	= $data['gender'];

			$this->ModelAdmin->updatePhotoShipper($shipper_id,$shipper_photo,$shipper_barcode,$name,$phone,$type,$company_id,$gender );
			$this->session->set_flashdata('info', "Data Succes To Update");
			redirect('admin/shipper');

			// var_dump($data);
			// echo "<pre>";
			// var_dump($config);
		}
	}

	

	function shipper_detail($shipper_id){
		$data['content'] 	= 'admin/v_shipper_detail';
		$data['judul']	 	= 'Dashboard';
		$data['sub_judul'] 	= 'Shipper';
		// $data['class'] 		= 'admin';
		// $data['class']		= 'right';
		$data['class'] 		= 'Shipper Detail';
		$detailShipper		= $this->dbInventory->query("select * from shipper where shipper_id = '$shipper_id'")->result();
		foreach ($detailShipper as $key => $value) {
			$data['shipper_barcode'] = $value->shipper_barcode;
			$data['name'] = $value->name;
			$data['gender'] = $value->gender;
			$data['phone'] = $value->phone;
			$data['type'] = $value->type;
			$data['foto'] = $value->shipper_photo;
		}
		// maximo detail
		$name1 = $this->addArrayCompanyMaximo($detailShipper);
		foreach ($name1 as $key => $value) {
			$data['name1'] = $value->NAME;
			$data['PHONE'] = $value->PHONE;
		}
		// echo "<pre>";
		// var_dump($data['name1']);
		$this->load->view('v_home', $data);
	}


	function print_shipper($shipper_barcode){
		$shipperBarcode = $this->dbInventory->query("select * from shipper where shipper_barcode = '$shipper_barcode'")->result();
		foreach ($shipperBarcode as $key => $value) {
       		$data['name']= $value->name;
		}
		$data['shipper_barcode'] = $shipper_barcode;
	
		$this->load->view('admin/print_shipper', $data);
	}

	private function set_barcodee($shipper_id)
    {
        $this->load->library('Zend');
        $this->zend->load('Zend/Barcode');
        //generate barcode
        Zend_Barcode::render('code128', 'image', array('text'=>$shipper_id), array());
    }

       public function get_barcodee($shipper_id)
    {
        $this->set_barcodee($shipper_id);
    }

	// function getCompanyName($shipper_id){
	// 	$getCompanyName = $this->dbMaximo->query("select * from VIEWCOMPANIES where COMPANY = '$shipper_id'")->result();
	// 	return $getCompanyName[0];
	// }

	// function getCompanyArray($detailShipper){
	// 	$i = 0;
	// 	foreach ($detailShipper as $key) {
	// 		$j = $i++;
	// 		$detailShipper[$j]->NAME = $this->getCompanyName($key->company_id)->NAME;
	// 		$detailShipper[$j]->PHONE = $this->getCompanyName($key->company_id)->PHONE; 
	// 	}
	// 	return $detailShipper;
	// 	// var_dump($detailShipper);
	// }


	function person(){
		$data['content'] 	=  'admin/v_person';
		$data['judul'] 		=  'Dashboard';
		$data['sub_judul'] 	=  'Admin';
		$data['class'] 		=  'admin';
		$data['class'] 		=  'person';
		$this->load->view('v_home', $data);
	}

	function personlist()
	{		
		$data = $this->ModelAdmin->getDatatablePerson();
		$this->ajax->send($data);
	}


	function coba(){
		$dataPerson=$this->dbMaximo->query("select * from VIEWPERSON")->result();
		foreach ($dataPerson as $key) {
			$data['username']=$key->PERSONID;
			$data['password']=md5($key->PERSONID);
			$data['displayname']=$key->DISPLAYNAME;
			$data['status']=$key->STATUS;
			$data['employetype'] = $key->EMPLOYEETYPE;
			$data['location_site']=$key->LOCATIONSITE;
			$data['status_date']=$key->STATUSDATE;
			$data['department']=$key->DEPARTMENT;
			$data['level']=2;

			$this->dbInventory->insert('user',$data);
		}
	}

	function profil()
	{
		$data['content'] 	=  'admin/v_profil';
		$data['judul'] 		=  'Dashboard';
		$data['sub_judul'] 	=  'Admin';
		$data['class'] 		=  'admin';
		$data['class'] 		=  'person';
		if ($this->session->userdata('logged') == TRUE) {
			$userid = $this->session->userdata('user_id');
			$query = $this->dbInventory->query("select * from user where user_id ='$userid'");
			foreach ($query->result() as $key => $value) {
				$data['user_id'] = $value->user_id;
				$data['name'] = $value->displayname;
				$data['email'] = $value->email;
				$data['location'] = $value->location_site;
				$data['password'] = $value->password;
				$data['status'] = $value->status;
				$data['status_date'] = $value->status_date;
				$data['employetype'] = $value->employetype;
				$data['foto'] = $value->foto;
				$data['department'] = $value->department;
			}
		}
		$this->load->view('v_home', $data);
	}

	function changepassword()
	{
		if ($this->session->userdata('logged') == TRUE) {
			$key = $this->uri->segment(3);
			$this->dbInventory->where('user_id', $key);
			$query = $this->dbInventory->get('user');
			$data = $this->input->post();
			if(isset($data)) {
				$id 		= $data['id'];
				$password 	= md5($data['newpassword']);
				
				$this->ModelAdmin->updatepassword($id, $password);
				$this->session->set_flashdata('info', 'Password Telah Diubah');
				redirect('admin/profil');
			}
		}
	}

	function update_profil(){
		if ($this->session->userdata('logged') == TRUE) {
			$key = $this->uri->segment(3);
			$this->dbInventory->where('user_id', $key);
			$query = $this->dbInventory->get('user');
			$data = $this->input->post();
			if(isset($data)) {
				$id 			= $data['id'];
				$name 			= $data['name'];
				$location		= $data['location'];
				$employetype 	= $data['employetype'];
				$status_date 	= $data['status_date'];
				$department 	= $data['department'];
				
				$this->ModelAdmin->updateprofil($id, $name,$location, $employetype,$status_date, $department);
				$this->session->set_flashdata('info', 'Data Has Been Changed');
				redirect('admin/profil');
			 // var_dump($data);
			}
		}
	}

	public function upload(){
         if($this->input->post('userSubmit')){
            
            //Check whether user upload picture
            if(!empty($_FILES['filefoto']['name'])){
                $config['upload_path'] = 'assets/uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['filefoto']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('filefoto')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];

				$session = array(
					'foto' 			=> $picture
					);
				$this->session->set_userdata($session);
                } else {
                    $picture = '';
                }
            } else {
                $picture = '';
            }
            //Prepare array of user data
            $data = array(
                $id = $this->input->post('id'),
                $foto = $picture
            );
            
            //Pass user data to model
            // $this->ModelAdmin->uploadfoto($id, $foto);
            
            // redirect('admin/profil','refresh');
            var_dump($data);
            var_dump($config);
        }
    }

	function downloadExcel()
    {
        $this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);

		//border
		$styleArray = array( 'borders' => 
			array( 'allborders' => 
				array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
					), 
				), 
			);
		//$this->excel->getActiveSheet()->getStyle(chr($col))->applyFromArray($styleArray);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('User');
       // $this->excel->getActiveSheet()->setName('User');
		$logo = 'assets/dist/img/logo.png'; // Provide path to your logo file
		//$this->excel->getActiveSheet()->setPath($logo);  //setOffsetY has no effect
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Download');
        $this->excel->getActiveSheet()->setCellValue('A4', 'S.No.');
        $this->excel->getActiveSheet()->setCellValue('B4', 'Username');
        $this->excel->getActiveSheet()->setCellValue('C4', 'Status');
        $this->excel->getActiveSheet()->setCellValue('D4', 'employetype');
        $this->excel->getActiveSheet()->setCellValue('E4', 'email');
        $this->excel->getActiveSheet()->setCellValue('F4', 'location_site');
        $this->excel->getActiveSheet()->setCellValue('G4', 'status_date');
        $this->excel->getActiveSheet()->setCellValue('H4', 'Level');
        $this->excel->getActiveSheet()->setCellValue('I4', 'password');
        $this->excel->getActiveSheet()->setCellValue('J4', 'foto');
        $this->excel->getActiveSheet()->setCellValue('K4', 'foto');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:K1');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       	for($col = ord('A'); $col <= ord('K'); $col++){ //set column dimension 
       	$this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
        //change the font size
        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
            //retrive contries table data
            $rs = $this->dbInventory->query('select * from user order by user_id asc');
            $exceldata="";
       		foreach ($rs->result_array() as $row){
            $exceldata[] = $row;

        }
            //Fill data
            $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
            $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
            //$this->excel->getActiveSheet()->getColumnDimension('A4')->setAutoSize(true);  
            $filename="user_".date('Y-m-d H-i-s').".xls"; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name

            header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');

 
    }

	function log_activities()
	{
		$data['content'] 	=  'admin/v_log_activity';
		$data['judul'] 		=  'Dashboard';
		$data['sub_judul'] 	=  'Admin';
		$data['class'] 		=  'Admin';
		$data['class'] 		=  'log';
		$data['data'] 		=  $this->dbInventory->query('select* from activity_log order by id asc');
		$this->load->view('v_home', $data);
	}

	function insert($tableName){
		$fieldsData = $this->dbInventory->field_data($tableName);
	    $datacc = array(); // you were setting this to a string to start with, which is bad
	    foreach ($fieldsData as $key => $field)
	    {
	        $datacc[ $field->name ] = $this->input->post($field->name);
	    }
	    $this->dbInventory->insert($tableName, $datacc);
	}
}