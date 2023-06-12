<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Lima');

class Marca extends CI_Controller{

	public function __construct(){
		parent::__construct();
		session_start();
		
		if (isset($_SESSION['user_okcs'])){
			$this->load->model('login_model');
			$this->load->model('ini_model');
		}else{
			header('Location:'.base_url());
		}
	}

	function index(){
		$this->header();
		$this->load->view('marca');
		$this->load->view('footer');
	}

	function header(){
		if (isset($_SESSION['user_okcs'])){
			$user = $this->userName($_SESSION['user_okcs']);
			$userName = $user['nombre'];
			$userProf = $user['perfil'];
		}else{
			$userName = '';
			$userProf = '';
		}

        $val['userName'] = $userName;
        $val['userProf'] = $userProf;

		$val['sys_setting'] = 'Configuración';
		$val['sys_close'] = 'Cerrar sesión';
		$this->load->view('header', $val);
	}

	function userName($user){
		$data = array('user' => $user);
		$userData = $this->login_model->userData($data);
		$name = '';
		$prof = '';

		foreach ($userData as $row){
			$name = $row->empleado;
			$prof = base_url('assets').'/resources/'.$row->perfil;
		}
		$array = array('nombre' => $name, 'perfil' => $prof);
		return $array;
	}

	function leftZero($lenght, $number){
		$nLen = strlen($number);
		$zeros = '';
		for($i=0; $i<($lenght-$nLen); $i++){
			$zeros = $zeros.'0';
		}
		return $zeros.$number;
	}

	function start(){
		$result = $this->ini_model->startMark();
		$output = array('data' => array());
		$type = "'marca'";
		$cont = 1;

		foreach ($result as $row){
			$id = $row->id_marca;
			$nom = $row->descripcion;
			$num = $this->leftZero(2, $cont);

			$action =
			'<div class="text-center">
				<button type="button" class="btn-primary boton" onClick="editPage('.$id.', '.$type.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Editar">
					<i class="icon-edit"></i>
				</button>
				<button type="button" class="btn-danger boton" onClick="deletePage('.$id.', '.$type.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar">
					<i class="icon-trash"></i>
				</button>
			</div>';

			$output['data'][] = array($num, $nom, $action);
			$cont++;
		}
		
		echo json_encode($output);
	}

	function register(){
		$name = strtoupper($_POST['desc']);
		$status = 1 ;

		$data = array(
			'descripcion'	=> $name,
			'estado'		=> $status
		);

		$insert = $this->ini_model->registerMark($data);
		
		if ($insert > 0){
			$value = 'ok';
			$id = $insert;
		}else{
			$value = 'null';
			$id = 0;
		}
		$array = array('response' => $value, 'value' => $id);
		echo json_encode($array);
	}

	function Edition($type){
		if($type == 'bringData'){
			$id = $_POST['id'];
			$sql = $this->ini_model->loadDataMark($id);
			
			foreach ($sql as $row) {
				$ids = $row->id_marca;
				$nom = $row->descripcion;
			}

			$json = array('id' => $ids, 'nom' => $nom);
			echo json_encode($json);

		}elseif($type == 'updateData'){
			$id = $_POST['id'];
			$name = strtoupper($_POST['desc']);
			$status = 1 ;

			$data = array(
				'descripcion'	=> $name,
				'estado'		=> $status
			);

			$update = $this->ini_model->updateMark($id, $data);
			
			if ($update > 0){
				$value = 'ok';
			}else{
				$value = 'null';
			}
			$array = array('response' => $value);
			echo json_encode($array);
		}
	}

	function delete($id){
        $response = $this->ini_model->deleteMark($id);
        echo $response;
    }
}