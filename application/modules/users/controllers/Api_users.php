<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_users extends CI_Controller{
	private $data;
	
	public function __construct(){
		parent::__construct();

		$this->load->model('users/m_users');

		$cdata = array(
			'username' => $this->input->post('username', TRUE),
			'password' => $this->input->post('password', TRUE),
			'confpassword' => $this->input->post('confpassword', TRUE),
			'fullname' => $this->input->post('fullname', TRUE),
			'email' => $this->input->post('email', TRUE),
			'phone' => $this->input->post('phone',TRUE)
		);	
		$this->data = $this->security->xss_clean($cdata);
	}
	

	public function check_existing(){
		$ret = array(
			'status' => FALSE,
			'message' => 'Unknown Erorr'
		);
		$rs = $this->m_users->check_existing($this->data);
		if($rs){
			$ret = array(
				'status' => TRUE,
				'message'=> 'Username Bisa digunakan.'
			);
		}else{
			$ret = array(
				'status' => FALSE,
				'message'=> 'Username/Phone/Email sudah digunakan sebelumnya.'
			);
		}
		return $this->output
        	->set_content_type('application/json')
        	->set_output(json_encode($ret));
	}
}