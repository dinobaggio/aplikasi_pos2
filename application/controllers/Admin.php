<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->helper('user'); // ini helper home made
        
    }
    

    public function index()
    {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made

        $user_login = json_decode($this->session->user_login);
        $data['title'] = "Home Admin";
        $data['username'] = $user_login->username;
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/home/v_home_admin', $data);
        $this->load->view('admin/template/footer', $data);

        
    }

    public function tambah_barang () {
        
    }

    

}

/* End of file Admin.php */
