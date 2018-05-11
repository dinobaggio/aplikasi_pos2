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
        $per_page = $data['per_page'];
        $start_form = $data['start_form'];
        
        if (!empty($id_barang) && !empty($id_produsen)) {
            
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
        } else if (!empty($per_page) || !empty($start_from)) {
            
            $this->db->select("
            id_barang,
            nama_barang,
            stok_barang,
            harga_beli,
            harga_jual");
            $this->db->limit($per_page, $start_form);
            $this->db->from('barang');
            return $this->db->get()->result_object();
        }
    }

    public function total_barang() {
        $this->db->select("id_barang");
        $this->db->from("barang");
        return $this->db->get()->num_rows();
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

    public function data_transaksi_pembelian ($per_page, $start_from) {
        $this->db->select("*");
        $this->db->from("transaksi_pembelian");
        $this->db->limit($per_page, $start_from );
        $query = $this->db->get();
        return $query->result_object();
    }

    public function jumlah_record_pembelian () {
        $this->db->select("*");
        $this->db->from("transaksi_pembelian");
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function detail_transaksi_pembelian($id_transaksi) {
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

    public function laporan_bulanan_pembelian($bulan) {
        $this->db->select("
            transaksi_pembelian.id_transaksi_pembelian,
            transaksi_pembelian.created,
            transaksi_pembelian.total_barang,
            transaksi_pembelian.total_harga,
        ");
        $this->db->from("transaksi_pembelian");
        $this->db->where(array(
            'MONTH(transaksi_pembelian.created)' => $bulan,
            'YEAR(transaksi_pembelian.created)' => 2018
        ));
        $query = $this->db->get();
        return $query->result_object();
        
    }

    public function laporan_bulanan_penjualan($bulan) {
        $this->db->select("
            transaksi_penjualan.id_transaksi_penjualan,
            transaksi_penjualan.created,
            transaksi_penjualan.total_barang,
            transaksi_penjualan.total_harga,
            pelanggan.id_user,
            pelanggan.nama_pelanggan
        ");
        $this->db->from("transaksi_penjualan");
        $this->db->join("pelanggan", "transaksi_penjualan.id_user = pelanggan.id_user");
        $this->db->where(array(
            'MONTH(transaksi_penjualan.created)' => $bulan,
            'YEAR(transaksi_penjualan.created)' => 2018
        ));
        $query = $this->db->get();
        return $query->result_object();
        
    }

    public function detail_transaksi_penjualan($id_transaksi) {
        $this->db->select("
            barang.nama_barang,
            barang.harga_jual,
            penjualan.jumlah_barang,
            penjualan.jumlah_harga,
            produsen.nama_produsen
        ");
        $this->db->from("penjualan");
        $this->db->join("barang", "penjualan.id_barang = barang.id_barang");
        $this->db->join("produsen", "barang.id_produsen = produsen.id_produsen", "left outer");
        $this->db->where(array(
            'penjualan.id_transaksi_penjualan' => $id_transaksi
        ));
        $query = $this->db->get();
        return $query->result_object();
        
    }

    public function data_transaksi_penjualan ($per_page, $start_form) {
        $this->db->select("*");
        $this->db->from("transaksi_penjualan");
        $this->db->limit($per_page, $start_form );
        $query = $this->db->get();
        return $query->result_object();
    }

    public function jumlah_record_penjualan () {
        $this->db->select("id_transaksi_penjualan");
        $this->db->from("transaksi_penjualan");
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_user ($data){
        $per_page = $data['per_page'];
        $start_form = $data['start_form'];
        $this->db->select("
        id_user,
        username,
        cookie");
        $this->db->limit($per_page, $start_form);
        $this->db->from('user');
        return $this->db->get()->result_object();
    }

    public function total_user (){
        $this->db->select("id_user");
        $this->db->from("user");
        return $this->db->get()->num_rows();
    }

    public function pembelian_penjualan($bulan) {
        if ($bulan) :
            $tahun = 2018;
            $que = $this->db->query(
                "SELECT id_transaksi_pembelian as id, total_barang, total_harga, created, kategori from transaksi_pembelian WHERE MONTH(created) = $bulan AND YEAR(created) = $tahun
                UNION SELECT id_transaksi_penjualan as id, total_barang, total_harga, created, kategori from transaksi_penjualan
                WHERE MONTH(created) = $bulan AND YEAR(created) = $tahun ORDER BY created DESC"
            );
            
            return $que->result_object(); 
        endif;

        return '';
    }

}

/* End of file Admin_model.php */
