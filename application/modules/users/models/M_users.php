<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_users extends CI_Model{
	public function check_existing($data){
		$ret = FALSE;
		$rs = $this->db->query("
			SELECT count(*) AS total FROM users WHERE 
				username ='{$data['username']}' OR
				phone = '{$data['phone']}' OR
				email = '{$data['email']}'
		")->row_array();
		if($rs AND $rs['total'] == 0){
			$ret = TRUE;
		}

		return $ret;
	}
}