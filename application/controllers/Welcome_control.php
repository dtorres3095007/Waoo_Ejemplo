<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome_control extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Welcome_model');
    }
     
    public function index() {

        $this->load->view('Pages/Welcome_vista');
    }

    function Listar() {
       
        $tareas = $this->Welcome_model->Listar();
        echo json_encode($tareas);
    }

}
