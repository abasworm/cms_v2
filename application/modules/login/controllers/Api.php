<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * API LOGIN
 */
class Api extends CI_Controller{

	var $crypto_key = 'n4dhifh4';
	var $encrypt_field = FALSE;
	var $message = array(
		'check_login_success' => 'Login Success.',
		'check_login_error' => 'Username / Password is not valid.',
		'check_login_captcha' => 'Captcha Invalid',
		'check_login_captcha_null' => 'Captcha harus Di isi',
		
	);
	
	public function __construct(){
		parent::__construct();
		$this->load->model('m_login');		
	}

	public function index(){
		echo 'There is nothing';
	}

	public function check_login(){
		$cap = $this->session->userdata('captcha');
        $this->session->unset_userdata('captcha');	
        
        $msg = "";	
        $rs = FALSE;

		$fusername = $this->input->post(($this->encrypt_field)?$this->session->userdata('fusername'):'username', TRUE);
		$fpassword = $this->input->post(($this->encrypt_field)?$this->session->userdata('fusername'):'password', TRUE);

		$this->load->library('crypto');
		$this->crypto->set_key($this->crypto_key);
		$pass = $this->crypto->encrypt($fpassword);

		if (!is_null($cap)) {
            if ($cap['word'] == strtoupper($this->input->post('captcha'))) {
            	$rs = $this->m_login->check($fusername, $pass);
                if ($rs) {
                    $c = $this->session->flashdata('cap_del');
                    echo $c;
                    if (!is_null($c)) {
                        unlink($c);
                    }
                    $ret = array(
						'status' => TRUE,
						'message' => $this->message['check_login_success'],
						//'result' => $rs
					);
                } else {
                	$ret = array(
						'status' => FALSE,
						'message' => $this->message['check_login_error'],
						//'result' => $rs
					);
                }
            } else {
             	$ret = array(
					'status' => FALSE,
					'message' => $this->message['check_login_captcha'],
					//'result' => $rs
				);
            }
        } else {
           	$ret = array(
				'status' => FALSE,
				'message' => $this->message['check_login_captcha_null'],
				//'result' => $rs
			);
            //redirect('login');
        }

		
		
		return $this->output
        	->set_content_type('application/json')
        	->set_output(json_encode($ret));
	}
}