<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();

		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
		$this->dbMaximoDummy = $this->load->database('maximodummy', TRUE);
	}

	public function index(){
		$this->bcpo();
		$this->bcwo();
	}
	



	public function bcpo(){

		//RECEIVING 
		$dataPo=$this->dbTrx->query("select trx_detail_id, trx_po_detail.ponum,item_number,receivedqty,receivingtype,trx_timestamp,location_id,enterby,conditioncode from trx_po_detail, trx_po where trx_po.trx_id=trx_po_detail.trx_id and trx_po_detail.export_status=0 and trx_po_detail.trx_status=1 and trx_po_detail.ponum IS NOT NULL")->result();
        foreach ($dataPo as $key) {
        	$this->dbMaximoDummy->set('PONUM',$key->ponum);
			$this->dbMaximoDummy->set('ITEMNUM',$key->item_number);
			$this->dbMaximoDummy->set('QUANTITY',$key->receivedqty);
			$this->dbMaximoDummy->set('ISSUETYPE',$key->receivingtype);
			$this->dbMaximoDummy->set('ACTUALDATE',"TO_DATE('".$key->trx_timestamp."', 'yyyy-mm-dd HH24:MI:SS')",FALSE);
			$this->dbMaximoDummy->set('TOSTORELOC',$this->getLocationName($key->location_id));
			$this->dbMaximoDummy->set('ENTERBY',$key->enterby);
			$this->dbMaximoDummy->set('REMARK',NULL);
			$this->dbMaximoDummy->set('TRANSID',$this->getLastTransIdPo());
			$this->dbMaximoDummy->set('TRANSSEQ',0);
			$this->dbMaximoDummy->set('PROCESSED',0);
			$this->dbMaximoDummy->set('CONDITIONCODE',$key->conditioncode);
			$this->dbMaximoDummy->set('BINNUM',$this->getBinnum($key->item_number,$key->location_id,$key->conditioncode)); 
			$this->dbMaximoDummy->insert('BCPO');

			$dataUpdate['export_status']=1;
			$this->dbTrx->where('trx_detail_id',$key->trx_detail_id);
			$this->dbTrx->update('trx_po_detail',$dataUpdate);
        }




        //RETURN TO VENDOR

        		//RECEIVING 
		$dataPo=$this->dbTrx->query("select trx_detail_id, trx_po_return.ponum,item_number,returnqty,receivingtype,trx_timestamp,location_id,enterby,conditioncode from trx_po_detail_return, trx_po_return where trx_po_return.trx_id=trx_po_detail_return.trx_id and trx_po_detail_return.trx_status=1 and trx_po_detail_return.export_status=0")->result();
        foreach ($dataPo as $key) {
        	$this->dbMaximoDummy->set('PONUM',$key->ponum);
			$this->dbMaximoDummy->set('ITEMNUM',$key->item_number);
			$this->dbMaximoDummy->set('QUANTITY',$key->returnqty);
			$this->dbMaximoDummy->set('ISSUETYPE',$key->receivingtype);
			$this->dbMaximoDummy->set('ACTUALDATE',"TO_DATE('".$key->trx_timestamp."', 'yyyy-mm-dd HH24:MI:SS')",FALSE);
			$this->dbMaximoDummy->set('TOSTORELOC',$this->getLocationName($key->location_id));
			$this->dbMaximoDummy->set('ENTERBY',$key->enterby);
			$this->dbMaximoDummy->set('REMARK',NULL);
			$this->dbMaximoDummy->set('TRANSID',$this->getLastTransIdPo());
			$this->dbMaximoDummy->set('TRANSSEQ',0);
			$this->dbMaximoDummy->set('PROCESSED',0);
			$this->dbMaximoDummy->set('CONDITIONCODE',$key->conditioncode);
			$this->dbMaximoDummy->set('BINNUM',$this->getBinnum($key->item_number,$key->location_id,$key->conditioncode)); 
			$this->dbMaximoDummy->insert('BCPO');

			$dataUpdate['export_status']=1;
			$this->dbTrx->where('trx_detail_id',$key->trx_detail_id);
			$this->dbTrx->update('trx_po_detail_return',$dataUpdate);

        }	


	}


	function getBinnum($item_number,$location_id,$conditioncode){
		$dataBinnum=$this->dbInventory->query("select binnum from item_balances where item_number=$item_number and location_id=$location_id and conditioncode='$conditioncode'")->result();
		return $dataBinnum[0]->binnum;
	}




	function getLocationName($location_id){
		$getLocation = $this->dbInventory->query("select * from location where location_id ='$location_id'")->result();
		return $getLocation[0]->name;
	}

	function getLastTransIdPo(){
		$transid=$this->dbMaximoDummy->query('select TRANSID from ( select * from BCPO order by TRANSID desc ) where ROWNUM <= 1')->result();
		return $transid[0]->TRANSID+1;
	}


	public function bcwo(){
		$dataWo=$this->dbTrx->query("select trx_detail_id, trx_wo.wonum,item_number,issuedqty,issuetype,note,issueto,trx_timestamp,location_id,enterby,conditioncode,binnum from trx_wo_detail, trx_wo where trx_wo.trx_id=trx_wo_detail.trx_id and trx_wo_detail.wonum IS NOT NULL and trx_wo_detail.export_status=0 and trx_wo_detail.trx_status=1")->result();
        foreach ($dataWo as $key) {
        	$this->dbMaximoDummy->set('WONUM',$key->wonum);
			$this->dbMaximoDummy->set('ITEMNUM',$key->item_number);
			$this->dbMaximoDummy->set('QUANTITY',''.$key->issuedqty.'');
			$this->dbMaximoDummy->set('ISSUETYPE',$key->issuetype);
			$this->dbMaximoDummy->set('ACTUALDATE',"TO_DATE('".$key->trx_timestamp."', 'yyyy-mm-dd HH24:MI:SS')",FALSE);
			$this->dbMaximoDummy->set('STORELOC',$this->getLocationName($key->location_id));
			$this->dbMaximoDummy->set('MEMO',$key->note);
			$this->dbMaximoDummy->set('ISSUETO',$key->issueto);
			$this->dbMaximoDummy->set('ENTERBY',$key->enterby);
			$this->dbMaximoDummy->set('TRANSID',$this->getLastTransIdWo());
			$this->dbMaximoDummy->set('TRANSSEQ',1);
			$this->dbMaximoDummy->set('PROCESSED',0);
			$this->dbMaximoDummy->set('CONDITIONCODE',$key->conditioncode);
			$this->dbMaximoDummy->set('BINNUM',$key->binnum); 
			$this->dbMaximoDummy->insert('BCWO');

			$dataUpdate['export_status']=1;
			$this->dbTrx->where('trx_detail_id',$key->trx_detail_id);
			$this->dbTrx->update('trx_wo_detail',$dataUpdate);
        }


		$dataWo=$this->dbTrx->query("select trx_detail_id, trx_wo_return.wonum,item_number,returnqty,issuetype,note,issueto,trx_timestamp,location_id,enterby,conditioncode from trx_wo_detail_return, trx_wo_return where trx_wo_return.trx_id=trx_wo_detail_return.trx_id and trx_wo_detail_return.export_status=0")->result();
        foreach ($dataWo as $key) {
        	$this->dbMaximoDummy->set('WONUM',$key->wonum);
			$this->dbMaximoDummy->set('ITEMNUM',$key->item_number);
			$this->dbMaximoDummy->set('QUANTITY',''.$key->returnqty.'');
			$this->dbMaximoDummy->set('ISSUETYPE',$key->issuetype);
			$this->dbMaximoDummy->set('ACTUALDATE',"TO_DATE('".$key->trx_timestamp."', 'yyyy-mm-dd HH24:MI:SS')",FALSE);
			$this->dbMaximoDummy->set('STORELOC',$this->getLocationName($key->location_id));
			$this->dbMaximoDummy->set('MEMO',$key->note);
			$this->dbMaximoDummy->set('ISSUETO',$key->issueto);
			$this->dbMaximoDummy->set('ENTERBY',$key->enterby);
			$this->dbMaximoDummy->set('TRANSID',$this->getLastTransIdWo());
			$this->dbMaximoDummy->set('TRANSSEQ',1);
			$this->dbMaximoDummy->set('PROCESSED',0);
			$this->dbMaximoDummy->set('CONDITIONCODE',$key->conditioncode);
			$this->dbMaximoDummy->set('BINNUM',$key->binnum); 
			$this->dbMaximoDummy->insert('BCWO');

			$dataUpdate['export_status']=1;
			$this->dbTrx->where('trx_detail_id',$key->trx_detail_id);
			$this->dbTrx->update('trx_wo_detail_return',$dataUpdate);
        }
	}

	function getLastTransIdWo(){
		$transid=$this->dbMaximoDummy->query('select TRANSID from ( select * from BCWO order by TRANSID desc ) where ROWNUM <= 1')->result();
		return $transid[0]->TRANSID+1;
	}



	function adjsample(){
		$dataCurbal=$this->dbInventory->query("select * from item_balances limit 50")->result();
		foreach ($dataCurbal as $value) {
			$data['ITEMNUM']=$value->item_number;
			$data['LOCATION']=$this->getLocationName($value->location_id);
			$data['BINNUM']=$value->binnum;
			$data['CURBAL']=$value->qty;
			$data['CONDITIONCODE']=$value->conditioncode;
			$data['SITEID']=$value->siteid;
			$this->dbMaximoDummy->set('TRX_TIMESTAMP',"TO_DATE('2017-02-21 09:14:58', 'yyyy-mm-dd HH24:MI:SS')",FALSE);
			$this->dbMaximoDummy->insert('BCCURBALADJ',$data);
		}
	}



}