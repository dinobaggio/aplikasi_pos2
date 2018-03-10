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

    public function tambah_barang ($id_produsen) {
        
        
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
            'id_produsen' => $id_produsen,
            'nama_barang' => $this->input->post('nama_barang'),
            'stok_barang' => $this->input->post('stok_barang'),
            'harga_jual' => $this->input->post('harga_jual'),
            'harga_beli' => $this->input->post('harga_beli')
        );

        if ($this->form_validation->run() == false ) {
            
            $value = $this->exists_value_tambah_barang($ray);
            $data = $this->data_form_tambah_barang($value);
            $data['id_produsen'] = $id_produsen;
            $data['title'] = "Tambah Barang";
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/tambah_barang/v_tambah_barang_form', $data);
            $this->load->view('admin/template/footer', $data);

        } else {

            $ray = array(
                'id_produsen' => $id_produsen,
                'nama_barang' => $this->input->post('nama_barang'),
                'stok_barang' => $this->input->post('stok_barang'),
                'harga_jual' => $this->input->post('harga_jual'),
                'harga_beli' => $this->input->post('harga_beli')
            );
            $tugas = $this->admin_model->tambah_barang($ray);
            if ($tugas) {
                $ray = array(
                    'id_produsen' => $id_produsen,
                    'nama_barang' => '',
                    'stok_barang' => '',
                    'harga_jual' => '',
                    'harga_beli' => ''
                );

                $value = $this->exists_value_tambah_barang($ray);
                $data = $this->data_form_tambah_barang($value);
                $data['id_produsen'] = $id_produsen;
                
                $data['title'] = "Tambah Barang Sukses";
                $this->load->view('admin/template/header', $data);
                $this->load->view('admin/tambah_barang/v_tambah_barang_form', $data);
                $this->load->view('admin/template/footer', $data);

            } else {

                $ray = array(
                    'id_produsen' => $id_produsen,
                    'nama_barang' => '',
                    'stok_barang' => '',
                    'harga_jual' => '',
                    'harga_beli' => ''
                );
                
                $value = $this->exists_value_tambah_barang($ray);
                $data = $this->data_form_tambah_barang($value);
                $data['id_produsen'] = $id_produsen;
                
                $data['title'] = "Tambah Barang Gagal";
                $this->load->view('admin/template/header', $data);
                $this->load->view('admin/tambah_barang/v_tambah_barang_form', $data);
                $this->load->view('admin/template/footer', $data);

            }

        }
        
        
    }

    public function tambah_produsen ()  {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made

        $this->form_validation->set_rules('nama_produsen', 'Nama Produsen', 'required');
        $this->form_validation->set_message(array(
            'required' => '* {field} harap diisi'
        ));

        if ($this->form_validation->run() == false) {

            $ray = array(
                'nama_produsen' => $this->input->post('nama_produsen')
            );
    
            $value = $this->exists_value_tambah_produsen($ray);
            $data = $this->data_form_tambah_produsen($value);
    
            $data['title'] = "Tambah Produsen";
    
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/tambah_produsen/v_tambah_produsen_form', $data);
            $this->load->view('admin/template/footer', $data);

        } else {
            $ray = array(
                'nama_produsen' => $this->input->post('nama_produsen')
            );

            $tugas = $this->admin_model->tambah_produsen($ray);
            if ($tugas) {

                $ray = array(
                    'nama_produsen' => ''
                );

                $value = $this->exists_value_tambah_produsen($ray);
                $data = $this->data_form_tambah_produsen($value);
        
                $data['title'] = "Sukses Menambah Produsen";
        
                $this->load->view('admin/template/header', $data);
                $this->load->view('admin/tambah_produsen/v_tambah_produsen_form', $data);
                $this->load->view('admin/template/footer', $data);

            } else {

                $ray = array(
                    'nama_produsen' => ''
                );

                $value = $this->exists_value_tambah_produsen($ray);
                $data = $this->data_form_tambah_produsen($value);
        
                $data['title'] = "Gagal Menambah Produsen";
        
                $this->load->view('admin/template/header', $data);
                $this->load->view('admin/tambah_produsen/v_tambah_produsen_form', $data);
                $this->load->view('admin/template/footer', $data);

            }
    
            
        }

        

    }

    public function tambah_pembelian ($id_produsen = false) {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made

        if ($id_produsen == false) {
            $data['title'] = "Pilih Produsen";
            $data['data_produsen'] = json_encode($this->admin_model->list_produsen());
            
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/tambah_pembelian/v_tambah_pembelian', $data);
            $this->load->view('admin/template/footer', $data);
        } else {
            $data['title'] = "Pilih barang";
            $data['data_barang'] = $this->admin_model->list_barang($id_produsen);
            
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/tambah_pembelian/v_tambah_pembelian', $data);
            $this->load->view('admin/template/footer', $data);
        }
    }

    public function list_produsen () {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made

        $data['title'] = "List Produsen";
        $data['data_produsen'] = json_encode($this->admin_model->list_produsen());

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/list_produsen/v_list_produsen', $data);
        $this->load->view('admin/template/footer', $data);

    }

    public function detail_produsen ($id_produsen) {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made
        $data['data_produsen'] = $this->admin_model->list_produsen($id_produsen);
        $data['data_barang'] = json_encode($this->admin_model->produsen_barang($id_produsen));
        $data['id_produsen'] = $id_produsen;
        $data['title'] = "Detail Produsen";
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/detail_produsen/v_detail_produsen', $data);
        $this->load->view('admin/template/footer', $data);

    }

    private function data_form_tambah_barang ($value) {
        $data['form_att'] = array(
            'id' => 'form_tambah_barang'
        );
        $data['input_id_produsen'] = array(
            'name' => 'id_produsen',
            'disabled' => 'true',
            'value' => $value['id_produsen']
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
        $id_produsen = $ray['id_produsen'];
        $nama_barang = $ray['nama_barang'];
        $stok_barang = $ray['stok_barang'];
        $harga_jual = $ray['harga_jual'];
        $harga_beli = $ray['harga_beli'];

        if (empty($id_produsen)) {
            $id_produsen = '';
        }
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
            'id_produsen' => $id_produsen,
            'nama_barang' => $nama_barang,
            'stok_barang' => $stok_barang,
            'harga_jual' => $harga_jual,
            'harga_beli' => $harga_beli
        );

        return $value;
    }

    private function data_form_tambah_produsen ($value) {
        $data['form_att'] = array(
            'id' => 'form_tambah_produsen'
        );
        $data['input_nama_produsen'] = array(
            'name' => 'nama_produsen',
            'type' => 'text',
            'placeholder' => 'Nama Produsen',
            'value' => $value['nama_produsen']
        );
        $data['input_submit'] = array(
            'type' => 'submit',
            'value' => 'Simpan'
        );

        return $data;
    }

    private function exists_value_tambah_produsen ($ray) {

        $nama_produsen = $ray['nama_produsen'];
        
        if (empty($nama_produsen)) {
            $nama_produsen = '';
        }
       
        $value = array(
            'nama_produsen' => $nama_produsen
        );

        return $value;

    }

}

/* End of file Admin.php */
