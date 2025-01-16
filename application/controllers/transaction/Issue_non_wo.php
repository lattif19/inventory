<?php
/**
* 
*/
class Issue_non_wo extends CI_Controller
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
		$this->load->library('ajax');
		$this->load->model('Model_Issue');
		$this->load->model('ModelCoreTrx', '', TRUE);
	}

	function index()
	{
		$data['content'] 	= 'issue_non_wo/v_issue';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Issue WO';
		// $data['class'] 		= 'transaction';
		$data['class'] 		= '';
		$data['query'] 		= $this->dbTrx->query("SELECT * FROM trx_wo_detail,trx_wo where trx_wo.trx_id=trx_wo_detail.trx_id and trx_wo_detail.trx_status!=1 order by trx_wo.trx_timestamp DESC");
		$this->load->view('v_home', $data);
	}



	function detailByTrxCode($trx_code)	{
		$trx_id=$this->dbTrx->query("select trx_id from trx_wo where trx_code = '$trx_code'")->result();
		$this->detail($trx_id[0]->trx_id);
	}

	function detail($trx_id)
	{
		$data['content'] 	= 'issue_non_wo/detail_issue';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Issue WO';
		// $data['class'] 		= 'transaction';
		$data['class'] 		= 'Detail Issue WO';

		$data['dataTrx']=$this->dbTrx->query("select *, shipper.name as name_shipper from trx.trx_wo_detail,trx.trx_wo, inventory.shipper, inventory.location where location.location_id=trx_wo_detail.location_id and trx_wo.trx_id=trx_wo_detail.trx_id and shipper.shipper_barcode=trx_wo.shipper_id and trx_wo_detail.trx_detail_id=$trx_id ")->row();

		$this->load->view('v_home', $data);

	}

	function getDataItemFromMaximo($trx_id)
	{
		$itemDataIssue = $this->dbMaximo->query("select * from VIEWITEM where ITEMNUM ='$trx_id'")->result();
		return $itemDataIssue[0];
	}

	function getDataLocation($location)
	{
		$getLocation = $this->dbInventory->query("select * from location where location_id ='$location'")->result();
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
		$data['content'] 	= 'issue_non_wo/add_issue';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Detail Issue WO';
		$data['class'] 		= 'Add Issue WO';
		// $data['class'] 		= 'issue';


		$dbMaximo=$this->load->database('maximo',TRUE);
		$dataLocation=$this->dbInventory->query("select * from location where type='STOREROOM' order by name asc")->result();
		$dataIssueTo=$dbMaximo->query("select * from VIEWMAXUSER")->result();

		$data['dataLocation']=$dataLocation;
		$data['dataIssueTo']=$dataIssueTo;
		$this->load->view('v_home', $data);
	}


	// TRX BY ANGULAR

	//TRX CEK BALANCE

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
	function getItem($itemNumber,$wo=NULL){
		$item=explode("x",$itemNumber);
		if(count($item)==2){
			$itemNumber=ltrim($arrayItem['itemNumber']=$item[1], '0');
			$arrayItem['qty']=$item[0];
		}else{
			$itemNumber=ltrim($arrayItem['itemNumber']=$item[0], '0');
			$arrayItem['qty']=1;
		}
		if($wo=='undefined'){
			$dbMaximo=$this->load->database('maximo',TRUE);
			$dataItem=$dbMaximo->query("select * from VIEWITEM where ITEMNUM='$itemNumber'")->result();
			// echo $itemNumber;
			if(count($dataItem)>0){
				$itemNumber=$dataItem[0]->ITEMNUM;
				$arrayItem['description']=$dataItem[0]->DESCRIPTION;
				$arrayItem['photo']=$this->getItemPhoto($itemNumber);
				$arrayItem['orderunit']=$this->getItemUnit($itemNumber);
				$arrayItem['issuedunit']=$arrayItem['orderunit'];
				$arrayItem['orderqty']=10000000;
				// $arrayItem['remaining']=(int)$this->getRemainingItem($itemNumber,$wo);
				$arrayItem['balance']='';
			}else{
				$arrayItem=[];
			}
		}else{

			$dbMaximo=$this->load->database('maximo',TRUE);
			$dataItem=$dbMaximo->query("select * from VIEWINVRESERVE where ITEMNUM='$itemNumber' AND WONUM='$wo'")->result();
		if(count($dataItem)>0){ //cek apakah available di reserve
			$arrayItem['orderqty']=(int)$dataItem[0]->RESERVEDQTY;
			$arrayItem['description']=$dataItem[0]->DESCRIPTION;
			$arrayItem['photo']=$this->getItemPhoto($itemNumber);
			$arrayItem['orderunit']=$this->getItemUnit($itemNumber);
			$arrayItem['issuedunit']=$arrayItem['orderunit'];
			$arrayItem['remaining']=(int)$this->getRemainingItem($itemNumber,$wo);
			$arrayItem['balance']='';
		}else{ //cari di wp-material
			$dataItem=$dbMaximo->query("select * from VIEWWPMATERIAL where ITEMNUM='$itemNumber' AND WONUM='$wo'")->result();
			if(count($dataItem)>0){
				$arrayItem['orderqty']=(int)$dataItem[0]->ITEMQTY;
				$arrayItem['description']=$dataItem[0]->DESCRIPTION;
				$arrayItem['photo']=$this->getItemPhoto($itemNumber);
				$arrayItem['orderunit']=$this->getItemUnit($itemNumber);
				$arrayItem['issuedunit']=$arrayItem['orderunit'];
				$arrayItem['remaining']=(int)$this->getRemainingItem($itemNumber,$wo);

				$arrayItem['balance']='';
			}else{ //cari di item
				$arrayItem=[];
			}
		}
	}

	echo json_encode($arrayItem);
}



