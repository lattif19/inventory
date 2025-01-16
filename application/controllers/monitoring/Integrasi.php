<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Integrasi extends CI_Controller {


	
	function __construct()
	{
		parent::__construct();

		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
		// $this->dbMaximodummy = $this->load->database('maximodummy', TRUE);
		$this->load->model('ModelCoreTrx', '', TRUE);
	}

	function checkLocation($location_id){

		$checkAvailable = $this->dbInventory->where('location_id',$location_id)->get('location')->num();
		return $checkAvailable;
	}

	function location(){

		$dataLocation=$this->dbMaximo->query("SELECT * FROM VIEWLOCATIONS")->result();
		foreach ($dataLocation as $key => $row) {
			$data['location_id']=$row->LOCATIONSID;
			$data['name']=$row->LOCATION;
			$data['description']=$row->DESCRIPTION;
			$data['type']=$row->TYPE;
			$data['status']=$row->STATUS;
			
			// if ($this->checkLocation($row->LOCATIONSID)->location_id!=$row->LOCATIONSID) {
			// 	echo "<pre>";
			// 	echo "belum ada <br>";
			// 	print_r($data);
			// } else {
			// 	echo "sudah ada";
			// }
			$this->dbInventory->insert('location',$data);

		}
		// echo "<pre>";
		// print_r($dataLocation);
	}


	function importBalance(){
		ini_set('memory_limit', '-1');
		$this->dbInventory->query("TRUNCATE `item_balances_maximo`;");
		$dataBalances=$this->dbMaximo->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES")->result();
		// $dataBalances=$this->dbMaximo->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES WHERE SITEID!='SP3' AND SITEID!='SP3A'")->result();
		foreach ($dataBalances as $dataBalance) {
			$data['item_number']=$dataBalance->ITEMNUM;
			$data['description']=$dataBalance->DESCRIPTION;
			$data['location_id']=$this->getLocationId($dataBalance->LOCATION);
			$data['binnum']=$dataBalance->BINNUM;
			$data['qty']=$dataBalance->CURBAL;
			$data['conditioncode']=$dataBalance->CONDITIONCODE;
			$data['siteid']=$dataBalance->SITEID;
			$data['date']=$dataBalance->PHYSCNTDATE;
			$this->dbInventory->insert('item_balances_maximo',$data);

		}
		$this->getFound();
	}



	public function index()
	{
		$data['title']="Realtime Monitoring Integrasi Barcode & Maximo";	

		$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring_integrasi")->result();
		$this->load->view('monitoring/integrasi',$data);
	}

	function getReportMonitoring(){
		$data['title']="Realtime Monitoring Integrasi Barcode & Maximo";	

		$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring_integrasi")->result();
		$this->load->view('monitoring/report_monitoring_integrasi',$data);
	}



public function getFound($location_id=null)
{
	$this->dbInventory->query("TRUNCATE `item_balances_monitoring_integrasi`;");

	$data['title']="Realtime Monitoring Stock Opname";	
	// $data['result'] = $foundInBalances = $this->dbInventory->query("SELECT item_balances.item_number,item_balances.location_id,item_balances.description,item_balances.conditioncode,item_balances.binnum,item_balances.qty,item_balances_maximo.qty as qtyMaximo FROM item_balances,item_balances_maximo where item_balances.item_number=item_balances_maximo.item_number and item_balances.location_id=item_balances_maximo.location_id  and item_balances.conditioncode=item_balances_maximo.conditioncode and item_balances.location_id!='3341' AND item_balances.location_id!='3818'")->result();
	$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT item_balances.item_number,item_balances.location_id,item_balances.description,item_balances.conditioncode,item_balances.binnum,item_balances.qty,item_balances_maximo.qty as qtyMaximo FROM item_balances,item_balances_maximo where item_balances.item_number=item_balances_maximo.item_number and item_balances.location_id=item_balances_maximo.location_id  and item_balances.conditioncode=item_balances_maximo.conditioncode")->result();


	foreach ($foundInBalances as $key) {
		$checkAvailable=$this->checkAvailable($key->item_number,$key->location_id,$key->conditioncode);
			
		if ($checkAvailable=='false'){
			$dataSubmit['item_number']=$key->item_number;
			$dataSubmit['location']=$this->getLocationName($key->location_id);
			$dataSubmit['description']=$key->description;
			$dataSubmit['binnum']=$key->binnum;
			$dataSubmit['conditioncode']=$key->conditioncode;
			$dataSubmit['qty']=$key->qty;
			$dataSubmit['qtyMaximo']=$key->qtyMaximo;
			$dataSubmit['selisih']=$key->qtyMaximo-$key->qty;

			$this->dbInventory->insert('item_balances_monitoring_integrasi',$dataSubmit);
		}else{
			$qtyLast=$checkAvailable['qty'];
			$qtyMaximoLast=$checkAvailable['qtyMaximo'];
			$dataSubmit['item_number']=$key->item_number;
			$dataSubmit['location']=$this->getLocationName($key->location_id);
				// $dataSubmit['conditioncode']=$key->conditioncode;
			$dataSubmit['binnum']=$key->binnum;
			$dataSubmit['qty']=$key->qty+$qtyLast;
			$dataSubmit['qtyMaximo']=$key->qtyMaximo+$qtyMaximoLast;
			$dataSubmit['selisih']=$dataSubmit['qtyMaximo']-$dataSubmit['qty'];

			$this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
			$this->dbInventory->update('item_balances_monitoring_integrasi',$dataSubmit);
		}
	}
}



public function checkAvailable($item_number,$location,$conditioncode){
	$location=$this->getLocationName($location);
	$result=$this->dbInventory->query("select * from item_balances_monitoring_integrasi where item_number='$item_number' and location='$location' and conditioncode='$conditioncode'")->result();
	if(count($result)>0){
		$data['item_balance_id']=$result[0]->item_balance_id;
		$data['qty']=$result[0]->qty;
		$data['qtyMaximo']=$result[0]->qtyMaximo;
		return $data;
	}else{
		return 'false';
	}
}



public function getLocationName($location_id){
	return	$this->dbInventory->query("select name from location where location_id=$location_id ")->row()->name;
}

public function getLocationId($location){
	return	$this->dbInventory->query("select location_id from location where name='$location'")->row()->location_id;
}



public function getAll($location=NULL){
	// $this->dbInventory->query("TRUNCATE `item_balances_monitoring`;");
	// $this->dbInventory->query("TRUNCATE `item_balances_monitoring2`;");
	// $this->getFound($this->getLocationId('WH'));
	// $this->getFound2($this->getLocationId('WH2'));
	// 	// $this->getNotFound();
	// $this->getNotFound($this->getLocationId('WH'));
	// $this->getNotFound2($this->getLocationId('WH2'));
	// $this->getNameStatus3();
}


public function getNameStatus3(){
	$query=$this->dbInventory->query("SELECT * FROM item_balances_monitoring where status=3")->result();
	foreach ($query as $key) {
		$dataUpdate['description']=$this->getName($key->item_number);
		$this->dbInventory->where('item_balance_id',$key->item_balance_id);
		$this->dbInventory->update('item_balances_monitoring',$dataUpdate);
	}



	$query=$this->dbInventory->query("SELECT * FROM item_balances_monitoring2 where status=3")->result();
	foreach ($query as $key) {
		$dataUpdate['description']=$this->getName($key->item_number);
		$this->dbInventory->where('item_balance_id',$key->item_balance_id);
		$this->dbInventory->update('item_balances_monitoring2',$dataUpdate);
	}


	$query=$this->dbInventory->query("SELECT * FROM item_balances_monitoring3 where status=3")->result();
	foreach ($query as $key) {
		$dataUpdate['description']=$this->getName($key->item_number);
		$this->dbInventory->where('item_balance_id',$key->item_balance_id);
		$this->dbInventory->update('item_balances_monitoring3',$dataUpdate);
	}
}

public function getName($item_number){
	$query=$this->dbInventory->query("SELECT * FROM item_balances where item_number=$item_number")->row();
	return $query->description;
}






public function export_excel_terscan($location="WH"){


	if($location=='WH'){
		$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring where status=1 and location='$location'")->result();
	}else if($location=='WH2'){
		$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring2 where status=1 and location='$location'")->result();
		}else if($location=='WH3'){
			$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring3 where status=1 and location='$location'")->result();
	}


	$data['result'] = $foundInBalances;
	$data['location'] = $location;
	$this->load->view('monitoring/monitoring_terscan', $data);
}

public function export_excel_belum_terscan($location="WH"){

		if($location=='WH'){
		$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring where status=3 and location='$location'")->result();
	}else if($location=='WH2'){
		$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring2 where status=3 and location='$location'")->result();
		}else if($location=='WH3'){
			$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring3 where status=3 and location='$location'")->result();
	}

	$data['result3'] = $foundInBalances; 	
	$data['location'] = $location;
	$this->load->view('monitoring/monitoring_belum_terscan', $data);
}

function export_not_compare(){
	$data['result'] = $foundInBalances = $this->dbInventory->query("select * from stock_opname.trx_so_detail where trx_so_detail.item_number not in (select inventory.item_balances_monitoring.item_number from inventory.item_balances_monitoring)");

	$data['location'] = $location;
	$this->load->view('monitoring/monitoring_tidak_tercompare', $data);
}


//NUMPANG MONITORING PR
	public function getDataPr(){
		$response=$this->dbMaximo->query("SELECT  * FROM (SELECT  * FROM VIEWPO ORDER BY ORDERDATE DESC) WHERE ROWNUM<'100'")->result();
		echo json_encode($response);
	}

	public function getDetailPr($pr){
		$detailPO=$this->dbMaximo->query("SELECT  * FROM VIEWPO WHERE PONUM='$pr'")->result();
		$detailItem=$this->dbMaximo->query("SELECT  * FROM VIEWPOLINE WHERE PONUM='$pr'")->result();
		$data['detailPO']=$detailPO;
		$data['detailItem']=$detailItem;
		echo json_encode($data);
	}

}