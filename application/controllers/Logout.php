<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Lima');

class Logout extends CI_Controller {

	function __construct(){
		parent::__construct();
		session_start();
	}

	function index(){
		if (isset($_SESSION['user_okcs'])){
			unset($_SESSION['id_okcs']);
			unset($_SESSION['user_okcs']);
			// session_destroy();
		}
		header('Location:'.base_url());
	}

}