function getRemainingItem($item_number,$wo){
	$result=$this->dbTrx->query("select sum(issuedqty) as qty from trx_wo_detail where item_number=$item_number and wonum=$wo and trx_status!=0")->row();
	return $result->qty;

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

	// trx WO
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
		$trxWoDetail['trx_status']=3;//as so
		$trxWoDetail['trx_id']=$lastTrxId;
		$trxWoDetail['location_id']=$item['location_id'];
		$trxWoDetail['item_number']=$item['itemNumber'];
		$trxWoDetail['description']=$item['description'];
		$trxWoDetail['issuedqty']=$item['qty'];
		$trxWoDetail['issuedunit']=$item['issuedunit'];
		$trxWoDetail['orderqty']=$item['orderqty'];
		$trxWoDetail['orderunit']=$item['orderunit'];
		$trxWoDetail['conditioncode']=$item['conditioncode'];
		$trxWoDetail['binnum']=$item['binnum'];



			$this->dbTrx->insert("trx_wo_detail",$trxWoDetail);

			// //trx core item
			// $itemNumber=$item['itemNumber'];
			// $location=$item['location_id'];
			// $conditionCode=$item['conditioncode'];
			// $qty=$item['qty'];
			// $trx="Kr";
			// $trxCode=2;
			// $reff=$trxWo['trx_code'];
			// $this->ModelCoreTrx->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff);

		}

		//return value

		$response['status']="success";
		$response['detail']="complete";
		echo json_encode($response);

	}



	function saveTrx() //save trx mapping detail
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		// var_dump($_POST);


		if(isset($_POST['dataTrx'])){$dataTrx=$_POST['dataTrx'];}else{$dataTrx=[];};

		$trx_detail_id=$dataTrx['trx_detail_id'];
		$wonum=$dataTrx['woNumber'];
		$orderqty=(int)$dataTrx['orderQty'];
		$issuedqty=(int)$dataTrx['issuedQty'];
		$remainingqty=(int)$dataTrx['remainingQty'];

		$resultTrx=$this->dbTrx->query("SELECT * from trx_wo_detail,trx_wo where trx_wo_detail.trx_id=trx_wo.trx_id and trx_wo_detail.trx_detail_id=$trx_detail_id")->result();

		foreach ($resultTrx as $key) {
			$data['item_number']=$key->item_number;
			$data['trx_id']=$key->trx_id;
			$data['description']=$key->description;
			$data['orderunit']=$key->orderunit;
			$data['issuedunit']=$key->issuedunit;
			$data['location_id']=$key->location_id;
			$data['binnum']=$key->binnum;
			$data['conditioncode']=$key->conditioncode;
			$dataItemTrx['trx_code']=$key->trx_code;
			$dataItemTrx['trx_status']=$key->trx_status;
			$data['wonum']=$wonum;
		}

		if($remainingqty==0){
			$data['wonum']=$wonum;
			$data['orderqty']=$orderqty;
			$data['issuedqty']=$issuedqty;
			$data['trx_status']=1;
			$this->dbTrx->where('trx_detail_id',$dataTrx['trx_detail_id']);
			$this->dbTrx->update('trx_wo_detail',$data);

			//trx core item
			//item di transaksikan
		
			$itemNumber=$data['item_number'];
			$location=$data['location_id'];
			$conditionCode=$data['conditioncode'];
			$qty=$data['issuedqty'];
			$trx="Kr";
			$trxCode=2;
			$reff=$dataItemTrx['trx_code'];
			$binnum=$data['binnum'];
			$this->ModelCoreTrx->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff,$binnum);




		}else if($orderqty>$issuedqty){

			$data['trx_status']=1;
			$data['wonum']=$wonum;
			$data['orderqty']=$orderqty;
			$data['issuedqty']=$issuedqty;
			$this->dbTrx->where('trx_detail_id',$dataTrx['trx_detail_id']);
			$this->dbTrx->update('trx_wo_detail',$data);

			//trx core item 
			//item di transaksikan
			$itemNumber=$data['item_number'];
			$location=$data['location_id'];
			$conditionCode=$data['conditioncode'];
			$qty=$data['issuedqty'];
			$trx="Kr";
			$trxCode=2;
			$reff=$dataItemTrx['trx_code'];
			$binnum=$data['binnum'];				
			$this->ModelCoreTrx->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff,$binnum);

			$data['trx_status']=0;//parsial
			$data['wonum']=$wonum;
			$data['orderqty']=$orderqty;
			$data['issuedqty']=$remainingqty;
			$this->dbTrx->insert('trx_wo_detail',$data);

		}





		$response['status']="success";
		echo json_encode($response);
	}


	function countItemInWPMaterial($wo){
		$query=$this->dbMaximo->query("SELECT * FROM VIEWWPMATERIAL WHERE WONUM='$wo'")->result();
		return count($query);
	}	


	function getLastTrxWoId(){
		$getTrxId=$this->dbTrx->query("select trx_code as jml from trx_wo where month='".date('m')."' and year='".date('Y')."' order by trx_id desc limit 1")->result();
		$trxId=$getTrxId[0]->jml;
		$trxId=substr($trxId, -5);
		$trxId=(int)$trxId+1;
		return sprintf("%'.05d", $trxId);
	}




}