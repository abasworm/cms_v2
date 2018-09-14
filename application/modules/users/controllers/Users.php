<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller{
	public function add(){
		$data = array(
			'_tab_title' => 'Adding User',
			'_title' => 'Add User',
			'ci_mod' => 'Users'
		);
		$this->load->view('users/form_add_user',$data);
	}

	

	public function insert(){

	}
}

