<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Lima');

class Lista extends CI_Controller{

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
		$this->load->view('lista');
		$this->load->view('footer');
	}

	function header(){
		if (isset($_SESSION['user_okcs'])){
			$user = $this->userName($_SESSION['user_okcs']);
			$userName = $user['nombre'];
			$userProf = $user['perfil'];

			$initial = $this->initialize();
			$tipo_in = $initial['select_tipo_interv'];
		}else{
			$userName = '';
			$userProf = '';
			$tipo_in = '';
		}

        $val['userName'] = $userName;
        $val['userProf'] = $userProf;
        $val['tipo_interv'] = $tipo_in;

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
		$query1 = $this->ini_model->loadCompanys();
		$query2 = $this->ini_model->loadCategorys();
		$query3 = $this->ini_model->loadMedium();
		$query4 = $this->ini_model->loadTypeAtention();
		$query5 = $this->ini_model->loadModality();
		$query6 = $this->ini_model->loadTypeIntervention();
		$query7 = $this->ini_model->loadDepartment();
		$query8 = $this->ini_model->loadMarca();
		$html1 = '';
		$html2 = '';
		$html3 = '';
		$html4 = '';
		$html5 = '';
		$html6 = '';
		$html7 = '';
		$html8 = '';

		foreach ($query1 as $key1){ $html1 .= '<option value="'.$key1->id_empresa.'">'.$key1->nombre.'</option>'; }
		foreach ($query2 as $key2){ $html2 .= '<option value="'.$key2->id_categoria.'">'.$key2->descripcion.'</option>'; }
		foreach ($query3 as $key3){ $html3 .= '<option value="'.$key3->id_medio.'">'.$key3->descripcion.'</option>'; }
		foreach ($query4 as $key4){ $html4 .= '<option value="'.$key4->id_tipo_atencion.'">'.$key4->descripcion.'</option>'; }
		foreach ($query5 as $key5){ $html5 .= '<option value="'.$key5->id_modalidad.'">'.$key5->descripcion.'</option>'; }
		foreach ($query6 as $key6){ $html6 .= '<option value="'.$key6->id_tipo_intervencion.'">'.$key6->descripcion.'</option>'; }
		foreach ($query7 as $key7){ $html7 .= '<option value="'.$key7->id_dpto.'">'.$key7->descripcion.'</option>'; }
		foreach ($query8 as $key8){ $html8 .= '<option value="'.$key8->id_marca.'">'.$key8->descripcion.'</option>'; }

		return $array = array(
			'select_empresa'		=> $html1, 
			'select_categoria'		=> $html2, 
			'select_medios'			=> $html3, 
			'select_tipo_atencion'	=> $html4,
			'select_modalidad'		=> $html5,
			'select_tipo_interv'	=> $html6,
			'select_departamento'	=> $html7,
			'select_marca'			=> $html8
		);
	}

	function start($filter){
		$result = $this->ini_model->startRequest($filter);
		$output = array('data' => array());
		$type = "'lista'";
		$cont = 1;

		foreach ($result as $row){
			$id = $row->id_solicitud;
			$empre = $row->empresa;
			$clien = $row->cliente;
			$marca = $row->marca;
			$model = $row->modelo;
			$produ = $row->producto;
			$tpate = $row->tipo_atencion;
			$cntc1 = $row->contacto_1;
			$idctc = $row->id_contacto;
			$depto = $row->departamento;
			$provi = $row->provincia;
			$distt = $row->distrito;
			$ubige = $depto.'<br>'.$provi.'<br>'.$distt;
			$direc = $row->direccion;
			$factu = ($row->factura != '') ? $row->factura : '-';
			$ordco = ($row->orden_compra != '') ? $row->orden_compra : '-';
			$ccost = ($row->cuadro_costo != '') ? $row->cuadro_costo : '-';
			$modad = $row->abrev_mod;
			$fsoli = date('d/m/Y', strtotime($row->fecha_solicitud));
			$falla = $row->descripcion;
			$estad = $row->estado_solicitud;
			$codes = $row->codigo;
			$pdcto = $marca.'<br>'.$model.'<br>'.$produ;
			$txtCode = "'".$codes."'";
			$num = $this->leftZero(2, $cont);

			if ($estad == 1){
				$txtEst = '<label class="text-primary">ABIERTO</label>';
			}elseif ($estad == 2){
				$txtEst = '<label class="text-success">PENDIENTE</label>';
			}if ($estad == 3){
				$txtEst = '<label class="text-danger">CERRADO</label>';
			}

			if ($filter == 1){
				$action =
				'<div class="text-center" style="margin-bottom: 10px;">
					<button type="button" class="boton-spt btn-primary" onClick="detailRequest('.$id.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Detalles">
						<i class="icon-clipboard"></i>
					</button>
					<button type="button" class="boton-spt btn-warning" onClick="editarRequest('.$id.', '.$idctc.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Editar">
						<i class="icon-edit"></i>
					</button>
					<button type="button" class="boton-spt btn-danger" onClick="deleteRequest('.$id.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar Solicitud">
						<i class="icon-trash"></i>
					</button>
				</div>
				<div class="text-center">
					<button type="button" class="boton-spt bg-teal" onClick="detailTotalRequest('.$id.', '.$txtCode.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Historial">
						<i class="icon-folder-open"></i>
					</button>
					<button type="button" class="boton-spt btn-success" onClick="historialRequest('.$id.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Atender Solicitud">
						<i class="icon-chat"></i>
					</button>
					<button type="button" class="boton-spt btn-danger" onClick="closeRequest('.$id.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Terminar Solicitud">
						<i class="icon-off"></i>
					</button>
				</div>';
			}else{
				$action =
				'<div class="text-center" style="margin-bottom: 10px;">
					<button type="button" class="boton-spt btn-primary" onClick="detailRequest('.$id.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Detalles">
						<i class="icon-clipboard"></i>
					</button>
					<button type="button" class="boton-spt bg-teal" onClick="detailTotalRequest('.$id.', '.$txtCode.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Historial">
						<i class="icon-folder-open"></i>
					</button>
				</div>';
			}

			$output['data'][] = array($codes, $empre, $clien, $pdcto, $ordco, $factu, $ubige, $direc, $modad, $fsoli, $falla, $txtEst, $action);
			$cont++;
		}
		
		echo json_encode($output);
	}

	function detailRequest($id){
		$sql = $this->ini_model->detailRequest($id);
		$html = '';

		foreach ($sql as $row){
			$id = $row->id_solicitud;
			$empre = $row->empresa;
			$clien = $row->cliente;
			$produ = $row->producto;
			$tpate = $row->tipo_atencion;
			$cntc1 = $row->contacto_1;
			$depto = $row->departamento;
			$provi = $row->provincia;
			$distt = $row->distrito;
			$ubige = $depto.'<br>'.$provi.'<br>'.$distt;
			$direc = $row->direccion;
			$factu = ($row->factura != '') ? $row->factura : '-';
			$ordco = ($row->orden_compra != '') ? $row->orden_compra : '-';
			$ccost = ($row->cuadro_costo != '') ? $row->cuadro_costo : '-';
			$modad = $row->abrev_mod;
			$modli = $row->modalidad;
			$fsoli = date('d/m/Y', strtotime($row->fecha_solicitud));
			$faten = date('d/m/Y', strtotime($row->fecha_atencion));
			$plazo = $row->plazo_atencion;
			$falla = $row->descripcion;
			$estad = $row->estado;
			$fcier = ($row->fecha_cierre != null) ? date('d/m/Y', strtotime($row->fecha_cierre)) : '-';
			$codig = $row->codigo;

			if ($estad == 1){
				$txtEst = '<strong class="text-primary">ABIERTO</strong>';
			}elseif ($estad == 2){
				$txtEst = '<strong class="text-success">PENDIENTE</strong>';
			}if ($estad == 3){
				$txtEst = '<strong class="text-danger">CERRADO</strong>';
			}

			$html .=
			'<div class="row">
				<div class="col-md-12">
					<label>Empresa:</label>
					<p>'.$empre.'</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label>Cliente:</label>
					<p>'.$clien.'</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label>Producto (serie):</label>
					<p>'.$produ.'</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Factura:</label>
					<p style="text-align: center;">'.$factu.'</p>
				</div>
				<div class="col-md-4">
					<label>Orden Compra:</label>
					<p style="text-align: center;">'.$ordco.'</p>
				</div>
				<div class="col-md-4">
					<label>Cuadro Costos:</label>
					<p style="text-align: center;">'.$ccost.'</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label>Ubigeo:</label>
					<p>'.$depto.' - '.$provi.' - '.$distt.'</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label>Dirección:</label>
					<p>'.$direc.'</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label>Modalidad:</label>
					<p>'.$modad.' -> '.$modli.'</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label>Problema/Falla:</label>
					<p>'.$falla.'</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Fecha Solicitud:</label>
					<p>'.$fsoli.'</p>
				</div>
				<div class="col-md-4">
					<label>Fecha Atención:</label>
					<p>'.$faten.'</p>
				</div>
				<div class="col-md-4">
					<label>Plazo Atención:</label>
					<p>'.$plazo.' día(s)</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label>Estado:</label>
					<p>'.$txtEst.'</p>
				</div>
				<div class="col-md-6">
					<label>Fecha Cierre:</label>
					<p>'.$fcier.'</p>
				</div>
			</div>';
		}
		$array = array('response' => $html, 'codigo' => $codig);
		echo json_encode($array);
	}

	function detailHistoryRequest($id){
		$sql = $this->ini_model->detailHistoryRequest($id);
		$html = '';

		foreach ($sql as $row){
			$idh = $row->id_historial;
			$com = $row->comentario;
			$cas = $row->codigo_caso;
			$usu = $row->usuario;
			$day = date('d/m/Y', strtotime($row->fecha));
			$sta = $row->status;

			if ($sta == 1){
				$class = 'callout-info"';
				$title = 'Creación de Solicitud';
			}elseif ($sta == 2){
				$class = 'callout-success"';
				$sbtit = 'Atención de Solicitud';
				$title = ($cas != null) ? $sbtit.' - (Caso: '.$cas.')' : $sbtit;
			}elseif ($sta == 3){
				$class = 'callout-danger"';
				$sbtit = 'Cierre de Solicitud';
				$title = ($cas != null) ? $sbtit.' - (Caso: '.$cas.')' : $sbtit;
			}

			$html .=
			'<div class="row">
				<div class="col-md-12">
					<div class="callout '.$class.'">
						<h5><strong>'.$title.'</strong></h5>
						<label>'.$usu.' - Fecha: '.$day.'</label>
						<p>'.$com.'</p>
					</div>
				</div>
			</div>';
		}
		echo json_encode($html);
	}

	function delete($id){
        $response = $this->ini_model->deleteSolicitud($id);
        echo $response;
    }
}