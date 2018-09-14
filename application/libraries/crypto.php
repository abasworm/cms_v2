<?php
include 'phpseclib/Crypt/AES.php';
class Crypto{

	private $aes;

	public function __construct(){
		$this->aes = new Crypt_AES();
	}

	public function set_key($key){
		$this->aes->setKey($key);
	}

	public function encrypt($text){
		return $this->aes->encrypt($text);
	}

	public function decrypt($text){
		return $this->aes->decrypt($text);
	}
	
}