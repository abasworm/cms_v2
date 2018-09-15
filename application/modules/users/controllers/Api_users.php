<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_users extends CI_Controller{
	private $data;
	private $ret = array(
		'status' => FALSE,
		'message' => 'Unknown Erorr'
	);
	
	public function __construct(){
		parent::__construct();
		$this->config->load('salt');
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
		$rs = $this->m_users->check_existing($this->data);
		if($rs){
			$this->ret = array(
				'status' => TRUE,
				'message'=> 'Username Bisa digunakan.'
			);
		}else{
			$this->ret = array(
				'status' => FALSE,
				'message'=> 'Username/Phone/Email sudah digunakan sebelumnya.'
			);
		}
		return $this->output
        	->set_content_type('application/json')
        	->set_output(json_encode($this->ret));
	}

	public function insert(){
		$this->load->library('form_validation');
		$config = array(
			array(
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'trim|required|min_length[5]|max_length[20]|is_unique[users.username]',
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|required|min_length[8]|max_length[30]'
			),
			array(
				'field' => 'confpassword',
				'label' => 'Confirm Password',
				'rules' => 'trim|required|matches[password]'
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'trim|required|valid_email|is_unique[users.email]'
			),
			array(
				'field' => 'phone',
				'label' => 'Phone',
				'rules' => 'trim|required|max_length[20]|is_unique[users.phone]|numeric'
			),
		);
		$this->form_validation->set_rules($config);
		if($this->form_validation->run()==FALSE){
			$rs = array(
				'username' => form_error('username'),
				'password' => form_error('password'),
				'confpassword' => form_error('confpassword'),
				'email' => form_error('email'),
				'phone' => form_error('phone')
			);
			$this->ret = array(
				'status' => FALSE,
				'message' => 'Mohon lengkapi data yang ada.',
				'result' => $rs
			);
		}else{
			$option = ['cost' => $this->config->item('hash_cost')];
			$this->data['password'] = password_hash($this->data['password'],PASSWORD_BCRYPT,$option);
			$rs = $this->m_users->insert($this->data);
			if($rs){
				$this->ret = array(
					'status' => TRUE,
					'message'=> 'Berhasil Insert Data.'
				);
			}else{
				$this->ret = array(
					'status' => FALSE,
					'message'=> 'Gagal Insert Data.'
				);
			}
		}

		return $this->output
        	->set_content_type('application/json')
        	->set_output(json_encode($this->ret));		
	}

}