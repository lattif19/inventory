<?php
/**
* 
*/
class Rtrn_warehouse extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged')) {
			redirect('login');
		}

		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
		$this->load->model('ModelRtrnWarehouse');
		$this->load->model('ModelCoreTrx', '', TRUE);
	}

	function index()
	{
		$data['content'] 	= 'rtrn_warehouse/v_rtrn_warehouse';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Return To Warehouse';
		$data['class'] 		= 'transaction';
		$data['class'] 		= '';
		$data['dataWO'] 	= $this->dbTrx->query("select * from trx_wo_return order by trx_id DESC");
		$this->load->view('v_home', $data);
		// echo "<pre>";
		// var_dump($data['dataWO']->result());
	}

	function add()
	{
		$data['content'] 	= 'rtrn_warehouse/add_rtrn_warehouse';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Add Warehouse';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'warehouse';
		$data['query'] 		= '';
		$autoPrint = $this->dbTrx->query('select * from trx_wo_return, trx_wo_detail_return where trx_wo_return.trx_id = trx_wo_detail_return.trx_id')->result();
		foreach ($autoPrint as $value) {
			$data['autoPrint'] = $value->trx_id;
		}
		// $dataLocation=$this->dbInventory->query("select * from location where location_id=1203 order by name asc")->result();
		$dataLocation=$this->dbInventory->query("select * from inventory.location where location_id=1203 or location_id=2201 or location_id=2301 order by name asc")->result();
		
		$data['dataLocation']=$dataLocation;
		$this->load->view('v_home', $data);
	}



	function detailByTrxCode($trx_code)	{
		$trx_id=$this->dbTrx->query("select trx_id from trx_wo_return where trx_code = '$trx_code'")->result();
		$this->detail($trx_id[0]->trx_id);
	}

	function detail($trx_id)
	{
		$data['content'] 	= 'rtrn_warehouse/detail_warehouse';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Return To Warehouse';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'Detail Return To Warehouse';

		$getDetailTrx 			= $this->ModelRtrnWarehouse->getDataWarehouse($trx_id);
		foreach ($getDetailTrx as $key => $getdata) {
			$data['trx_code'] = $getdata->trx_code;
			$data['trx_timestamp'] = $getdata->trx_timestamp;
			$data['enterby'] = $getdata->enterby;
			$data['shipper'] = $getdata->shipper_id;
			// $data['name_shipper'] = $getdata->name;
			$data['ipaddress'] = $getdata->ip_address;
			$data['wonum'] = $getdata->wonum;
			$data['trx_status'] = $getdata->trx_status;
		}
		$getDetailWO 		= $this->dbMaximo->query("select * from VIEWWORKORDER where WONUM='".$getDetailTrx[0]->wonum."'")->result();	
		foreach ($getDetailWO as $key => $wo) {
			$data['desc'] = $wo->DESCRIPTION;
			$data['date'] = $wo->STATUSDATE;
		}  
		
		$dataItem = $this->dbTrx->query("select * from trx_wo_detail_return where trx_id = '$trx_id'")->result();
		$data['dataItem']=$this->addArrayItemDetailToArrayItem($dataItem);


       $this->load->view('v_home', $data);
	}

	function getItemDetailFromMaximo($trx_id){
		$itemDetailFromMaximo=$this->dbMaximo->query("select * from VIEWITEM where ITEMNUM = '$trx_id'")->result();
		return $itemDetailFromMaximo[0];
	}

	function getLocationInventory($trx_id){
		$locationDetail=$this->dbInventory->query("select * from location where location_id = '$trx_id'")->result();
		return $locationDetail[0];
	}

	function addArrayItemDetailToArrayItem($dataItemDescription){
		$i=0;
		foreach ($dataItemDescription as $key){
			$j=$i++;
			$dataItemDescription[$j]->DESCRIPTION = $this->getItemDetailFromMaximo($key->item_number)->DESCRIPTION;
			$dataItemDescription[$j]->name = $this->getLocationInventory($key->location_id)->name;
		}
		return $dataItemDescription;
	}

	// TRX BY ANGULAR

	//TRX ITEM
	function getItem($item,$wo){
		$item=explode("x",$item);
		if(count($item)==2){
			$itemNumber=$arrayItem['itemNumber']=$item[1];
			$arrayItem['qty']=$item[0];
		}else{
			$itemNumber=$arrayItem['itemNumber']=$item[0];
			$arrayItem['qty']=1;
		}
		if($wo!=null){
			$dataItem=$this->dbTrx->query("select *,sum(issuedqty) as totalqty from trx_wo_detail where item_number='$itemNumber' AND wonum='$wo'")->result();
			// echo $itemNumber;
			// var_dump($dataItem);
			if(count($dataItem)>0){
				$arrayItem['description']=$dataItem[0]->description;
				$arrayItem['photo']=$this->getItemPhoto($arrayItem['itemNumber']);
				$arrayItem['orderunit']=$dataItem[0]->orderunit;
				$arrayItem['orderqty']=$dataItem[0]->totalqty-$this->getQtyReturnWarehouseBefore($itemNumber,$wo);
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
				$arrayItem['orderqty']=0;
				$arrayItem['orderunit']=$dataItem[0]->ORDERUNIT;
			}else{
				$arrayItem=[];
			}
		}
		echo json_encode($arrayItem);
	}


	function getQtyReturnWarehouseBefore($itemNumber,$wo){
		$dataItem=$this->dbTrx->query("select sum(returnqty) as returnedqty from trx_wo_detail_return where item_number='$itemNumber' AND wonum='$wo'")->result();
		return $dataItem[0]->returnedqty;
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
	public function getDataWO($trxCodeIssue){
		$dbMaximo=$this->load->database('maximo',TRUE);
		$dataWO=$this->dbTrx->query("SELECT wonum FROM trx_wo WHERE trx_code='$trxCodeIssue'")->result();
		if(count($dataWO)>0){
		$woNumber=$dataWO[0]->wonum;
		$dataWODetail=$dbMaximo->query("SELECT * FROM VIEWWORKORDER WHERE WONUM='$woNumber'")->result();
		if(count($dataWO)>0){
			$arrayWO['trxCodeIssue']=$trxCodeIssue;
			$arrayWO['woNumber']=$dataWODetail[0]->WONUM;
			$arrayWO['description']=$dataWODetail[0]->DESCRIPTION;
			$arrayWO['status']=$dataWODetail[0]->STATUS;
			$arrayWO['statusDate']=$dataWODetail[0]->STATUSDATE;
		// $arrayWO['trasactionBefore']="TRX123123123";
		}else{
			$arrayWO=[];
		}
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
		$dataShipper=$this->dbInventory->query("select * from shipper where shipper_barcode=$shipper_barcode")->result();
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

		$dataItem=$_POST['dataItem'];
		$dataShipper=$_POST['dataShipper'];
		$dataWO=$_POST['dataWO'];
		$dataNote=$_POST['dataNote'];

			// trx WO
		$trxWo['wonum']=$dataWO['woNumber'];
		$trxWo['shipper_id']=$dataShipper['shipperId'];

		$trxWo['trx_code']="RTRNWH".date('Y').date('m').$this->getLastTrxWoId();
		$trxWo['month']=date('m');
		$trxWo['year']=date('Y');
		$trxWo['trx_code_reff']=$dataWO['trxCodeIssue'];
		$trxWo['enterby']=$this->session->userdata('username');
		$trxWo['trx_status']=1;
		$trxWo['note']=$_POST['dataNote'];
		$trxWo['ip_address']=$this->input->ip_address();

		$this->dbTrx->insert("trx_wo_return",$trxWo);


		// get last id from trx_id
		$this->dbTrx->select_max('trx_id');
		$result= $this->dbTrx->get('trx_wo_return')->row_array();
		$lastTrxId=$result['trx_id'];



		foreach ($dataItem as $item) {
			$trxWoDetail['trx_id']=$lastTrxId;
			$trxWoDetail['item_number']=$item['itemNumber'];
			$trxWoDetail['returnqty']=$item['qty'];
			$trxWoDetail['location_id']=$item['location_id'];
			$trxWoDetail['returnunit']=$item['orderunit'];
			$trxWoDetail['conditioncode']=$item['conditioncode'];
			$trxWoDetail['wonum']=$dataWO['woNumber'];
			$this->dbTrx->insert("trx_wo_detail_return",$trxWoDetail);


			//trx core item
			$itemNumber=$item['itemNumber'];
			$location=$item['location_id'];
			$conditionCode=$item['conditioncode'];
			$qty=$item['qty'];
			$trx="Dr";
			$trxCode=4;
			$reff=$trxWo['trx_code'];
			$this->ModelCoreTrx->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff);
		}


	}

	function getLastTrxWoId(){
		$getTrxId=$this->dbTrx->query("select count(*) as jml from trx_wo_return where month='".date('m')."'")->result();
		$trxId=(int)$getTrxId[0]->jml;
		$trxId=$trxId+1;
		return sprintf("%'.05d", $trxId);

	}

	function download_rtrn_warehouse(){
		$data['judul'] 			= 'Report';
		$data['sub_judul'] 		= 'Return To Warehouse';
		$dataItem = $this->dbTrx->query("select * from trx_wo_return, trx_wo_detail_return where trx_wo_return.trx_id=trx_wo_detail_return.trx_id order by trx_wo_return.trx_id DESC")->result();
		$data['returnWHreport'] =$this->addArrayItemDetailToArrayItem($dataItem);
		$this->load->view('rtrn_warehouse/download_rtrn_warehouse', $data);

		// $this->load->view('v_home', $data);

		// var_dump($data['returnWHreport']);
	}




	
}