<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Lima');

class Login extends CI_Controller{

	function __construct(){
		parent::__construct();
		session_start();
		
		if (isset($_SESSION['user_okcs'])){
			header('Location:'.base_url('inicio'));
			$this->load->model('ini_model');
		}else{
			$this->load->model('login_model');
			$this->load->model('ini_model');
		}
	}

	function index(){
		$this->load->view('login');
	}

	function logeo(){
		$user = addslashes($_POST['user']);
		$pass = $this->encode5t(addslashes($_POST['pass']));
		$hoy = date('Y-m-d');
		$data = array('user' => $user, 'pass' => $pass);

		$result = $this->login_model->accessLogin($data);
		$response = json_decode($result);

		if ($response[0] == 2){
			if ($response[1] > 0){
				$_SESSION['user_okcs'] = $user;
				$_SESSION['id_okcs'] = $response[1];
			}
			$status = 'ok';
		}elseif($response[0] == 1){
			$status = 'e_clave';
		}elseif($response[0] == 0){
			$status = 'e_usu';
		}

		$array = array('sesion' => $status);
		echo json_encode($array);
	}

	function encode5t($str){
	  	for($i=0; $i<5;$i++){
	    	$str=strrev(base64_encode($str));
	  	}
	  	return $str;
	}

	function decode5t($str){
	  	for($i=0; $i<5;$i++){
	    	$str=base64_decode(strrev($str));
	  	}
	  	return $str;
	}
}	
