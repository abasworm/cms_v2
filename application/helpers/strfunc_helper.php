<?php
if(!function_exists("random_string")){
	function random_string($length){
		return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+'), 0, $length);
	}
}