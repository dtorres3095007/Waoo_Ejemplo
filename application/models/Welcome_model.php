
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome_model extends CI_Model {

    public function Listar() {
        $this->db->select("*");
        $this->db->from("lista");
        $query = $this->db->get();
        return $query->result();
    }

}
