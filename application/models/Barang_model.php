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

    public function insert_transaksi_penjualan ($data_transaksi) {

        $data = array(
            'id_user' => $data_transaksi->id_user,
            'total_barang' => $data_transaksi->total_barang,
            'total_harga' => $data_transaksi->total_harga,
            'created' =>  date('Y-m-j H:i:s')
        );

        $this->db->insert('transaksi_penjualan', $data);

        return $this->db->insert_id();

    }

    public function insert_penjualan($data_barang, $id_transaksi_penjualan) {
        for ($i=0;$i<count($data_barang);$i++) {
            $data = array(
                'id_transaksi_penjualan' => $id_transaksi_penjualan,
                'id_barang' => $data_barang[$i]->id_barang,
                'jumlah_barang' => $data_barang[$i]->jumlah_barang,
                'jumlah_harga' => $data_barang[$i]->jumlah_harga,
                'created' => date("Y-m-j H:i:s")
            );
            $this->db->insert('penjualan', $data);
        }

        return true;
    }

    public function jumlah_barang() {
        $query = $this->db->get('barang');
        return $query->num_rows();
    }

}

/* End of file Barang_model.php */
