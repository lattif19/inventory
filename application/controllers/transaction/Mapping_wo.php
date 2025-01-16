<?php
/**
* 
*/
class Mapping_wo extends CI_Controller
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
		$this->dbSo = $this->load->database('trxSo', TRUE);
		$this->load->model('ModelMapping');
		$this->load->model('ModelCoreTrx', '', TRUE);

	}


	//MAPPING PO


	function mapping_wo()
	{
		$data['content']	= 'mapping/v_mapping_wo';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Mapping PO';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'mapping';
		$data['class'] 		= '';
		$data['dataWO'] 	= $this->ModelMapping->getMappingWO();

		
		$this->load->view('v_home', $data);


		// echo "<pre>";
		// var_dump($data['dataPO']);
	}

	function detail_wo($trxId)
	{
		$data['trxId']		= $trxId;
		$data['content'] 	= 'mapping/process_mapping_wo';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Mapping WO';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'mapping';
		$data['class'] 		= 'mapping1';
		$data['class'] 		= 'Detail Mapping WO';
		$dataLocation=$this->dbInventory->query("select * from location order by name asc")->result();
		$data['dataLocation']=$dataLocation;
       	$this->load->view('v_home', $data);

	}

	function getDetailTrx($trxId){
		$dataTrx=$this->dbTrx->query("SELECT wonum as woNumber,shipper_id,issueto as issueToId, trx_code FROM trx_wo WHERE trx_wo.trx_id=$trxId")->result();
		$dataTrxDetail=$this->dbTrx->query("SELECT item_number as itemNumber, description,location_id, orderunit,orderqty,issuedqty as qty,issuedunit,trx_status FROM trx_wo_detail WHERE trx_wo_detail.trx_id=$trxId")->result();
		$shipper_id=$dataTrx[0]->shipper_id;
		$dataShipper=$this->dbInventory->query("SELECT shipper_barcode FROM shipper where shipper_barcode=$shipper_id")->result();
		$data['trx']=$dataTrx;
		$data['trxDetail']=$dataTrxDetail;
		$data['shipper']=$dataShipper;
		echo json_encode($data);
	}


	function saveMappingWO($trxId){
		$_POST = json_decode(file_get_contents('php://input'), true);

		if(isset($_POST['dataItem'])){$dataItem=$_POST['dataItem'];}else{$dataItem=[];};
		if(isset($_POST['dataWO'])){$dataWO=$_POST['dataWO'];}else{$dataWO=[];};
		if(isset($_POST['dataCompany'])){$dataCompany=$_POST['dataCompany'];}else{$dataCompany=[];};
		if(isset($_POST['dataShipper'])){$dataShipper=$_POST['dataShipper'];}else{$dataShipper=[];};


		// var_dump($_POST);

		//trxDB WO & company
		if(isset($dataWO['woNumber'])){//WITH WO
			$trxWo['trx_status']=1;
			$trxWo['wonum']=$dataWO['woNumber'];
			$trxWoDetail['wonum']=$dataWO['woNumber'];
		}else{//WITHOUT WO
			$trxWo['trx_status']=0;
		}


	    $dataMapping=[];
	    $dataSuccess=[];
	    
	    //trxDB item
		foreach ($dataItem as $item) {
			if(!isset($item['trx_status'])){
				$trxWoDetail['trx_id']=$trxId;
				$trxWoDetail['location_id']=$item['location_id'];
				$trxWoDetail['item_number']=$item['itemNumber'];
				$trxWoDetail['description']=$item['description'];
				$trxWoDetail['orderqty']=$item['orderqty'];
				$trxWoDetail['orderunit']=$item['orderunit'];
				$trxWoDetail['issuedqty']=$item['qty'];
				$trxWoDetail['issuedunit']=$item['orderunit'];
				$trxWoDetail['binnum']=$item['binnum'];
				$trxWoDetail['conditioncode']=$item['conditioncode'];

				$finalQty=intval($item['qty'])+intval($this->countItemIssuedQty($trxId,$item['itemNumber']));
			
				//as mapping : qyt < orderqty
				if($finalQty<intval($item['orderqty'])){
					$trxWoDetail['trx_status']=0;//as mapping
					$dataMapping[]=$item['itemNumber'];
				}else{
					$dataSuccess[]=$item['itemNumber'];//count for compare with jumlah item in WPMATERIAL
					$this->updateItemAsComplete($trxId,$item['itemNumber']); //update all itemnumber as complete qty, changed all status to 1
				}

				//insert WO detail
				$this->dbTrx->insert("trx_wo_detail",$trxWoDetail);

				$itemNumber=$trxWoDetail['item_number'];
				$location=$trxWoDetail['location_id'];
				$conditionCode="NEW-MATERIAL";
				$qty=$item['qty'];
				$trx="Kr";
				$trxCode=2;
				$reff=$this->getTrxCode($trxId);
				$this->ModelCoreTrx->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff);
			}
		}

		//return value
		if(count($dataMapping)>0){
			$trxWoMapping['trx_status']=0;//as mapping
			//insert WO
			$this->dbTrx->where('trx_id',$trxId);
			$this->dbTrx->update("trx_wo",$trxWoMapping);
			$response['status']="success";
			$response['detail']="mapping";
			$response['trxId']=$trxId;
			echo json_encode($response);
		}else if(isset($trxWo['wonum'])){
			if($this->countItemInTrxWo($trxId)==$this->countItemInWPMaterail($trxWo['wonum'])){ // all item complete

				//check is all item is complete qty
				if($this->checkTrxIfComplete($trxId)){
					$trxWoMapping['trx_status']=1;//complete
					//insert WO
					$this->dbTrx->where('trx_id',$trxId);
					$this->dbTrx->update("trx_wo",$trxWoMapping);
					$response['status']="success";
					$response['detail']="complete";
					$response['trxId']=$trxId;
					echo json_encode($response);
				}else{ //not item qty complete
					$this->dbTrx->where('trx_id',$trxId);
					$this->dbTrx->update("trx_wo",$trxWoMapping);
					$response['status']="success";
					$response['detail']="mapping";
					$response['trxId']=$trxId;
					echo json_encode($response);
				}	

			}else{				
				$trxWoMapping['trx_status']=0;//as mapping : item not all item received
				//insert WO
				$this->dbTrx->where('trx_id',$trxId);
				$this->dbTrx->update("trx_wo",$trxWoMapping);
				$response['status']="success";
				$response['detail']="mapping";
				$response['trxId']=$trxId;
				echo json_encode($response);
			}
		}else if(!isset($trxWo['wonum'])){
				$trxWoMapping['trx_status']=0;//as mapping : WITHOUT WO
				//insert WO
				$this->dbTrx->where('trx_id',$trxId);
				$this->dbTrx->update("trx_wo",$trxWoMapping);
				$response['status']="success";
				$response['detail']="mapping";
				$response['trxId']=$trxId;
				echo json_encode($response);

		}else{
			$response['status']="error";
			$response['message']="Unknown Error..";
			echo json_encode($response);
		}
	}


	function checkTrxIfComplete($trxId){
		$query=$this->dbTrx->query("SELECT * FROM trx_wo_detail WHERE trx_id=$trxId and trx_status=0")->result();
		if(count($query)>0){
			return 0;
		}else{
			return 1;
		}
	}

	function updateItemAsComplete($trxId,$itemNumber){
		$dataItem['trx_status']=1;
		$this->dbTrx->where('trx_id',$trxId);
		$this->dbTrx->where('item_number',$itemNumber);
		$this->dbTrx->update('trx_wo_detail',$dataItem);
	}

	function countItemIssuedQty($trxId,$itemNumber){
		$query=$this->dbTrx->query("select sum(issuedqty) as totalQty from trx_wo_detail where item_number=$itemNumber and trx_id=$trxId")->result();
		return $query[0]->totalQty;
	}

	function countItemInWPMaterail($wo){
		$query=$this->dbMaximo->query("SELECT * FROM VIEWWPMATERIAL WHERE WONUM='$wo'")->result();
		return count($query);
	}	

	function countItemInTrxWo($trxId){
		$query=$this->dbTrx->query("SELECT * FROM trx_wo_detail WHERE trx_id='$trxId' group by item_number")->result();
		return count($query);
	}	


	function getLocationIdFromName($location_name){
		$getLocationId=$this->dbInventory->query("select location_id from location where name='$location_name'")->result();
		return $getLocationId[0]->location_id;
	}

	function getTrxCode($trxId){
		$getTrxCode=$this->dbTrx->query("select trx_code from trx_wo where trx_id='$trxId'")->result();
		return $getTrxCode[0]->trx_code;
	}
}