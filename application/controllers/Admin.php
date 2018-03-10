<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->helper('user'); // ini helper home made
        $this->load->model('admin_model');
        
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
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made

        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('stok_barang', 'Stok Barang', 'trim|required|numeric');
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'trim|required|numeric');
        $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'trim|required|numeric');

        $this->form_validation->set_message(array(
            'required' => '* {field} Harap diisi',
            'alpha_numeric' => '* {field} Hanya terdiri dari angka atau alfabet saja',
            'numeric' => '* {field} Harus angka'
        ));

        $ray = array(
            'nama_barang' => $this->input->post('nama_barang'),
            'stok_barang' => $this->input->post('stok_barang'),
            'harga_jual' => $this->input->post('harga_jual'),
            'harga_beli' => $this->input->post('harga_beli')
        );

        if ($this->form_validation->run() == false ) {

            $value = $this->exists_value_tambah_barang($ray);
            $data = $this->data_form_tambah_barang($value);
            
            $data['title'] = "Tambah Barang";
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/tambah_barang/v_tambah_barang_form', $data);
            $this->load->view('admin/template/footer', $data);

        } else {

            $ray = array(
                'nama_barang' => $this->input->post('nama_barang'),
                'stok_barang' => $this->input->post('stok_barang'),
                'harga_jual' => $this->input->post('harga_jual'),
                'harga_beli' => $this->input->post('harga_beli')
            );
            $tugas = $this->admin_model->tambah_barang($ray);
            if ($tugas) {
                $ray = array(
                    'nama_barang' => '',
                    'stok_barang' => '',
                    'harga_jual' => '',
                    'harga_beli' => ''
                );

                $value = $this->exists_value_tambah_barang($ray);
                $data = $this->data_form_tambah_barang($value);
                
                $data['title'] = "Tambah Barang Sukses";
                $this->load->view('admin/template/header', $data);
                $this->load->view('admin/tambah_barang/v_tambah_barang_form', $data);
                $this->load->view('admin/template/footer', $data);

            } else {

                $ray = array(
                    'nama_barang' => '',
                    'stok_barang' => '',
                    'harga_jual' => '',
                    'harga_beli' => ''
                );
                
                $value = $this->exists_value_tambah_barang($ray);
                $data = $this->data_form_tambah_barang($value);
                
                $data['title'] = "Tambah Barang Gagal";
                $this->load->view('admin/template/header', $data);
                $this->load->view('admin/tambah_barang/v_tambah_barang_form', $data);
                $this->load->view('admin/template/footer', $data);

            }

        }

        
        
    }

    private function data_form_tambah_barang ($value) {
        $data['form_att'] = array(
            'id' => 'form_tambah_barang'
        );
        $data['input_nama_barang'] = array(
            'name' => 'nama_barang',
            'type' => 'text',
            'placeholder' => 'Nama Barang',
            'value' => $value['nama_barang']
        );
        $data['input_stok_barang'] = array(
            'name' => 'stok_barang',
            'type' => 'number',
            'placeholder' => 'Stok Barang',
            'value' => $value['stok_barang']
        );
        $data['input_harga_jual'] = array(
            'name' => 'harga_jual',
            'type' => 'number',
            'placeholder' => 'Harga Jual',
            'value' => $value['harga_jual']
        );
        $data['input_harga_beli'] = array(
            'name' => 'harga_beli',
            'type' => 'number',
            'placeholder' => 'Harga Beli',
            'value' => $value['harga_beli']
        );
        $data['form_submit'] = array(
            'type' => 'submit',
            'value' => 'Simpan'
        );

        return $data;
    }

    private function exists_value_tambah_barang($ray) {
        $nama_barang = $ray['nama_barang'];
        $stok_barang = $ray['stok_barang'];
        $harga_jual = $ray['harga_jual'];
        $harga_beli = $ray['harga_beli'];

        if (empty($nama_barang)) {
            $nama_barang = '';
        }
        if (empty($stok_barang)) {
            $stok_barang = '';
        }
        if (empty($harga_jual)) {
            $harga_jual = '';
        }
        if(empty($harga_beli)) {
            $harga_beli = '';
        }
        
        $value = array(
            'nama_barang' => $nama_barang,
            'stok_barang' => $stok_barang,
            'harga_jual' => $harga_jual,
            'harga_beli' => $harga_beli
        );

        return $value;
    }

}

/* End of file Admin.php */
