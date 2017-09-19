
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Personas_model extends CI_Model {

    var $table_persona = "personas";
    var $select_column = array("id", "nombre", "segundo_nombre", "apellido", "segundo_apellido", "id_departamento", "identificacion", "correo", "telefono", "id_tipo_identificacion", "id_cargo", "foto", "usuario");

    public function make_query() {
        $this->db->select($this->select_column);
        $this->db->from($this->table_persona);
    }

    public function Listar() {
        $this->make_query();
        $this->db->where('estado', "1");
        $query = $this->db->get();
        return $query->result();
    }

    public function Listar_por_departamento($id) {
        $this->make_query();
        $this->db->where('estado', "1");
        $this->db->where('id_departamento', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
     public function Listar_por_departamento_audiovisual() {
        $this->db->select("p.id,p.nombre,p.apellido,p.segundo_apellido");
        $this->db->from("personas p");
        $this->db->join('valor_parametro u', 'p.id_cargo=u.id');
        $this->db->where('p.estado', "1");
        $this->db->where('u.id_aux', "aux_aud");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function obtener_Datos_persona($id) {
        $this->make_query();
        $this->db->where('estado', "1");
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function obtener_Datos_persona_identificacion($identificacion, $tipoidentificacion) {
        $this->db->select("u2.valor id_tipo_identificacion,u.valor id_cargo,u1.valor id_departamento,u1.valorx ubicacion,p.nombre,p.apellido,p.segundo_nombre,p.segundo_apellido,p.identificacion,p.telefono,p.correo,p.foto,p.id");
        $this->db->from('personas p');
        $this->db->join('valor_parametro u', 'p.id_cargo=u.id');
        $this->db->join('valor_parametro u1', 'p.id_departamento=u1.id');
        $this->db->join('valor_parametro u2', 'p.id_tipo_identificacion=u2.id');
        $this->db->where('p.estado', "1");
        $this->db->where('p.identificacion', $identificacion);
        $this->db->where('p.id_tipo_identificacion', $tipoidentificacion);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function obtener_Datos_persona_id_completos($id) {
        $this->db->select("u2.valor id_tipo_identificacion,u.valor id_cargo,u1.valor id_departamento,u1.valorx ubicacion,p.nombre,p.apellido,p.segundo_nombre,p.segundo_apellido,p.identificacion,p.telefono,p.correo,p.foto,p.id,p.usuario");
        $this->db->from('personas p');
        $this->db->join('valor_parametro u', 'p.id_cargo=u.id');
        $this->db->join('valor_parametro u1', 'p.id_departamento=u1.id');
        $this->db->join('valor_parametro u2', 'p.id_tipo_identificacion=u2.id');
        $this->db->where('p.estado', "1");
        $this->db->where('p.id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function guardar($identificacion, $tipo_identificacion, $nombre, $apellido, $celular, $correo, $imagen, $cargo, $departamento, $segundoapellido, $segundonombre, $usuario, $contrasena) {

        $this->db->insert($this->table_persona, array(
            "identificacion" => $identificacion,
            "nombre" => $nombre,
            "segundo_nombre" => $segundonombre,
            "apellido" => $apellido,
            "segundo_apellido" => $segundoapellido,
            "id_departamento" => $departamento,
            "correo" => $correo,
            "telefono" => $celular,
            "id_tipo_identificacion" => $tipo_identificacion,
            "id_cargo" => $cargo,
            "foto" => $imagen,
            "usuario" => $usuario,
            "contrasena" => $contrasena,
        ));

        return 4;
    }

    public function Existe_Identificacion($identificacion) {
        $this->make_query();
        $this->db->where('estado', "1");
        $this->db->where('identificacion', $identificacion);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function Existe_usuario($usuario) {
        $this->make_query();
        $this->db->where('estado', "1");
        $this->db->where('usuario', $usuario);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function Eliminar_Persona($id) {

        $this->db->set('estado', '0');
        $this->db->where('id', $id);
        $this->db->update($this->table_persona);
        return 1;
    }
    
       public function existe_Persona_id($id) {

        $this->make_query();
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function Modificar_Persona($id, $identificacion, $tipo_identificacion, $nombre, $apellido, $celular, $correo, $imagen, $cargo, $departamento, $segundoapellido, $segundonombre, $usuario) {
        if (!empty($imagen)) {
            $this->db->set('foto', $imagen);
        }
        $this->db->set('usuario', $usuario);
        $this->db->set('identificacion', $identificacion);
        $this->db->set('nombre', $nombre);
        $this->db->set('segundo_nombre', $segundonombre);
        $this->db->set('apellido', $apellido);
        $this->db->set('segundo_apellido', $segundoapellido);
        $this->db->set('id_departamento', $departamento);
        $this->db->set('correo', $correo);
        $this->db->set('telefono', $celular);
        $this->db->set('id_tipo_identificacion', $tipo_identificacion);
        $this->db->set('id_cargo', $cargo);

        $this->db->where('id', $id);
        $this->db->update($this->table_persona);
        return 4;
    }

    public function Listar_usuario_contrasena($usuario, $contrasena) {
        $this->db->select("u2.valor id_tipo_identificacion,u.valor id_cargo,u1.valor id_departamento,u1.valorx ubicacion,p.nombre,p.apellido,p.segundo_nombre,p.segundo_apellido,p.identificacion,p.telefono,p.correo,p.foto,p.id,p.usuario");
        $this->db->from('personas p');
        $this->db->join('valor_parametro u', 'p.id_cargo=u.id');
        $this->db->join('valor_parametro u1', 'p.id_departamento=u1.id');
        $this->db->join('valor_parametro u2', 'p.id_tipo_identificacion=u2.id');
        $this->db->where('p.estado', "1");
        $this->db->where('p.usuario', $usuario);
        $this->db->where('p.contrasena', $contrasena);
        $query = $this->db->get();
        return $query->result_array();
    }

}
