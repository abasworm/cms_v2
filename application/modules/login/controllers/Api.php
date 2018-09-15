<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * API LOGIN
 */
class Api extends CI_Controller{

	var $crypto_key = 'n4dhifh4';
	var $encrypt_field = FALSE;
	private $message = array(
		'check_login_success' => 'Login Success.',
		'check_login_error' => 'Username / Password is not valid.',
		'check_login_captcha' => 'Captcha Tidak Sama',
		'check_login_captcha_null' => 'Captcha Gagal',
		
	);

	private $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->model('m_login');		

		$fusername = $this->input->post(($this->encrypt_field)?$this->session->userdata('fusername'):'username', TRUE);
		$fpassword = $this->input->post(($this->encrypt_field)?$this->session->userdata('fusername'):'password', TRUE);

		$cdata = array(
			'username' => $fusername,
			'password' => $fpassword,
			'captcha' => $this->input->post('captcha', TRUE)
		);
		$this->data = $this->security->xss_clean($cdata);
	}

	public function index(){
		echo 'There is nothing';
	}

	public function check_captcha(){
		$cap = $this->session->flashdata('captcha');
		$fcap = $this->data['captcha'];
		if(!is_null($cap)){ //Jika session captcha NULL
			if ($cap['word'] == strtoupper($fcap)) { //Jika Captcha Match dengan input
				return FALSE;
		 	}else{
		 		$ret = array(
					'status' => FALSE,
					'message' => $this->message['check_login_captcha'],
					//'result' => $rs
				);
		 	}
		}else{
			$ret = array(
				'status' => FALSE,
				'message' => $this->message['check_login_captcha_null'],
				//'result' => $rs
			);
		}
		return $ret;
	}

	public function process(){
		$ret = array();
		$captcha = $this->check_captcha();
		if(!$captcha){
			$rs_pwd = $this->m_login->get_password($this->data['username']);
			if($rs_pwd AND $rs_pwd != '' AND !is_null($rs_pwd)){
				if(password_verify($this->data['password'],$rs_pwd)){
				  	$c = $this->session->flashdata('cap_del');
                   	if (!is_null($c)) {
                        unlink($c);
                    }
                    $ret = array(
						'status' => TRUE,
						'message' => $this->message['check_login_success'],
					);
				}
			}else{
				$ret = array(
					'status' => FALSE,
					'message' => $this->message['check_login_error'],
				);
			}
		}else{
			$ret = $captcha;
		}

		return $this->output
        	->set_content_type('application/json')
        	->set_output(json_encode($ret));
	}

	public function init_sess(){
		var_dump();
	}
}