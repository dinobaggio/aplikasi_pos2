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

    public function transaksi_pembelian($beli) {
        $data = array(
            'total_barang' => $beli['total_barang'],
            'total_harga' => $beli['total_harga'],
            'created' => date("Y-m-j H:i:s")
        );
        $this->db->insert('transaksi_pembelian', $data);
        return $this->db->insert_id();
    }
    //insert kedalam tabel pembelian
    public function pembelian ($beli) {
        $data = array(
            'id_transaksi_pembelian' => $beli['id_transaksi_pembelian'],
            'id_barang' => $beli['id_barang'],
            'id_produsen' => $beli['id_produsen'],
            'jumlah_barang' => $beli['jumlah_barang'],
            'jumlah_harga' => $beli['jumlah_harga'],
            'created' => date("Y-m-j H:i:s")
        );
        $this->db->insert('pembelian', $data);
        return $this->db->insert_id();
    }

    public function data_transaksi () {
        $this->db->select("*");
        $this->db->from("transaksi_pembelian");
        $query = $this->db->get();
        return $query->result_object();
    }

    public function detail_transaksi($id_transaksi) {
        $this->db->select("
            barang.nama_barang,
            barang.harga_beli,
            pembelian.jumlah_barang,
            pembelian.jumlah_harga,
            produsen.nama_produsen
        ");
        $this->db->from("pembelian");
        $this->db->join("barang", "pembelian.id_barang = barang.id_barang");
        $this->db->join("produsen", "pembelian.id_produsen = produsen.id_produsen");
        $this->db->where(array(
            'pembelian.id_transaksi_pembelian' => $id_transaksi
        ));
        $query = $this->db->get();
        return $query->result_object();
        
    }

    public function laporan_bulanan($bulan) {
        $this->db->select("
            transaksi_pembelian.id_transaksi_pembelian,
            transaksi_pembelian.created,
            transaksi_pembelian.total_barang,
            transaksi_pembelian.total_harga
        ");
        $this->db->from("transaksi_pembelian");
        $this->db->where(array(
            'MONTH(transaksi_pembelian.created)' => $bulan,
            'YEAR(transaksi_pembelian.created)' => 2018
        ));
        $query = $this->db->get();
        return $query->result_object();
        
    }

}

/* End of file Admin_model.php */
