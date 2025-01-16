<?php
/**
* 
*/
class ModelReport extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->dbMaster = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
		$this->dbMaximo = $this->load->database('maximo', TRUE);
		$this->dbSo = $this->load->database('trxSo', TRUE);
	}


	function getReportReceiving()
	{
		$this->dbTrx->select ('*');
		$this->dbTrx->from ('trx_po');
		$query = $this->dbTrx->get();
		if ($query) {
            return $query;
        } else {
            return false;
        }
	}

	function getIdReceiving($trx_id)
	{
		return $this->dbTrx->query("select * from trx_po where trx_id ='$trx_id'");
	}


	function getReportIssue()
    {
    	$this->dbTrx->select ('*');
		$this->dbTrx->from ('trx_wo');
		$query = $this->dbTrx->get();
		if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    function getDetailReportIssue($trx_id)
    {
    	$this->dbTrx->select('*');
		$this->dbTrx->from('trx.trx_wo');
		$this->dbTrx->join('trx.trx_wo_detail', 'trx.trx_wo.trx_id = trx.trx_wo_detail.trx_id', 'left');
		$this->dbTrx->join('inventory.shipper', 'shipper.shipper_barcode = trx_wo.shipper_id', 'left');
		$this->dbTrx->where('trx_wo.trx_id', $trx_id);
		$query = $this->dbTrx->get();
		if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getIdIssue($trx_id)
	{
		return $this->dbTrx->query("select * from trx_wo where trx_id ='$trx_id'");
	}

	function getReportVendor()
	{
		$this->dbTrx->select('*');
		$this->dbTrx->from('trx_po_return');
		//$this->dbTrx->join('trx_po_detail_return', 'trx_po_return.trx_id = trx_po_detail_return.trx_id', 'left');
		$query = $this->dbTrx->get();
		if (count($query)>0) {
			return $query->result();
		} else {
			echo "Not Found Data";
		}
	}

	function getReportWarehouse()
	{
		$this->dbTrx->select('*');
		$this->dbTrx->from('trx_wo_return');
		//$this->dbTrx->join('trx_wo_detail_return', 'trx_wo_return.trx_id = trx_wo_detail_return.trx_id', 'left');
		$reportWarehouse = $this->dbTrx->get();
		if (count($reportWarehouse)>0) {
			return $reportWarehouse->result();
		} else {
			echo "Not Found Data";
		}
	}

	function getReportStockopname()
	{
		$this->dbSo->select('*');
		$this->dbSo->from('trx_so');
		$this->dbSo->join('so', 'so.id_so = trx_so.id_so', 'left');
		$reportStockopname = $this->dbSo->get();
		if (count($reportStockopname)>0) {
			return $reportStockopname->result();
		} else {
			echo "Not Found Data";
		}
	}

	function getReportCompare()
	{
		$this->dbSo->select('*');
		$this->dbSo->from('so_detail_summary');
		$this->dbSo->join('so', 'so.id_so = so_detail_summary.id_so', 'left');
		$reportCompare = $this->dbSo->get();
		if (count($reportCompare)>0) {
			return $reportCompare->result();
		} else {
			echo "Not Found Data";
		}
	}

	function getReportSSR($trx_id) {
		return $this->dbTrx->query("select * from trx_po, trx_item_log where trx_po.trx_code = trx_item_log.trx_code and trx_po.trx_code = '$trx_id'")->result();
	}


}