<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Lima');

class Asignacion extends CI_Controller{

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
		$this->load->view('asignacion');
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

	function initialize(){
		$result1 = $this->ini_model->loadMarca();
		$result2 = $this->ini_model->loadTipoEquipo();
		$html1 = '';
		$html2 = '';

		foreach ($result1 as $key1){
			$html1 .= '<option value="'.$key1->id_marca.'">'.$key1->descripcion.'</option>';
		}

		foreach ($result2 as $key2){
			$html2 .= '<option value="'.$key2->id_tipo_equipo.'">'.$key2->descripcion.'</option>';
		}

		$array = array('marca' => $html1, 'tipo_equipo' => $html2);
		return json_encode($array);
	}

	function register(){
		$ideq = $_POST['id_equipo_asg'];
		$equi = $_POST['equipo_asg'];
		$fsol = $_POST['fec_sol'];
		$fent = $_POST['fec_ent'];
		$area = strtoupper($_POST['area']);
		$soli = strtoupper($_POST['solic']);
		$resp = strtoupper($_POST['resp']);
		$motv = strtoupper($_POST['motiv']);

		$data = array(
			'id_equipo'			=> $ideq,
			'fecha_solicitud'	=> $fsol,
			'fecha_entrega'		=> $fent,
			'area'				=> $area,
			'solicitante'		=> $soli,
			'responsable'		=> $resp,
			'motivo'			=> $motv,
			'id_usuario'		=> $_SESSION['id_okcs'],
			'estado'			=> 1,
			'fecha_registro'	=> date('Y-m-d H:i:s')
		);

		$insert = $this->ini_model->registerAsign($data);
		
		if ($insert > 0){
			$value = 'ok';
			$id = $insert;
			$html = $this->loadAsignacion($ideq, 'return', $equi);
		}else{
			$value = 'null';
			$id = 0;
			$html = '';
		}
		$array = array('response' => $value, 'value' => $id, 'view' => $html);
		echo json_encode($array);
	}

	function searchComputer($equipo){
		$sql = $this->ini_model->searchEquip($equipo);

		if ($sql > 0){
			$id = $sql;
			$html = $this->loadAsignacion($id, 'return', $equipo);
		}else{
			$id = 0;
			$html = '<tr><td colspan="8">No hay registros encontrados.</td></tr>';
		}
		$array = array('id' => $id, 'view' => $html);
		echo json_encode($array);
	}

	function loadAsignacion($id, $type, $equipo){
		$html = '';
		$sql = $this->ini_model->loadAsignacion($id);

		if ($sql){
			foreach ($sql as $key){
				$num = $this->leftZero(3, $key->id_asignacion);
				$code = 'ASG'.$num;

				if ($key->fecha_solicitud != null){
					if ($key->fecha_entrega != null){
						$txtFec = date('d/m/Y', strtotime($key->fecha_solicitud)).'<br>'.date('d/m/Y', strtotime($key->fecha_entrega));
					}else{
						$txtFec = date('d/m/Y', strtotime($key->fecha_solicitud));
					}
				}else{
					if ($key->fecha_entrega != null){
						$txtFec = date('d/m/Y', strtotime($key->fecha_entrega));
					}else{
						$txtFec = '';
					}
				}

				$user = $this->ini_model->loadDataUser($key->id_usuario);

				$html.=
				'<tr>
					<td>'.$code.'</td>
					<td>'.$equipo.'</td>
					<td>'.$key->area.'</td>
					<td>'.$key->solicitante.'</td>
					<td>'.$key->responsable.'</td>
					<td>'.$txtFec.'</td>
					<td>'.$key->motivo.'</td>
					<td>'.$user.'</td>
				</tr>';
			}
		}else{
			$html .= '<tr><td colspan="8">No hay registros encontrados.</td></tr>';
		}

		if ($type == 'echo'){
			echo json_encode($html);
		}else{
			return $html;
		}
	}

	function imprimir($id){
	    $this->load->library('pdf');

		$html =
		'<style type="text/css">
			*{
				font-family: "Helvetica";
			}
			table{
				width: 100%;
				font-size: 12px;
				border: 1px solid #ddd;
				border-collapse: collapse;
			}
			table th,
			table td{
				border: 1px solid #ddd;
				padding: 4px;
			}
        </style>';

	    $this->dompdf->loadHtml($html);
	    $this->dompdf->setPaper('A4', 'portrait');
	    $this->dompdf->render();
	    $this->dompdf->stream("ficha_equipo.pdf", array("Attachment"=>0));
	}
}