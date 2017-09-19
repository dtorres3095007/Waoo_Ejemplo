<?php

class Personas_control extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Personas_model');
    }

    public function index() {

        $this->load->view('Templates/Header_Alt');
        $this->load->view("Pages/Personas");
    }

    function Cargar_personas() {
        $personas = array();
        $datos = $this->Personas_model->Listar();

        $i = 1;

        foreach ($datos as $row) {
            //   $row["indice"] = $i;
            $personas["data"][] = $row;
            //   $i++;
        }

        echo json_encode($personas);
    }

    function Cargar_personas_departamento() {
        $id = $this->input->post('id');
        $personas = array();
        $datos = $this->Personas_model->Listar_por_departamento($id);

        $i = 1;

        foreach ($datos as $row) {
            //   $row["indice"] = $i;
            $personas["data"][] = $row;
            //   $i++;
        }

        echo json_encode($personas);
    }

    public function modificar_persona() {
        $id = $this->input->post('id');
        $identificacion = $this->input->post('identificacion');
        $tipo_identificacion = $this->input->post('tipo_identificacion');
        $nombre = $this->input->post('nombre');
        $apellido = $this->input->post('apellido');
        $segundonombre = $this->input->post('segundonombre');
        $segundoapellido = $this->input->post('segundoapellido');
        $celular = $this->input->post('celular');
        $correo = $this->input->post('correo');
        $cargo = $this->input->post('cargo');
        $departamento = $this->input->post('departamento');
        $usuario = $this->input->post('usuario');
        $imagen = $_FILES['imagen']['name'];
        $imageFileType = pathinfo($imagen, PATHINFO_EXTENSION);
        $uploaddir = '../../../ImagenesPersonas/';
        $name = $identificacion . "." . $imageFileType;


        $sw = false;


        if (!empty($imageFileType)) {
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo 5;
            } else {
                $name = $identificacion . "." . $imageFileType;
                $sw = true;
            }
        }
        $s = false;
        $existe = $this->Personas_model->Existe_Identificacion($identificacion);


        if (!empty($existe)) {
            $idexistente = $existe[0];
            if ($idexistente["id"] != $id) {
                echo json_encode(3);
                return false;
            }
        }
        $existe_usuario = $this->Personas_model->Existe_usuario($usuario);
        if (!empty($existe_usuario)) {
            $idexistente_usuario = $existe_usuario[0];
            if ($idexistente_usuario["id"] != $id) {
                echo json_encode(6);
                return false;
            }
        }


        if (ctype_space($nombre) || ctype_space($apellido) || ctype_space($correo) || ctype_space($identificacion) || ctype_space($segundoapellido) || empty($nombre) || empty($apellido) || empty($correo) || empty($identificacion) || empty($segundoapellido)) {
            echo json_encode(1);
        } else {

            $resultado = $this->Personas_model->Modificar_Persona($id, $identificacion, $tipo_identificacion, $nombre, $apellido, $celular, $correo, $imagen, $cargo, $departamento, $segundoapellido, $segundonombre, $usuario);
            /*  if ($sw == true) {
              $uploadfile1 = $uploaddir . basename($name);
              move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadfile1);
              } */
            echo json_encode($resultado);
        }
    }

    public function guardar_persona() {

        $identificacion = $this->input->post('identificacion');
        $tipo_identificacion = $this->input->post('tipo_identificacion');
        $nombre = $this->input->post('nombre');
        $apellido = $this->input->post('apellido');
        $segundonombre = $this->input->post('segundonombre');
        $segundoapellido = $this->input->post('segundoapellido');
        $celular = $this->input->post('celular');
        $correo = $this->input->post('correo');
        $cargo = $this->input->post('cargo');
        $departamento = $this->input->post('departamento');
        $usuario = $this->input->post('usuario');
        $imagen = $_FILES['imagen']['name'];
        $imageFileType = pathinfo($imagen, PATHINFO_EXTENSION);
        $uploaddir = '../../../ImagenesPersonas/';
        $name = $identificacion . "." . $imageFileType;

        $name = "Myfoto.png";
        $sw = false;
        $existe_usuario = $this->Personas_model->Existe_usuario($usuario);
        if (!empty($existe_usuario)) {
            echo json_encode(6);
            return false;
        }

        if (!empty($imageFileType)) {
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo 5;
            } else {
                $name = $identificacion . "." . $imageFileType;
                $sw = true;
            }
        }
        $existe = $this->Personas_model->Existe_Identificacion($identificacion);

        if (!empty($existe)) {
            echo json_encode(3);
        } else {

            if (ctype_space($nombre) || ctype_space($apellido) || ctype_space($correo) || ctype_space($identificacion) || ctype_space($segundoapellido) || empty($nombre) || empty($apellido) || empty($correo) || empty($identificacion) || empty($segundoapellido)) {
                echo json_encode(1);
            } else {

                $resultado = $this->Personas_model->guardar($identificacion, $tipo_identificacion, $nombre, $apellido, $celular, $correo, $name, $cargo, $departamento, $segundoapellido, $segundonombre, $usuario, md5($identificacion));
                /*  if ($sw == true) {
                  $uploadfile1 = $uploaddir . basename($name);
                  move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadfile1);
                  } */
                echo json_encode($resultado);
            }
        }
    }

    public function Eliminar_persona() {
        $id = $this->input->post("idpersona");

        $resultado = $this->Personas_model->Eliminar_Persona($id);

        echo json_encode($resultado);
    }

    function obtener_datos_persona() {
        $id = $this->input->post("id");

        $datos = $this->Personas_model->obtener_Datos_persona($id);
        echo json_encode($datos);
    }
   function obtener_datos_personas_audiovisuales() {

        $datos = $this->Personas_model->Listar_por_departamento_audiovisual();
        echo json_encode($datos);
    }
    function obtener_datos_persona_identificacion() {
        $identificacion = $this->input->post("identificacion");
        $tipoidentificacion = $this->input->post("id_tipo");
        $datos = $this->Personas_model->obtener_Datos_persona_identificacion($identificacion, $tipoidentificacion);
        echo json_encode($datos);
    }

    function obtener_datos_persona_id_completo() {
        $id = $this->input->post("id");

        $datos = $this->Personas_model->obtener_Datos_persona_id_completos($id);
        echo json_encode($datos);
    }

}

?>