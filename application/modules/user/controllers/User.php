<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		echo 'hello world';
	}

	public function get_nama(){
		echo 'Aris Baskoro';
	}

}