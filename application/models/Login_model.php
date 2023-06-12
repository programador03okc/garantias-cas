<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function accessLogin($data){
		$user = trim($data['user']);
		$pass = trim($data['pass']);
		$id = 0;

		$where_usu = array('usuario.nombre' => $user, 'usuario.estado' => 1);
		$where_pas = array('usuario.nombre' => $user, 'usuario.clave' => $pass, 'usuario.estado' => 1);

		$login = $this->db->select('id_usuario')->from('soporte.usuario')->where($where_usu)->get();
		$result = $login->num_rows();

		if ($result > 0){
			$login1 = $this->db->select('id_usuario')->from('soporte.usuario')->where($where_pas)->get();
			$result1 = $login1->num_rows();

			if ($result1 > 0){
				$id = $login->row()->id_usuario;
				$status = 2;
			}else{
				$status = 1;
			}
		}else{
			$status = 0;
		}

		$array = array(0 => $status, 1 => $id);
		return json_encode($array);
	}

	function userData($data){
		$sql = $this->db->select('usuario.empleado, usuario.perfil')
						->from('soporte.usuario')
						->where('usuario.nombre', $data['user'])->limit(1);
		return $sql->get()->result();
	}

	// function changeMoney($fecha){
	// 	$sql = $this->db->get_where('tesoreria.tipo_cambio', array('fecha' => $fecha));
	// 	if ($sql->num_rows() > 0){
	// 		return $sql->row()->id_tipo_cambio;
	// 	}else{
	// 		return 0;
	// 	}
	// }
}