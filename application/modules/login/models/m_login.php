<?php

class M_login extends CI_Model{

	public function get_password($username){
		$this->db->select('password');
		$this->db->where('status',1);
		$rs = $this->db->get_where('users',array('username'=>$username))->result_array();
		if(count($rs)>0){
			return $rs[0]['password'];
		}else{
			return FALSE;
		}
	}	

}