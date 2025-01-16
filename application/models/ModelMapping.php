<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelMapping extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->dbInventory = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
		$this->dbSo = $this->load->database('trxSo', TRUE);
	}

	function getMappingPO()
	{
		return $this->dbTrx->query("select a.*, b.* from trx_po as a, trx_po_detail as b where a.trx_id = b.trx_id and a.trx_status=0  or a.trx_id = b.trx_id and a.trx_status=2 group by b.trx_id")->result();
	}

	function getMappingWO(){
		return $this->dbTrx->query("SELECT a.*, b.* FROM trx_wo as a, trx_wo_detail as b WHERE a.trx_id = b.trx_id and a.trx_status=0  or a.trx_id = b.trx_id and a.trx_status=2 group by b.trx_id")->result();
	}

	function getDataReceiving($trx_id)
    {
        $query = $this->dbTrx->query("SELECT a.*, b.* FROM trx_po as a, trx_po_detail as b WHERE a.trx_id = b.trx_id AND a.trx_id = '$trx_id'");
        return $query->result();
    }

    function getDataWO($trx_id)
    {
        $query = $this->dbTrx->query("SELECT a.*, b.* FROM trx_wo as a, trx_wo_detail as b WHERE a.trx_id = b.trx_id AND a.trx_id = '$trx_id'");
        return $query->result();
    }

}

/* End of file ModelMapping.php */
/* Location: .//C/Users/asus/AppData/Local/Temp/fz3temp-2/ModelMapping.php */