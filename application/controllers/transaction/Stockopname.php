<?php
/**
* 
*/
class Stockopname extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged')) {
			redirect('login');
		}

		$this->dbSo 		= $this->load->database('trxSo', TRUE);
		$this->dbInventory 	= $this->load->database('default', TRUE);
		$this->dbTrx 		= $this->load->database('trx', TRUE);
		$this->dbMaximo 	= $this->load->database('maximo', TRUE);
		$this->load->model('ModelStockopname');
        $this->load->library('csvimport');

	}

	function index()
	{
		$data['content'] 	= 'stockopname/v_stockopname';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Stock Opname';
		// $data['class'] 		= 'transaction';
		$data['class'] 		= '';
		$data['query'] 		= '';
		$this->load->view('v_home', $data);
	}


	function add()
	{
		$data['content'] 	= 'stockopname/add_stockopname';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Stock Opname';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'Add Stock Opname';
		$data['query'] 		= '';
		$dbMaximo=$this->load->database('maximo',TRUE);
		$dataLocation=$dbMaximo->query("select * from VIEWLOCATIONS")->result();
		$dataIssueTo=$dbMaximo->query("select * from VIEWPERSON")->result();

		$data['dataLocation']=$dataLocation;
		$data['dataIssueTo']=$dataIssueTo;
		// var_dump($dataLocation);
		$this->load->view('v_home', $data);
	}



	function save()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);

		var_dump($_POST);

		$trxSo['id_so']="";
		$trxSo['trx_so_code']="SO".date('Y').date('m').date('d').$this->getLastTrxSoRtrnId();
		$trxSo['trx_so_month']=date('m');
		$trxSo['trx_so_year']=date('Y');
		$trxSo['trx_so_user']="rosikin";
		$trxSo['trx_so_user_login']="rosikin";
		$trxSo['location_id']="WH";
		$trxSo['trx_so_file']="WH";
		$trxSo['trx_so_type']="WH";
		// $trxSo['enterby']=$this->session->data('username');

		$this->dbSo->insert("trx_so",$trxSo);


		// // get last id from trx_id
		// $this->db->select_max('trx_id');
		// $result= $this->db->get('trx_po_return')->row_array();
		// $lastTrxId=$result['trx_id'];

		
	 //    //trxDB item
		// foreach ($dataItem as $item) {
		// 	$trxSoDetail['trx_id']=$lastTrxId;
		// 	$trxSoDetail['location_id']='WH';
		// 	$trxSoDetail['item_number']=$item['itemNumber'];
		// 	$trxSoDetail['issueqty']=$item['qty'];
		// 	$trxSoDetail['conditioncode']=$item['conditioncode'];
		// 	echo $trxSoDetail['issueunit']=$item['orderunit'];
		// 	$this->dbSo->insert("trx_po_detail_return",$trxSoDetail);

		// }


		// $response["message"]="Not blank";
		// $response["status"]="error";

		// echo json_encode($response);

	}

	function getLastTrxSoRtrnId(){
		$getTrxId=$this->dbSo->query("select count(*) as jml from trx_so where trx_so_month='".date('m')."'")->result();
		$trxId=(int)$getTrxId[0]->jml;
		$trxId=$trxId+1;
		return sprintf("%'.07d", $trxId);

	}




	// TRX BY ANGULAR

	//TRX ITEM
	function getItem($item){
		$item=explode("x",$item);
		if(count($item)==2){
			$itemNumber=$arrayItem['itemNumber']=$item[1];
			$arrayItem['qty']=$item[0];
		}else{
			$itemNumber=$arrayItem['itemNumber']=$item[0];
			$arrayItem['qty']=1;
		}
		$dbMaximo=$this->load->database('maximo',TRUE);
		$dataItem=$dbMaximo->query("select * from VIEWITEM where ITEMNUM='$itemNumber'")->result();
		// echo $itemNumber;
		// var_dump($dataItem);
		if(count($dataItem)>0){
			$arrayItem['description']=$dataItem[0]->DESCRIPTION;
			$arrayItem['pict']="cinta.jpg";
			$arrayItem['orderunit']=$dataItem[0]->ORDERUNIT;
		}else{
			$arrayItem=[];
		}
		echo json_encode($arrayItem);
	}

	//TRX PO

	function getDataPO($po){
		$dbMaximo=$this->load->database('maximo',TRUE);
		$dataPO=$dbMaximo->query("select * from VIEWPO where PONUM='$po'")->result();
		if(count($dataPO)>0){
			$arrayPO['poNumber']=$dataPO[0]->PONUM;
			$arrayPO['description']=$dataPO[0]->DESCRIPTION;
			$arrayPO['date']=$dataPO[0]->ORDERDATE;
			$arrayPO['companyId']=$dataPO[0]->VENDOR;
			$arrayPO['companyName']=$this->getCompanyName($dataPO[0]->VENDOR);
		// $arrayPO['trasactionBefore']="TRX123123123";
		}else{
			$arrayPO=[];
		}
		echo json_encode($arrayPO);
	}

	function getCompanyName($companyId){
		return $this->ModelReceiving->getCompanyName($companyId);
	}

	//TRX SHIPPER

	function getDataShipper($id){
		$dbMaximo=$this->load->database('maximo',TRUE);
		$dataShipper=$dbMaximo->query("select * from VIEWPERSON where PERSONUID='$id'")->result();
		if(count($dataShipper)>0){
			$arrayShipper['shipperId']=$dataShipper[0]->PERSONUID;
			$arrayShipper['name']=$dataShipper[0]->FIRSTNAME." ".$dataShipper[0]->LASTNAME;
			$arrayShipper['pict']="cinta.jpg";
			$arrayShipper['departement']=$dataShipper[0]->DEPARTMENT;
			// $arrayPO['trasactionBefore']="TRX123123123";
		}else{
			$arrayShipper=[];
		}
		echo json_encode($arrayShipper);
	}

	function periode()
	{
		$data['content'] 	= 'stockopname/v_periode_stockopname';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Stockopname';
		// $data['class'] 		= 'transaction';
		$data['class'] 		= 'Periode Stockopname';
		// $data['class'] 		= 'periode';
		$data['periodeSO'] 	= $this->dbSo->query("SELECT a.*, c.* FROM inventory.location a, stock_opname.so as c WHERE a.location_id = c.so_location")->result();

		// $dataItem= $this->dbSo->query("select * from trx_so")->result();
		// $data['dataItem']	= $this->getArrayItemStockopname($dataItem);

		// echo "<pre>";
		// var_dump($dataItem);

		$this->load->view('v_home', $data);
	}

	function dtLocation(){
		// WHSP3 = 3341
		// WHSP3A = 3818
		$dataLocation = $this->dbMaximo->query("SELECT * FROM LOCATIONS")->result();
		echo "<pre>";
		print_r($dataLocation);

	}
	
	function add_periode()
	{
		$data['content'] 	= 'stockopname/add_periode_stockopname';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Stockopname';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'stockopname1';
		$data['class'] 		= 'Add Periode Stockopname';
		$data['location'] 	= $this->ModelStockopname->getLocation();
		$this->load->view('v_home', $data);
	}

	function save_periode()
	{
		$data = array(
			'so_month' 		=> date('m'),
			'so_year' 		=> date('Y'),
			'so_name' 		=> $this->input->post('so_name'),
			'so_start_date' => $this->input->post('start_date'),
			'so_end_date' 	=> $this->input->post('end_date'),
			'so_note' 		=> $this->input->post('so_note'),
			'so_location' 	=> $this->input->post('location_id'),
			'so_status'		=> $this->input->post('so_status'),
			'so_date_posted'=> date('Y-m-d H:i:s'),
			'so_date_create'=> date('Y-m-d H:i:s'),
			'so_user_create'=> $this->session->userdata('username')
			);

		$this->ModelStockopname->insert($data);
		redirect('transaction/stockopname/periode','refresh');
	}

	function detail_periode($id_so){
		$data['content'] 	= 'stockopname/detail_periode';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Stockopname';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'stockopname1';
		$data['class'] 		= 'Detail Periode Stockopname';
		$data['detailPeriode'] = $this->dbSo->query("select * from so where so.id_so = trx_so.id_so and so.id_so = '$id_so'");
		// var_dump($dataPeriode);
		$this->load->view('v_home', $data);
	}

	function update($id_so)
	{
		$data['content'] 	= 'stockopname/update_periode';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Stockopname';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'stockopname1';
		$data['class'] 		= 'Update Periode Stockopname';
		$periode 	= $this->dbSo->query("select * from stock_opname.so, inventory.location where location.location_id=so.so_location and so.id_so='$id_so'")->result();
		// $dataPeriode= $this->ModelStockopname->listPeriode($id_so);
		foreach ($periode as $key => $value) {
			// foreach ($dataPeriode as $key => $value) {
				$data['id_so'] = $value->id_so;
				$data['so_name'] = $value->so_name;
				$data['so_start_date'] = $value->so_start_date;
				$data['so_end_date'] = $value->so_end_date;
				$data['so_note'] = $value->so_note;
				$data['name'] = $value->name;
				$data['so_location'] = $value->so_location;
			// }
		}
		// var_dump($dataPeriode);
		$this->load->view('v_home', $data);
	}

	function update_periode(){
		$key = $this->uri->segment(3);
		$this->dbSo->where('id_so', $key);
		$query = $this->dbSo->query('select * from so')->result();
		$data = $this->input->post();
		if(isset($data)) {
			$id_so		= $data['id_so'];
			$so_status 	= $data['so_status'];

			$this->ModelStockopname->updateDetailPeriode($id_so, $so_status);
			if ($so_status == "2") {
				$id_so		= $data['id_so'];
				$this->insertItemSo($id_so);
			}
			// var_dump($data);
			redirect('transaction/stockopname/periode');
		}

	}

	function insertItemSo($id_so){
		$dataSo=$this->dbSo->query("select * from trx_so as a, trx_so_detail as c where a.trx_so_id = c.trx_so_id and a.trx_so_id ='$id_so'")->result();
		foreach ($dataSo as $so) {
			$data['id_so']=$so->id_so;
			$data['item_number']=ltrim($so->item_number, '0');
			$data['issue_unit']=$so->issue_unit;
			$data['location_id']=$so->location_id;
			$data['condition_code']=$so->condition_code;
			$data['qty_so']=$so->qty;
			$data['qty_system']=$this->getBalancesItem($data['item_number'], $data['location_id'], $data['condition_code']);
			$data['qty_diff']= $so->qty - $data['qty_system'];
			$data['status_adjus']= 0;
			$data['updated_by']=$this->session->userdata('username');

			$this->dbSo->insert('so_detail_summary', $data);		
		}

	// 	// var_dump($this->getBalancesItem($data['item_number'], $data['location_id'], $data['condition_code']));
	}

	function getBalancesItem($item_number, $location_id, $condition_code){
		$qtyItemBalance = $this->dbInventory->query("select qty from item_balances where item_number ='$item_number' and location_id='$location_id' and conditioncode='$condition_code'")->row();

		if (count($qtyItemBalance)>0) {
			return $qtyItemBalance->qty;
		} else {
			return 0;
		}
	}

	function list_stockopname()
	{
		$data['content'] 	= 'stockopname/v_list_stockopname';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Stock Opname';
		$data['class'] 		= 'List Stockopname';
		// $data['class'] 		= 'stockopname1';
		// $data['class'] 		= 'stockopname2';
		$data['getStockopname']	= $this->ModelStockopname->listStockopname();

		// $dataItem= $this->dbSo->query("select * from trx_so")->result();
		// $data['dataItem']	= $this->getArrayItemStockopname($dataItem);

		// echo "<pre>";
		// var_dump($data['getStockopname']);
		$this->load->view('v_home', $data);
	}

	// function abc() {
	// 	$data = $this->dbSo->query("SELECT a.*, b.* FROM inventory.location a, stock_opname.trx_so b WHERE a.location_id = b.location_id")->result();
	// 	echo "<pre>";
	// 	var_dump($data);
	// }

	function getLocation($trx_so_id){
		$getItemLocation = $this->dbInventory->query("select * from location where location_id = '$trx_so_id'")->result();
		return $getItemLocation[0];

		// echo $getLocation[0]->name;
		// var_dump($getLocation);
	}

	function getArrayItemStockopname($itemDesc){
		$i=0;
		foreach ($itemDesc as $key){
			$j=$i++;
			$itemDesc[$j]->name = $this->getLocation($key->location_id)->name;
		}
		return $itemDesc;
	}

	function detail_stockopname($trx_so_id)
	{
		$data['content'] 	= 'stockopname/v_det_stockopname';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Stockopname';
		$data['class'] 		= 'Detail Item Stockopname';
		// $data['class'] 		= 'stockopname1';
		// $data['class'] 		= 'stockopname2';
		$detail_stockopname	= $this->dbSo->query("select * from trx_so where trx_so_id = '$trx_so_id'")->result();
			foreach ($detail_stockopname as $detail) {
			$data['trx_so_id'] = $detail->trx_so_id;
			$data['trx_so_code'] = $detail->trx_so_code;
			$data['trx_so_date'] = $detail->trx_so_date;
			$data['trx_so_user'] = $detail->trx_so_user;
			}
		
		// $data['itemSO'] 	= $this->ModelStockopname->itemStockopname($trx_so_id);	

		$itemSO= $this->ModelStockopname->itemStockopname($trx_so_id);
		$data['itemSO']	= $this->addArrayItemDetailMaximoToArrayItem($itemSO);
		

		// echo "<pre>";
		// var_dump($detail_stockopname);
		// echo "</pre>";
		// var_dump($data['itemSO']);
		$this->load->view('v_home', $data);
	}

	function getItemDetailFromMaximo($trx_so_id) {
		$getItemDescMaximo = $this->dbMaximo->query("select * from VIEWITEM where ITEMNUM = '$trx_so_id'")->result();
		return $getItemDescMaximo[0];
	}

	function addArrayItemDetailMaximoToArrayItem($dataItemDescription){
		$i=0;
		foreach ($dataItemDescription as $key){
			$j=$i++;
			$dataItemDescription[$j]->DESCRIPTION = $this->getItemDetailFromMaximo($key->item_number)->DESCRIPTION;
			$dataItemDescription[$j]->COMMODITYGROUP = $this->getItemDetailFromMaximo($key->item_number)->COMMODITYGROUP;
			// $dataItemDescription[$j]->name = $this->getLocationInventory($key->location_id)->name;
		}
		return $dataItemDescription;
	}



	function upload()
	{
		$data['content'] 	= 'stockopname/upload_csv';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Stockopname';
		$data['class'] 		= 'Upload CSV';
		// $data['class'] 		= 'stockopname1';
		// $data['class'] 		= 'stockopname2';
		$this->load->view('v_home', $data);
	}

	function saveCSV()
	{
		$data['error'] = '';    //initialize image upload error array to empty
 
        $config['upload_path'] = 'assets/uploads/file/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '2000';
 
        $this->load->library('upload', $config);
 
 
        // If upload failed, display error
        
        if ( ! $this->upload->do_upload()){
        	$data['error'] 		= $this->upload->display_errors();
        	$data = array(
        		'content' 	=> 'stockopname/upload_csv',
        		'judul' 	=> 'Dashboard',
        		'sub_judul' => 'Stockopname',
        		'class' 	=> 'Upload CSV', 
        		// 'class' 	=> 'stockopname1', 
        		// 'class' 	=> 'stockopname1'
        		);
        	$this->session->set_flashdata('info', 'Error Upload Data CSV Successfull');
			$this->load->view('v_home', $data);
        } else{
        	$file_data = $this->upload->data();
            $file_path =  'assets/uploads/file/'.$file_data['file_name'];
 
            $this->session->set_flashdata('info', 'Upload Data CSV Successfull');
			$data =$this->ModelStockopname->insertCSV();
			// echo "<pre>";
			// var_dump($data);
			// echo "</pre>";
            redirect('transaction/stockopname/upload');
        }
	}

	function download_detail_stockopname($trx_so_id){
		$itemSO= $this->ModelStockopname->itemStockopname($trx_so_id);
		$data['dataStockopname']	= $this->addArrayItemDetailMaximoToArrayItem($itemSO);

		$this->load->view('stockopname/export_excel_stockopname', $data);
	}

	function whNameToId($whName){
		$query=$this->dbInventory->query("Select * From location where name='$whName'")->result();
		echo $query[0]->location_id;
	}

	function searchIdSo($date,$location_id){
		$query =$this->dbSo->query("select * from so where so_location='$location_id' and so_start_date<='$date' and so_end_date>='$date'")->result();
		echo $query[0]->id_so;
	}

	function parseDate($date)
	{
		$year=substr($date,0,4);
		$month=substr($date,4,2);
		$day=substr($date,6,2);
		echo  $year."-".$month."-".$day;
	}

	function getLastTrxSoId($trx_so_id){
		$query = $this->dbSo->query("select * from trx_so where trx_so_id = '$trx_so_id'");
		var_dump($query->result());
	}



}