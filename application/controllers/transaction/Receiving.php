<?php
/**
* 
*/
class Receiving extends CI_Controller
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
		$this->dbSo = $this->load->database('trxSo', TRUE);
		$this->load->library('ajax');
	}

	function index()
	{
		$data['content'] 	= 'receiving/v_receiving';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Receiving PO';
		// $data['class'] 		= 'transaction';
		$data['class'] 		= '';
		// $data['query'] 		= $this->dbTrx->query("select * from trx_po order by trx_id desc");
		$this->load->view('v_home', $data);
	}

	function getReceivingData(){
		$data = $this->ModelReceiving->getDataTableReceiving();
		$this->ajax->send($data);
		// echo "<pre>";
		// var_dump($data);
	}

	function detailByTrxCode($trx_code)	{
		$trx_id=$this->dbTrx->query("select trx_id from trx_po where trx_code = '$trx_code'")->result();
		$this->detail($trx_id[0]->trx_id);
	}


	function detail($trx_id)
	{
		
		$data['content'] 	= 'receiving/detail_receiving';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Receiving';
		// $data['class'] 		= 'transaction';
		$data['class'] 		= 'Detail Receiving PO';

		$getDetailTrx 		= $this->dbTrx->query("select * from inventory.shipper, trx.trx_po where shipper.shipper_barcode = trx_po.shipper_id and trx_po.trx_id = '$trx_id'")->result();
		foreach ($getDetailTrx as $getdata) {
			$data['trx_code'] = $getdata->trx_code;
			$data['trx_timestamp'] = $getdata->trx_timestamp;
			$data['enterby'] = $getdata->enterby;
			$data['shipper'] = $getdata->name;
			$data['shipper_barcode'] = $getdata->shipper_barcode;
			$data['ipaddress'] = $getdata->ip_address;
			$data['ponum'] = $getdata->ponum;
		}

		$dataDetailPO 		= $this->dbMaximo->query("select * from VIEWPO where PONUM='".$getDetailTrx[0]->ponum."'")->result();
		foreach ($dataDetailPO as $po) {
			$data['desc'] = $po->DESCRIPTION;
			$data['date'] = $po->REQUIREDDATE;			
		} 

		$getCompanyPO 		= $this->dbMaximo->query("select * from VIEWCOMPANIES where COMPANY='".$getDetailTrx[0]->company_id."'")->result();
		foreach ($getCompanyPO as $company) {
			$data['company'] = $company->NAME;		
		}  
		
		$data['dataItem']= $this->dbTrx->query("select *, trx_po_detail.description as desc_detail from trx.trx_po_detail, inventory.location where trx_po_detail.trx_id='$trx_id' and location.location_id = trx_po_detail.location_id and trx_po_detail.trx_status=1")->result();
		// $dataItem= $this->dbTrx->query("select * from trx_po_detail where trx_id='$trx_id' and trx_status=1")->result();
		// $data['dataItem']	= $this->addArrayItemDetailMaximoToArrayItem($dataItem);

		$this->load->view('v_home', $data);


	}


	function tampil()
	{		
		$barcode = $this->input->post('barcode');
		$data['query'] 		= $this->dbInventory->query('select a.*, b.* from item_barcode as a, item as b where a.item_number = b.item_number');
		$this->load->view('receiving/tampil_data', $data);
	}

	function add()
	{
		//check stockopname
		if($this->checkIsItSO()){

			$data['content'] 	= 'receiving/stockopname';
			$data['judul'] 		= 'Dashboard';
			$data['sub_judul'] 	= 'Receiving';
			// $data['class'] 		= 'transaction';
			$data['class'] 		= 'Add Receiving PO';
			$data['dataCompany'] 	= $this->ModelReceiving->getdatacompanies();
			$data['month'] = date('m');
			$data['year'] = date('Y');
			$data['query1'] = $this->dbInventory->get('item_barcode');

		}else{

			$data['content'] 	= 'receiving/add_receiving';
			$data['judul'] 		= 'Dashboard';
			$data['sub_judul'] 	= 'Receiving';
			// $data['class'] 		= 'transaction';
			$data['class'] 		= 'Add Receiving PO';
			$data['dataCompany'] 	= $this->ModelReceiving->getdatacompanies();
			$data['month'] = date('m');
			$data['year'] = date('Y');
			$data['query1'] = $this->dbInventory->get('item_barcode');
			$autoPrint = $this->dbTrx->query('select * from trx_po, trx_po_detail where trx_po.trx_id = trx_po_detail.trx_id')->result();
			foreach ($autoPrint as $value) {
				$data['autoPrint'] = $value->trx_id;
			}
		}
		$this->load->view('v_home', $data);
	}


	function checkIsItSO(){
		$dataSo=$this->dbSo->query("select count(*) as hasil from so where so_location=1203 AND so_status=0")->row();
		if($dataSo->hasil>0){
			return 1;
		}else{
			return 0;
		}
	}

	function save()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);

		if(isset($_POST['dataPO'])){$dataPO=$_POST['dataPO'];}else{$dataPO=[];};

		//trxDB PO & company
		if(isset($dataPO['poNumber'])){
			$this->withPO($_POST);
		}
	}


	function withPO($POST){

		if(isset($POST['dataItem'])){$dataItem=$POST['dataItem'];}else{$dataItem=[];};
		if(isset($POST['dataPO'])){$dataPO=$POST['dataPO'];}else{$dataPO=[];};
		if(isset($POST['dataShipper'])){$dataShipper=$POST['dataShipper'];}else{$dataShipper=[];};

		//WITH PO
		$trxPo['company_id']=$dataPO['companyId'];
		$trxPo['ponum']=$dataPO['poNumber'];
		$trxPoDetail['ponum']=$dataPO['poNumber'];

		$trxPo['shipper_id']=$dataShipper['shipperId']."<br>";
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

		$dataMapping=[];
		$dataSuccess=[];

	    //trxDB item
		foreach ($dataItem as $item) {
			$trxPoDetail['trx_id']=$lastTrxId;
			$trxPoDetail['location_id']=$this->getLocationIdFromName('WH');
			$trxPoDetail['item_number']=$item['itemNumber'];
			$trxPoDetail['description']=$item['description'];
			$trxPoDetail['orderqty']=$item['orderqty'];
			$trxPoDetail['orderunit']=$item['orderunit'];
			$trxPoDetail['receivedqty']=$item['qty'];
			$trxPoDetail['trx_status']=1;//as success
			$trxPoDetail['receivedunit']=$item['orderunit'];

			//insert PO detail
			$this->dbTrx->insert("trx_po_detail",$trxPoDetail);

			$itemNumber=$trxPoDetail['item_number'];
			$location=$trxPoDetail['location_id'];
			$conditionCode="NEW-MATERIAL";
			$binnum=$this->getSuggestionBinnum($itemNumber,$this->getLocationNameFromId($location),$conditionCode);
			$qty=$item['qty'];
			$trx="Dr";
			$trxCode=1;
			$reff=$trxPo['trx_code'];
			$this->ModelCoreTrx->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff,$binnum);

			//as mapping : qyt < orderqty
			//PARSIAL
			// if($item['orderqty']!=999999999){
			// 	if($item['qty']<$item['orderqty']){
			// 		$trxWoDetail['trx_status']=0;//as parsial
			// 		$trxWoDetail['issuedqty']=$item['orderqty']-$item['qty'];
			// 		$this->dbTrx->insert("trx_wo_detail",$trxWoDetail);
			// 	}
			// }
		}



		$response['status']="success";
		$response['trxId']=$lastTrxId;
		echo json_encode($response);

	}	

	function getSuggestionBinnum($itemNumber,$location,$conditionCode){
		$itemDetailFromMaximo=$this->dbMaximo->query("select * from VIEWINVBALANCES where ITEMNUM = '$itemNumber' AND LOCATION = '$location' AND CONDITIONCODE = '$conditionCode'")->result();
		if(count($itemDetailFromMaximo)>0){
			return $itemDetailFromMaximo[0]->BINNUM;
		}else{
			$location=$this->getLocationIdFromName($location);
			$dataQty=$this->dbInventory->query("SELECT qty,binnum FROM item_balances where item_number='$itemNumber' AND location_id='$location' AND conditioncode='$conditionCode' AND qty>0")->row(); //search binnum that non 0

			if(isset($dataQty->qty)){
				return $dataQty->binnum;
			}else{
				$dataQty=$this->dbInventory->query("SELECT qty,binnum FROM item_balances where item_number='$itemNumber' AND location_id='$location' AND conditioncode='$conditionCode'")->row();
				if(isset($dataQty->qty)){
					return $dataQty->binnum;
				}else{
					return NULL;
				}
			}
		}
	}

	function countItemInPoLine($po){
		$query=$this->dbMaximo->query("SELECT * FROM VIEWPOLINE WHERE PONUM='$po'")->result();
		return count($query);
	}	

	function getLocationIdFromName($location_name){
		$getLocationId=$this->dbInventory->query("select location_id from location where name='$location_name'")->result();
		return $getLocationId[0]->location_id;
	}

	function getLocationNameFromId($location_id){
		$getLocationId=$this->dbInventory->query("select name from location where location_id='$location_id'")->result();
		return $getLocationId[0]->name;
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
	function getItem($item,$po){
		$item=explode("x",$item);
		if(count($item)==2){
			$itemNumber=ltrim($arrayItem['itemNumber']=$item[1], '0');
			$arrayItem['qty']=$item[0];
		}else{
			$itemNumber=ltrim($arrayItem['itemNumber']=$item[0], '0');
			$arrayItem['qty']=1;
		}
			$dbMaximo=$this->load->database('maximo',TRUE);
			$dataItem=$dbMaximo->query("select * from VIEWPOLINE where ITEMNUM='$itemNumber' AND PONUM='$po'")->result();

			$dataTotalQty=$dbMaximo->query("select sum(ORDERQTY) AS TOTALQTY from VIEWPOLINE where ITEMNUM='$itemNumber' AND PONUM='$po'")->row(); // untuk case 1 po 2 atau lebih item yang sama
			// echo $itemNumber;
			// var_dump($dataItem);
			if(count($dataItem)>0){
				$arrayItem['description']=$dataItem[0]->DESCRIPTION;
				$arrayItem['photo']=$this->getItemPhoto($arrayItem['itemNumber']);
				$arrayItem['orderunit']=$dataItem[0]->ORDERUNIT;
				$arrayItem['orderqty']=$dataTotalQty->TOTALQTY;
				$arrayItem['iteminpo']=count($dataItem);
			}else{
				$arrayItem=[];
			}
		echo json_encode($arrayItem);
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
			if($this->getSuggestionPO($dataPO[0]->PONUM)!=NULL){
				$arrayPO['trasactionBefore']=$this->getSuggestionPO($dataPO[0]->PONUM)->trx_id;
				$arrayPO['trasactionBeforeStatus']=$this->getSuggestionPO($dataPO[0]->PONUM)->trx_status;
			}
		}else{
			$arrayPO=[];
		}
		echo json_encode($arrayPO);
	}

	function getSuggestionPO($po){
			return NULL;
	}


	function getCompanyName($companyId){
		return $this->ModelReceiving->getCompanyName($companyId);
	}

	//TRX SHIPPER
	function getDataShipper($shipper_barcode,$companyId){
		$dataShipper=$this->dbInventory->query("select * from shipper where shipper_barcode=$shipper_barcode and company_id=$companyId and type=2")->result();
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

	function getTrxPo(){
		$date=date("Y-m-d");
		$data=$this->dbTrx->query("SELECT * FROM trx_po_detail WHERE timestamp='$date'")->result();
		var_dump($date);
	}

}
