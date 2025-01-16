<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelCoreTrx extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
        $this->dbMaster = $this->load->database('default', TRUE);
        $this->dbTrx = $this->load->database('trx', TRUE);
        $this->dbMaximo = $this->load->database('maximo', TRUE);
    }


    function trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff,$binnum=NULL,$siteid=NULL){
        $qty=floatval($qty);
        if($this->checkItemIsAvailable($itemNumber,$location,$conditionCode)){
            if($trx=="Dr"){ #Debit (adebeo)
                $this->dbMaster->query("UPDATE item_balances SET qty = @qty := qty+$qty WHERE item_number=$itemNumber AND location_id=$location AND conditioncode='$conditionCode' LIMIT 1;");
                $currentBalance=$this->dbMaster->query("SELECT @qty as curbal;"); 
            }else if($trx=="Kr"){ #Kredit (credito)
                if($binnum==NULL){//binnum null
                $this->dbMaster->query("UPDATE item_balances SET qty = @qty := qty-$qty WHERE item_number=$itemNumber AND location_id=$location AND conditioncode='$conditionCode' LIMIT 1;");
                }else{
                $this->dbMaster->query("UPDATE item_balances SET qty = @qty := qty-$qty WHERE item_number=$itemNumber AND location_id=$location AND conditioncode='$conditionCode' AND binnum='$binnum' LIMIT 1;");
                }
                $currentBalance=$this->dbMaster->query("SELECT @qty as curbal;"); 
            }
            $currentBalance=$currentBalance->result();
            $this->trxLog($itemNumber,$location,$conditionCode,$qty,$currentBalance[0]->curbal,$trx,$trxCode,$reff,$binnum);

        }else{
            $dataNewItem['item_number']=$itemNumber;
            $dataNewItem['location_id']=$location;
            $dataNewItem['conditioncode']=$conditionCode;
            $dataNewItem['siteid']=$siteid;
            $this->dbMaster->insert('item_balances',$dataNewItem);
            $this->trxItemQty($itemNumber,$location,$conditionCode,$qty,$trx,$trxCode,$reff,$binnum);
        }
        return 0;
    }

    function trxLog($itemNumber,$location,$conditionCode,$qty,$currentBalance,$trx,$trxCode,$reff,$binnum){
            $dataLog['item_number']=$itemNumber;
            $dataLog['location']=$location;
            $dataLog['conditioncode']=$conditionCode;
            $dataLog['qty']=$qty;

            if($currentBalance!=NULL){
                $dataLog['currentBalance']=$currentBalance;
            }
            $dataLog['trx']=$trx;
            $dataLog['trx_code']=$trxCode;
            $dataLog['trx_reff']=$reff;
            $dataLog['binnum']=$binnum;
            $this->dbTrx->insert('trx_item_log',$dataLog);
            return 0;
    }


    function checkItemIsAvailable($itemNumber,$location,$conditionCode){
        $countItem=$this->dbMaster->query("Select count(*) as jml from item_balances WHERE item_number=$itemNumber AND location_id=$location AND conditioncode='$conditionCode'")->result();
        if($countItem[0]->jml>0){
            return 1;
        }else{
            return 0;
        }
    }


    function updateBin($itemNumber,$location,$conditionCode,$oldbin,$bin,$qty,$reff){
        $data['item_number']=$itemNumber;
        $data['location_id']=$location;
        $data['conditioncode']=$conditionCode;
        $data['binnum']=$bin;

        $this->dbMaster->query("UPDATE item_balances SET qty = @qty := $qty, binnum='$bin' WHERE item_number=$itemNumber AND location_id=$location AND conditioncode='$conditionCode' LIMIT 1;");
        $currentBalance=$this->dbMaster->query("SELECT @qty as curbal;"); 
        $currentBalance=$currentBalance->result();
        $this->trxLog($itemNumber,$location,$conditionCode,$currentBalance[0]->curbal,$currentBalance[0]->curbal,'',"5",$reff,$binnum);

    }




}