<?php
/**
* 
*/
class Rtrn_vendor extends CI_Controller
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
		$this->load->model('ModelCoreTrx', '', TRUE);
		$this->load->model('ModelRtrnVendor');
	}

	function index()
	{
		$data['content'] 	= 'rtrn_vendor/v_rtrn_vendor';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Return To Vendor';
		// $data['class'] 		= 'transaction';
		$data['class'] 		= '';
		$data['dataRtrnVendor'] = $this->dbTrx->query("select * from trx_po_return order by trx_id asc");
		$this->load->view('v_home', $data);
	}



	function detailByTrxCode($trx_code)	{
		$trx_id=$this->dbTrx->query("select trx_id from trx_po_return where trx_code = '$trx_code'")->result();
		$this->detail($trx_id[0]->trx_id);
	}

	function detail($trx_id)
	{
		$data['content'] 	= 'rtrn_vendor/detail_rtrn_vendor';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Return To Vendor';
		$data['class'] 		= 'Detail Return To Vendor';
		// $data['class'] 		= 'vendor';
		$dataDetailTrx 		= $this->ModelRtrnVendor->getDataVendor($trx_id);
		foreach ($dataDetailTrx as $key => $getdata) {
			$data['trx_code'] = $getdata->trx_code;
			$data['trx_timestamp'] = $getdata->trx_timestamp;
			$data['enterby'] = $getdata->enterby;
			$data['shipper'] = $getdata->shipper_id;
			$data['ipaddress'] = $getdata->ip_address;
			$data['ponum'] = $getdata->ponum;
			$data['trx_status'] = $getdata->trx_status;
		}

		$dataDetailPO 		= $this->dbMaximo->query("select * from VIEWPO where PONUM='".$dataDetailTrx[0]->ponum."'")->result();
		foreach ($dataDetailPO as $key => $po) {
			$data['desc'] = $po->DESCRIPTION;
			$data['date'] = $po->REQUIREDDATE;			  
		}

		$dataItem= $this->dbTrx->query("select * from trx_po_detail_return where trx_id='$trx_id'")->result();
		$data['dataItem']	= $this->addArrayItemDetailMaximoToArrayItem($dataItem);
		

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

	// function getConditionCodeDetailFromMaximo($trx_id){
	// 	$CoditioncodeDetailFromMaximo=$this->dbMaximo->query("select * from VIEWINVBALANCES where ITEMNUM = '$trx_id'")->result();
	// 	return $CoditioncodeDetailFromMaximo[0];
	// }


	function addArrayItemDetailMaximoToArrayItem($dataItemDescription){
		$i=0;
		foreach ($dataItemDescription as $key){
			$j=$i++;
			$dataItemDescription[$j]->DESCRIPTION = $this->getItemDetailFromMaximo($key->item_number)->DESCRIPTION;
			$dataItemDescription[$j]->name = $this->getLocationInventory($key->location_id)->name;
			//$dataItemDescription[$j]->CONDITIONCODE = $this->getConditionCodeDetailFromMaximo($key->item_number)->CONDITIONCODE;
		}
		return $dataItemDescription;
	}



	function add()
	{
		$data['content'] 	= 'rtrn_vendor/add_rtrn_vendor';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Detail Return To Vendor';
		$data['class'] 		= 'Add Return To Vendor';
		// $data['class'] 		= 'vendor';
		// $data['query'] 		= '';
		$dataLocation=$this->dbInventory->query("select * from location order by name asc")->result();
		$data['dataLocation']=$dataLocation;

		$autoPrint = $this->dbTrx->query("select * from trx_po_return, trx_po_detail_return where trx_po_return.trx_id = trx_po_detail_return.trx_id")->result();
		foreach ($autoPrint as $key => $value) {
			$data['autoPrint'] = $value->trx_id;
		}

		$this->load->view('v_home', $data);
	}


	function save()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);

		if(isset($_POST['dataItem'])){$dataItem=$_POST['dataItem'];}else{$dataItem=[];};
		if(isset($_POST['dataPO'])){$dataPO=$_POST['dataPO'];}else{$dataPO=[];};
		if(isset($_POST['dataShipper'])){$dataShipper=$_POST['dataShipper'];}else{$dataShipper=[];};



		//trxDB PO & company
		if(isset($dataPO['poNumber'])){//WITH PO
			$trxPo['trx_status']="2";
			$trxPo['ponum']=$dataPO['poNumber'];
		}else{//WITHOUT PO
			$trxPo['company_id']=$dataCompany['companyId']."<br>";
			$trxPo['trx_status']="1";
		}

		$trxPo['shipper_id']=$dataShipper['shipperId']."<br>";
		$trxPo['trx_code']="RTRNVNDR".date('Y').date('m').$this->getLastTrxPoRtrnId();
		$trxPo['month']=date('m');
		$trxPo['year']=date('Y');
		$trxPo['receivingtype']="RETURN";
		$trxPo['note']=$_POST['dataNote'];
		$trxPo['enterby']=$this->session->userdata('username');
		$trxPo['trx_status']=1;
		$trxPo['ip_address']=$this->input->ip_address();

		$this->dbTrx->insert("trx_po_return",$trxPo);
		// var_dump($trxPo);


		// get last id from trx_id
		$this->dbTrx->select_max('trx_id');
		$result= $this->dbTrx->get('trx_po_return')->row_array();
		$lastTrxId=$result['trx_id'];

		
	    //trxDB item
		foreach ($dataItem as $item) {
			$trxPoDetail['trx_id']=$lastTrxId;
			$trxPoDetail['location_id']=$item['location_id'];
			$trxPoDetail['item_number']=$item['itemNumber'];
			$trxPoDetail['returnqty']=$item['qty'];
			$trxPoDetail['conditioncode']="NEW-MATERIAL";
			$trxPoDetail['ponum']=$trxPo['ponum'];
			$trxPoDetail['returnunit']=$item['orderunit'];
			$this->dbTrx->insert("trx_po_detail_return",$trxPoDetail);
			// var_dump($trxPoDetail);

			//trx core item
			$itemNumber=$item['itemNumber'];
			$location=$item['location_id'];
			$conditionCode="NEW-MATERIAL";
			$qty=$item['qty'];
			$trx="Kr";
			$trxCode=3;
			$reff=$trxPo['trx_code'];
			$this->ModelCoreTrx->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff);
			// var_dump($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff);
		}


		$response['status']="success";
		echo json_encode($response);

	}

	function asasdas()
	{
		echo "asasdas";
	}

	function getLastTrxPoRtrnId(){
		$getTrxId=$this->dbTrx->query("select count(*) as jml from trx_po_return where month='".date('m')."'")->result();
		$trxId=(int)$getTrxId[0]->jml;
		$trxId=$trxId+1;
		return sprintf("%'.05d", $trxId);

	}




	// TRX BY ANGULAR

	//TRX ITEM
	function getItem($item,$po){
		$item=explode("x",$item);
		if(count($item)==2){
			$itemNumber=$arrayItem['itemNumber']=$item[1];
			$arrayItem['qty']=$item[0];
		}else{
			$itemNumber=$arrayItem['itemNumber']=$item[0];
			$arrayItem['qty']=1;
		}
		if($po!=null){
			$dataItem=$this->dbTrx->query("select *,sum(receivedqty) as totalqty from trx_po_detail where item_number='$itemNumber' AND ponum='$po'")->result();
			// echo $itemNumber;
			// var_dump($dataItem);
			if(count($dataItem)>0){
				$arrayItem['description']=$dataItem[0]->description;
				$arrayItem['photo']=$this->getItemPhoto($arrayItem['itemNumber']);
				$arrayItem['orderunit']=$dataItem[0]->orderunit;
				$arrayItem['orderqty']=$dataItem[0]->totalqty-$this->getQtyReturnVendorBefore($itemNumber,$po);
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


	function getQtyReturnVendorBefore($itemNumber,$po){
		$dataItem=$this->dbTrx->query("select sum(returnqty) as returnedqty from trx_po_detail_return where item_number='$itemNumber' AND ponum='$po'")->result();
		return $dataItem[0]->returnedqty;
	}



	function checkItemIsInPo($qtyreq,$itemNumber,$po,$location_id){
		$qtyReceive=$this->dbTrx->query("SELECT sum(orderqty) as jml from trx_po_detail where item_number='$itemNumber' and location_id='$location_id' and ponum='$po'")->row()->jml;
		$qtyReturnReceive=$this->dbTrx->query("SELECT sum(issueqty) as jml from trx_po_detail_return where item_number='$itemNumber' and location_id='$location_id' and ponum='$po'")->row()->jml;

		//check receive > return 
		if($qtyReceive>=$qtyreq){
			if($qtyReceive>$qtyReturnReceive){
			return 1;
			}
		}else{
			return 0;
		}


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


}