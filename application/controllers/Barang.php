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
        
        $this->load->view('user/template/header', $data);
        $this->load->view('user/keranjang_barang/v_keranjang_barang', $data);
        $this->load->view('user/template/footer', $data);
    }

    public function transaksi_barang() {
        $data = $this->input->post('data');
        if($data){
            echo "<h1>Transaksi Barang</h1>";
            echo $data;
        }
        
    }

}

/* End of file Barang.php */
