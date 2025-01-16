	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
		// $this->dbMaximodummy = $this->load->database('maximodummy', TRUE);
		$this->load->model('ModelCoreTrx', '', TRUE);
	}

	function index(){

		$data['title']="IMPORT DATA STOCK OPNAME";	
		$data['countWh1'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_forSo where location_id='1203'")->row();
		$data['countWh2'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_forSo where location_id='2201'")->row();
		$data['countWh3'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_forSo where location_id='2301'")->row();
		$data['countChem'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_forSo where location_id='1902'")->row();
		$data['countSP3'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_forSo where location_id='3341'")->row();
		$data['countSP3A'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_forSo where location_id='3818'")->row();
		
		$data['countBalancesMonitoringWh1'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_monitoring where location='1203'")->row();
		$data['countBalancesMonitoringWh2'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_monitoring2 where location='2201'")->row();
		$data['countBalancesMonitoringWh3'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_monitoring3 where location='2301'")->row();
		$data['countBalancesMonitoringChem'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_monitoring_chem where location='1902'")->row();
		$data['countBalancesMonitoringSP3'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_monitoringsp3 where location='3341'")->row();
		$data['countBalancesMonitoringSP3A'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_monitoringsp3a where location='3818'")->row();
		$this->load->view('import',$data);
	}


	function importBalance(){

		$dataBalances=$this->dbMaximo->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES")->result();
		foreach ($dataBalances as $dataBalance) {
			$data['item_number']=$dataBalance->ITEMNUM;
			$data['description']=$dataBalance->DESCRIPTION;
			$data['location_id']=$this->getLocationId($dataBalance->LOCATION);
			$data['binnum']=$dataBalance->BINNUM;
			$data['qty']=$dataBalance->CURBAL;
			$data['conditioncode']=$dataBalance->CONDITIONCODE;
			$data['siteid']=$dataBalance->SITEID;
			$data['date']=$dataBalance->PHYSCNTDATE;
			$this->dbInventory->insert('item_balances',$data);

		}

	}

	function getLocationId($location){
		$getLocation = $this->dbInventory->query("select * from location where name ='$location'")->result();
		return $getLocation[0]->location_id;
	}


	function importBalanceForSo(){
		// UNTUK MEN TRUNCATE DATA
		$this->dbInventory->query("TRUNCATE `item_balances_forSo`;");
		// UNTUK MENGINSERT DATA
		$dataBalances=$this->dbMaximo->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WH'")->result();
		// $dataBalances=$this->dbMaximodum->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WH'")->result();
		foreach ($dataBalances as $dataBalance) {
			$data['item_number']=$dataBalance->ITEMNUM;
			if($dataBalance->DESCRIPTION!=NULL){
			$data['description']=$dataBalance->DESCRIPTION;
				
			}
			$data['location_id']=$this->getLocationId($dataBalance->LOCATION);
			$data['binnum']=$dataBalance->BINNUM;
			$data['qty']=$dataBalance->CURBAL;
			$data['conditioncode']=$dataBalance->CONDITIONCODE;
			$data['siteid']=$dataBalance->SITEID;
			$data['date']=$dataBalance->PHYSCNTDATE;
			$this->dbInventory->insert('item_balances_forSo',$data);

		}

		redirect('integration/import');

	}

	// import data maximo to barcode stockopname where location and item_balances_monitoring
	// untuk WH 1
	function importBalanceForMonitoring1(){
		// UNTUK MEN TRUNCATE DATA
		$this->dbInventory->query("TRUNCATE `item_balances_monitoring`;");
		// UNTUK MENGINSERT DATA
		$dataBalances=$this->dbMaximo->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WH'")->result();
		foreach ($dataBalances as $dataBalance) {
			$data['item_number']=$dataBalance->ITEMNUM;
			if($dataBalance->DESCRIPTION!=NULL){
			$data['description']=$dataBalance->DESCRIPTION;
				
			}
			$data['location']=$this->getLocationId($dataBalance->LOCATION);
			$data['binnum']=$dataBalance->BINNUM;
			$data['qty']=$dataBalance->CURBAL;
			$data['conditioncode']=$dataBalance->CONDITIONCODE;
			// $data['siteid']=$dataBalance->SITEID;
			$data['date']=$dataBalance->PHYSCNTDATE;
			$this->dbInventory->insert('item_balances_monitoring',$data);

		}

		redirect('integration/import');
	}


	function importBalanceForSoWH2(){
		// UNTUK MEN TRUNCATE DATA
		// $this->dbInventory->query("TRUNCATE `item_balances_forSo`;");
		// UNTUK MENGINSERT DATA
		$dataBalances=$this->dbMaximo->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WH2'")->result();
		// $dataBalances=$this->dbMaximodum->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WH'")->result();
		foreach ($dataBalances as $dataBalance) {
			$data['item_number']=$dataBalance->ITEMNUM;
			if($dataBalance->DESCRIPTION!=NULL){
			$data['description']=$dataBalance->DESCRIPTION;
				
			}
			$data['location_id']=$this->getLocationId($dataBalance->LOCATION);
			$data['binnum']=$dataBalance->BINNUM;
			$data['qty']=$dataBalance->CURBAL;
			$data['conditioncode']=$dataBalance->CONDITIONCODE;
			$data['siteid']=$dataBalance->SITEID;
			$data['date']=$dataBalance->PHYSCNTDATE;
			$this->dbInventory->insert('item_balances_forSo',$data);

		}

		redirect('integration/import');
	}

	// import data maximo to barcode stockopname where location and item_balances_monitoring2
	// UNTUK WH 2
	function importBalanceForMonitoring2(){
		// UNTUK MEN TRUNCATE DATA
		$this->dbInventory->query("TRUNCATE `item_balances_monitoring2`;");
		// UNTUK MENGINSERT DATA
		$dataBalances=$this->dbMaximo->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WH2'")->result();
		foreach ($dataBalances as $dataBalance) {
			$data['item_number']=$dataBalance->ITEMNUM;
			if($dataBalance->DESCRIPTION!=NULL){
			$data['description']=$dataBalance->DESCRIPTION;
				
			}
			$data['location']=$this->getLocationId($dataBalance->LOCATION);
			$data['binnum']=$dataBalance->BINNUM;
			$data['qty']=$dataBalance->CURBAL;
			$data['conditioncode']=$dataBalance->CONDITIONCODE;
			// $data['siteid']=$dataBalance->SITEID;
			$data['date']=$dataBalance->PHYSCNTDATE;
			$this->dbInventory->insert('item_balances_monitoring2',$data);

		}

		redirect('integration/import');
	}


	function importBalanceForSoWH3(){
		// UNTUK MEN TRUNCATE DATA
		// $this->dbInventory->query("TRUNCATE `item_balances_forSo`;");
		// UNTUK MENGINSERT DATA
		$dataBalances=$this->dbMaximo->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WH3'")->result();
		// $dataBalances=$this->dbMaximodum->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WH'")->result();
		foreach ($dataBalances as $dataBalance) {
			$data['item_number']=$dataBalance->ITEMNUM;
			if($dataBalance->DESCRIPTION!=NULL){
			$data['description']=$dataBalance->DESCRIPTION;
				
			}
			$data['location_id']=$this->getLocationId($dataBalance->LOCATION);
			$data['binnum']=$dataBalance->BINNUM;
			$data['qty']=$dataBalance->CURBAL;
			$data['conditioncode']=$dataBalance->CONDITIONCODE;
			$data['siteid']=$dataBalance->SITEID;
			$data['date']=$dataBalance->PHYSCNTDATE;
			$this->dbInventory->insert('item_balances_forSo',$data);

		}

		redirect('integration/import');

	}
	// import data maximo to barcode stockopname where location and item_balances_monitoring
	// UNTUK WH 3
	function importBalanceForMonitoring3(){
		// UNTUK MEN TRUNCATE DATA
		$this->dbInventory->query("TRUNCATE `item_balances_monitoring3`;");
		// UNTUK MENGINSERT DATA
		$dataBalances=$this->dbMaximo->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WH3'")->result();
		foreach ($dataBalances as $dataBalance) {
			$data['item_number']=$dataBalance->ITEMNUM;
			if($dataBalance->DESCRIPTION!=NULL){
			$data['description']=$dataBalance->DESCRIPTION;
				
			}
			$data['location']=$this->getLocationId($dataBalance->LOCATION);
			$data['binnum']=$dataBalance->BINNUM;
			$data['qty']=$dataBalance->CURBAL;
			$data['conditioncode']=$dataBalance->CONDITIONCODE;
			// $data['siteid']=$dataBalance->SITEID;
			$data['date']=$dataBalance->PHYSCNTDATE;
			$this->dbInventory->insert('item_balances_monitoring3',$data);

		}

		redirect('integration/import');

	}



	function importBalanceForSoWHSP3(){
		// UNTUK MEN TRUNCATE DATA
		// $this->dbInventory->query("TRUNCATE `item_balances_forSo`;");
		// UNTUK MENGINSERT DATA
		$dataBalances=$this->dbMaximo->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WHSP3'")->result();
		// $dataBalances=$this->dbMaximodum->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WH'")->result();
		foreach ($dataBalances as $dataBalance) {
			$data['item_number']=$dataBalance->ITEMNUM;
			if($dataBalance->DESCRIPTION!=NULL){
			$data['description']=$dataBalance->DESCRIPTION;
				
			}
			$data['location_id']=$this->getLocationId($dataBalance->LOCATION);
			$data['binnum']=$dataBalance->BINNUM;
			$data['qty']=$dataBalance->CURBAL;
			$data['conditioncode']=$dataBalance->CONDITIONCODE;
			$data['siteid']=$dataBalance->SITEID;
			$data['date']=$dataBalance->PHYSCNTDATE;
			$this->dbInventory->insert('item_balances_forSo',$data);

		}

		redirect('integration/import');

	}

	function importBalanceForMonitoringSP3(){
		// UNTUK MEN TRUNCATE DATA
		$this->dbInventory->query("TRUNCATE `item_balances_monitoringsp3`;");
		// UNTUK MENGINSERT DATA
		$dataBalances=$this->dbMaximo->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WHSP3'")->result();
		foreach ($dataBalances as $dataBalance) {
			$data['item_number']=$dataBalance->ITEMNUM;
			if($dataBalance->DESCRIPTION!=NULL){
			$data['description']=$dataBalance->DESCRIPTION;
				
			}
			$data['location']=$this->getLocationId($dataBalance->LOCATION);
			$data['binnum']=$dataBalance->BINNUM;
			$data['qty']=$dataBalance->CURBAL;
			$data['conditioncode']=$dataBalance->CONDITIONCODE;
			// $data['siteid']=$dataBalance->SITEID;
			$data['date']=$dataBalance->PHYSCNTDATE;
			$this->dbInventory->insert('item_balances_monitoringsp3',$data);

		}

		redirect('integration/import');

	}


	function importBalanceForSoWHSP3A(){
		// UNTUK MEN TRUNCATE DATA
		// $this->dbInventory->query("TRUNCATE `item_balances_forSo`;");
		// UNTUK MENGINSERT DATA
		$dataBalances=$this->dbMaximo->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WHSP3A'")->result();
		// $dataBalances=$this->dbMaximodum->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WH'")->result();
		foreach ($dataBalances as $dataBalance) {
			$data['item_number']=$dataBalance->ITEMNUM;
			if($dataBalance->DESCRIPTION!=NULL){
			$data['description']=$dataBalance->DESCRIPTION;
				
			}
			$data['location_id']=$this->getLocationId($dataBalance->LOCATION);
			$data['binnum']=$dataBalance->BINNUM;
			$data['qty']=$dataBalance->CURBAL;
			$data['conditioncode']=$dataBalance->CONDITIONCODE;
			$data['siteid']=$dataBalance->SITEID;
			$data['date']=$dataBalance->PHYSCNTDATE;
			$this->dbInventory->insert('item_balances_forSo',$data);

		}

		redirect('integration/import');

	}

	function importBalanceForMonitoringSP3A(){
		// UNTUK MEN TRUNCATE DATA
		$this->dbInventory->query("TRUNCATE `item_balances_monitoringsp3a`;");
		// UNTUK MENGINSERT DATA
		$dataBalances=$this->dbMaximo->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WHSP3A'")->result();
		foreach ($dataBalances as $dataBalance) {
			$data['item_number']=$dataBalance->ITEMNUM;
			if($dataBalance->DESCRIPTION!=NULL){
			$data['description']=$dataBalance->DESCRIPTION;
				
			}
			$data['location']=$this->getLocationId($dataBalance->LOCATION);
			$data['binnum']=$dataBalance->BINNUM;
			$data['qty']=$dataBalance->CURBAL;
			$data['conditioncode']=$dataBalance->CONDITIONCODE;
			// $data['siteid']=$dataBalance->SITEID;
			$data['date']=$dataBalance->PHYSCNTDATE;
			$this->dbInventory->insert('item_balances_monitoringsp3a',$data);

		}

		redirect('integration/import');

	}

	// UNTUK CHEMICAL
	function importBalanceForMonitoringChem(){
		// UNTUK MEN TRUNCATE DATA
		$this->dbInventory->query("TRUNCATE `item_balances_monitoring_chem`;");
		// UNTUK MENGINSERT DATA
		$dataBalances=$this->dbMaximo->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='CHEM'")->result();
		foreach ($dataBalances as $dataBalance) {
			$data['item_number']=$dataBalance->ITEMNUM;
			if($dataBalance->DESCRIPTION!=NULL){
			$data['description']=$dataBalance->DESCRIPTION;
				
			}
			$data['location']=$this->getLocationId($dataBalance->LOCATION);
			$data['binnum']=$dataBalance->BINNUM;
			$data['qty']=$dataBalance->CURBAL;
			$data['conditioncode']=$dataBalance->CONDITIONCODE;
			// $data['siteid']=$dataBalance->SITEID;
			$data['date']=$dataBalance->PHYSCNTDATE;
			$this->dbInventory->insert('item_balances_monitoring_chem',$data);
			// var_dump($data);

		}

		redirect('integration/import');
	}

	function importMonitoringChemToForSo(){
		$dataBalances=$this->dbInventory->query("SELECT description, item_number,location,binnum,qty,conditioncode FROM item_balances_monitoring_chem WHERE location=1902")->result();
		foreach ($dataBalances as $dataBalance) {
			$data['item_number']=$dataBalance->item_number;
			if($dataBalance->description!=NULL){
				$data['description']=$dataBalance->description;			
			}
			$data['location_id']=$dataBalance->location;
			$data['binnum']=$dataBalance->binnum;
			$data['qty']=$dataBalance->qty;
			$data['conditioncode']=$dataBalance->conditioncode;
			$this->dbInventory->insert('item_balances_forSo',$data);
			// var_dump($data);
			// echo "<pre>";
			// print_r($data);

		}

		redirect('integration/import');

	}


	function getViewItem(){
		ini_set('memory_limit', '256M');
		$dataItem=$this->dbMaximo->query("SELECT * FROM VIEWITEM WHERE ITEMNUM=1001")->result();
		echo "<pre>";
		print_r($dataItem);
		
	}

	function get_detail_maximo_barcode($item_number,$location){

		$dataBarcode=$this->dbMaximo->query("SELECT * FROM VIEWINVBARCODE where ITEMNUM='".$item_number."' and LOCATION='".$location."'")->row();
		return $dataBarcode->DESCRIPTION;
	}

	function get_data_maximo_balanceForSO($location=''){
		// $this->dbInventory->query("TRUNCATE `item_balances_forSo`;");
		// UNTUK MENGINSERT DATA
		$dataBalances=$this->dbMaximo->query("SELECT * FROM VIEWINVBALANCES where LOCATION='$location'")->result();
		// $dataBalances=$this->dbMaximodum->query("SELECT DESCRIPTION, ITEMNUM,LOCATION,BINNUM,CURBAL,CONDITIONCODE,SITEID,PHYSCNTDATE FROM VIEWINVBALANCES where LOCATION='WH'")->result();
		if (count($dataBalances)>0) {
			foreach ($dataBalances as $row => $dataBalance) {
				$data[$row]['item_number']	=$dataBalance->ITEMNUM;
				$data[$row]['description']	=$this->get_detail_maximo_barcode($dataBalance->ITEMNUM,$location);	
				$data[$row]['location_id']	=$this->getLocationId($dataBalance->LOCATION);
				$data[$row]['binnum']		=$dataBalance->BINNUM;
				$data[$row]['qty']			=$dataBalance->CURBAL;
				$data[$row]['conditioncode']=$dataBalance->CONDITIONCODE;
				$data[$row]['siteid']		=$dataBalance->SITEID;
				$data[$row]['date']			=$dataBalance->PHYSCNTDATE;
				// $this->dbInventory->insert('item_balances_forSo',$data);

			}

			echo json_encode(['status'=>'success','data'=>$data]);
		} else {
			echo json_encode(['status'=>'failed','data'=>'not found']);
		}
	}


}
