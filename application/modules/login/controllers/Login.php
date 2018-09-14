<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

	
	var $encrypt_field = FALSE;


	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->load->helper('strfunc');
		$this->load->helper('captcha');
		$this->load->helper('file');

		//captcha build in
        $c = $this->session->flashdata('cap_del');
        if (!is_null($c)) {
            unlink($c);
        }

        if(!file_exists('./public/captcha/'.date('Ymd'))){
            mkdir('./public/captcha/'.date('Ymd'));
        }
        
        $vals = array(
            'img_path' => './public/captcha/'.date('Ymd').'/',
            'img_url' => base_url() . 'public/captcha/'.date('Ymd').'/',
            'font_path' => './public/font/cc.ttf',
            'word_length' => 4,
            'font_size' => 40,
            'img_width' => '200',
            'img_height' => 60,
            'pool' => '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ',
        );

        $cap = create_captcha($vals);
        $data_x = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $this->input->ip_address(),
            'word' => $cap['word']
        );
        $this->session->set_flashdata('cap_del', './public/captcha/'.date('Ymd').'/' . $cap['time'] . '.jpg');
        $this->session->set_userdata('captcha', $data_x);
        
		//field must be random name
		$fusername = ($this->encrypt_field)?random_string(30):'username';
		$fpassword = ($this->encrypt_field)?random_string(30):'password';
		$fcaptcha = ($this->encrypt_field)?random_string(30):'captcha';
		$frole_akses = "role_akses";

		//create session for field
		$this->session->set_userdata('fusername',$fusername);
		$this->session->set_userdata('fpassword',$fpassword);
		$this->session->set_userdata('fcaptcha',$fcaptcha);

		//include into view
		$data = array(
			'username' => $fusername,
			'password' => $fpassword,
			'fcaptcha' => $fcaptcha,
			'captcha' => $cap['image'],
			'role_akses' => $frole_akses,
			'ci_mod' => 'login'
 		);
		$this->load->view('login/login_view',$data);
	}

	public function refresh_captcha(){
		$this->load->helper('captcha');
		$this->load->helper('file');
        
		//captcha build in
        $c = $this->session->cap_del;
        $this->session->unset_userdata('cap_del');
        //var_dump($c);
        if (!is_null($c)) {
            unlink($c);
        }

        if(!file_exists('./public/captcha/'.date('Ymd'))){
            mkdir('./public/captcha/'.date('Ymd'));
        }
        
        $vals = array(
            'img_path' => './public/captcha/'.date('Ymd').'/',
            'img_url' => base_url() . 'public/captcha/'.date('Ymd').'/',
            'font_path' => './public/font/cc.ttf',
            'word_length' => 4,
            'font_size' => 40,
            'img_width' => '200',
            'img_height' => 60,
            'pool' => '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ',
        );

        $cap = create_captcha($vals);
        $data_x = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $this->input->ip_address(),
            'word' => $cap['word']
        );
        $this->session->set_userdata('cap_del', './public/captcha/'.date('Ymd').'/' . $cap['time'] . '.jpg');
        $this->session->set_userdata('captcha', $data_x);

        if(!is_null($cap['image'])){
        	$data = array(
        		'status' => TRUE,
        		'captcha' => $cap['image'],
        		'time' => $this->session->cap_del
        	);
        }else{
        	$data = array(
        		'status' => FALSE,
        		'message' => 'captcha invalid to show.'
        	);
        }

        return $this->output
        	->set_content_type('application/json')
        	->set_output(json_encode($data));
	}


	public function process(){

		
		$fcaptcha = $this->session->userdata('fpassword');


		$this->load->library('crypto');
		$this->crypto->set_key('n4dhifh4');

		$ps = $this->crypto->encrypt($password);
		$this->mlog->insert($ps);
		echo $ps;
	}

}