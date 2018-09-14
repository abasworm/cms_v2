<?php

class M_login extends CI_Model{
	public function get_data_user($username){
		$this->db->select('
				full_name,
				role,
				email
			');
		$rs = $this->db->get_where('users', array('username'=>$username))->row_array();
		if($this->check_result($rs)){
			return $rs;
		}else{
			return FALSE;
		}
	}

	public function get_password($username){
		$this->db->select('password');
		$rs = $this->db->get_where('users', array('username'=>$username))->row_array();
		if(check_result($rs)){
			return $rs;
		}else{
			return FALSE;
		}
	}

	public function insert($ps){
		$data = array(
			'password' => $ps
		);
		$rs = $this->db->insert('test_enc',$data);
		return $rs;
	}

	private function check_result($rs){
		if($rs){
			if(count($rs)>0 && !is_null($rs) && $rs!==''){
				return $rs;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	/////////////////////////////////////////////////////////
	
	public function check($username, $password){
		$rs = $this->db->get_where('users',array('username'=>$username,'password'=>$password))->result_array();
		if(count($rs)>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}


}