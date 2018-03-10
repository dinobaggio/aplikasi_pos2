<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function tambah_barang ($ray) {
        $ray['created'] = date("Y-m-j H:i:s");
        
        $this->db->insert('barang', $ray);
        return $this->db->insert_id();
    }

    public function tambah_produsen ($ray) {
        $ray['created'] = date("Y-m-j H:i:s");

        $this->db->insert('produsen', $ray);
        return $this->db->insert_id();
    }

    public function list_produsen($id_produsen = false) {
        if($id_produsen == false ){
            $query = $this->db->get('produsen');
            return $query->result();
        } else {
            $query = $this->db->get_where('produsen', array(
                'id_produsen' => $id_produsen
            ));
            return $query->row();
        }
    }

    public function produsen_barang ($id_produsen) {
        $this->db->select("*");
        $this->db->from("produsen");
        $this->db->join("barang", "produsen.id_produsen = barang.id_produsen");
        $this->db->where(array(
            'barang.id_produsen' => $id_produsen
        ));
        $hasil = $this->db->get();
        return $hasil->result();
    }

}

/* End of file Admin_model.php */
