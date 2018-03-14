<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->library('pdfgenerator');
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
        
        
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made
        
        $this->form_validation->set_rules('id_produsen', 'Produsen', array(
            'required',
            array(
                'value_produsen',
                array($this->admin_model, 'cek_id_produsen')
            )
        ));
        
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('stok_barang', 'Stok Barang', 'trim|required|numeric');
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'trim|required|numeric');
        $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'trim|required|numeric');

        $this->form_validation->set_message(array(
            'required' => '* {field} Harap diisi',
            'alpha_numeric' => '* {field} Hanya terdiri dari angka atau alfabet saja',
            'numeric' => '* {field} Harus angka',
            'value_produsen' => '* {field} Harus dipilih'
        ));

        $ray = array(
            'id_produsen' => $this->input->post('id_produsen'),
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
                'id_produsen' => $this->input->post('id_produsen'),
                'nama_barang' => $this->input->post('nama_barang'),
                'stok_barang' => $this->input->post('stok_barang'),
                'harga_jual' => $this->input->post('harga_jual'),
                'harga_beli' => $this->input->post('harga_beli')
            );
            $tugas = $this->admin_model->tambah_barang($ray);
            if ($tugas) {
                $ray = array(
                    'id_produsen' => '',
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
                    'id_produsen' => '',
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
            $data['data_barang'] = json_encode($this->admin_model->produsen_barang($id_produsen));
            $data['id_produsen'] = $id_produsen;
            
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/tambah_pembelian/v_list_barang', $data);
            $this->load->view('admin/template/footer', $data);
        }

    }

    public function proses_pembelian () {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made
        $data_barang = json_decode($this->input->post('data_barang'));
        $data_transaksi = json_decode($this->input->post('data_transaksi'));
        $beli = array(
            'total_harga' => $data_transaksi->total_harga,
            'total_barang' => $data_transaksi->total_barang
        );
        $id_transaksi_pembelian = $this->admin_model->transaksi_pembelian($beli);
        
        for($i=0;$i<count($data_barang);$i++) {
            $data_produsen = $data_barang[$i];
            for($j=0;$j<count($data_produsen);$j++) {
                $barang = $data_produsen[$j];
                $beli = array(
                    'id_transaksi_pembelian' => $id_transaksi_pembelian,
                    'id_barang' => $barang->id_barang,
                    'id_produsen' => $barang->id_produsen,
                    'jumlah_barang' => $barang->jumlah_barang,
                    'jumlah_harga' => $barang->jumlah_harga
                );
                $tugas = $this->admin_model->pembelian($beli);
                //print_r($barang);
            }
        }

        $sukses = new stdClass();
        $sukses->id_transaksi_pembelian = $id_transaksi_pembelian;
        $sukses->sukses = true;
        $sukses = json_encode($sukses);
        echo $sukses;
        
    }

    public function transaksi_sukses () {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made
        
        $data['title'] = 'Sukses melakukan transaksi';
        if ($this->input->get('id_transaksi_pembelian')) {
            $data['id_transaksi_pembelian'] = $this->input->get('id_transaksi_pembelian');
        } else {
            $data['id_transaksi_pembelian'] = 0;
        }

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tambah_pembelian/v_transaksi_sukses', $data);
        $this->load->view('admin/template/footer', $data);
    }

    public function detail_barang_beli ($string) {
        $string = explode('produsen', $string);
        $id_produsen = $string[1];
        $id_barang = $string[0];
        $barang = array(
            'id_barang' => $id_barang,
            'id_produsen' => $id_produsen
        );
        $data['data_barang'] = $this->admin_model->get_barang($barang);
        $data['id_produsen'] = $id_produsen;
        $data['title'] = 'detail barang';

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tambah_pembelian/v_detail_barang', $data);
        $this->load->view('admin/template/footer', $data);

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

    public function record_pembelian () {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made

        $data['title'] = "Record Pembelian";
        $data['data_transaksi'] = $this->admin_model->data_transaksi();

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/record_pembelian/v_record_pembelian', $data);
        $this->load->view('admin/template/footer', $data);
        
    }

    public function detail_transaksi () {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made

        $id_transaksi = $this->input->post('id_transaksi_pembelian');
        if ($id_transaksi) {
            $data['title'] = "Detail Transaksi";
            $data['data_transaksi'] = $this->admin_model->detail_transaksi($id_transaksi);
            $data['id_transaksi'] = $id_transaksi;
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/record_pembelian/v_detail_transaksi', $data);
            $this->load->view('admin/template/footer', $data);
        } else {
            echo "transaksi tidak diketahui";
        }
    }

    public function laporan_pembelian() {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made

        $bulan = $this->input->get('bulan');
        $data['title'] = "Laporan Pembelian";

        if (empty($bulan)) {
            
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/laporan_pembelian/v_laporan_pembelian', $data);
            $this->load->view('admin/template/footer', $data);

        } else {
            $data['bulan'] = $bulan;
            $data['laporan'] = $this->admin_model->laporan_bulanan($bulan);

            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/laporan_pembelian/v_laporan_pembelian', $data);
            $this->load->view('admin/template/footer', $data);
        }
        
    }

    public function laporan_pembelian_barang() {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made
        
        $id_transaksi_pembelian = $this->input->post('id_transaksi_pembelian');
        
        if (isset($id_transaksi_pembelian)) {
            $data['barang'] = $this->admin_model->detail_transaksi($id_transaksi_pembelian);
            echo json_encode($data['barang']);
        } else {
            echo 'id tidak diketahui';
        }
    }

    public function cetak_laporan_pembelian(){
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made
        $bulan = $this->input->post("bulan");
        if (isset($bulan)) {

            $data['laporan'] = $this->admin_model->laporan_bulanan($bulan);

            $html = $this->load->view('admin/laporan_pembelian/v_cetak', $data, TRUE);

            $this->pdfgenerator->generate($html,'contoh');

        } else {
            echo "tidak ada data";
        }

    }

    private function data_form_tambah_barang ($value) {
        $data['form_att'] = array(
            'id' => 'form_tambah_barang'
        );
        
        $data['produsen_value'] = $this->list_value_produsen();

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

    private function list_value_produsen() {
        $data = $this->admin_model->list_value_produsen();
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
