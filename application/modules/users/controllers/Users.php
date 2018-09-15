<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->helper('bootstrap_form');
	}

	public function add(){
		$data = array(
			'_tab_title' => 'Adding User',
			'_title' => 'Add User',
			'ci_mod' => 'Users',

			'fusername'=> frm_input('text','username','USERNAME','new-password',TRUE),
			'fpassword'=> frm_input('password','password','PASSWORD','new-password',TRUE),
			'fconfpassword' => frm_input('password','confpassword','CONFIRM PASSWORD','new-password',TRUE),
			'ffullname'=> frm_input('text','fullname','FULL NAME','nope'),
			'fphone'=> frm_input('text','phone','PHONE','nope',TRUE),
			'femail'=> frm_input('text','email','EMAIL','nope',TRUE),

		);
		$this->load->view('users/form_add_user',$data);
	}

}

