<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ini_model extends CI_Model{

	public $user;

	function __construct(){
		parent::__construct();
		$this->load->database();
		if (isset($_SESSION['user_okcs'])) {
			$this->user = $_SESSION['user_okcs'];
		}
	}

	function startRequest($type){
		if ($type == 1) {
			$where = array('sol.estado' => 1, 'sol.estado_solicitud <' => 3);
		}else{
			$where = array('sol.estado' => 1, 'sol.estado_solicitud' => 3);
		}
		$sql = $this->db->select('sol.*, mar.descripcion AS marca, emp.nombre AS empresa, cli.nombre AS cliente,
								  tat.descripcion AS tipo_atencion, ctc.contacto_reporta AS contacto_1, dpt.descripcion AS departamento,
								  pvc.descripcion AS provincia, dis.descripcion AS distrito, uso.direccion, exs.factura, exs.orden_compra,
								  exs.cuadro_costo, mdd.descripcion AS modalidad, mdd.abrev AS abrev_mod')
						->from('soporte.solicitud sol')

						->join('soporte.empresa emp', 'emp.id_empresa = sol.id_empresa')
						->join('soporte.marca mar', 'mar.id_marca = sol.id_marca')
						->join('soporte.tipo_atencion tat', 'tat.id_tipo_atencion = sol.id_tipo_atencion')
						->join('soporte.contacto ctc', 'ctc.id_contacto = sol.id_contacto')
						->join('soporte.cliente cli', 'cli.id_cliente = ctc.id_cliente')

						->join('soporte.ubicacion_solicitud uso', 'uso.id_solicitud = sol.id_solicitud')
						->join('soporte.departamento dpt', 'dpt.id_dpto = uso.id_dpto')
						->join('soporte.provincia pvc', 'pvc.id_prov = uso.id_prov')
						->join('soporte.distrito dis', 'dis.id_dist = uso.id_dist')

						->join('soporte.extra_solicitud exs', 'exs.id_solicitud = sol.id_solicitud')
						->join('soporte.modalidad mdd', 'mdd.id_modalidad = exs.id_modalidad')
						->join('soporte.tipo_intervencion tin', 'tin.id_tipo_intervencion = exs.id_tipo_intervencion')
						->where($where)
						->order_by('sol.codigo', 'DESC')->get();
		return $sql->result();
	}

	function startMark(){
		$sql = $this->db->order_by('descripcion', 'ASC')->get_where('soporte.marca', array('estado' => 1));
		return $sql->result();
	}

	function startCategory(){
		$sql = $this->db->order_by('descripcion', 'ASC')->get_where('soporte.categoria', array('estado' => 1));
		return $sql->result();
	}

	function startType(){
		$sql = $this->db->order_by('descripcion', 'ASC')->get_where('soporte.tipo_equipo', array('estado' => 1));
		return $sql->result();
	}

	function startComputer(){
		$where = array('equi.estado' => 1);
		$sql = $this->db->select('equi.*, mar.descripcion AS marca, teq.descripcion AS tipo_equipo, espe.procesador, espe.disco_duro,
								  espe.capacidad, espe.sis_operativo, espe.grafico, espe.ip,
								  espe.mac1, espe.mac2, espe.mac3, espe.ram_slot, espe.modelo AS modelo_proc')
						->from('soporte.equipo equi')
						->join('soporte.especificacion espe', 'espe.id_equipo = equi.id_equipo', 'left')
						->join('soporte.equipo_accesorio acce', 'acce.id_equipo = equi.id_equipo', 'left')
						->join('soporte.marca mar', 'mar.id_marca = equi.id_marca')
						->join('soporte.tipo_equipo teq', 'teq.id_tipo_equipo = equi.id_tipo_equipo')
						->where($where)
						->order_by('equi.codigo', 'DESC')->get();
		return $sql->result();
	}

	function detailRequest($id){
		$where = array('sol.id_solicitud' => $id);
		$sql = $this->db->select('sol.*, emp.nombre AS empresa, cli.nombre AS cliente, tat.descripcion AS tipo_atencion,
								  ctc.contacto_reporta AS contacto_1, dpt.descripcion AS departamento, pvc.descripcion AS provincia, 
								  dis.descripcion AS distrito, uso.direccion, exs.factura, exs.orden_compra, exs.cuadro_costo,
								  mdd.descripcion AS modalidad, mdd.abrev AS abrev_mod')
						->from('soporte.solicitud sol')
						->join('soporte.empresa emp', 'emp.id_empresa = sol.id_empresa')
						->join('soporte.tipo_atencion tat', 'tat.id_tipo_atencion = sol.id_tipo_atencion')
						->join('soporte.contacto ctc', 'ctc.id_contacto = sol.id_contacto')
						->join('soporte.cliente cli', 'cli.id_cliente = ctc.id_cliente')

						->join('soporte.ubicacion_solicitud uso', 'uso.id_solicitud = sol.id_solicitud')
						->join('soporte.departamento dpt', 'dpt.id_dpto = uso.id_dpto')
						->join('soporte.provincia pvc', 'pvc.id_prov = uso.id_prov')
						->join('soporte.distrito dis', 'dis.id_dist = uso.id_dist')

						->join('soporte.extra_solicitud exs', 'exs.id_solicitud = sol.id_solicitud')
						->join('soporte.modalidad mdd', 'mdd.id_modalidad = exs.id_modalidad')
						->join('soporte.tipo_intervencion tin', 'tin.id_tipo_intervencion = exs.id_tipo_intervencion')
						->where($where)
						->order_by('sol.fecha_recepcion', 'DESC')->get();
		return $sql->result();
	}

	function detailHistoryRequest($id){
		$where = array('sol.id_solicitud' => $id);
		$sql = $this->db->select('sol.*, usu.empleado AS usuario')
						->from('soporte.historial_solicitud sol')
						->join('soporte.usuario usu', 'usu.id_usuario = sol.id_usuario')
						->where($where)
						->order_by('sol.fecha_registro', 'DESC')->get();
		return $sql->result();
	}

	function checkPassword($pass){
		$sql = $this->db->get_where('soporte.usuario', array('clave' => $pass, 'nombre' => $this->user));
		return $sql->num_rows();
	}

	function updatePassword($id, $data){
		$this->db->where('id_usuario', $id);
		$this->db->update('soporte.usuario', $data);

		$update = $this->db->affected_rows();
		if ($update){
    		return 1;
		}else{
			return 0;
		}
	}

	function loadCompanys(){
		$sql = $this->db->order_by('nombre', 'ASC')->get_where('soporte.empresa', array('estado' => 1));
		return $sql->result();
	}

	function loadCategorys(){
		$sql = $this->db->order_by('descripcion', 'ASC')->get_where('soporte.categoria', array('estado' => 1));
		return $sql->result();
	}

	function loadMedium(){
		$sql = $this->db->order_by('descripcion', 'ASC')->get_where('soporte.medio', array('estado' => 1));
		return $sql->result();
	}

	function loadTypeAtention(){
		$sql = $this->db->order_by('descripcion', 'ASC')->get_where('soporte.tipo_atencion', array('estado' => 1));
		return $sql->result();
	}

	function loadModality(){
		$sql = $this->db->order_by('descripcion', 'ASC')->get_where('soporte.modalidad', array('estado' => 1));
		return $sql->result();
	}

	function loadTypeIntervention(){
		$sql = $this->db->order_by('descripcion', 'ASC')->get_where('soporte.tipo_intervencion', array('estado' => 1));
		return $sql->result();
	}

	function loadDepartment(){
		$sql = $this->db->order_by('descripcion', 'ASC')->get_where('soporte.departamento', array('estado' => 1));
		return $sql->result();
	}

	function loadMarca(){
		$sql = $this->db->order_by('descripcion', 'ASC')->get_where('soporte.marca', array('estado' => 1));
		return $sql->result();
	}

	function loadTipoEquipo(){
		$sql = $this->db->order_by('descripcion', 'ASC')->get_where('soporte.tipo_equipo', array('estado' => 1));
		return $sql->result();
	}

	function loadProvince($dpto){
		$sql = $this->db->order_by('descripcion', 'ASC')->get_where('soporte.provincia', array('id_dpto' => $dpto, 'estado' => 1));
		return $sql->result();
	}

	function loadDistrict($prov){
		$sql = $this->db->order_by('descripcion', 'ASC')->get_where('soporte.distrito', array('id_prov' => $prov, 'estado' => 1));
		return $sql->result();
	}

	function loadDataCustomer($value){
		$sql = $this->db->where('estado', 1)
						->group_start()
							->like('nombre', $value, 'both')
						->group_end()
						->limit(10)->get('soporte.cliente');
		return $sql->result();
	}

	function registerCustomer($data){
		$insert = $this->db->insert('soporte.cliente', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}

	function registerContact($data){
		$insert = $this->db->insert('soporte.contacto', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}

	function registerSolicitud($data){
		$insert = $this->db->insert('soporte.solicitud', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}

	function registerAddress($data){
		$insert = $this->db->insert('soporte.ubicacion_solicitud', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}

	function registerSolicitudExtra($data){
		$insert = $this->db->insert('soporte.extra_solicitud', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}

	function registerHistory($data){
		$insert = $this->db->insert('soporte.historial_solicitud', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}

	function registerComputer($data){
		$insert = $this->db->insert('soporte.equipo', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}

	function registerEspec($data){
		$insert = $this->db->insert('soporte.especificacion', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}

	function registerRam($data){
		$insert = $this->db->insert('soporte.memorias_slot', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}

	function registerAccesory($data){
		$insert = $this->db->insert('soporte.equipo_accesorio', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}

	function registerPiece($data){
		$insert = $this->db->insert('soporte.equipo_upgrade', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}

	function registerAccess($data){
		$insert = $this->db->insert('soporte.equipo_acceso', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}

	function registerAsign($data){
		$insert = $this->db->insert('soporte.equipo_asignacion', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}

	function updateRequest($id, $data){
		$this->db->where('id_solicitud', $id);
		$this->db->update('soporte.solicitud', $data);

		$update = $this->db->affected_rows();
		if ($update){
    		return 1;
		}else{
			return 0;
		}
	}

	function updateExtraRequest($id, $data){
		$this->db->where('id_solicitud', $id);
		$this->db->update('soporte.extra_solicitud', $data);

		$update = $this->db->affected_rows();
		if ($update){
    		return 1;
		}else{
			return 0;
		}
	}

	function updateContact($id, $data){
		$this->db->where('id_contacto', $id);
		$this->db->update('soporte.contacto', $data);

		$update = $this->db->affected_rows();
		if ($update){
    		return 1;
		}else{
			return 0;
		}
	}

	function updateUbication($id, $data){
		$this->db->where('id_ubicacion', $id);
		$this->db->update('soporte.ubicacion_solicitud', $data);

		$update = $this->db->affected_rows();
		if ($update){
    		return 1;
		}else{
			return 0;
		}
	}

	function updateState($id, $data){
		$this->db->where('id_solicitud', $id);
		$this->db->update('soporte.solicitud', $data);

		$update = $this->db->affected_rows();
		if ($update){
    		return 1;
		}else{
			return 0;
		}
	}

	function totalRequest($anio){
		$sql = $this->db->get_where('soporte.solicitud', array('estado' => 1, 'periodo' => $anio));
		return $sql->num_rows();
	}

	function loadDataRequest($id){
		$sql = $this->db->limit(1)->get_where('soporte.solicitud', array('id_solicitud' => $id));
		$value = ($sql->num_rows() > 0) ? $sql->row()->descripcion : '';
		return $value;
	}

	function loadDataExtraRequest($id){
		$oc = '';
		$cc = '';
		$ti = '';
		$sql = $this->db->limit(1)->get_where('soporte.extra_solicitud', array('id_solicitud' => $id));
		if ($sql->num_rows() > 0){
			$oc = $sql->row()->orden_compra;
			$cc = $sql->row()->cuadro_costo;
			$ti = $sql->row()->id_tipo_intervencion;
		}
		$arrayName = array('oc' => $oc, 'cc' => $cc, 'ti' => $ti);
		return $arrayName;
	}

	function loadDataUbication($id){
		$sql = $this->db->limit(1)->get_where('soporte.ubicacion_solicitud', array('id_solicitud' => $id));
		$value = ($sql->num_rows() > 0) ? $sql->row()->direccion : '';
		return $value;
	}

	function loadDataContact($id){
		$dts_rpor = '';
		$mai_rpor = '';
		$tlf_rpor = '';
		$dts_prin = '';
		$mai_prin = '';
		$tlf_prin = '';
		$sql = $this->db->limit(1)->get_where('soporte.contacto', array('id_contacto' => $id));
		if ($sql->num_rows() > 0){
			$dts_rpor = $sql->row()->contacto_reporta;
			$mai_rpor = $sql->row()->correo_reporta;
			$tlf_rpor = $sql->row()->telefono_reporta;
			$dts_prin = $sql->row()->contacto_principal;
			$mai_prin = $sql->row()->correo_principal;
			$tlf_prin = $sql->row()->telefono_principal;
		}
		$arrayName = array('dts_rpor' => $dts_rpor, 'mai_rpor' => $mai_rpor, 'tlf_rpor' => $tlf_rpor,
						   'dts_prin' => $dts_prin, 'mai_prin' => $mai_prin, 'tlf_prin' => $tlf_prin);
		return $arrayName;
	}

	/***************/

	function registerMark($data){
		$insert = $this->db->insert('soporte.marca', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}
	function loadDataMark($id){
		$sql = $this->db->get_where('soporte.marca', array('id_marca' => $id));
		return $sql->result();
	}
	function updateMark($id, $data){
		$this->db->where('id_marca', $id);
		$this->db->update('soporte.marca', $data);

		$update = $this->db->affected_rows();
		if ($update){
    		return 1;
		}else{
			return 0;
		}
	}
	function deleteMark($id){
        $this->db->set('estado', 0)->where('id_marca', $id)->update('soporte.marca');

        $update = $this->db->affected_rows();
        if ($update){
            return 1;
        }else{
            return 0;
        }
    }

	function registerCategory($data){
		$insert = $this->db->insert('soporte.categoria', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}
	function loadDataCategory($id){
		$sql = $this->db->get_where('soporte.categoria', array('id_categoria' => $id));
		return $sql->result();
	}
	function updateCategory($id, $data){
		$this->db->where('id_categoria', $id);
		$this->db->update('soporte.categoria', $data);

		$update = $this->db->affected_rows();
		if ($update){
    		return 1;
		}else{
			return 0;
		}
	}
	function deleteCategory($id){
        $this->db->set('estado', 0)->where('id_categoria', $id)->update('soporte.categoria');

        $update = $this->db->affected_rows();
        if ($update){
            return 1;
        }else{
            return 0;
        }
    }

    function registerTypes($data){
		$insert = $this->db->insert('soporte.tipo_equipo', $data);

		if ($insert){
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}
	function loadDataTypes($id){
		$sql = $this->db->get_where('soporte.tipo_equipo', array('id_tipo_equipo' => $id));
		return $sql->result();
	}
	function updateTypes($id, $data){
		$this->db->where('id_tipo_equipo', $id);
		$this->db->update('soporte.tipo_equipo', $data);

		$update = $this->db->affected_rows();
		if ($update){
    		return 1;
		}else{
			return 0;
		}
	}
	function deleteTypes($id){
        $this->db->set('estado', 0)->where('id_categoria', $id)->update('soporte.tipo_equipo');

        $update = $this->db->affected_rows();
        if ($update){
            return 1;
        }else{
            return 0;
        }
    }

	function loadSlots($id){
		$sql = $this->db->get_where('soporte.memorias_slot', array('id_equipo' => $id, 'estado' => 1));
		return $sql->result();
	}
	function loadAccesory($id){
		$sql = $this->db->get_where('soporte.equipo_accesorio', array('id_equipo' => $id, 'estado' => 1));
		return $sql->result();
	}
	function loadAccess($id){
		$sql = $this->db->get_where('soporte.equipo_acceso', array('id_equipo' => $id, 'estado' => 1));
		return $sql->result();
	}

	function searchEquip($value){
		$sql = $this->db->get_where('soporte.equipo', array('codigo' => $value));
		if ($sql->num_rows() > 0){
			return $sql->row()->id_equipo;
		}else{
			return 0;
		}
	}

	function loadAsignacion($id){
		$sql = $this->db->get_where('soporte.equipo_asignacion', array('id_equipo' => $id, 'estado' => 1));
		return $sql->result();
	}

	function loadDataUser($id){
		$sql = $this->db->get_where('soporte.usuario', array('id_usuario' => $id));
		if ($sql->num_rows() > 0){
			return $sql->row()->empleado;
		}else{
			return '';
		}
	}

	function deleteSolicitud($id)
	{
		$this->db->set('estado', 0)->where('id_solicitud', $id)->update('soporte.solicitud');

        $update = $this->db->affected_rows();
        if ($update){
            return 1;
        }else{
            return 0;
        }
	}
}