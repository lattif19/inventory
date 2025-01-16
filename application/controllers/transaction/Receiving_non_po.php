<?php
/**
* 
*/
class Receiving_non_po extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged')) {
			redirect('login');
		}

		$this->load->model('ModelReceiving', 'kode');
		$this->load->model('ModelCoreTrx', '', TRUE);
		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
		$this->load->library('ajax');
	}

	function index()
	{
		$data['content'] 	= 'receiving_non_po/v_receiving';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Receiving PO';
		// $data['class'] 		= 'transaction';
		$data['class'] 		= '';
		$query 		= $this->dbTrx->query("SELECT * FROM trx_po_detail,trx_po where trx_po.trx_id=trx_po_detail.trx_id and trx_po_detail.trx_status!=1")->result(); // tidak sama dengan 1 (non po) tidak ditampilkan 
		//$query 		= $this->dbTrx->query("SELECT * FROM trx_po_detail,trx_po where trx_po.trx_id=trx_po_detail.trx_id and trx_po_detail.trx_status!=NULL")->result(); // tidak sama dengan 1 (non po) tidak ditampilkan 
		$data['query'] = $this->addArrayItemDetailMaximoToArrayItem($query);

		// autoPrint
		$autoPrint = $this->dbTrx->query('SELECT * FROM trx_po_detail,trx_po where trx_po.trx_id=trx_po_detail.trx_id and trx_po_detail.trx_status!=1')->result();
		foreach ($autoPrint as $value) {
			$data['autoPrint'] = $value->trx_id;
		}
		$this->load->view('v_home', $data);
		// var_dump($query);
	}

	function dataTable()
	{
		$data['content'] 	= 'receiving_non_po/tampil_data';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Receiving PO';
		// $data['class'] 		= 'transaction';
		$data['class'] 		= '';
		$this->load->view('v_home', $data);
	}

	function getReceivingData(){
		$data = $this->ModelReceiving->getDataTableReceivingNonPo();
		$this->ajax->send($data);
		// echo "<pre>";
		// var_dump($data);
	}


    function getCompanyName($companyId)
    {
        $result = $this->dbMaximo->query("SELECT * FROM VIEWCOMPANIES WHERE COMPANY=$companyId")->result();
        return $result[0]->NAME;
    }

	function detailByTrxCode($trx_code)	{
		$trx_id=$this->dbTrx->query("select trx_id from trx_po where trx_code = '$trx_code'")->result();
		$this->detail($trx_id[0]->trx_id);
	}


	function detail($trx_id)
	{
		$data['content'] 	= 'receiving_non_po/detail_receiving';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Mapping PO '.$trx_id;
		// $data['class'] 		= 'transaction';
		$data['class'] 		= 'Detail Mapping PO';

		$data['dataTrx']=$this->dbTrx->query("select * from inventory.shipper, trx.trx_po_detail,trx.trx_po where shipper.shipper_barcode=trx_po.shipper_id and trx_po.trx_id=trx_po_detail.trx_id and trx_po_detail.trx_detail_id=$trx_id ")->row();
		// $data['dataTrx'] = $this->addArrayItemDetailMaximoToArrayItem($dataTrx);

		$this->load->view('v_home', $data);
	}

	function searchPo($itemNumber,$poNumber){
		$data['orderQty']=10+$poNumber;
		echo json_encode($data); 
	}


	function getItemDetailFromMaximo($trx_id){
		$itemDetailFromMaximo=$this->dbMaximo->query("select * from VIEWITEM where ITEMNUM = '$trx_id'")->result();
		return $itemDetailFromMaximo[0];
	}

	function getLocationInventory($trx_id){
		$locationDetail=$this->dbInventory->query("select * from location where location_id = '$trx_id'")->result();
		return $locationDetail[0];
	}
	
	function getCompanyInventory($trx_id){
		$company=$this->dbMaximo->query("select * from VIEWCOMPANIES where COMPANY = '$trx_id'")->result();
		return $company[0];
	}

	function addArrayItemDetailMaximoToArrayItem($dataItemDescription){
		$i=0;
		foreach ($dataItemDescription as $key){
			$j=$i++;
			$dataItemDescription[$j]->NAME = $this->getCompanyInventory($key->company_id)->NAME;
		}
		return $dataItemDescription;
	}


	// function tampil()
	// {		
	// 	$barcode = $this->input->post('barcode');
	// 	$data['query'] 		= $this->dbInventory->query('select a.*, b.* from item_barcode as a, item as b where a.item_number = b.item_number');
	// 	$this->load->view('receiving_non_po/tampil_data', $data);
	// }

	function add()
	{
		$data['content'] 	= 'receiving_non_po/add_receiving';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Receiving';
		// $data['class'] 		= 'transaction';
		$data['class'] 		= 'Add Receiving PO';
		$data['dataCompany'] 	= $this->ModelReceiving->getdatacompanies();
		$data['month'] = date('m');
		$data['year'] = date('Y');
		$data['query1'] = $this->dbInventory->get('item_barcode');
		//}
		$this->load->view('v_home', $data);
	}

	function save()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);

		if(isset($_POST['dataItem'])){$dataItem=$_POST['dataItem'];}else{$dataItem=[];};
		if(isset($_POST['dataCompany'])){$dataCompany=$_POST['dataCompany'];}else{$dataCompany=[];};
		if(isset($_POST['dataShipper'])){$dataShipper=$_POST['dataShipper'];}else{$dataShipper=[];};


		// $trxPo['trx_status']=2;
		$trxPo['company_id']=$dataCompany['companyId'];

		$trxPo['shipper_id']=$dataShipper['shipperId'];
		$trxPo['trx_code']="RCPT".date('Y').date('m').$this->getLastTrxPoId();
		$trxPo['month']=date('m');
		$trxPo['year']=date('Y');
		$trxPo['receivingtype']="RECEIPT";
		$trxPo['enterby']=$this->session->userdata('username');
		$trxPo['ip_address']=$this->input->ip_address();
		$this->dbTrx->insert("trx_po",$trxPo);


		// get last id from trx_id
		$this->dbTrx->select_max('trx_id');
		$result= $this->dbTrx->get('trx_po')->row_array();
		$lastTrxId=$result['trx_id'];


	    //trxDB item
		foreach ($dataItem as $item) {
			$trxPoDetail['trx_id']=$lastTrxId;
			$trxPoDetail['location_id']=$this->getLocationIdFromName('WH');
			$trxPoDetail['item_number']=$item['itemNumber'];
			$trxPoDetail['description']=$item['description'];
			$trxPoDetail['orderqty']=$item['orderqty'];
			$trxPoDetail['orderunit']=$item['orderunit'];
			$trxPoDetail['receivedqty']=$item['qty'];
			$trxPoDetail['receivedunit']=$item['orderunit'];
			$trxPoDetail['trx_status']=2;//as non po

			//insert PO detail
			$this->dbTrx->insert("trx_po_detail",$trxPoDetail);

			$itemNumber=$trxPoDetail['item_number'];
			$location=$trxPoDetail['location_id'];
			$conditionCode="NEW-MATERIAL";
			$qty=$item['qty'];
			$trx="Dr";
			$trxCode=1;
			$reff=$trxPo['trx_code'];
			$this->ModelCoreTrx->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff);
		}


		$response['status']="success";
		$response['detail']="mapping";
		echo json_encode($response);
	}


	function saveTrx() //save trx mapping detail
	{
		$_POST = json_decode(file_get_contents('php://input'), true);

		if(isset($_POST['dataTrx'])){$dataTrx=$_POST['dataTrx'];}else{$dataTrx=[];};

		$trx_detail_id=$dataTrx['trx_detail_id'];
		$ponum=$dataTrx['poNumber'];
		$orderqty=(int)$dataTrx['orderQty'];
		$receivedqty=(int)$dataTrx['receiveQty'];
		$remainingqty=(int)$dataTrx['remainingQty'];

		$resultTrx=$this->dbTrx->query("SELECT * from trx_po_detail where trx_detail_id=$trx_detail_id")->result();

		foreach ($resultTrx as $key) {
			$data['item_number']=$key->item_number;
			$data['trx_id']=$key->trx_id;
			$data['description']=$key->description;
			$data['orderunit']=$key->orderunit;
			$data['receivedunit']=$key->receivedunit;
			$data['location_id']=$key->location_id;
		}



		if($remainingqty==0){
			$data['ponum']=$ponum;
			$data['orderqty']=$orderqty;
			$data['receivedqty']=$receivedqty;
			$data['trx_status']=1;
			$this->dbTrx->where('trx_detail_id',$dataTrx['trx_detail_id']);
			$this->dbTrx->update('trx_po_detail',$data);
		}else if($orderqty>$receivedqty){

			$data['trx_status']=1;
			$data['ponum']=$ponum;
			$data['orderqty']=$orderqty;
			$data['receivedqty']=$receivedqty;
			$this->dbTrx->where('trx_detail_id',$dataTrx['trx_detail_id']);
			$this->dbTrx->update('trx_po_detail',$data);

			$data['trx_status']=2;//non po
			$data['ponum']=NULL;
			$data['orderqty']=$orderqty;
			$data['receivedqty']=$orderqty-$receivedqty;
			$this->dbTrx->insert('trx_po_detail',$data);

		}



		$response['status']="success";
		echo json_encode($response);
	}



	function countItemInPoLine($po){
		$query=$this->dbMaximo->query("SELECT * FROM VIEWPOLINE WHERE PONUM='$po'")->result();
		return count($query);
	}	

	function getLocationIdFromName($location_name){
		$getLocationId=$this->dbInventory->query("select location_id from location where name='$location_name'")->result();
		return $getLocationId[0]->location_id;
	}

	function getLastTrxPoId(){
		$getTrxId=$this->dbTrx->query("select count(*) as jml from trx_po where month='".date('m')."'")->result();
		$trxId=(int)$getTrxId[0]->jml;
		$trxId=$trxId+1;
		return sprintf("%'.05d", $trxId);
	}	
	
	function getLastId(){
		$getTrxId=$this->dbTrx->query("select count(*) as jml from trx_po where month='".date('m')."'")->result();
		$trxId=(int)$getTrxId[0]->jml;
		$trxId=$trxId+1;
		return sprintf("%'.05d", $trxId);
	}




	// TRX BY ANGULAR

	//TRX ITEM
	//TRX ITEM
	function getItem($item,$po){
		$item=explode("x",$item);
		if(count($item)==2){
			$itemNumber=ltrim($arrayItem['itemNumber']=$item[1], '0');
			$arrayItem['qty']=$item[0];
		}else{
			$itemNumber=ltrim($arrayItem['itemNumber']=$item[0], '0');
			$arrayItem['qty']=1;
		}
		if($po!='undefined'){
			$dbMaximo=$this->load->database('maximo',TRUE);
			$dataItem=$dbMaximo->query("select * from VIEWPOLINE where ITEMNUM='$itemNumber' AND PONUM='$po'")->row();
			$dataTotalQty=$dbMaximo->query("select sum(ORDERQTY) AS TOTALQTY from VIEWPOLINE where ITEMNUM='$itemNumber' AND PONUM='$po'")->row(); // untuk case 1 po 2 atau lebih item yang sama
			// echo $itemNumber;
			// var_dump($dataItem);
			if(count($dataItem)>0){
				$arrayItem['description']=$dataItem->DESCRIPTION;
				$arrayItem['photo']=$this->getItemPhoto($arrayItem['itemNumber']);
				$arrayItem['orderunit']=$dataItem->ORDERUNIT;
				$arrayItem['orderqty']=$dataTotalQty->TOTALQTY;
				$arrayItem['remaining']=$this->getRemainingItem($itemNumber,$po);
			}else{
				$arrayItem=[];
			}
		}else{
			$dbMaximo=$this->load->database('maximo',TRUE);
			$dataItem=$dbMaximo->query("select * from VIEWITEM where ITEMNUM='$itemNumber'")->result();
			// echo $itemNumber;
			// var_dump($dataItem);
			if(count($dataItem)>0){
				$arrayItem['description']=$dataItem[0]->DESCRIPTION;
				$arrayItem['photo']=$this->getItemPhoto($arrayItem['itemNumber']);
				$arrayItem['orderqty']=1000000;
				$arrayItem['orderunit']=$dataItem[0]->ORDERUNIT;
			}else{
				$arrayItem=[];
			}
		}
		echo json_encode($arrayItem);
	}

	function getRemainingItem($item_number,$po){
		$result=$this->dbTrx->query("select sum(receivedqty) as qty from trx_po_detail where item_number=$item_number and ponum=$po and trx_status!=0")->row();
		return $result->qty;

	}


	function getItemPhoto($itemNumber){
		$dataItemPhoto=$this->dbInventory->query("select photo from item_photo where item_number=$itemNumber")->result();
		if(count($dataItemPhoto)>0){
			if($dataItemPhoto[0]->photo!=''){
				return $dataItemPhoto[0]->photo;
			}else{
				return "notavailable.jpg";
			}
		}else{
			return "notavailable.jpg";
		}
	}


	//TRX SHIPPER
	function getDataShipper($shipper_barcode,$companyId){
		$dataShipper=$this->dbInventory->query("select * from shipper where shipper_barcode=$shipper_barcode and company_id=$companyId")->result();
		if(count($dataShipper)>0){
			$arrayShipper['shipperId']=$dataShipper[0]->shipper_barcode;
			$arrayShipper['name']=$dataShipper[0]->name;
			$arrayShipper['photo']=$this->getShipperPhoto($shipper_barcode);
			$arrayShipper['departement']=$dataShipper[0]->company_id;
			$arrayShipper['shipper_type']=$this->getShipperType($dataShipper[0]->type);
		}else{
			$arrayShipper=[];
		}
		echo json_encode($arrayShipper);
	}


	function getShipperPhoto($shipper_barcode){
		$dataShipperPhoto=$this->dbInventory->query("select shipper_photo from shipper where shipper_barcode=$shipper_barcode")->result();
		if(count($dataShipperPhoto)>0){
			if($dataShipperPhoto[0]->shipper_photo!=''){
				return $dataShipperPhoto[0]->shipper_photo;
			}else{
				return "notavailable.png";
			}
		}else{
			return "notavailable.png";
		}
	}

	function getShipperType($type){
		if ($type==1) {
			return "INTERNAL";
		}else{
			return "EXTERNAL";
		}
	}

	function getDataTableReceivingNonPo(){
		$data = $this->ModelReceiving->getDataTableReceivingNonPo();
		echo "<pre>";
		var_dump($data);
	}




}
