<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelRtrnWarehouse extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
	}

	function getDataWarehouse($trx_id)
	{
		$query = $this->dbTrx->query("SELECT a.*, b.* FROM trx_wo_return as a, trx_wo_detail_return as b WHERE a.trx_id = b.trx_id AND a.trx_id = '$trx_id'");
        return $query->result();
	}

	

}

/* End of file ModelRtrnWarehouse.php */
/* Location: .//C/Users/asus/AppData/Local/Temp/fz3temp-2/ModelRtrnWarehouse.php */