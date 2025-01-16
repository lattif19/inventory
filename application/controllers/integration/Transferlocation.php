<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transferlocation extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
		$this->load->model('ModelCoreTrx', '', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
		$this->dbMaximoDummy = $this->load->database('maximodummy', TRUE);
		
	}

	public function index(){
		$this->import();
		$this->process();
	}


	public function import(){

		$from_date=date('m/d/Y').' 00:00:00';
		$to_date=date('m/d/Y').' 23:59:00';

		// $from_date='02/09/2017 00:00:01';
		// $to_date='02/09/2017 23:59:59';


		$dataTrfLoc=$this->dbMaximo->query("Select MATRECTRANSID,ITEMNUM,to_char(TRANSDATE, 'yyyy-mm-dd HH24:MI:SS') as TRANSDATE,QUANTITY,RECEIVEDUNIT,TOSTORELOC,FROMSTORELOC,TOBIN,FROMBIN,FROMSITEID,SITEID,FROMCONDITIONCODE,CONDITIONCODE from VIEWMATRECTRANS WHERE transdate between to_date('$from_date', 'mm/dd/yyyy HH24:MI:SS') and to_date('$to_date','mm/dd/yyyy HH24:MI:SS') order by transdate asc")->result();

		foreach ($dataTrfLoc as $key) {
			$data['MATRECTRANSID']=$key->MATRECTRANSID;
			$data['ITEMNUM']=$key->ITEMNUM;
			$data['TRANSDATE']=$key->TRANSDATE;
			$data['QUANTITY']=$key->QUANTITY;
			$data['RECEIVEDUNIT']=$key->RECEIVEDUNIT;
			$data['TOSTORELOC']=$key->TOSTORELOC;
			$data['FROMSTORELOC']=$key->FROMSTORELOC;
			$data['TOBIN']=$key->TOBIN;
			$data['FROMBIN']=$key->FROMBIN;
			$data['FROMSITEID']=$key->FROMSITEID;
			$data['SITEID']=$key->SITEID;
			$data['FROMCONDITIONCODE']=$key->FROMCONDITIONCODE;
			$data['CONDITIONCODE']=$key->CONDITIONCODE;
			if($this->checkTransId($key->MATRECTRANSID)){
				$this->dbTrx->insert('trx_trf_location',$data);
			}
		}
	}

	function checkTransId($TransId){
		$dataTrfLoc=$this->dbTrx->query("Select * from trx_trf_location WHERE MATRECTRANSID=$TransId")->result();
		if(count($dataTrfLoc)==0){
			return 1;
		}else{
			return 0;
		}
	}

	public function process(){
		$this->processTransferToDummy();
		$dataTrfLoc=$this->dbTrx->query("Select * from trx_trf_location WHERE PROCESSED=0")->result();
		foreach ($dataTrfLoc as $key) {
			$data['MATRECTRANSID']=$key->MATRECTRANSID;
			$data['ITEMNUM']=$key->ITEMNUM;
			$data['TRANSDATE']=$key->TRANSDATE;
			$data['QUANTITY']=$key->QUANTITY;
			$data['RECEIVEDUNIT']=$key->RECEIVEDUNIT;
			$data['TOSTORELOC']=$key->TOSTORELOC;
			$data['FROMSTORELOC']=$key->FROMSTORELOC;
			$data['TOBIN']=$key->TOBIN;
			$data['FROMBIN']=$key->FROMBIN;
			$data['FROMSITEID']=$key->FROMSITEID;
			$data['SITEID']=$key->SITEID;
			$data['FROMCONDITIONCODE']=$key->FROMCONDITIONCODE;
			$data['CONDITIONCODE']=$key->CONDITIONCODE;


			if($key->TOSTORELOC==$key->FROMSTORELOC&&$key->FROMCONDITIONCODE==$key->CONDITIONCODE){ //cek apakah hanya penambahan nama binum
				$itemNumber=$key->ITEMNUM;
				$location=$this->getLocationId($key->FROMSTORELOC);
				$conditionCode=$key->FROMCONDITIONCODE;
				$fromBin=$key->FROMBIN;
				$toBin=$key->TOBIN;
				$qty=$key->QUANTITY;
				$siteid=$key->SITEID;
				$reff="MATRECTRANSID ".$key->MATRECTRANSID." : BIN TO BIN | From $key->FROMBIN to $key->TOBIN";
				$this->ModelCoreTrx->updateBin($itemNumber,$location,$conditionCode,$fromBin,$toBin,$qty,$reff);
			}else{
				//trx core item FROM
				$itemNumber=$key->ITEMNUM;
				$location=$this->getLocationId($key->FROMSTORELOC);
				$conditionCode=$key->FROMCONDITIONCODE;
				$qty=$key->QUANTITY;
				$trx="Kr";
				$trxCode=5;
				$binnum=$key->FROMBIN;
				$siteid=$key->SITEID;
				$reff="MATRECTRANSID ".$key->MATRECTRANSID." : From $key->FROMSTORELOC to $key->TOSTORELOC";
				$this->ModelCoreTrx->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff,$binnum,$siteid);

				//trx core item TO
				$itemNumber=$key->ITEMNUM;
				$location=$this->getLocationId($key->TOSTORELOC);
				$conditionCode=$key->CONDITIONCODE;
				$qty=$key->QUANTITY;
				$trx="Dr";
				$trxCode=5;
				$binnum=$key->TOBIN;
				$siteid=$key->SITEID;
				$reff="MATRECTRANSID ".$key->MATRECTRANSID." : From $key->FROMSTORELOC to $key->TOSTORELOC";
				$this->ModelCoreTrx->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff,$binnum,$siteid);
			}

			$dataUpdate['PROCESSED']=1;
			$this->dbTrx->where('MATRECTRANSID',$key->MATRECTRANSID);
			$this->dbTrx->update('trx_trf_location',$dataUpdate);

		}
	}




	public function processTransferToDummy(){
		$dataTrfLoc=$this->dbTrx->query("Select * from trx_trf_location WHERE PROCESSED=0")->result();
		foreach ($dataTrfLoc as $key) {
			$this->dbMaximoDummy->set('MATRECTRANSID',$key->MATRECTRANSID);
			$this->dbMaximoDummy->set('ITEMNUM',$key->ITEMNUM);
			$this->dbMaximoDummy->set('TRANSDATE',"TO_DATE('".$key->TRANSDATE."', 'yyyy-mm-dd HH24:MI:SS')",FALSE);
			$this->dbMaximoDummy->set('QUANTITY',$key->QUANTITY);
			$this->dbMaximoDummy->set('RECEIVEDUNIT',$key->RECEIVEDUNIT);
			$this->dbMaximoDummy->set('TOSTORELOC',$key->TOSTORELOC);
			$this->dbMaximoDummy->set('FROMSTORELOC',$key->FROMSTORELOC);
			$this->dbMaximoDummy->set('TOBIN',$key->TOBIN);
			$this->dbMaximoDummy->set('FROMBIN',$key->FROMBIN);
			$this->dbMaximoDummy->set('FROMSITEID',$key->FROMSITEID);
			$this->dbMaximoDummy->set('SITEID',$key->SITEID);
			$this->dbMaximoDummy->set('FROMCONDITIONCODE',$key->FROMCONDITIONCODE);
			$this->dbMaximoDummy->set('CONDITIONCODE',$key->CONDITIONCODE);
			$this->dbMaximoDummy->set('TRANSID',$this->getLastTransIdNico());
			$this->dbMaximoDummy->insert('BCTRANSFER');
		}
	}


	function getLastTransIdNico(){
		$transid=$this->dbMaximoDummy->query('select TRANSID from ( select TRANSID from BCTRANSFER order by TRANSID desc ) where ROWNUM <= 1')->result();
		return $transid[0]->TRANSID+1;
	}

	function reqNico(){


		$from_date='07/17/2017 00:00:00';
		$to_date='07/17/2017 23:59:00';

		// $from_date='02/09/2017 00:00:01';
		// $to_date='02/09/2017 23:59:59';


		$dataTrfLoc=$this->dbMaximo->query("Select MATRECTRANSID,ITEMNUM,to_char(TRANSDATE, 'yyyy-mm-dd HH24:MI:SS') as TRANSDATE,QUANTITY,RECEIVEDUNIT,TOSTORELOC,FROMSTORELOC,TOBIN,FROMBIN,FROMSITEID,SITEID,FROMCONDITIONCODE,CONDITIONCODE from VIEWMATRECTRANS WHERE transdate between to_date('$from_date', 'mm/dd/yyyy HH24:MI:SS') and to_date('$to_date','mm/dd/yyyy HH24:MI:SS') order by transdate asc")->result();

		foreach ($dataTrfLoc as $key) {

			$this->dbMaximoDummy->set('MATRECTRANSID',$key->MATRECTRANSID);
			$this->dbMaximoDummy->set('ITEMNUM',$key->ITEMNUM);
			$this->dbMaximoDummy->set('TRANSDATE',"TO_DATE('".$key->TRANSDATE."', 'yyyy-mm-dd HH24:MI:SS')",FALSE);
			$this->dbMaximoDummy->set('QUANTITY',$key->QUANTITY);
			$this->dbMaximoDummy->set('RECEIVEDUNIT',$key->RECEIVEDUNIT);
			$this->dbMaximoDummy->set('TOSTORELOC',$key->TOSTORELOC);
			$this->dbMaximoDummy->set('FROMSTORELOC',$key->FROMSTORELOC);
			$this->dbMaximoDummy->set('TOBIN',$key->TOBIN);
			$this->dbMaximoDummy->set('FROMBIN',$key->FROMBIN);
			$this->dbMaximoDummy->set('FROMSITEID',$key->FROMSITEID);
			$this->dbMaximoDummy->set('SITEID',$key->SITEID);
			$this->dbMaximoDummy->set('FROMCONDITIONCODE',$key->FROMCONDITIONCODE);
			$this->dbMaximoDummy->set('CONDITIONCODE',$key->CONDITIONCODE);
			$this->dbMaximoDummy->set('TRANSID',$this->getLastTransIdNico());
			$this->dbMaximoDummy->insert('BCTRANSFER');

			}
		}

	function getLocationId($location){
		$dataLocation=$this->dbInventory->query("select * from location where name='$location'")->result();
		return $dataLocation[0]->location_id;
	}


}