<?php


class ModelLogin extends CI_Model
{

	function __construct()
	{
		parent::__construct();
        $this->dbInventory = $this->load->database('default', TRUE);
        $this->dbTrx 	= $this->load->database('trx', TRUE);
	}

	public function getlogin($u,$p)
	{
		$pwd = md5($p);
		$this->dbInventory->select('*');
		$this->dbInventory->from('user');
		$this->dbInventory->join('user_level', 'user.level = user_level.level', 'left');
		$this->dbInventory->where('username',$u);
		$this->dbInventory->where('password',$pwd);
		$query = $this->dbInventory->get();

		if($query->num_rows()>0)
		{
			foreach ($query->result() as $key) {
				$session = array(
					'username' 		=> $key->username,
					'password' 		=> $key->password,
					'displayname'	=> $key->displayname,
					'user_id' 		=> $key->user_id,
					'level' 		=> $key->level,
					'status_date' 	=> $key->status_date,
					'foto' 			=> $key->foto,
					'name_level'	=> $key->name,
					'logged' 		=> TRUE
					);
			$this->session->set_userdata($session);
			redirect('home');
			}
		} else {
			$this->session->set_flashdata('info','maaf username atau password salah ');
			redirect('login');
		}
	}
}