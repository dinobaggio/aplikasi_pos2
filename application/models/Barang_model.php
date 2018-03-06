<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model {

    public function get_barang($perPage, $from, $id_barang = false, $katalog = false) {
        if ($id_barang == false) {
            if ($katalog == true){
                $this->db->select('id_barang, nama_barang, harga_jual, stok_barang');
            }
            $this->db->limit($perPage,$from);
            $query = $this->db->get('barang');
            return $query->result();
        } else {
            if($katalog == true) {
                $this->db->select('id_barang, nama_barang, harga_jual, stok_barang');
            }
            $data = array(
                'id_barang' => $id_barang
            );
            $this->db->from('barang');
            $this->db->where($data);
            $query = $this->db->get();
            
            //$query = $this->db->get('barang');
            return $query->row();
        }
    }

    public function jumlah_barang() {
        $query = $this->db->get('barang');
        return $query->num_rows();
    }

}

/* End of file Barang_model.php */
