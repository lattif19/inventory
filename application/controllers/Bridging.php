<?php
/**
* 
*/
class Bridging extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->dbMaster = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
		$this->load->model('ModelReport');
		$this->load->library('excel');
	}

	public function importBalanceFromMaximo(){
		$dataItem=$this->dbMaximo->query("SELECT * FROM VIEWINVBALANCES")->result();
		foreach ($dataItem as $key) {
			$data['item_number']=$key->ITEMNUM;
			$data['location_id']=$this->nameLocationToId($key->LOCATION);
			$data['qty']=$key->CURBAL;
			$data['conditioncode']=$key->CONDITIONCODE;
			$data['binnum']=$key->BINNUM;
			$data['date']=$key->PHYSCNTDATE;
			$data['siteid']=$key->SITEID;
			$this->dbMaster->insert('item_balances',$data);
		}
		// var_dump($data);
	}

	function nameLocationToId($nameLocation){
		$dataLocation=$this->dbMaster->query("SELECT * FROM location where name='".$nameLocation."'")->result();
		return $dataLocation[0]->location_id;


	}


	public function importLocationFromMaximo(){
		$dataLocation=$this->dbMaximo->query("SELECT * FROM VIEWLOCATIONS")->result();
		var_dump($dataLocation[0]);
		foreach ($dataLocation as $key) {			
			$data['location_id']=$key->LOCATIONSID;
			$data['name']=$key->LOCATION;
			$data['description']=$key->DESCRIPTION;
			$data['type']=$key->TYPE;
			$data['status']=$key->STATUS;
			$this->dbMaster->insert('location',$data);
		}

	}





}