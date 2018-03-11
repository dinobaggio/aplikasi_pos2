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
        $this->db->select("
        barang.id_barang, 
        barang.nama_barang, 
        barang.stok_barang,
        barang.harga_jual,
        barang.harga_beli,
        produsen.id_produsen
        ");
        $this->db->from("produsen");
        $this->db->join("barang", "produsen.id_produsen = barang.id_produsen");
        $this->db->where(array(
            'barang.id_produsen' => $id_produsen
        ));
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function list_value_produsen () {
        $this->db->select('id_produsen, nama_produsen');
        $this->db->from('produsen');
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function cek_id_produsen($id_produsen) {
        if(empty($id_produsen)) {
            return false;
        } else {
            return true;
        }
    }

    public function get_barang($data) {
        $id_barang = $data['id_barang'];
        $id_produsen = $data['id_produsen'];
        if ($id_barang != false) {
            $this->db->select("
            id_barang,
            nama_barang,
            stok_barang,
            harga_beli,
            harga_jual");
            $this->db->from('barang');
            $this->db->where(array(
                'id_barang' => $id_barang,
                'id_produsen' => $id_produsen
            ));
            $tugas = $this->db->get();
            return $tugas->row();
        }
    }

}

/* End of file Admin_model.php */
