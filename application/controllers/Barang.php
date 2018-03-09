<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

    
    
    public function __construct()
    {
        parent::__construct();
        $params = array(
            'perPage' => 10,
            'instance' => 'halaman'
        );
        $this->load->library('paginator', $params);
        $this->load->model('barang_model');
        $this->load->helper('user'); // ini helper home made
        
    }
    

    public function index()
    {
        cek_login_admin(); // ini helper $this->load->helper('user'); home made

        $user_login = json_decode($this->session->user_login);
        if ($user_login) {
            $data['username'] = $user_login->username;
        }
        $data['title'] = 'Welcome';
         

        $this->load->view('user/template/header', $data);
        $this->load->view('user/home/v_home', $data);
        $this->load->view('user/template/footer', $data);
        
    }

    public function katalog_barang () {
        
        cek_login_admin(); // ini helper $this->load->helper('user'); home made
        $jumlah_barang = $this->barang_model->jumlah_barang();
        $per_page = $this->paginator->get_perpage();
        $start_from = $this->paginator->get_start();

        $this->paginator->set_total($jumlah_barang);

        $data['all_barang'] = $this->barang_model->get_barang($per_page, $start_from, false, true);
        $data['page_links'] = $this->paginator->page_links();
        $data['page'] = $this->paginator->get_page();

        $data['json_data'] = json_encode($data['all_barang']);

        $data['title'] = "Katalog Barang";
        
        $this->load->view('user/template/header', $data);
        $this->load->view("user/katalog_barang/v_katalog_barang", $data);
        $this->load->view('user/template/footer', $data);

        

    }

    public function detail_barang ($string) {

        cek_login_admin(); // ini helper $this->load->helper('user'); home made 

        $data['kode_barang'] = $string;
        $string = explode('hal', $string);
        $id_barang = $string[0];
        $data['halaman'] = $string[1];
        $data['barang'] = $this->barang_model->get_barang('', '', $id_barang, true);
        $data['title'] = $data['barang']->nama_barang;
        $data['id_barang'] = $id_barang;
        $data['json_data'] = json_encode($data['barang']);


        $this->load->view('user/template/header', $data);
        $this->load->view("user/detail_barang/v_detail_barang", $data);
        $this->load->view('user/template/footer', $data);

        
    }

    public function keranjang_barang() {

        cek_login_admin(); // ini helper $this->load->helper('user'); home made

        $data['title'] = "Keranjang Barang";
        
        if($this->session->user_login) {
            $user_login = json_decode($this->session->user_login);
            $data['id_user'] = $user_login->id_user;
        } else {
            $data['id_user'] = "0";
        }
        
        $this->load->view('user/template/header', $data);
        $this->load->view('user/keranjang_barang/v_keranjang_barang', $data);
        $this->load->view('user/template/footer', $data);
    }

    public function transaksi_barang() {
        $data_keranjang = json_decode($this->input->post('data_keranjang'));
        $data_transaksi = json_decode($this->input->post('data_transaksi'));
        $id_transaksi_penjualan = $this->barang_model->insert_transaksi_penjualan($data_transaksi);
        $tugas = $this->barang_model->insert_penjualan($data_keranjang, $id_transaksi_penjualan);
        $sukses = new stdClass();
        $sukses->id_transaksi_penjualan = $id_transaksi_penjualan;
        $sukses->sukses = true;
        $sukses = json_encode($sukses);
        if ($tugas) {
            echo $sukses;
        }
    }

    public function transaksi_sukses() {
        
        $data['title'] = 'Sukses melakukan transaksi';
        if ($this->input->get('id_transaksi_penjualan')) {
            $data['id_transaksi_penjualan'] = $this->input->get('id_transaksi_penjualan');
        } else {
            $data['id_transaksi_penjualan'] = 0;
        }

        $this->load->view('user/template/header', $data);
        $this->load->view('user/keranjang_barang/v_transaksi_sukses', $data);
        $this->load->view('user/template/footer', $data);
    }

    public function record_transaksi() {
        $data['title'] = "Record Transaksi";

        $this->load->view('user/template/header', $data);
        $this->load->view('user/record_transaksi/v_record_transaksi', $data);
        $this->load->view('user/template/footer', $data);
    }

}

/* End of file Barang.php */
