<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $params = array(
            'perPage' => 10,
            'instance' => 'halaman'
        );
        $cookie = get_cookie('aplikasi_pos2');
        $this->load->library('paginator', $params);

        $this->load->model('barang_model');
        if($this->session->user_login) {
            $user_login = json_decode($this->session->user_login);
            if ($user_login->is_admin) {
                header("Location:".base_url('admin'));
            }
        } else {
            if($cookie) {
                header("Location:".base_url('user/login'));
            }
        }
        
    }
    

    public function index()
    {
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
        $data['kode_barang'] = $string;
        $string = explode('hal', $string);
        $id_barang = $string[0];
        $data['halaman'] = $string[1];
        $data['barang'] = $this->barang_model->get_barang('', '', $id_barang, true);
        $data['title'] = $data['barang']->nama_barang;
        $data['id_barang'] = $id_barang;
        $data['json_data'] = json_encode($data['barang']);
        if($this->session->user_login) {
            $user_login = json_decode($this->session->user_login);
            $data['user'] = $user_login->username;
        } else {
            $data['user'] = 'anonymous';
        }

        $this->load->view('user/template/header', $data);
        $this->load->view("user/detail_barang/v_detail_barang", $data);
        $this->load->view('user/template/footer', $data);
        
    }

    public function keranjang_barang() {
        $data['title'] = "Keranjang Barang";
        
        $data['data_keranjang'] = $this->load->view('user/keranjang_barang/data_keranjang', '', TRUE);
        $this->load->view('user/template/header', $data);
        $this->load->view('user/keranjang_barang/v_keranjang_barang', $data);
        $this->load->view('user/template/footer', $data);
    }

}

/* End of file Home.php */
