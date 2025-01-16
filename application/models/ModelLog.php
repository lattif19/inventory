<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class ModelLog extends CI_Model {
 	
 	function __construct(){
 		parent::__construct();
 		$this->dbInventory = $this->load->database('default', TRUE);
 	}
    public function save_log($param)
    {
        $sql        = $this->dbInventory->insert_string('activity_log',$param);
        $ex         = $this->dbInventory->query($sql);
        return $this->dbInventory->affected_rows($sql);
    }
}