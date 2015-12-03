<?php 
require_once './DBController.php';
class Admin {
	public $user_name;
	public $password;

	function Admin($_user_name , $_password){
		$this->user_name = $_user_name;
		$this->password = $_password;
	}
}
?>