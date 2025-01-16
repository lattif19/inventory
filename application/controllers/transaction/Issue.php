<?php
/**
* 
*/
class Issue extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged')) {
			redirect('login');
		}

		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbSo = $this->load->database('trxSo', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
		// $this->dbMaximoDummy = $this->load->database('maximodummy', TRUE);
		$this->load->library('ajax');
		$this->load->model('Model_Issue');
		$this->load->model('ModelCoreTrx', '', TRUE);
	}

	function index()
	{
		$data['content'] 	= 'issue/v_issue';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Issue WO';
		// $data['class'] 		= 'transaction';
		$data['class'] 		= '';
		$this->load->view('v_home', $data);
	}

	function getIssueData(){
		$data = $this->Model_Issue->getDataTableIssue();
		$this->ajax->send($data);
	}

	function detailByTrxCode($trx_code)	{
		$trx_id=$this->dbTrx->query("select trx_id from trx_wo where trx_code = '$trx_code'")->result();
		$this->detail($trx_id[0]->trx_id);
	}

	function detail($trx_id)
	{
		$data['content'] 	= 'issue/detail_issue';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Issue WO';
		// $data['class'] 		= 'transaction';
		$data['class'] 		= 'Detail Issue WO';

		//getDetail
		$getDetailTrx 		= $this->dbTrx->query("select * from inventory.shipper, trx.trx_wo where shipper.shipper_barcode = trx_wo.shipper_id and trx_wo.trx_id = '$trx_id'")->result();
		foreach ($getDetailTrx as $getdata) {
			$data['trx_code'] = $getdata->trx_code;
			$data['trx_timestamp'] = $getdata->trx_timestamp;
			$data['enterby'] = $getdata->enterby;
			$data['shipper_name'] = $getdata->name;
			$data['shipper_barcode'] = $getdata->shipper_barcode;
			$data['ipaddress'] = $getdata->ip_address;
			$data['issue_to'] = $getdata->issueto;
			$data['wonum'] = $getdata->wonum;
		}

		//getDesctiptionDetail
		$getDetailWO 		= $this->dbMaximo->query("select * from VIEWWORKORDER where WONUM='".$getDetailTrx[0]->wonum."'")->result();
		foreach ($getDetailWO as $wo) {
			$data['desc'] = $wo->DESCRIPTION;
			$data['date'] = $wo->STATUSDATE;
		}

		// getCompanyDetail
		$getDetailCompany 	= $this->dbMaximo->query("select * from VIEWCOMPANIES where COMPANY='".$getDetailTrx[0]->company_id."'")->result();
		foreach ($getDetailCompany as $company) {
			$data['company'] = $company->NAME;
		}    

		$dataItem = $this->dbTrx->query("select * from trx_wo_detail where trx_id = '$trx_id' and trx_status=1")->result();
		$data['dataItem']=$this->addArrayItemDetailMaximoToArrayItem($dataItem);


		$this->load->view('v_home', $data);

	}

	function getDataItemFromMaximo($trx_id)
	{
		$itemDataIssue = $this->dbMaximo->query("select * from VIEWITEM where ITEMNUM ='$trx_id'")->result();
		return $itemDataIssue[0];
	}

	function getDataLocation($location)
	{
		$getLocation = $this->dbInventory->query("select * from location where location_id ='$location' and type='STOREROOM'")->result();
		return $getLocation[0];
	}

	function addArrayItemDetailMaximoToArrayItem($dataItemDescription){
		$i=0;
		foreach ($dataItemDescription as $key){
			$j=$i++;
			$dataItemDescription[$j]->DESCRIPTION = $this->getDataItemFromMaximo($key->item_number)->DESCRIPTION;
			$dataItemDescription[$j]->name = $this->getDataLocation($key->location_id)->name;
		}
		return $dataItemDescription;
	}


	function add()
	{
		$data['content'] 	= 'issue/add_issue';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Detail Issue WO';
		$data['class'] 		= 'Add Issue WO';
		// $data['class'] 		= 'issue';


		$dbMaximo=$this->load->database('maximo',TRUE);
		$dataLocation=$this->dbInventory->query("select * from location where type='STOREROOM' order by name asc")->result();
		$dataIssueTo=$dbMaximo->query("select * from VIEWMAXUSER")->result();


		$autoPrint = $this->dbTrx->query('select * from trx_wo, trx_wo_detail where trx_wo.trx_id = trx_wo_detail.trx_id')->result();
		foreach ($autoPrint as $value) {
			$data['autoPrint'] = $value->trx_id;
		}
		$data['dataLocation']=$dataLocation;
		$data['dataIssueTo']=$dataIssueTo;
		$this->load->view('v_home', $data);
	}


	// TRX BY ANGULAR


	//TRX CEK BALANCE
	function getQty($itemNumber,$locationId,$conditionCode){
		//CEK LOKASI APAKAH SO
			$dataQty=$this->dbInventory->query("SELECT qty,binnum FROM item_balances where item_number='$itemNumber' AND location_id='$locationId' AND conditioncode='$conditionCode' AND qty>0")->row(); //search binnum that non 0

			if(isset($dataQty->qty)){
				$data['qty']=(int)$dataQty->qty;
				$data['so']=false;
				$data['binnum']=$dataQty->binnum;
			}else{
				$dataQty=$this->dbInventory->query("SELECT qty,binnum FROM item_balances where item_number='$itemNumber' AND location_id='$locationId' AND conditioncode='$conditionCode'")->row();
				if(isset($dataQty->qty)){
					$data['qty']=(int)$dataQty->qty;
					$data['so']=false;
					$data['binnum']=$dataQty->binnum;
				}else{
					$data['qty']=0;
					$data['binnum']=NULL;
					$data['so']=false;
				}
			}


			if($this->checkIsItSO($locationId)==0){
				$data['so']=false;
				echo json_encode($data);
			}else{
				$data['so']=true;
				echo json_encode($data);
			}
		}

		function checkIsItSO($locationId){
			$dataSo=$this->dbSo->query("select count(*) as hasil from so where so_location='$locationId' and so_status=0")->row();
			if($dataSo->hasil>0){
				return 1;
			}else{
				return 0;
			}
		}

	//TRX ITEM
		function getItem($item,$wo){
			$item=explode("x",$item);
			if(count($item)==2){
				$itemNumber=$arrayItem['itemNumber']=ltrim($item[1], '0');
				$arrayItem['qty']=$item[0];
				$qty=$arrayItem['qty'];
				
			}else{
				$itemNumber=$arrayItem['itemNumber']=ltrim($item[0], '0');
				$arrayItem['qty']=1;
				$qty=$arrayItem['qty'];
			}


			$dataItem=$this->dbMaximo->query("select * from VIEWINVRESERVE where ITEMNUM='$itemNumber' AND WONUM='$wo' AND RESERVEDQTY='$qty' ORDER BY REQUESTEDDATE DESC")->result();
			if(count($dataItem)>0){
				$arrayItem['orderqty']=$dataItem[0]->RESERVEDQTY;
				$arrayItem['description']=$dataItem[0]->DESCRIPTION;
				$arrayItem['photo']=$this->getItemPhoto($itemNumber);
				$arrayItem['orderunit']=$this->getItemUnit($itemNumber);
				$arrayItem['issuedunit']=$arrayItem['orderunit'];
				$arrayItem['balance']='';
				$arrayItem['from']='invreserve';


		}else{ //cari di wp-material
			$dataItem=$this->dbMaximo->query("select * from VIEWWPMATERIAL where ITEMNUM='$itemNumber' AND WONUM='$wo'")->result();
			if(count($dataItem)>0){ //cek apakah available di reserve
				$arrayItem['orderqty']=$dataItem[0]->ITEMQTY;
				$arrayItem['description']=$dataItem[0]->DESCRIPTION;
				$arrayItem['photo']=$this->getItemPhoto($itemNumber);
				$arrayItem['orderunit']=$this->getItemUnit($itemNumber);
				$arrayItem['issuedunit']=$arrayItem['orderunit'];
				$arrayItem['balance']='';
				$arrayItem['from']='wpmaterial';
				}else{ //cari di item
					$dataItem=$this->dbMaximo->query("select * from VIEWITEM where ITEMNUM='$itemNumber'")->result();
					if(count($dataItem)>0){ 
						$itemNumber=$dataItem[0]->ITEMNUM;
						$arrayItem['description']=$dataItem[0]->DESCRIPTION;
						$arrayItem['photo']=$this->getItemPhoto($itemNumber);
						$arrayItem['orderunit']=$this->getItemUnit($itemNumber);
						$arrayItem['issuedunit']=$arrayItem['orderunit'];
						$arrayItem['orderqty']=999999999;//dummyqty
						$arrayItem['balance']='';
					}else{
					$arrayItem=[];
					}
				}
			}


		// echo $itemNumber;
		// var_dump($dataItem);


		echo json_encode($arrayItem);
	}

	function getBinnum($item_number,$location_id,$conditioncode){
		$dataBinnum=$this->dbInventory->query("select binnum from item_balances where item_number=$item_number and location_id=$location_id and conditioncode='$conditioncode'")->result();
		return $dataBinnum[0]->binnum;
	}

	function getItemUnit($itemNumber){
		$dataWO=$this->dbMaximo->query("select * from VIEWITEM where ITEMNUM='$itemNumber'")->result();
		return $dataWO[0]->ORDERUNIT;
	}


	function getItemPhoto($itemNumber){
		$dataItemPhoto=$this->dbInventory->query("select photo from item_photo where item_number=$itemNumber")->result();
		if(count($dataItemPhoto)>0){
			if($dataItemPhoto[0]->photo!=''){
				return $dataItemPhoto[0]->photo;
			}else{
				return "notavailable.png";
			}
		}else{
			return "notavailable.png";
		}
	}

	//TRX WO

	public function getDataWO($wo){
		$dbMaximo=$this->load->database('maximo',TRUE);
		$dataWO=$dbMaximo->query("SELECT * FROM VIEWWORKORDER WHERE WONUM='$wo'")->result();
		if(count($dataWO)>0){
			$arrayWO['woNumber']=$dataWO[0]->WONUM;
			$arrayWO['description']=$dataWO[0]->DESCRIPTION;
			$arrayWO['status']=$dataWO[0]->STATUS;
			$arrayWO['statusDate']=$dataWO[0]->STATUSDATE;
		// $arrayWO['trasactionBefore']="TRX123123123";
		}else{
			$arrayWO=[];
		}
		echo json_encode($arrayWO);
	}

	function getCompanyName($companyId){
		return $this->ModelReceiving->getCompanyName($companyId);
	}

	//TRX SHIPPER
	function getDataShipper($shipper_barcode){
		$dataShipper=$this->dbInventory->query("select * from shipper where shipper_barcode=$shipper_barcode AND type=1")->result();
		if(count($dataShipper)>0){
			$arrayShipper['shipperId']=$dataShipper[0]->shipper_barcode;
			$arrayShipper['name']=$dataShipper[0]->name;
			$arrayShipper['photo']=$this->getShipperPhoto($shipper_barcode);
			$arrayShipper['departement']=$this->getCompanyName($dataShipper[0]->company_id);
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




	//TRX ISSUE TO
	function getDataIssueTo($id){
		$dbMaximo=$this->load->database('maximo',TRUE);
		$dataIssueTo=$dbMaximo->query("select * from VIEWMAXUSER where USERID='$id'")->result();
		if(count($dataIssueTo)>0){
			$arrayIssueTo['issueToId']=$dataIssueTo[0]->USERID;
			$arrayIssueTo['name']=$dataIssueTo[0]->USERID;
			$arrayIssueTo['photo']=$this->getIssueToPhoto();
			$arrayIssueTo['department']='';
			// $arrayPO['trasactionBefore']="TRX123123123";
		}else{
			$arrayIssueTo=[];
		}
		echo json_encode($arrayIssueTo);
	}


	function getIssueToPhoto(){
		return 'notavailable.png';
	}



	function save()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);

		$dataIssueTo=$_POST['dataIssueTo'];
		$dataItem=$_POST['dataItem'];
		$dataShipper=$_POST['dataShipper'];
		$dataWO=$_POST['dataWO'];

		// trx WO
		$trxWo['wonum']=$dataWO['woNumber'];
		$trxWo['shipper_id']=$dataShipper['shipperId'];
		$trxWo['issueto']=$dataIssueTo['issueToId'];
		$trxWo['trx_code']="ISSUE".date('Y').date('m').$this->getLastTrxWoId();
		$trxWo['month']=date('m');
		$trxWo['year']=date('Y');
		$trxWo['enterby']=$this->session->userdata('username');
		$trxWo['ip_address']=$this->input->ip_address();

		$this->dbTrx->insert("trx_wo",$trxWo);


		// get last id from trx_id
		$this->dbTrx->select_max('trx_id');
		$result= $this->dbTrx->get('trx_wo')->row_array();
		$lastTrxId=$result['trx_id'];



		$dataMapping=[];
		$dataSuccess=[];
	    // trx item

		foreach ($dataItem as $item) {
			if($item['so']==1){
				$trxWoDetail['trx_status']=4;//as so
			}else{
				$trxWoDetail['trx_status']=1;//as success
			}
			$trxWoDetail['trx_id']=$lastTrxId;
			$trxWoDetail['wonum']=$dataWO['woNumber'];
			$trxWoDetail['location_id']=$item['location_id'];
			$trxWoDetail['item_number']=$item['itemNumber'];
			$trxWoDetail['description']=$item['description'];
			$trxWoDetail['issuedqty']=$item['qty'];
			$trxWoDetail['issuedunit']=$item['issuedunit'];
			$trxWoDetail['orderqty']=$item['orderqty'];
			$trxWoDetail['orderunit']=$item['orderunit'];
			$trxWoDetail['binnum']=$item['binnum'];
			$trxWoDetail['conditioncode']=$item['conditioncode'];
			$this->dbTrx->insert("trx_wo_detail",$trxWoDetail);


			if($item['so']!=1){ //mbak tammy 20
				//trx core item
				$itemNumber=$item['itemNumber'];
				$location=$item['location_id'];
				$conditionCode=$item['conditioncode'];
				$qty=$item['qty'];
				$binnum=$item['binnum'];
				$trx="Kr";
				$trxCode=2;
				$reff=$trxWo['trx_code'];
				$this->ModelCoreTrx->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff,$binnum);
			}

			//as mapping : qyt < orderqty

			//PARSIAL
			// if($item['orderqty']!=999999999){//dummy qty
			// 	if($item['qty']<$item['orderqty']){
			// 		$trxWoDetail['trx_status']=0;//as parsial
			// 		$trxWoDetail['issuedqty']=$item['orderqty']-$item['qty'];
			// 		$this->dbTrx->insert("trx_wo_detail",$trxWoDetail);
			// 	}
			// }
		}

		$response['status']="success";
		$response['trxId']=$lastTrxId;
		$response['detail']="mapping";
		echo json_encode($response);

	}




	function countItemInWPMaterial($wo){
		$query=$this->dbMaximo->query("SELECT * FROM VIEWWPMATERIAL WHERE WONUM='$wo'")->result();
		return count($query);
	}	


	function getLastTrxWoId(){
		$getTrxId=$this->dbTrx->query("select count(*) as jml from trx_wo where month='".date('m')."'")->result();
		$trxId=(int)$getTrxId[0]->jml;
		$trxId=$trxId+3;
		return sprintf("%'.05d", $trxId);
		// echo sprintf("%'.05d", $trxId);
		// echo $trxId=(int)$getTrxId[0]->jml;

	}




}