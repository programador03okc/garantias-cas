<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Lima');

class Registro extends CI_Controller{

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
		$this->load->view('registro');
		$this->load->view('footer');
	}

	function header(){
		if (isset($_SESSION['user_okcs'])){
			$user = $this->userName($_SESSION['user_okcs']);
			$userName = $user['nombre'];
			$userProf = $user['perfil'];

			$initial = $this->initialize();
			$empresa = $initial['select_empresa'];
			$categor = $initial['select_categoria'];
			$medios = $initial['select_medios'];
			$tipo_at = $initial['select_tipo_atencion'];
			$modalid = $initial['select_modalidad'];
			$tipo_in = $initial['select_tipo_interv'];
			$depart = $initial['select_departamento'];
			$marcas = $initial['select_marca'];
		}else{
			$userName = '';
			$userProf = '';

			$empresa = '';
			$categor = '';
			$medios = '';
			$tipo_at = '';
			$modalid = '';
			$tipo_in = '';
			$depart = '';
			$marcas = '';
		}

        $val['userName'] = $userName;
        $val['userProf'] = $userProf;

        $val['empresas'] = $empresa;
        $val['categorias'] = $categor;
        $val['medios'] = $medios;
        $val['tipo_atencion'] = $tipo_at;
        $val['modalidad'] = $modalid;
        $val['tipo_interv'] = $tipo_in;
        $val['departamento'] = $depart;
        $val['marcas'] = $marcas;

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

	function encode5t($str){
	  	for($i=0; $i<5;$i++){
	    	$str=strrev(base64_encode($str));
	  	}
	  	return $str;
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

	public function updatePassword(){
		$clave_ini = $this->encode5t(addslashes($_POST['pass_1']));
		$clave_fin = $this->encode5t(addslashes($_POST['pass_2']));
		$data = array('clave' => $clave_fin);
		$user = $_SESSION['id_okcs'];
		
		$sql = $this->ini_model->checkPassword($clave_ini);
		if($sql > 0){
			$update = $this->ini_model->updatePassword($user, $data);
			$val = ($update > 0) ? 'ok'	: 'error';
		}else{
			$val = 'null';
		}
		echo json_encode($val);
	}

	function loadProvince($id){
        $html = '';
        $query = $this->ini_model->loadProvince($id);
        foreach ($query as $key){ $html .= '<option value="'.$key->id_prov.'">'.$key->descripcion.'</option>'; }
        echo json_encode($html);
    }

    function loadDistrict($id){
        $html = '';
        $query = $this->ini_model->loadDistrict($id);
        foreach ($query as $key){ $html .= '<option value="'.$key->id_dist.'">'.$key->descripcion.'</option>'; }
        echo json_encode($html);
    }

    function loadCustomer(){
		$value = strtoupper($_GET['term']);
		$data = array();
		$sql = $this->ini_model->loadDataCustomer($value);

		foreach ($sql as $row){ $data[] = array('value' => $row->nombre, 'id' => $row->id_cliente, 'name' => $row->nombre); }
		echo json_encode($data);
    }

    function registerRequest(){
		$id_empa = $_POST['id_empresa'];
		$id_cate = $_POST['id_categoria'];
		$product = $_POST['producto'];
		$id_mark = $_POST['id_marca'];
		$modelop = $_POST['model_producto'];
		$fec_sol = $_POST['fecha_sol'];

    	$id_clie = $_POST['id_cliente'];
		$cliente = $_POST['cliente'];
		$ctc_med = $_POST['cont_medio'];
		$ctc_rep = $_POST['cont_reporta'];
		$tlf_rep = $_POST['tlf_reporta'];
		$ema_rep = $_POST['mail_reporta'];
		$ctc_key = $_POST['cont_princ'];
		$tlf_key = $_POST['tlf_princ'];
		$ema_key = $_POST['mail_princ'];
		
		$departm = $_POST['depart'];
		$provinc = $_POST['provin'];
		$distrit = $_POST['dist'];
		$address = $_POST['direccion'];

		$problem = $_POST['problema'];
		$fec_rec = $_POST['fecha_rec'];
		$tpo_ate = $_POST['aten_tipo'];
		$fec_ate = ($_POST['aten_fecha'] != '') ? $_POST['aten_fecha'] : null;
		$pls_ate = $_POST['aten_plazo'];
		$fec_cie = ($_POST['fecha_cie'] != '') ? $_POST['fecha_cie'] : null;

		$modalid = $_POST['modalidad'];
		$factura = ($_POST['factura'] != '') ? $_POST['factura'] : null;
		$ord_com = ($_POST['orden_cc'] != '') ? $_POST['orden_cc'] : null;
		$cc_cost = ($_POST['cuadro_cc'] != '') ? $_POST['cuadro_cc'] : null;
		$interve = $_POST['tipo_interv'];

		$today = date('Y-m-d H:i:s');

		if ($id_clie == 0){
			$arrayClient = array(
				'nombre'			=> $cliente,
				'estado'			=> 1,
				'fecha_registro'	=> $today
			);

			$insertCus = $this->ini_model->registerCustomer($arrayClient);

			if ($insertCus > 0){
				$customer = $insertCus;
				$val_cli = 1;
			}else{
				$val_cli = 0;
			}
		}else{
			$customer = $id_clie;
			$val_cli = 1;
		}

		if ($val_cli > 0){
			$arrayContact = array(
				'id_cliente' 			=> $customer,
				'id_medio'				=> $ctc_med,
				'contacto_reporta'		=> $ctc_rep,
				'correo_reporta'		=> $ema_rep,
				'telefono_reporta'		=> $tlf_rep,
				'contacto_principal'	=> $ctc_key,
				'correo_principal'		=> $ema_key,
				'telefono_principal'	=> $tlf_key,
				'estado'				=> 1,
				'fecha_registro'		=> $today
			);

			$insertCtc = $this->ini_model->registerContact($arrayContact);

			if ($insertCtc > 0) {
				$codigo = $this->generateCode();
				$arraySolicitud = array(
					'codigo' 			=> $codigo,
					'id_empresa' 		=> $id_empa,
					'id_categoria' 		=> $id_cate,
					'id_marca' 			=> $id_mark,
					'modelo' 			=> $modelop,
					'producto' 			=> $product,
					'fecha_solicitud' 	=> $fec_sol,
					'id_contacto' 		=> $insertCtc,
					'descripcion' 		=> $problem,
					'fecha_recepcion' 	=> $fec_rec,
					'id_tipo_atencion' 	=> $tpo_ate,
					'fecha_atencion' 	=> $fec_ate,
					'plazo_atencion' 	=> $pls_ate,
					'fecha_cierre' 		=> $fec_cie,
					'estado' 			=> 1,
					'estado_solicitud' 	=> 1,
					'id_usuario' 		=> $_SESSION['id_okcs'],
					'fecha_registro' 	=> $today,
					'periodo'			=> date('Y')
				);

				$insertSol = $this->ini_model->registerSolicitud($arraySolicitud);

				if ($insertSol > 0){
					$arrayExtra = array(
						'id_solicitud'			=> $insertSol,
						'id_modalidad'			=> $modalid,
						'factura'				=> $factura,
						'orden_compra'			=> $ord_com,
						'cuadro_costo'			=> $cc_cost,
						'id_tipo_intervencion'	=> $interve,
						'estado' 				=> 1,
						'fecha_registro' 		=> $today
					);

					$insertExt = $this->ini_model->registerSolicitudExtra($arrayExtra);

					if ($insertExt > 0){
						$arrayUbic = array(
							'id_solicitud'		=> $insertSol,
							'id_dpto'			=> $departm,
							'id_prov'			=> $provinc,
							'id_dist'			=> $distrit,
							'direccion'			=> $address,
							'estado' 			=> 1,
							'fecha_registro'	=> $today
						);

						$arrayHist = array(
							'id_solicitud'		=> $insertSol,
							'comentario'		=> 'Nueva solicitud',
							'status'			=> 1,
							'fecha'				=> date('Y-m-d'),
							'id_usuario'		=> $_SESSION['id_okcs'],
							'estado' 			=> 1,
							'fecha_registro'	=> $today
						);

						$this->ini_model->registerAddress($arrayUbic);
						$this->ini_model->registerHistory($arrayHist);
						$rpta = 'ok';
					}else{
						$rpta = 'no_extra';
					}
				}else{
					$rpta = 'no_solicitud';
				}
			}else{
				$rpta = 'no_contacto';
			}
		}else{
			$rpta = 'no_cliente';
		}

    	echo json_encode($rpta);
    }

    function loadInfo($soli, $contac){
    	$direc = $this->ini_model->loadDataUbication($soli);
    	$dataC = $this->ini_model->loadDataContact($contac);
    	$extra = $this->ini_model->loadDataExtraRequest($soli);
    	$problema = $this->ini_model->loadDataRequest($soli);
    	$dts_rpor = $dataC['dts_rpor'];
    	$mai_rpor = $dataC['mai_rpor'];
    	$tlf_rpor = $dataC['tlf_rpor'];
    	$dts_prin = $dataC['dts_prin'];
    	$mai_prin = $dataC['mai_prin'];
    	$tlf_prin = $dataC['tlf_prin'];
    	$ext_nocc = $extra['oc'];
    	$ext_ncco = $extra['cc'];
    	$ext_tint = $extra['ti'];

    	$rpta = array('dts_rpor' => $dts_rpor, 'mai_rpor' => $mai_rpor, 'tlf_rpor' => $tlf_rpor,
					  'dts_prin' => $dts_prin, 'mai_prin' => $mai_prin, 'tlf_prin' => $tlf_prin,
					  'direc' => $direc, 'des_prob' => $problema, 'ord_comp' => $ext_nocc, 
					  'num_ccoo' => $ext_ncco, 'tipo_int' => $ext_tint);
    	echo json_encode($rpta);
    }

    function editionAction(){
		$id_soli = $_POST['id_solicit'];
		$id_cont = $_POST['id_contac'];
		$ctc_rep = $_POST['cont_reporta'];
		$tlf_rep = $_POST['tlf_reporta'];
		$ema_rep = $_POST['mail_reporta'];
		$ctc_key = $_POST['cont_princ'];
		$tlf_key = $_POST['tlf_princ'];
		$ema_key = $_POST['mail_princ'];
		$address = $_POST['direccion'];
		$problem = $_POST['problema'];
		$ordencc = $_POST['orden_cc'];
		$cuadroc = $_POST['cuadro_cc'];
		$interve = $_POST['tipo_interv'];

		$arraySoli = array('descripcion' => $problem);

		$arrayExt = array('orden_compra' => $ordencc, 'cuadro_costo' => $cuadroc, 'id_tipo_intervencion' => $interve);

		$arrayContact = array(
			'contacto_reporta'		=> $ctc_rep,
			'correo_reporta'		=> $ema_rep,
			'telefono_reporta'		=> $tlf_rep,
			'contacto_principal'	=> $ctc_key,
			'correo_principal'		=> $ema_key,
			'telefono_principal'	=> $tlf_key
		);

		$updateSol = $this->ini_model->updateRequest($id_soli, $arraySoli);
		if ($updateSol > 0) {
			$updateExta = $this->ini_model->updateExtraRequest($id_soli, $arrayExt);
			if ($updateExta > 0) {
				$updateCtc = $this->ini_model->updateContact($id_cont ,$arrayContact);
				if ($updateCtc > 0){
					$arrayUbic = array('direccion' => $address);
					$updateUbic = $this->ini_model->updateUbication($id_soli ,$arrayUbic);
					if ($updateUbic > 0){
						$rpta = 'ok';
					}else{
						$rpta = 'null_dir';
					}
				}else{
					$rpta = 'null_contact';
				}
			} else{
				$rpta = 'null_extra';
			}
		} else {
			$rpta = 'null';
		}
		echo json_encode($rpta);
    }

    function registerAction(){
    	$solici = $_POST['id_solicitud'];
		$status = $_POST['status'];
		$date_h = $_POST['fecha_hist'];
		$coment = $_POST['comentario'];
		$codeat = $_POST['codigo_aten'];
		$today = date('Y-m-d H:i:s');

    	$arrayHist = array(
			'id_solicitud'		=> $solici,
			'comentario'		=> $coment,
			'codigo_caso'		=> $codeat,
			'status'			=> $status,
			'fecha'				=> $date_h,
			'id_usuario'		=> $_SESSION['id_okcs'],
			'estado' 			=> 1,
			'fecha_registro'	=> $today
		);
		
		$insert = $this->ini_model->registerHistory($arrayHist);
		if ($insert > 0){
			$rpta = 'ok';
			$detail = array('estado_solicitud' => $status);
			$this->ini_model->updateState($solici, $detail);
		}else{
			$rpta = 'null';
		}

		echo json_encode($rpta);
    }

    function generateCode(){
    	$anios = date('Y');
    	$perio = substr($anios, -2);
    	$tnume = $this->ini_model->totalRequest($anios);
    	$nnume = $tnume + 1;
    	$serie = $this->leftZero(4, $nnume);
    	$codigo = 'INC-'.$perio.'.'.$serie;
    	return $codigo;
    }
}