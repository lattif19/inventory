<?php
/**
* 
*/
class Mapping_po extends CI_Controller
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
		$this->load->model('ModelReceiving', 'kode');

	}


	//MAPPING PO


	function mapping_po()
	{
		$data['content']	= 'mapping/v_mapping_po';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Mapping PO';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'mapping';
		$data['class'] 		= '';
		$data['dataPO'] 	= $this->ModelMapping->getMappingPO();

		
		$this->load->view('v_home', $data);


		// echo "<pre>";
		// var_dump($data['dataPO']);
	}


	function detail_po($trxId)
	{
		$data['trxId']		= $trxId;
		$data['content'] 	= 'mapping/process_mapping_po';
		$data['judul'] 		= 'Dashboard';
		$data['sub_judul'] 	= 'Mapping PO';
		$data['class'] 		= 'transaction';
		$data['class'] 		= 'mapping';
		$data['class'] 		= 'Detail Mapping PO';
		$data['dataCompany'] 	= $this->ModelReceiving->getdatacompanies();

		$this->load->view('v_home', $data);

	}


	function getDetailTrx($trxId){
		$dataTrx=$this->dbTrx->query("SELECT ponum as poNumber,shipper_id,company_id as companyId, trx_code FROM trx_po WHERE trx_po.trx_id=$trxId")->result();
		$dataTrxDetail=$this->dbTrx->query("SELECT item_number as itemNumber, description,location_id, orderunit,orderqty,receivedqty as qty,receivedunit,trx_status FROM trx_po_detail WHERE trx_po_detail.trx_id=$trxId")->result();
		$shipper_id=$dataTrx[0]->shipper_id;
		$dataShipper=$this->dbInventory->query("SELECT shipper_barcode FROM shipper where shipper_barcode=$shipper_id")->result();
		$dataTrx[0]->companyName=$this->getCompanyName($dataTrx[0]->companyId);
		$data['trx']=$dataTrx;
		$data['trxDetail']=$dataTrxDetail;
		$data['shipper']=$dataShipper;
		echo json_encode($data);
	}

	function getCompanyName($companyId){
		$dataCompany=$this->dbMaximo->query("SELECT NAME FROM VIEWCOMPANIES WHERE COMPANY='$companyId'")->result();
		return $dataCompany[0]->NAME;
	}


	function saveMappingPO($trxId){


		$_POST = json_decode(file_get_contents('php://input'), true);

		if(isset($_POST['dataPO'])){$dataPO=$_POST['dataPO'];}else{$dataPO=[];};

		//trxDB PO & company
		if(isset($dataPO['poNumber'])){
			$this->withPO($_POST,$trxId);
		}else{//WITHOUT PO
			$this->withoutPO($_POST,$trxId);
		}

	}

	function withPO($POST,$trxId){

		if(isset($POST['dataItem'])){$dataItem=$POST['dataItem'];}else{$dataItem=[];};
		if(isset($POST['dataPO'])){$dataPO=$POST['dataPO'];}else{$dataPO=[];};
		if(isset($POST['dataCompany'])){$dataCompany=$POST['dataCompany'];}else{$dataCompany=[];};
		if(isset($POST['dataShipper'])){$dataShipper=$POST['dataShipper'];}else{$dataShipper=[];};

		$trxPo['company_id']=$dataPO['companyId'];
		$trxPo['trx_status']=1;
		$trxPo['ponum']=$dataPO['poNumber'];
		$trxPoDetail['ponum']=$dataPO['poNumber'];

		//cek apakah ada perbedaan orderqty dengan orderqty di POLINE jika ada ubah semua data sesuai dengan POLINE
		//hanya kasus tanpa PO dan PO baru saja dimasukan
		$dataItem=$this->updateItemMappingWithPO($dataItem,$trxPo['ponum']);

		$dataMapping=[];
		$dataSuccess=[];
	    //trxDB item
		foreach ($dataItem as $item) {
			if(isset($item['nonPoInsertPo'])){ //NON PO DATA ITEM  yang baru dimasukan PO dan dimanipulasi data orderqty nya
				$trxPoDetail['orderqty']=$item['orderqty'];
				$trxPoDetail['location_id']=$this->getLocationIdFromName('WH');
				$trxPoDetail['item_number']=$item['itemNumber'];
				//hitung total qty dari barang yang direceive dan qty item yang akan di receive

				//as mapping : qyt < orderqty
				if($item['qty']<intval($item['orderqty'])){
					$trxPoDetail['trx_status']=0;//as mapping
					$dataMapping[]=$item['itemNumber'];
				}else if($item['qty']==intval($item['orderqty'])){
					$trxPoDetail['trx_status']=1;
					$dataSuccess[]=$item['itemNumber'];//count for compare with jumlah item in POLINE
					$this->updateItemAsComplete($trxId,$item['itemNumber']); //update all itemnumber as complete qty, changed all status to 1
				}else{
					$trxPoDetail['trx_status']=0;//as mapping
					$dataMapping[]=$item['itemNumber'];
				}

				//insert PO detail
				$this->dbTrx->where('trx_id',$trxId);
				$this->dbTrx->where('item_number',$item['itemNumber']);
				$this->dbTrx->where('location_id',$this->getLocationIdFromName('WH'));
				$this->dbTrx->update("trx_po_detail",$trxPoDetail);

				$itemNumber=$trxPoDetail['item_number'];
				$location=$trxPoDetail['location_id'];
				$conditionCode="NEW-MATERIAL";
				$qty=$item['qty'];
				$trx="Dr";
				$trxCode=1;
				$reff=$this->getTrxCode($trxId);
				$this->ModelCoreTrx->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff);

			}else if(!isset($item['trx_status'])){ //with PO Insert data item
				$trxPoDetail['trx_id']=$trxId;
				$trxPoDetail['location_id']=$this->getLocationIdFromName('WH');
				$trxPoDetail['item_number']=$item['itemNumber'];
				$trxPoDetail['description']=$item['description'];
				$trxPoDetail['orderqty']=$item['orderqty'];
				$trxPoDetail['orderunit']=$item['orderunit'];
				$trxPoDetail['receivedqty']=$item['qty'];
				$trxPoDetail['receivedunit']=$item['orderunit'];

				//hitung total qty dari barang yang direceive dan qty item yang akan di receive
				$finalQty=intval($item['qty'])+intval($this->countItemReceivedQty($trxId,$item['itemNumber'])); 

				//as mapping : qyt < orderqty
				if($finalQty<intval($item['orderqty'])){
					$trxPoDetail['trx_status']=0;//as mapping
					$dataMapping[]=$item['itemNumber'];

					//insert PO detail
					$this->dbTrx->insert("trx_po_detail",$trxPoDetail);

				}else{
					$dataSuccess[]=$item['itemNumber'];//count for compare with jumlah item in POLINE

					//insert PO detail
					$this->dbTrx->insert("trx_po_detail",$trxPoDetail);

					$this->updateItemAsComplete($trxId,$item['itemNumber']); //update all itemnumber as complete qty, changed all status to 1
				}

				$itemNumber=$trxPoDetail['item_number'];
				$location=$trxPoDetail['location_id'];
				$conditionCode="NEW-MATERIAL";
				$qty=$item['qty'];
				$trx="Dr";
				$trxCode=1;
				$reff=$this->getTrxCode($trxId);
				$this->ModelCoreTrx->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff);


			}
		}


		//kros cek lagi apakah semua item quantitynya udah complete
		$this->checkAgainIfQtyIsEnough($trxId);


		//return value
		if(count($dataMapping)>0){

			$trxPoMapping['ponum']=$trxPo['ponum'];
			$trxPoMapping['trx_status']=0;//as mapping
			//insert PO
			$this->dbTrx->where('trx_id',$trxId);
			$this->dbTrx->update("trx_po",$trxPoMapping);
			$response['status']="success";
			$response['detail']="mapping";
			$response['trxId']=$trxId;

			echo json_encode($response);
		}else if(isset($trxPo['ponum'])){

			$trxPoMapping['ponum']=$trxPo['ponum'];

			if($this->countItemInTrxPo($trxId)==$this->countItemInPoLine($trxPo['ponum'])){ // all item complete

				//check is all item is complete qty
				if($this->checkTrxIfComplete($trxId)){
					$trxPoMapping['trx_status']=1;//complete
					//insert PO
					$this->dbTrx->where('trx_id',$trxId);
					$this->dbTrx->update("trx_po",$trxPoMapping);
					$response['status']="success";
					$response['detail']="complete";
					$response['trxId']=$trxId;

					echo json_encode($response);
				}else{ //not item qty complete
					$this->dbTrx->where('trx_id',$trxId);
					$this->dbTrx->update("trx_po",$trxPoMapping);
					$response['status']="success";
					$response['detail']="mapping";
					$response['trxId']=$trxId;

					echo json_encode($response);
				}	

			}else{				
				$trxPoMapping['trx_status']=0;//as mapping : item not all item received
				//insert PO
				$this->dbTrx->where('trx_id',$trxId);
				$this->dbTrx->update("trx_po",$trxPoMapping);
				$response['status']="success";
				$response['detail']="mapping";
				$response['trxId']=$trxId;

				echo json_encode($response);
			}

		}else if(!isset($trxPo['ponum'])){
				$trxPoMapping['trx_status']=0;//as mapping : WITHOUT PO
				//insert PO
				$this->dbTrx->where('trx_id',$trxId);
				$this->dbTrx->update("trx_po",$trxPoMapping);
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

		function checkAgainIfQtyIsEnough($trx_id){
			$dataItem=$this->dbTrx->query("SELECT * FROM trx_po_detail WHERE trx_id='$trx_id'")->result();
			foreach ($dataItem as $key) {
				$dataDetailItem=$this->dbTrx->query("SELECT *,sum(receivedqty) as totalQty FROM trx_po_detail WHERE item_number='$key->item_number' and  trx_id='$trx_id'")->result();
				if($dataDetailItem[0]->totalQty==$dataDetailItem[0]->orderqty){
					$dataUpdate['trx_status']=1;
					$this->dbTrx->where('item_number',$key->item_number);
					$this->dbTrx->where('trx_id',$trx_id);
					$this->dbTrx->update('trx_po_detail',$dataUpdate);
				}
			}
		}


		function updateItemMappingWithPO($dataItem,$po){

			$dataItemNew=[];
			foreach ($dataItem as $item) {
				if($item['orderqty']!=intval($this->getOrderQtyFromPoLine($item['itemNumber'],$po))){
					$trxDetail['location_id']=$this->getLocationIdFromName('WH');
					$trxDetail['itemNumber']=$item['itemNumber'];
					$trxDetail['description']=$item['description'];
					$trxDetail['orderqty']=$this->getOrderQtyFromPoLine($item['itemNumber'],$po);
					$trxDetail['orderunit']=$item['orderunit'];
					$trxDetail['qty']=$item['qty'];
					$trxDetail['receivedunit']=$item['orderunit'];
					$trxDetail['nonPoInsertPo']=0;
					$trxDetail['trx_status']=0;
					array_push($dataItemNew,$trxDetail);
				}
			}

			if(count($dataItemNew)>0){
				return $dataItemNew;
			}else{
				return $dataItem;
			}
		}

		function getOrderQtyFromPoLine($itemNumber,$po){
			$dataOrderQty= $this->dbMaximo->query("SELECT SUM(ORDERQTY) AS ORDERQTY FROM VIEWPOLINE WHERE PONUM='$po' AND ITEMNUM='$itemNumber'")->result();
			return $dataOrderQty[0]->ORDERQTY;
		}


		function withoutPO($POST,$trxId){

			if(isset($POST['dataItem'])){$dataItem=$POST['dataItem'];}else{$dataItem=[];};
			if(isset($POST['dataPO'])){$dataPO=$POST['dataPO'];}else{$dataPO=[];};
			if(isset($POST['dataCompany'])){$dataCompany=$POST['dataCompany'];}else{$dataCompany=[];};
			if(isset($POST['dataShipper'])){$dataShipper=$POST['dataShipper'];}else{$dataShipper=[];};


		//WITH PO
			$trxPo['trx_status']=2;
			$trxPo['company_id']=$dataCompany['companyId'];

	    //trxDB item
			foreach ($dataItem as $item) {
				if(!isset($item['trx_status'])){
					$trxPoDetail['trx_id']=$trxId;
					$trxPoDetail['location_id']=$this->getLocationIdFromName('WH');
					$trxPoDetail['item_number']=$item['itemNumber'];
					$trxPoDetail['description']=$item['description'];
					$trxPoDetail['orderqty']=$item['orderqty'];
					$trxPoDetail['orderunit']=$item['orderunit'];
					$trxPoDetail['receivedqty']=$item['qty'];
					$trxPoDetail['receivedunit']=$item['orderunit'];
				$trxPoDetail['trx_status']=0;//as mapping

				//insert PO detail
				$this->dbTrx->insert("trx_po_detail",$trxPoDetail);

				$itemNumber=$trxPoDetail['item_number'];
				$location=$trxPoDetail['location_id'];
				$conditionCode="NEW-MATERIAL";
				$qty=$item['qty'];
				$trx="Dr";
				$trxCode=1;
				$reff=$this->getTrxCode($trxId);
				$this->ModelCoreTrx->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff);
			}
		}

		$response['status']="success";
		$response['detail']="mapping";
		echo json_encode($response);
	}


	function checkTrxIfComplete($trxId){
		$query=$this->dbTrx->query("SELECT * FROM trx_po_detail WHERE trx_id=$trxId and trx_status=0")->result();
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
		$this->dbTrx->update('trx_po_detail',$dataItem);
	}

	function countItemReceivedQty($trxId,$itemNumber){
		$query=$this->dbTrx->query("select sum(receivedqty) as totalQty from trx_po_detail where item_number=$itemNumber and trx_id=$trxId")->result();
		return $query[0]->totalQty;
	}

	function countItemInPoLine($po){
		$query=$this->dbMaximo->query("SELECT ITEMNUM FROM VIEWPOLINE WHERE PONUM='$po' group by ITEMNUM")->result();
		return count($query);
	}	

	function countItemInTrxPo($trxId){
		$query=$this->dbTrx->query("SELECT * FROM trx_po_detail WHERE trx_id='$trxId' group by item_number")->result();
		return count($query);
	}	


	function getLocationIdFromName($location_name){
		$getLocationId=$this->dbInventory->query("select location_id from location where name='$location_name'")->result();
		return $getLocationId[0]->location_id;
	}

	function getTrxCode($trxId){
		$getTrxCode=$this->dbTrx->query("select trx_code from trx_po where trx_id='$trxId'")->result();
		return $getTrxCode[0]->trx_code;
	}

}