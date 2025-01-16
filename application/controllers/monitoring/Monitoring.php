
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {


	
	public function __construct()
	{
		parent::__construct();

		$this->dbInventory = $this->load->database('default', TRUE);

	}

	function insertItemNew(){
		$itemMaximo=$this->dbInventory->query("SELECT * FROM item_balances_maximo where item_balance_id=3205")->row();
		$data['item_number'] 	= $itemMaximo->item_number;
		$data['description'] 	= $itemMaximo->description;
		$data['location'] 		= 'WH';
		$data['qty'] 			= $itemMaximo->qty;
		$data['conditioncode'] 	= $itemMaximo->conditioncode;
		$data['binnum'] 		= $itemMaximo->binnum;
		$data['date'] 			= $itemMaximo->date;

		// echo "<pre>";
		// print_r($data);
		// $this->dbInventory->insert('item_balances_forSo',$data);
		$this->dbInventory->insert('item_balances_monitoring',$data);
	}

	public function index($location="WH")
	{
		$data['title']="Realtime Monitoring Stock Opname";	

		if($location=='WH'){
			$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring where status=1 and location='$location'")->result(); // INI QUERY UNTUK MENDAPATKAN ITEM YANG TERSCAN 
			$data['result3'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring where status=3 and location='$location'")->result(); 
			// INI QUERY UNTUK ITEM YANG BELUM TERSCAN
		}else if($location=='WH2'){
				$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring2 where status=1 and location='$location'")->result(); // INI QUERY UNTUK MENDAPATKAN ITEM YANG TERSCAN 
				$data['result3'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring2 where status=3 and location='$location'")->result(); 
				// INI QUERY UNTUK ITEM YANG BELUM TERSCAN
		}else if($location=='WH3'){
			$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring3 where status=1 and location='$location'")->result(); // INI QUERY UNTUK MENDAPATKAN ITEM YANG TERSCAN 
			$data['result3'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring3 where status=3 and location='$location'")->result(); 
			// INI QUERY UNTUK ITEM YANG BELUM TERSCAN
		}else if($location=='CHEM'){
			$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring_chem where status=1 and location='$location'")->result(); // INI QUERY UNTUK MENDAPATKAN ITEM YANG TERSCAN 
			$data['result3'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring_chem where status=3 and location='$location'")->result(); 
			// INI QUERY UNTUK ITEM YANG BELUM TERSCAN
		}else if($location=='WHSP3'){
			$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoringsp3 where status=1 and location='$location'")->result(); // INI QUERY UNTUK MENDAPATKAN ITEM YANG TERSCAN 
			$data['result3'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoringsp3 where status=3 and location='$location'")->result(); 
			// INI QUERY UNTUK ITEM YANG BELUM TERSCAN
		}else if($location=='WHSP3A'){
			$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoringsp3a where status=1 and location='$location'")->result(); // INI QUERY UNTUK MENDAPATKAN ITEM YANG TERSCAN 
			$data['result3'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoringsp3a where status=3 and location='$location'")->result(); 
			// INI QUERY UNTUK ITEM YANG BELUM TERSCAN
		}
		$data['location'] = $location;
		$this->load->view('monitoring/monitoring',$data);
	}

	public function chem($location="CHEM")
	{
		$data['title']="Realtime Monitoring Stock Opname";	

		if($location=='CHEM'){
			$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring_chem where status=1 and location='$location'")->result(); // INI QUERY UNTUK MENDAPATKAN ITEM YANG TERSCAN 
			$data['result3'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring_chem where status=3 and location='$location'")->result(); 
			// INI QUERY UNTUK ITEM YANG BELUM TERSCAN
			// var_dump($data['result3']);
		}
		$data['location'] = $location;
		$this->load->view('monitoring/monitoring_chem',$data);
	}


	public function getFound($location_id=null)
	{
		$data['title']="Realtime Monitoring Stock Opname";	
		// $data['result'] = $foundInBalances = $this->dbInventory->query('SELECT inventory.item_balances_forSo.item_number,inventory.item_balances_forSo.location_id,inventory.item_balances_forSo.description,inventory.item_balances_forSo.conditioncode,inventory.item_balances_forSo.binnum,inventory.item_balances_forSo.qty,stock_opname.trx_so_detail.qty as qtySo FROM inventory.item_balances_forSo,stock_opname.trx_so_detail where inventory.item_balances_forSo.item_number=stock_opname.trx_so_detail.item_number')->result();


		// simpan query so lama
		// $data['result'] = $foundInBalances = $this->dbInventory->query("SELECT inventory.item_balances_forSo.item_number,inventory.item_balances_forSo.location_id,inventory.item_balances_forSo.description,inventory.item_balances_forSo.conditioncode,inventory.item_balances_forSo.binnum,inventory.item_balances_forSo.qty,stock_opname.trx_so_detail.qty as qtySo FROM inventory.item_balances_forSo,stock_opname.trx_so_detail where inventory.item_balances_forSo.item_number=stock_opname.trx_so_detail.item_number and inventory.item_balances_forSo.location_id=stock_opname.trx_so_detail.location_id and stock_opname.trx_so_detail.location_id=$location_id and stock_opname.trx_so_detail.trx_so_id>334")->result();

		// simpan query so 6 agustus 2018
		// $data['result'] = $foundInBalances = $this->dbInventory->query("SELECT inventory.item_balances_forSo.item_number,inventory.item_balances_forSo.location_id,inventory.item_balances_forSo.description,inventory.item_balances_forSo.conditioncode,inventory.item_balances_forSo.binnum,inventory.item_balances_forSo.qty,stock_opname.trx_so_detail.qty as qtySo FROM inventory.item_balances_forSo,stock_opname.trx_so_detail where inventory.item_balances_forSo.item_number=stock_opname.trx_so_detail.item_number and inventory.item_balances_forSo.location_id=stock_opname.trx_so_detail.location_id and stock_opname.trx_so_detail.location_id=$location_id and stock_opname.trx_so_detail.trx_so_id>418")->result();

		// simpan query so 23 april 2019
		$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT inventory.item_balances_forSo.item_number,inventory.item_balances_forSo.location_id,inventory.item_balances_forSo.description,inventory.item_balances_forSo.conditioncode,inventory.item_balances_forSo.binnum,inventory.item_balances_forSo.qty,stock_opname.trx_so_detail.qty as qtySo FROM inventory.item_balances_forSo,stock_opname.trx_so_detail where inventory.item_balances_forSo.item_number=stock_opname.trx_so_detail.item_number and inventory.item_balances_forSo.location_id=stock_opname.trx_so_detail.location_id and stock_opname.trx_so_detail.location_id=$location_id and stock_opname.trx_so_detail.trx_so_id>928")->result();

		// $data['result'] = $foundInBalances = $this->dbInventory->query('SELECT inventory.item_balances_forSo.item_number,inventory.item_balances_forSo.location_id,inventory.item_balances_forSo.description,inventory.item_balances_forSo.conditioncode,inventory.item_balances_forSo.binnum,inventory.item_balances_forSo.qty,stock_opname.trx_so_detail.qty as qtySo FROM inventory.item_balances_forSo,stock_opname.trx_so_detail where inventory.item_balances_forSo.item_number=stock_opname.trx_so_detail.item_number and inventory.item_balances_forSo.location_id=stock_opname.trx_so_detail.location_id')->result();

		// 928

		foreach ($foundInBalances as $key) {
			$checkAvailable=$this->checkAvailable($key->item_number,$key->location_id);
			// var_dump($checkAvailable); 
			if ($checkAvailable=='false'){
				// echo $key->item_number.'<br>';
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				$dataSubmit['description']=$key->description;
				$dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty;
				$dataSubmit['qtySo']=$key->qtySo;
				$dataSubmit['selisih']=$key->qtySo-$key->qty;
				$dataSubmit['status']=1;
				$this->dbInventory->insert('item_balances_monitoring',$dataSubmit);
				
			}else{
				$qtyLast=$checkAvailable['qty'];
				$qtyLastSo=$checkAvailable['qtySo'];
				$binnumLast=$checkAvailable['binnum'];
				$conditioncodeLast=$checkAvailable['conditioncode'];

				// echo $key->item_number.'-'.$key->qtySo.'-'.$qtyLastSo.'-'.$key->conditioncode.'-'.$conditioncodeLast.'<br>';

				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				// $dataSubmit['conditioncode']=$key->conditioncode;

				if($key->binnum==$binnumLast){ //binnum sama berati tidak dijumlah qty-nya
					if($key->conditioncode==$conditioncodeLast){ //condition tidak sama berati dijumlah qty-nya
						$dataSubmit['qty']=$key->qty;
					}else{
						$dataSubmit['qty']=$key->qty+$qtyLast;
					}
				}else{
					// if ($key->qty) {
					// if ($key->item_number=='13272' || $key->item_number=='4381') {
					// 	$dataSubmit['qty']=$key->qty;
					// } else {
					// 	$dataSubmit['qty']=$key->qty+$qtyLast;

					// }
					$dataSubmit['qty']=$key->qty+$qtyLast;
				}

						// echo $checkAvailable['item_balance_id']." xxx ".$key->item_number." => ".$dataSubmit['qty']."<br>";
					$dataSubmit['qtySo']=$key->qtySo; //diambil qty tearahir ter upload CSV


				$dataSubmit['selisih']=($dataSubmit['qtySo'])-($dataSubmit['qty']);
				$dataSubmit['status']=1;

				// $this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
				// $this->dbInventory->update('item_balances_monitoring',$dataSubmit);
				// echo "<pre>";

				// print_r($dataSubmit);
				if ($key->item_number=='13272' || $key->item_number=='4381') {
					$datas =array (
						'item_balance_id' =>$checkAvailable['item_balance_id'],
						'item_number' => $key->item_number,
						'qty' => $checkAvailable['qty'],
						'qtySo' => $qtyLastSo,
					);

					// echo "<pre>";

					$this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
					$this->dbInventory->update('item_balances_monitoring',$datas);
					// print_r($datas);
				} else {
					// echo "update all";
					// echo "<pre>";
					// print_r($dataSubmit['qty']);
					// print_r($dataSubmit);
					$this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
					$this->dbInventory->update('item_balances_monitoring',$dataSubmit);
				}
				
			}
		}
	}



	public function checkAvailable($item_number,$location){
		$location=$this->getLocationName($location);
		$result=$this->dbInventory->query("select * from item_balances_monitoring where item_number='$item_number' and location='$location'")->result();
		if(count($result)>0){
			$data['item_balance_id']=$result[0]->item_balance_id;
			$data['qty']=$result[0]->qty;
			$data['qtySo']=$result[0]->qtySo;
			$data['binnum']=$result[0]->binnum;
			$data['conditioncode']=$result[0]->conditioncode;

			return $data;
		}else{
			return 'false';
		}
	}

	function cekDesc(){
		$$foundInBalances = $this->dbInventory->query("SELECT inventory.item_balances_forSo.item_number,inventory.item_balances_forSo.location_id,inventory.item_balances_forSo.description,inventory.item_balances_forSo.conditioncode,inventory.item_balances_forSo.binnum,inventory.item_balances_forSo.qty,stock_opname.trx_so_detail.qty as qtySo FROM inventory.item_balances_forSo,stock_opname.trx_so_detail where inventory.item_balances_forSo.item_number=stock_opname.trx_so_detail.item_number and inventory.item_balances_forSo.location_id=stock_opname.trx_so_detail.location_id and stock_opname.trx_so_detail.location_id=2201  and stock_opname.trx_so_detail.trx_so_id>928 ")->result();

		foreach ($foundInBalances as $key => $value) {
			$data['item_number']=$value->item_number;
			$data['description']=$value->description;

			var_dump($data);
		}
	}


	public function getFound2($location_id=null)
	{
		$data['title']="Realtime Monitoring Stock Opname";	

		// simpan query so 23 agustus 2019 #553
		$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT inventory.item_balances_forSo.item_number,inventory.item_balances_forSo.location_id,inventory.item_balances_forSo.description,inventory.item_balances_forSo.conditioncode,inventory.item_balances_forSo.binnum,inventory.item_balances_forSo.qty,stock_opname.trx_so_detail.qty as qtySo FROM inventory.item_balances_forSo,stock_opname.trx_so_detail where inventory.item_balances_forSo.item_number=stock_opname.trx_so_detail.item_number and inventory.item_balances_forSo.location_id=stock_opname.trx_so_detail.location_id and stock_opname.trx_so_detail.location_id=$location_id  and stock_opname.trx_so_detail.trx_so_id>928")->result();


		foreach ($foundInBalances as $key) {
			$checkAvailable=$this->checkAvailable2($key->item_number,$key->location_id);
			// var_dump($checkAvailable); 
			if ($checkAvailable=='false'){
				// echo $key->item_number.'<br>';
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				$dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['description']=$key->description;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty;
				$dataSubmit['qtySo']=$key->qtySo;
				$dataSubmit['selisih']=$key->qtySo-$key->qty;
				$dataSubmit['status']=1;
				$this->dbInventory->insert('item_balances_monitoring2',$dataSubmit);
				
			}else{
				$qtyLast=$checkAvailable['qty'];
				$qtyLastSo=$checkAvailable['qtySo'];
				$binnumLast=$checkAvailable['binnum'];
				$conditioncodeLast=$checkAvailable['conditioncode'];

				// echo $key->item_number.'-'.$key->qtySo.'-'.$qtyLastSo.'-'.$key->conditioncode.'-'.$conditioncodeLast.'<br>';

				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				$dataSubmit['description']=$key->description;
				// $dataSubmit['conditioncode']=$key->conditioncode;

				if($key->binnum==$binnumLast){ //binnum sama berati tidak dijumlah qty-nya
					if($key->conditioncode==$conditioncodeLast){ //condition tidak sama berati dijumlah qty-nya
						$dataSubmit['qty']=$key->qty;
					}else{
						$dataSubmit['qty']=$key->qty+$qtyLast;
					}
				}else{
					$dataSubmit['qty']=$key->qty+$qtyLast;
				}

					$dataSubmit['qtySo']=$key->qtySo; //diambil qty tearahir ter upload CSV


				$dataSubmit['selisih']=($dataSubmit['qtySo'])-($dataSubmit['qty']);
				$dataSubmit['status']=1;

				$this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
				$this->dbInventory->update('item_balances_monitoring2',$dataSubmit);
			}
		}
	}


	public function checkAvailable2($item_number,$location){

		$location=$this->getLocationName($location);
		$result=$this->dbInventory->query("select * from item_balances_monitoring2 where item_number='$item_number' and location='$location'")->result();
		if(count($result)>0){
			$data['item_balance_id']=$result[0]->item_balance_id;
			$data['qty']=$result[0]->qty;
			$data['qtySo']=$result[0]->qtySo;
			$data['binnum']=$result[0]->binnum;
			$data['conditioncode']=$result[0]->conditioncode;

			return $data;
		}else{
			return 'false';
		}
	}

	public function getFound3($location_id=null)
	{
		$data['title']="Realtime Monitoring Stock Opname";	

		// simpan query so 23 agustus 2019 #553
		$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT inventory.item_balances_forSo.item_number,inventory.item_balances_forSo.location_id,inventory.item_balances_forSo.description,inventory.item_balances_forSo.conditioncode,inventory.item_balances_forSo.binnum,inventory.item_balances_forSo.qty,stock_opname.trx_so_detail.qty as qtySo FROM inventory.item_balances_forSo,stock_opname.trx_so_detail where inventory.item_balances_forSo.item_number=stock_opname.trx_so_detail.item_number and inventory.item_balances_forSo.location_id=stock_opname.trx_so_detail.location_id and stock_opname.trx_so_detail.location_id=$location_id  and stock_opname.trx_so_detail.trx_so_id>928 ")->result();

		foreach ($foundInBalances as $key) {
			$checkAvailable=$this->checkAvailable3($key->item_number,$key->location_id);
			// var_dump($checkAvailable); 
			if ($checkAvailable=='false'){
				// echo $key->item_number.'<br>';
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				$dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['description']=$key->description;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty;
				$dataSubmit['qtySo']=$key->qtySo;
				$dataSubmit['selisih']=$key->qtySo-$key->qty;
				$dataSubmit['status']=1;
				$this->dbInventory->insert('item_balances_monitoring3',$dataSubmit);
				
			}else{
				$qtyLast=$checkAvailable['qty'];
				$qtyLastSo=$checkAvailable['qtySo'];
				$binnumLast=$checkAvailable['binnum'];
				$conditioncodeLast=$checkAvailable['conditioncode'];

				// echo $key->item_number.'-'.$key->qtySo.'-'.$qtyLastSo.'-'.$key->conditioncode.'-'.$conditioncodeLast.'<br>';

				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['description']=$key->description; // ini adalah tambahan karena untuk tarik data sempat error ada beberapa desc nya sama
				$dataSubmit['binnum']=$key->binnum; // ini adalah tambahan karena untuk tarik data sempat error ada beberapa binnum nya sama
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				// $dataSubmit['conditioncode']=$key->conditioncode;

				if($key->binnum==$binnumLast){ //binnum sama berati tidak dijumlah qty-nya
					if($key->conditioncode==$conditioncodeLast){ //condition tidak sama berati dijumlah qty-nya
						$dataSubmit['qty']=$key->qty;
					}else{
						$dataSubmit['qty']=$key->qty+$qtyLast;
					}
				}else{
					$dataSubmit['qty']=$key->qty+$qtyLast;
				}

					$dataSubmit['qtySo']=$key->qtySo; //diambil qty tearahir ter upload CSV


				$dataSubmit['selisih']=($dataSubmit['qtySo'])-($dataSubmit['qty']);
				$dataSubmit['status']=1;

				$this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
				$this->dbInventory->update('item_balances_monitoring3',$dataSubmit);
			}
		}
	}


	public function checkAvailable3($item_number,$location){
		$location=$this->getLocationName($location);
		$result=$this->dbInventory->query("select * from item_balances_monitoring3 where item_number='$item_number' and location='$location'")->result();
		if(count($result)>0){
			$data['item_balance_id']=$result[0]->item_balance_id;
			$data['qty']=$result[0]->qty;
			$data['qtySo']=$result[0]->qtySo;
			$data['binnum']=$result[0]->binnum;
			$data['conditioncode']=$result[0]->conditioncode;
			// var_dump($data);
			return $data;
		}else{
			return 'false';
		}
	}




	public function getFoundSP3($location_id=null)
	{
		$data['title']="Realtime Monitoring Stock Opname";	

		// simpan query so 23 agustus 2019 #553
		$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT inventory.item_balances_forSo.item_number,inventory.item_balances_forSo.location_id,inventory.item_balances_forSo.description,inventory.item_balances_forSo.conditioncode,inventory.item_balances_forSo.binnum,inventory.item_balances_forSo.qty,stock_opname.trx_so_detail.qty as qtySo FROM inventory.item_balances_forSo,stock_opname.trx_so_detail where inventory.item_balances_forSo.item_number=stock_opname.trx_so_detail.item_number and inventory.item_balances_forSo.location_id=stock_opname.trx_so_detail.location_id and stock_opname.trx_so_detail.location_id=$location_id  and stock_opname.trx_so_detail.trx_so_id>866 ")->result();


		foreach ($foundInBalances as $key) {
			$checkAvailable=$this->checkAvailablesp3($key->item_number,$key->location_id);
			// var_dump($checkAvailable); 
			if ($checkAvailable=='false'){
				// echo $key->item_number.'<br>';
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				$dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['description']=$key->description;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty;
				$dataSubmit['qtySo']=$key->qtySo;
				$dataSubmit['selisih']=$key->qtySo-$key->qty;
				$dataSubmit['status']=1;
				$this->dbInventory->insert('item_balances_monitoringsp3',$dataSubmit);
				
			}else{
				$qtyLast=$checkAvailable['qty'];
				$qtyLastSo=$checkAvailable['qtySo'];
				$binnumLast=$checkAvailable['binnum'];
				$conditioncodeLast=$checkAvailable['conditioncode'];

				// echo $key->item_number.'-'.$key->qtySo.'-'.$qtyLastSo.'-'.$key->conditioncode.'-'.$conditioncodeLast.'<br>';

				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['description']=$key->description; // ini adalah tambahan karena untuk tarik data sempat error ada beberapa desc nya sama
				$dataSubmit['binnum']=$key->binnum; // ini adalah tambahan karena untuk tarik data sempat error ada beberapa binnum nya sama
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				// $dataSubmit['conditioncode']=$key->conditioncode;

				if($key->binnum==$binnumLast){ //binnum sama berati tidak dijumlah qty-nya
					if($key->conditioncode==$conditioncodeLast){ //condition tidak sama berati dijumlah qty-nya
						$dataSubmit['qty']=$key->qty;
					}else{
						$dataSubmit['qty']=$key->qty+$qtyLast;
					}
				}else{
					$dataSubmit['qty']=$key->qty+$qtyLast;
				}

					$dataSubmit['qtySo']=$key->qtySo; //diambil qty tearahir ter upload CSV


				$dataSubmit['selisih']=($dataSubmit['qtySo'])-($dataSubmit['qty']);
				$dataSubmit['status']=1;

				$this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
				$this->dbInventory->update('item_balances_monitoringsp3',$dataSubmit);
			}
		}
	}


	public function checkAvailablesp3($item_number,$location){
		$location=$this->getLocationName($location);
		$result=$this->dbInventory->query("select * from item_balances_monitoringsp3 where item_number='$item_number' and location='$location'")->result();
		if(count($result)>0){
			$data['item_balance_id']=$result[0]->item_balance_id;
			$data['qty']=$result[0]->qty;
			$data['qtySo']=$result[0]->qtySo;
			$data['binnum']=$result[0]->binnum;
			$data['conditioncode']=$result[0]->conditioncode;
			// var_dump($data);
			return $data;
		}else{
			return 'false';
		}
	}


	public function getFoundSP3A($location_id=null)
	{
		$data['title']="Realtime Monitoring Stock Opname";	

		// simpan query so 23 agustus 2019 #553
		$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT inventory.item_balances_forSo.item_number,inventory.item_balances_forSo.location_id,inventory.item_balances_forSo.description,inventory.item_balances_forSo.conditioncode,inventory.item_balances_forSo.binnum,inventory.item_balances_forSo.qty,stock_opname.trx_so_detail.qty as qtySo FROM inventory.item_balances_forSo,stock_opname.trx_so_detail where inventory.item_balances_forSo.item_number=stock_opname.trx_so_detail.item_number and inventory.item_balances_forSo.location_id=stock_opname.trx_so_detail.location_id and stock_opname.trx_so_detail.location_id=$location_id  and stock_opname.trx_so_detail.trx_so_id>866 ")->result();


		foreach ($foundInBalances as $key) {
			$checkAvailable=$this->checkAvailablesp3a($key->item_number,$key->location_id);
			// var_dump($checkAvailable); 
			if ($checkAvailable=='false'){
				// echo $key->item_number.'<br>';
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				$dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['description']=$key->description;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty;
				$dataSubmit['qtySo']=$key->qtySo;
				$dataSubmit['selisih']=$key->qtySo-$key->qty;
				$dataSubmit['status']=1;
				$this->dbInventory->insert('item_balances_monitoringsp3a',$dataSubmit);
				
			}else{
				$qtyLast=$checkAvailable['qty'];
				$qtyLastSo=$checkAvailable['qtySo'];
				$binnumLast=$checkAvailable['binnum'];
				$conditioncodeLast=$checkAvailable['conditioncode'];

				// echo $key->item_number.'-'.$key->qtySo.'-'.$qtyLastSo.'-'.$key->conditioncode.'-'.$conditioncodeLast.'<br>';

				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['description']=$key->description; // ini adalah tambahan karena untuk tarik data sempat error ada beberapa desc nya sama
				$dataSubmit['binnum']=$key->binnum; // ini adalah tambahan karena untuk tarik data sempat error ada beberapa binnum nya sama
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				// $dataSubmit['conditioncode']=$key->conditioncode;

				if($key->binnum==$binnumLast){ //binnum sama berati tidak dijumlah qty-nya
					if($key->conditioncode==$conditioncodeLast){ //condition tidak sama berati dijumlah qty-nya
						$dataSubmit['qty']=$key->qty;
					}else{
						$dataSubmit['qty']=$key->qty+$qtyLast;
					}
				}else{
					$dataSubmit['qty']=$key->qty+$qtyLast;
				}

					$dataSubmit['qtySo']=$key->qtySo; //diambil qty tearahir ter upload CSV


				$dataSubmit['selisih']=($dataSubmit['qtySo'])-($dataSubmit['qty']);
				$dataSubmit['status']=1;

				$this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
				$this->dbInventory->update('item_balances_monitoringsp3a',$dataSubmit);
			}
		}
	}


	public function checkAvailablesp3a($item_number,$location){
		$location=$this->getLocationName($location);
		$result=$this->dbInventory->query("select * from item_balances_monitoringsp3a where item_number='$item_number' and location='$location'")->result();
		if(count($result)>0){
			$data['item_balance_id']=$result[0]->item_balance_id;
			$data['qty']=$result[0]->qty;
			$data['qtySo']=$result[0]->qtySo;
			$data['binnum']=$result[0]->binnum;
			$data['conditioncode']=$result[0]->conditioncode;
			// var_dump($data);
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

	function direct(){

		redirect('monitoring/admin');
	}



	public function getAll($location=NULL){
		// if ($location=='WH') {
		// 	# code...
		// }
		// echo $location;
		if ($location=='WH') {
			$this->dbInventory->query("TRUNCATE `item_balances_monitoring`;");
			$this->getFound($this->getLocationId('WH'));
			$this->getNotFound($this->getLocationId('WH'));
			$this->session->set_flashdata('message', 'Success to sinkron with maximo balance');
			// redirect('monitoring/admin');
			redirect('monitoring/admin/index/'.$location);

		} else if ($location=='WH2') {
			$this->dbInventory->query("TRUNCATE `item_balances_monitoring2`;");
			$this->getFound2($this->getLocationId('WH2'));
			$this->getNotFound2($this->getLocationId('WH2'));
			$this->session->set_flashdata('message', 'Success to sinkron with maximo balance');
			// redirect('monitoring/admin');
			redirect('monitoring/admin/index/'.$location);

		} else if ($location=='WH3') {
			$this->dbInventory->query("TRUNCATE `item_balances_monitoring2`;");
			$this->getFound3($this->getLocationId('WH3'));
			$this->getNotFound3($this->getLocationId('WH3'));

			$this->session->set_flashdata('message', 'Success to sinkron with maximo balance');
			// redirect('monitoring/admin');
			redirect('monitoring/admin/index/'.$location);

		} else if ($location=='WHSP3') {
			$this->dbInventory->query("TRUNCATE `item_balances_monitoringsp3a`;");
			$this->getFoundSP3($this->getLocationId('WHSP3'));
			$this->getNotFoundSP3($this->getLocationId('WHSP3'));
			$this->getNameStatus3();

			$this->session->set_flashdata('message', 'Success to sinkron with maximo balance');
			// redirect('monitoring/admin');
			redirect('monitoring/admin/index/'.$location);
		} else if ($location=='WHSP3A') {
			$this->dbInventory->query("TRUNCATE `item_balances_monitoringsp3a`;");
			$this->getFoundSP3A($this->getLocationId('WHSP3A'));
			$this->getNotFoundSP3A($this->getLocationId('WHSP3A'));
			$this->getNameStatus3();

			$this->session->set_flashdata('message', 'Success to sinkron with maximo balance');
			// redirect('monitoring/admin');
			redirect('monitoring/admin/index/'.$location);

		} else {
			// $this->dbInventory->query("TRUNCATE `item_balances_monitoring`;");
			// $this->dbInventory->query("TRUNCATE `item_balances_monitoring2`;");
			// $this->dbInventory->query("TRUNCATE `item_balances_monitoring3`;");
			// $this->getFound($this->getLocationId('WH'));
			// $this->getFound2($this->getLocationId('WH2'));
			// $this->getFound3($this->getLocationId('WH3'));


			// // $this->getNotFound();
			// $this->getNotFound($this->getLocationId('WH'));
			// $this->getNotFound2($this->getLocationId('WH2'));
			// $this->getNotFound3($this->getLocationId('WH3'));

			// $this->dbInventory->query("TRUNCATE `item_balances_monitoring_chem`;");
			// $this->getFoundChem($this->getLocationId('CHEM'));
			// $this->getNotFoundChem($this->getLocationId('CHEM'));
			// $this->getNameStatusChem();


			$this->dbInventory->query("TRUNCATE `item_balances_monitoringsp3`;");
			$this->dbInventory->query("TRUNCATE `item_balances_monitoringsp3a`;");
			
			$this->getFoundSP3($this->getLocationId('WHSP3'));
			$this->getNotFoundSP3($this->getLocationId('WHSP3'));

			$this->getFoundSP3A($this->getLocationId('WHSP3A'));
			$this->getNotFoundSP3A($this->getLocationId('WHSP3A'));

			$this->getNameStatus3();



			redirect('monitoring/monitoring/');
		}

	}


	public function getNameStatus3(){
		// $query=$this->dbInventory->query("SELECT * FROM item_balances_monitoring")->result();
		// foreach ($query as $key) {
		// 	$dataUpdate['description']=$this->getName($key->item_number);
		// 	$this->dbInventory->where('item_balance_id',$key->item_balance_id);
		// 	$this->dbInventory->update('item_balances_monitoring',$dataUpdate);
		// }



		// $query2=$this->dbInventory->query("SELECT * FROM item_balances_monitoring2 where status=3")->result();
		// foreach ($query2 as $key) {
		// 	$dataUpdate2['description']=$this->getName($key->item_number);
		// 	$this->dbInventory->where('item_balance_id',$key->item_balance_id);
		// 	$this->dbInventory->update('item_balances_monitoring2',$dataUpdate2);
		// }


		// $query3=$this->dbInventory->query("SELECT * FROM item_balances_monitoring3 where status=3")->result();
		// foreach ($query3 as $key) {
		// 	$dataUpdate3['description']=$this->getName($key->item_number);
		// 	$this->dbInventory->where('item_balance_id',$key->item_balance_id);
		// 	$this->dbInventory->update('item_balances_monitoring3',$dataUpdate3);
		// }


		$querysp3=$this->dbInventory->query("SELECT * FROM item_balances_monitoringsp3 where status=3")->result();
		foreach ($querysp3 as $key) {
			$dataUpdate['description']=$this->getName($key->item_number);
			$this->dbInventory->where('item_balance_id',$key->item_balance_id);
			$this->dbInventory->update('item_balances_monitoringsp3',$dataUpdate);
		}

		$querysp3a=$this->dbInventory->query("SELECT * FROM item_balances_monitoringsp3a where status=3")->result();
		foreach ($querysp3a as $key) {
			$dataUpdate['description']=$this->getName($key->item_number);
			$this->dbInventory->where('item_balance_id',$key->item_balance_id);
			$this->dbInventory->update('item_balances_monitoringsp3a',$dataUpdate);
		}

	}

	public function getName($item_number){
		$query=$this->dbInventory->query("SELECT * FROM item_balances_forSo where item_number=$item_number")->row();
		// $query=$this->dbInventory->query("SELECT * FROM item_balances where item_number=$item_number")->row();
		return $query->description;
	}


	public function getNotFound($location_id=NULL)
	{
		$data['title']="Realtime Monitoring Stock Opname";	
		$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_forSo where item_number NOT IN (SELECT item_number FROM item_balances_monitoring) and location_id=$location_id")->result();

		foreach ($foundInBalances as $key) {
			$checkAvailable=$this->checkAvailable($key->item_number,$key->location_id);
			if ($checkAvailable=='false'){
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				$dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty;
				$dataSubmit['status']=3;

				$this->dbInventory->insert('item_balances_monitoring',$dataSubmit);

			}else{
				$qtyLast=$checkAvailable['qty'];
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				// $dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty+$qtyLast;
				$dataSubmit['status']=3;

				$this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
				$this->dbInventory->update('item_balances_monitoring',$dataSubmit);
			}
		}
	}



	public function getNotFound2($location_id=NULL)
	{
		$data['title']="Realtime Monitoring Stock Opname";	
		$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_forSo where item_number NOT IN (SELECT item_number FROM item_balances_monitoring2) and location_id=$location_id")->result();

		foreach ($foundInBalances as $key) {
			$checkAvailable=$this->checkAvailable2($key->item_number,$key->location_id);
			if ($checkAvailable=='false'){
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				$dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty;
				$dataSubmit['status']=3;

				$this->dbInventory->insert('item_balances_monitoring2',$dataSubmit);

			}else{
				$qtyLast=$checkAvailable['qty'];
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				// $dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty+$qtyLast;
				$dataSubmit['status']=3;

				$this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
				$this->dbInventory->update('item_balances_monitoring2',$dataSubmit);
			}
		}
	}

	public function getNotFound3($location_id=NULL)
	{
		$data['title']="Realtime Monitoring Stock Opname";	
		$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_forSo where item_number NOT IN (SELECT item_number FROM item_balances_monitoring3) and location_id=$location_id")->result();

		foreach ($foundInBalances as $key) {
			$checkAvailable=$this->checkAvailable3($key->item_number,$key->location_id);
			if ($checkAvailable=='false'){
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				$dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty;
				$dataSubmit['status']=3;

				$this->dbInventory->insert('item_balances_monitoring3',$dataSubmit);

			}else{
				$qtyLast=$checkAvailable['qty'];
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				// $dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty+$qtyLast;
				$dataSubmit['status']=3;

				$this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
				$this->dbInventory->update('item_balances_monitoring3',$dataSubmit);
			}
		}
	}


	public function getNotFoundSP3($location_id=NULL)
	{
		$data['title']="Realtime Monitoring Stock Opname";	
		$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_forSo where item_number NOT IN (SELECT item_number FROM item_balances_monitoringsp3) and location_id=$location_id")->result();

		foreach ($foundInBalances as $key) {
			$checkAvailable=$this->checkAvailablesp3($key->item_number,$key->location_id);
			if ($checkAvailable=='false'){
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				$dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty;
				$dataSubmit['status']=3;

				$this->dbInventory->insert('item_balances_monitoringsp3',$dataSubmit);

			}else{
				$qtyLast=$checkAvailable['qty'];
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				// $dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty+$qtyLast;
				$dataSubmit['status']=3;

				$this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
				$this->dbInventory->update('item_balances_monitoringsp3',$dataSubmit);
			}
		}
	}

	public function getNotFoundSP3A($location_id=NULL)
	{
		$data['title']="Realtime Monitoring Stock Opname";	
		$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_forSo where item_number NOT IN (SELECT item_number FROM item_balances_monitoringsp3a) and location_id=$location_id")->result();

		foreach ($foundInBalances as $key) {
			$checkAvailable=$this->checkAvailablesp3a($key->item_number,$key->location_id);
			if ($checkAvailable=='false'){
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				$dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty;
				$dataSubmit['status']=3;

				$this->dbInventory->insert('item_balances_monitoringsp3a',$dataSubmit);

			}else{
				$qtyLast=$checkAvailable['qty'];
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				// $dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty+$qtyLast;
				$dataSubmit['status']=3;

				$this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
				$this->dbInventory->update('item_balances_monitoringsp3a',$dataSubmit);
			}
		}
	}





	public function export_excel_terscan($location="WH"){


		if($location=='WH'){
			$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring where status=1 and location='$location'")->result();
		}else if($location=='WH2'){
			$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring2 where status=1 and location='$location'")->result();
		}else if($location=='WH3'){
			$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring3 where status=1 and location='$location'")->result();
		}else if($location=='CHEM'){
			$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring_chem where status=1 and location='$location'")->result();
		}else if($location=='WHSP3'){
			$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoringsp3 where status=1 and location='$location'")->result();
		}else if($location=='WHSP3A'){
			$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoringsp3a where status=1 and location='$location'")->result();
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
		}else if($location=='CHEM'){
			$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoring_chem where status=3 and location='$location'")->result();
		}else if($location=='WHSP3'){
			$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoringsp3 where status=3 and location='$location'")->result();
		}else if($location=='WHSP3A'){
			$foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_monitoringsp3a where status=3 and location='$location'")->result();
		}

		$data['result3'] = $foundInBalances; 	
		$data['location'] = $location;
		$this->load->view('monitoring/monitoring_belum_terscan', $data);
	}

	function export_not_compare($location="WH"){
	// $data['result'] = $foundInBalances = $this->dbInventory->query("select * from stock_opname.trx_so_detail where trx_so_detail.item_number not in (select inventory.item_balances_monitoring.item_number from inventory.item_balances_monitoring)")->result();


		if($location=='WH'){
			$foundInBalances = $this->dbInventory->query("select item_number,qty,name from stock_opname.trx_so_detail, inventory.location where location.location_id=trx_so_detail.location_id and stock_opname.trx_so_detail.item_number not in (select item_number from inventory.item_balances_monitoring where location='WH') and stock_opname.trx_so_detail.location_id=1203 and trx_so_detail.trx_so_id>928")->result();
		}else if($location=='WH2'){
			$foundInBalances = $this->dbInventory->query("select item_number,qty,name from stock_opname.trx_so_detail, inventory.location where location.location_id=trx_so_detail.location_id and stock_opname.trx_so_detail.item_number not in (select item_number from inventory.item_balances_monitoring2 where location='WH2') and stock_opname.trx_so_detail.location_id=2201 and trx_so_detail.trx_so_id>928")->result();
		}else if($location=='WH3'){
			$foundInBalances = $this->dbInventory->query("select item_number,qty,name from stock_opname.trx_so_detail, inventory.location where location.location_id=trx_so_detail.location_id and stock_opname.trx_so_detail.item_number not in (select item_number from inventory.item_balances_monitoring3 where location='WH3') and stock_opname.trx_so_detail.location_id=2301 and trx_so_detail.trx_so_id>928")->result();
		}

		$data['result'] = $foundInBalances; 
		$data['location'] = $location;
		$this->load->view('monitoring/monitoring_tidak_tercompare', $data);
	}




	public function getFoundChem($location_id=null){
		$data['title']="Realtime Monitoring Stock Opname";	
		// $data['result'] = $foundInBalances = $this->dbInventory->query('SELECT inventory.item_balances_forSo.item_number,inventory.item_balances_forSo.location_id,inventory.item_balances_forSo.description,inventory.item_balances_forSo.conditioncode,inventory.item_balances_forSo.binnum,inventory.item_balances_forSo.qty,stock_opname.trx_so_detail.qty as qtySo FROM inventory.item_balances_forSo,stock_opname.trx_so_detail where inventory.item_balances_forSo.item_number=stock_opname.trx_so_detail.item_number and inventory.item_balances_forSo.location_id=stock_opname.trx_so_detail.location_id')->result();

		// SIMPAN QUERY SO 2019 MARET 23 553
		$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT inventory.item_balances_forSo.item_number,inventory.item_balances_forSo.location_id,inventory.item_balances_forSo.description,inventory.item_balances_forSo.conditioncode,inventory.item_balances_forSo.binnum,inventory.item_balances_forSo.qty,stock_opname.trx_so_detail.qty as qtySo FROM inventory.item_balances_forSo,stock_opname.trx_so_detail where inventory.item_balances_forSo.item_number=stock_opname.trx_so_detail.item_number and inventory.item_balances_forSo.location_id=stock_opname.trx_so_detail.location_id and stock_opname.trx_so_detail.location_id=$location_id and stock_opname.trx_so_detail.trx_so_id>928")->result();



		foreach ($foundInBalances as $key) {
			$checkAvailable=$this->checkAvailableChem($key->item_number,$key->location_id);
			// var_dump($checkAvailable); 
			if ($checkAvailable=='false'){
				// echo $key->item_number.'<br>';
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				$dataSubmit['description']=$key->description;
				$dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty;
				$dataSubmit['qtySo']=$key->qtySo;
				$dataSubmit['selisih']=$key->qtySo-$key->qty;
				$dataSubmit['status']=1;
				$this->dbInventory->insert('item_balances_monitoring_chem',$dataSubmit);
				
			}else{
				$qtyLast=$checkAvailable['qty'];
				$qtyLastSo=$checkAvailable['qtySo'];
				$binnumLast=$checkAvailable['binnum'];
				$conditioncodeLast=$checkAvailable['conditioncode'];

				// echo $key->item_number.'-'.$key->qtySo.'-'.$qtyLastSo.'-'.$key->conditioncode.'-'.$conditioncodeLast.'<br>';

				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				// $dataSubmit['conditioncode']=$key->conditioncode;

				if($key->binnum==$binnumLast){ //binnum sama berati tidak dijumlah qty-nya
					if($key->conditioncode==$conditioncodeLast){ //condition tidak sama berati dijumlah qty-nya
						$dataSubmit['qty']=$key->qty;
					}else{
						$dataSubmit['qty']=$key->qty+$qtyLast;
					}
				}else{
					$dataSubmit['qty']=$key->qty+$qtyLast;
				}

					$dataSubmit['qtySo']=$key->qtySo; //diambil qty tearahir ter upload CSV


				$dataSubmit['selisih']=($dataSubmit['qtySo'])-($dataSubmit['qty']);
				$dataSubmit['status']=1;

				$this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
				$this->dbInventory->update('item_balances_monitoring_chem',$dataSubmit);
			}
		}
	}



	public function checkAvailableChem($item_number,$location){
		$location=$this->getLocationName($location);
		$result=$this->dbInventory->query("select * from item_balances_monitoring_chem where item_number='$item_number' and location='$location'")->result();
		if(count($result)>0){
			$data['item_balance_id']=$result[0]->item_balance_id;
			$data['qty']=$result[0]->qty;
			$data['qtySo']=$result[0]->qtySo;
			$data['binnum']=$result[0]->binnum;
			$data['conditioncode']=$result[0]->conditioncode;

			return $data;
		}else{
			return 'false';
		}
	}

	public function getNotFoundChem($location_id=NULL)
	{
		$data['title']="Realtime Monitoring Stock Opname";	
		$data['result'] = $foundInBalances = $this->dbInventory->query("SELECT * FROM item_balances_forSo where item_number NOT IN (SELECT item_number FROM item_balances_monitoring_chem) and location_id=$location_id")->result();

		foreach ($foundInBalances as $key) {
			$checkAvailable=$this->checkAvailableChem($key->item_number,$key->location_id);
			if ($checkAvailable=='false'){
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				$dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty;
				$dataSubmit['status']=3;

				$this->dbInventory->insert('item_balances_monitoring',$dataSubmit);

			}else{
				$qtyLast=$checkAvailable['qty'];
				$dataSubmit['item_number']=$key->item_number;
				$dataSubmit['location']=$this->getLocationName($key->location_id);
				// $dataSubmit['conditioncode']=$key->conditioncode;
				$dataSubmit['binnum']=$key->binnum;
				$dataSubmit['qty']=$key->qty+$qtyLast;
				$dataSubmit['status']=3;

				$this->dbInventory->where('item_balance_id',$checkAvailable['item_balance_id']);
				$this->dbInventory->update('item_balances_monitoring_chem',$dataSubmit);
			}
		}
	}

	function getAllChem($location=NULL){
		$this->dbInventory->query("TRUNCATE `item_balances_monitoring_chem`;");
		$this->getFoundChem($this->getLocationId('CHEM'));
		// $this->getNotFound();
		$this->getNotFoundChem($this->getLocationId('CHEM'));
		$this->getNameStatusChem();
	}

	public function getNameStatusChem(){
		$query=$this->dbInventory->query("SELECT * FROM item_balances_monitoring_chem where status=3")->result();
		foreach ($query as $key) {
			// $dataUpdate['item_balance_id']=$key->item_balance_id;
			$dataUpdate['description']=$this->getName($key->item_number);
			$dataUpdate['item_number']=$key->item_number;

			// echo "<pre>";
			// print_r($dataUpdate);
			$this->dbInventory->where('item_balance_id',$key->item_balance_id);
			$this->dbInventory->update('item_balances_monitoring_chem',$dataUpdate);
		}
	}

	function hidezero(){
		$a = '12000';
		$b = substr($a, 0, -3);
		echo $b;
	}

	// function insertTrxSoDetail(){
	// 	$data['trx_so_id'] 		= '601';
	// 	$data['item_number'] 	= '14928';
	// 	$data['issue_unit'] 	= 0;
	// 	$data['location_id'] 	= '1203';
	// 	$data['condition_code'] = 'NEW-MATERIAL'
	// 	$data['qty'] 			= 0;

	// 	$this->

	// }




	function howtostockopname(){

		$data['title']="IMPORT DATA STOCK OPNAME";	
		$data['countWh1'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_forSo where location_id='1203'")->row();
		$data['countWh2'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_forSo where location_id='2201'")->row();
		$data['countWh3'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_forSo where location_id='2301'")->row();
		$data['countChem'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_forSo where location_id='1902'")->row();
		
		$data['countBalancesMonitoringWh1'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_monitoring where location='1203'")->row();
		$data['countBalancesMonitoringWh2'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_monitoring2 where location='2201'")->row();
		$data['countBalancesMonitoringWh3'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_monitoring3 where location='2301'")->row();
		$data['countBalancesMonitoringChem'] = $this->dbInventory->query("select COUNT(*) as jml from item_balances_monitoring_chem where location='1902'")->row();
		$this->load->view('import',$data);
	}


}