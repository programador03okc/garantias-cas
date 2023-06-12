<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Lima');

class Equipo extends CI_Controller{

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
		$this->load->view('equipo');
		$this->load->view('footer');
	}

	function header(){
		if (isset($_SESSION['user_okcs'])){
			$user = $this->userName($_SESSION['user_okcs']);
			$userName = $user['nombre'];
			$userProf = $user['perfil'];

			$dataIni = json_decode($this->initialize());
			$marca = $dataIni->marca;
			$tp_eq = $dataIni->tipo_equipo;
		}else{
			$userName = '';
			$userProf = '';
			$marca = '';
			$tp_eq = '';
		}

        $val['userName'] = $userName;
        $val['userProf'] = $userProf;
        $val['select_marca'] = $marca;
        $val['select_tipoe'] = $tp_eq;

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

	function start(){
		$result = $this->ini_model->startComputer();
		$output = array('data' => array());
		$type = "'equipo'";
		$mmss = '';
		$ndir = '';

		foreach ($result as $row){
			$id = $row->id_equipo;
			$code = $row->codigo;
			$tipo = $row->tipo_equipo;
			$mark = $row->marca;
			$mode = $row->modelo;
			$seri = $row->serie;
			$gara = $row->garantia;
			$proc = $row->procesador;
			$pmod = $row->modelo_proc;
			$capa = $row->capacidad;
			$siso = $row->sis_operativo;
			$disc = $row->disco_duro;
			$nrip = $row->ip;
			$nmac1 = $row->mac1;
			$nmac2 = $row->mac2;
			$nmac3 = $row->mac3;
			$cslot = $row->ram_slot;
			$html_slot = '';

			if ($mark != null){
				if ($mode != null) {
					$mmss = $mark.'<br>'.$mode;
				}else{
					$mmss = $mark;
				}
			}

			if ($disc != null){
				if ($pmod != null) {
					$dismode = $disc.'<br>'.$capa.'<br>'.$pmod;
				}else{
					$dismode = $disc;
				}
			}

			if ($nrip != null){
				if ($nmac1 != null){
					if ($nmac2 != null){
						if ($nmac3 != null){
							$ndir = $nrip.'<br>'.$nmac1.'<br>'.$nmac2.'<br>'.$nmac3;
						}else{
							$ndir = $nrip.'<br>'.$nmac1.'<br>'.$nmac2;
						}
					}else{
						$ndir = $nrip.'<br>'.$nmac1;
					}
				}else{
					$ndir = $nrip;
				}
			}

			$sql_slot = $this->ini_model->loadSlots($id);
			foreach ($sql_slot as $key){
				$html_slot .= '<br>'.$key->descripcion;
			}
			$txtSlot = 'Cantidad: '.$cslot.$html_slot;

			$sql_acsr = $this->ini_model->loadAccesory($id);
			if ($sql_acsr){
				$txtAccesory = '<ul>';
				foreach ($sql_acsr as $val){
					$txtAccesory .= '<li>- '.$val->descripcion.'</li>';
				}
				$txtAccesory .= '</ul>';
			}else{
				$txtAccesory = 'Sin accesorios';
			}

			$action =
			'<div class="text-center">
				<button type="button" class="btn-primary boton" onClick="addAccesory('.$id.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Accesorios">
					<i class="icon-keyboard"></i>
				</button>
				<button type="button" class="btn-warning boton" onClick="addPiece('.$id.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Repotenciar">
					<i class="icon-desktop"></i>
				</button>
				<button type="button" class="btn-info boton" onClick="addModify('.$id.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Modificar">
					<i class="icon-history"></i>
				</button>
				<button type="button" class="btn-success boton" onClick="addAccess('.$id.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Accesos">
					<i class="icon-lock-open-alt"></i>
				</button>
				<button type="button" class="btn-danger boton" onClick="printComputer('.$id.');" data-toggle="tooltip" data-placement="bottom" data-original-title="Imprimir">
					<i class="icon-print"></i>
				</button>
			</div>';

			$output['data'][] = array($code, $tipo, $mmss, $seri, $proc, $dismode, $ndir, $txtSlot, $txtAccesory, $action);
		}
		
		echo json_encode($output);
	}

	function register(){
		$codes = $_POST['code'];
		$ty_eq = $_POST['type_eq'];
		$marks = $_POST['mark'];
		$model = $_POST['model'];
		$serie = $_POST['serie'];
		$garan = $_POST['garant'];
		$cmark = $_POST['code_mark'];
		$proce = $_POST['process'];
		$nslot = $_POST['slot'];
		$diskh = $_POST['disk'];
		$marke = $_POST['mark_esp'];
		$emode = $_POST['model_esp'];
		$capac = $_POST['capac'];
		$grafi = $_POST['graphic'];
		$sisop = $_POST['sisop'];
		$mac_1 = $_POST['dir_mac1'];
		$mac_2 = $_POST['dir_mac2'];
		$mac_3 = $_POST['dir_mac3'];
		$nroip = $_POST['dir_ip'];
		$aclan = (isset($_POST['lan'])) ? 1 : 0;
		$awifi = (isset($_POST['wifi'])) ? 1 : 0;
		$cslot = $_POST['cant_slot'];
		$sta_act = $_POST['status_act'];
		$obs_act = $_POST['obs_act'];

		$data = array(
		    'codigo'			=> $codes,
		    'id_tipo_equipo'	=> $ty_eq,
		    'id_marca'			=> $marks,
		    'modelo'			=> $model,
		    'serie'				=> $serie,
		    'garantia'			=> $garan,
		    'codigo_marca'		=> $cmark,
		    'id_usuario'		=> $_SESSION['id_okcs'],
		    'estado_actual'		=> $sta_act,
		    'observacion'		=> $obs_act,
		    'estado'			=> 1,
		    'fecha_registro'	=> date('Y-m-d H:i:s')
		);

		$insert = $this->ini_model->registerComputer($data);
		$cont_slot = count($cslot);
		
		if ($insert > 0){
			$dataEspec = array(
			    'id_equipo'		=> $insert,
			    'procesador'	=> $proce,
			    'ram_slot'		=> $nslot,
			    'disco_duro'	=> $diskh,
			    'id_marca'		=> $marke,
			    'modelo'		=> $emode,
			    'capacidad'		=> $capac,
			    'grafico'		=> $grafi,
			    'sis_operativo'	=> $sisop,
			    'mac1'			=> $mac_1,
			    'mac2'			=> $mac_2,
			    'mac3'			=> $mac_3,
			    'ip'			=> $nroip,
			    'lan'			=> $aclan,
			    'wifi'			=> $awifi,
			    'estado'		=> 1
			);
			
			$insertEspec = $this->ini_model->registerEspec($dataEspec);
			if ($insertEspec > 0){
				for ($i = 0; $i < $cont_slot; $i ++){
					$slot_desc = $cslot[$i];
					$dataRam = array(
					    'id_equipo'		=> $insert,
					    'descripcion'	=> $slot_desc,
					    'estado'		=> 1
					);
					$rams = $this->ini_model->registerRam($dataRam);
				}
				$value = 'ok';
				$id = $insert;
			}else{
				$value = 'null_espec';
				$id = 0;
			}
		}else{
			$value = 'null';
			$id = 0;
		}
		$array = array('response' => $value, 'value' => $id);
		echo json_encode($array);
	}

	function register_accesory(){
		$ideq = $_POST['id_equipo_acc'];
		$desc = addslashes($_POST['desc_accessory']);
		$dett = addslashes($_POST['detail_accessory']);
		$status = 1 ;

		$data = array(
			'id_equipo'		=> $ideq,
			'descripcion'	=> $desc,
			'detalle'		=> $dett,
			'estado'		=> 1
		);

		$insert = $this->ini_model->registerAccesory($data);
		
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

	function register_repower(){
		$ideq = $_POST['id_equipo_acc_rpw'];
		$desc = addslashes($_POST['desc_repower']);
		$dett = addslashes($_POST['detail_repower']);
		$auth = addslashes($_POST['autor_repowe']);
		$status = 1 ;

		$data = array(
			'id_equipo'		=> $ideq,
			'tipo_upgrade'	=> 1,
			'pieza_inicial'	=> null,
			'pieza_nueva'	=> $desc,
			'observacion'	=> $dett,
			'autoriza'		=> $auth,
			'estado'		=> 1,
			'fecha_registro'=> date('Y-m-d H:i:s')
		);

		$insert = $this->ini_model->registerPiece($data);
		
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

	function register_modify(){
		$ideq = $_POST['id_equipo_acc_mod'];
		$pza1 = addslashes($_POST['mod_pieza_1']);
		$pza2 = addslashes($_POST['mod_pieza_2']);
		$obsv = addslashes($_POST['mod_obs']);
		$auth = addslashes($_POST['mod_autor']);
		$status = 1 ;

		$data = array(
			'id_equipo'		=> $ideq,
			'tipo_upgrade'	=> 1,
			'pieza_inicial'	=> $pza1,
			'pieza_nueva'	=> $pza2,
			'observacion'	=> $obsv,
			'autoriza'		=> $auth,
			'estado'		=> 1,
			'fecha_registro'=> date('Y-m-d H:i:s')
		);

		$insert = $this->ini_model->registerPiece($data);
		
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

	function register_acceso(){
		$ideq = $_POST['id_equipo_acs'];
		$tipo = addslashes($_POST['access_tpo']);
		$apps = addslashes($_POST['access_app']);
		$usua = addslashes($_POST['access_usu']);
		$pass = addslashes($_POST['access_pas']);
		$dett = addslashes($_POST['access_det']);
		$status = 1 ;

		$data = array(
			'id_equipo'		=> $ideq,
			'tipo'			=> $tipo,
			'aplicacion'	=> $apps,
			'usuario'		=> $usua,
			'clave'			=> $pass,
			'observacion'	=> $dett,
			'estado'		=> 1,
			'fecha_registro'=> date('Y-m-d H:i:s')
		);

		$insert = $this->ini_model->registerAccess($data);
		
		if ($insert > 0){
			$value = 'ok';
			$id = $insert;
			$html = $this->loadDataAccess($ideq, 'return');
		}else{
			$value = 'null';
			$id = 0;
			$html = '<tr><td colspan="4">No se encontraron registros</td></tr>';
		}
		$array = array('response' => $value, 'value' => $id, 'view' => $html);
		echo json_encode($array);
	}

	function loadDataAccess($id, $type){
		$sql = $this->ini_model->loadAccess($id);
		$html = '';

		if ($sql){
			foreach ($sql as $key){
				$html.=
				'<tr>
					<td>'.$key->tipo.'</td>
					<td>'.$key->aplicacion.'</td>
					<td>'.$key->usuario.'</td>
					<td>'.$key->clave.'</td>
				</tr>';
			}
		}else{
			$html.= '<tr><td colspan="4">No se encontraron registros</td></tr>';
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
			ul{
				font-size: 12px;
			}
			ul li.lista{
				list-style-type: square;
			}
			table ul{
				list-style: none;
			}
			table ul li{
				margin-left: -20px;
			}
			h2, h4{
				text-align: center;
			}
			h5{
				margin-bottom: 5px;
			}
        </style>';

        $sql = $this->ini_model->startComputer();
        $html .= '<h2>Ficha Técnica</h2>';

        foreach ($sql as $row){
        	$id = $row->id_equipo;
			$code = $row->codigo;
			$tipo = $row->tipo_equipo;
			$mark = $row->marca;
			$mode = $row->modelo;
			$seri = $row->serie;
			$gara = $row->garantia;
			$proc = $row->procesador;
			$pmod = $row->modelo_proc;
			$capa = $row->capacidad;
			$siso = $row->sis_operativo;
			$graf = $row->grafico;
			$disc = $row->disco_duro;
			$nrip = ($row->ip != null) ? $row->ip : '';
			$nmac1 = ($row->mac1 != null) ? $row->mac1 : '';
			$nmac2 = ($row->mac2 != null) ? $row->mac2 : '';
			$nmac3 = ($row->mac3 != null) ? $row->mac3 : '';
			$cslot = $row->ram_slot;

			$html .=
			'<h4>Equipo N° '.$code.'</h4>
			<br>
			<h5>1. Información del Equipo</h5>
			<table>
				<tbody>
					<tr>
						<th width="120">Tipo</th>
						<td>'.$tipo.'</td>
					</tr>
					<tr>
						<th>Marca / Modelo</th>
						<td>'.$mark.' / '.$mode.'</td>
					</tr>
					<tr>
						<th>N° Serie</th>
						<td>'.$seri.'</td>
					</tr>
					<tr>
						<th>Procesador</th>
						<td>'.$proc.'</td>
					</tr>
					<tr>
						<th>Disco Duro  / Capacidad / Modelo</th>
						<td>'.$disc.' / '.$capa.' / '.$pmod.'</td>
					</tr>
					<tr>
						<th>Sist. Operativo</th>
						<td>'.$siso.'</td>
					</tr>
					<tr>
						<th>Gráficos</th>
						<td>'.$graf.'</td>
					</tr>
					<tr>
						<th>Dirección IP</th>
						<td>'.$nrip.'</td>
					</tr>
					<tr>
						<th>Direcciones MAC</th>
						<td>
							<ul>
								<li>MAC 1: '.$nmac1.'</li>
								<li>MAC 2: '.$nmac2.'</li>
								<li>MAC 3: '.$nmac3.'</li>
							</ul>
						</td>
					</tr>
					<tr>
						<th>Garantía</th>
						<td>'.$gara.'</td>
					</tr>
				</tbody>
			</table>';
        	
        	$sqlA1 = $this->ini_model->loadAccesory($id);
        	$html .= 
        	'<h5>2. Accesorios del Equipo</h5>
        	<ul>';
        	foreach ($sqlA1 as $key1){
        		$html .= '<li class="lista">'.$key1->descripcion.'</li>';
        	}
        	$html .=
        	'</ul>
        	<h5>3. Lista de Accesos</h5>
        	<table>
	        	<thead>
	        		<tr>
		        		<th>Tipo</th>
						<th>Aplicación</th>
						<th>Usuario</th>
						<th>Clave</th>
					</tr>
	        	</thead>
	        	<tbody>'.$this->loadDataAccess($id, 'return').'</tbody>
	        </table>';
        }

	    $this->dompdf->loadHtml($html);
	    $this->dompdf->setPaper('A4', 'portrait');
	    $this->dompdf->render();
	    $this->dompdf->stream("ficha_equipo.pdf", array("Attachment"=>0));
	}
}