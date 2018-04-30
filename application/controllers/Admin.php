<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('admin_model', 'user_model'));
        
        $this->load->helper('user'); // ini helper home made
        $params = array(
            'perPage' => 10,
            'instance' => 'halaman'
        );
        $this->load->library('paginator', $params);
        
        
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
        $kosong = '';
        $id_produsen = $this->input->post("id_produsen");
        $nama_barang = $this->input->post("nama_barang");
        $stok_barang = $this->input->post("stok_barang");
        $harga_jual = $this->input->post("harga_jual");
        $harga_beli = $this->input->post("harga_beli");
        

        $ray = array(
            'id_produsen' => $id_produsen,
            'nama_barang' => $nama_barang,
            'stok_barang' => $stok_barang,
            'harga_jual' => $harga_jual,
            'harga_beli' => $harga_beli
        );
        $data = array(
            'total_harga'=> ($harga_beli * $stok_barang) ,
            'total_barang'=> $stok_barang
        );

        if ($this->form_validation->run() == false ) {
            $value = $this->exists_value_tambah_barang($ray);
            $data = $this->data_form_tambah_barang($value);
            $data['title'] = "Tambah Barang";
        } else {
            $tugas = $this->admin_model->tambah_barang($ray);
            $tugas2 = $this->admin_model->transaksi_pembelian($data);

            $ray = array(
                'id_produsen' => $kosong,
                'nama_barang' => $kosong,
                'stok_barang' => $kosong,
                'harga_jual' => $kosong,
                'harga_beli' => $kosong
            );
            
            if ($tugas) {
                if ($tugas2) {
                    $value = $this->exists_value_tambah_barang($ray);
                    $data = $this->data_form_tambah_barang($value);
                    $data['title'] = "Tambah Barang Sukses";
                }else {
                    $value = $this->exists_value_tambah_barang($ray);
                    $data = $this->data_form_tambah_barang($value);
                    $data['title'] = "Tambah Barang Gagal Tambah Pembelian";
                }

            } else {
                $value = $this->exists_value_tambah_barang($ray);
                $data = $this->data_form_tambah_barang($value);
                $data['title'] = "Tambah Barang Gagal Tambah Barang";
            }

        }

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tambah_barang/v_tambah_barang_form', $data);
        $this->load->view('admin/template/footer', $data);
        
        
    }

    public function list_barang () {
        $total_barang = $this->admin_model->total_barang();
        $per_page = $this->paginator->get_perpage();
        $start_form = $this->paginator->get_start();

        $this->paginator->set_total($total_barang);

        $pagin = array(
            'id_barang' => '',
            'id_produsen' => '',
            'per_page' => $per_page,
            'start_form' => $start_form
        );

        $data['all_barang'] = $this->admin_model->get_barang($pagin);
        $data['page_links'] = $this->paginator->page_links();
        $data['page'] = $this->paginator->get_page();

        $data['title'] = "List Barang";

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/list_barang/v_list_barang', $data);
        $this->load->view('admin/template/footer', $data);
    }

    public function tambah_produsen ()  {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made

        $this->form_validation->set_rules('nama_produsen', 'Nama Produsen', 'required');
        $this->form_validation->set_message(array(
            'required' => '* {field} harap diisi'
        ));

        $nama_produsen = $this->input->post('nama_produsen');
        $kosong = '';

        $ray = array(
            'nama_produsen' => $nama_produsen
        );


        if ($this->form_validation->run() == false) {
            $value = $this->exists_value_tambah_produsen($ray);
            $data = $this->data_form_tambah_produsen($value);
            $data['title'] = "Tambah Produsen";

        } else {
            $tugas = $this->admin_model->tambah_produsen($ray);
            $ray = array(
                'nama_produsen' => $kosong
            );

            if ($tugas) {
                $value = $this->exists_value_tambah_produsen($ray);
                $data = $this->data_form_tambah_produsen($value);
                $data['title'] = "Sukses Menambah Produsen";
        
            } else {
                $value = $this->exists_value_tambah_produsen($ray);
                $data = $this->data_form_tambah_produsen($value);
                $data['title'] = "Gagal Menambah Produsen";
            }
        }

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tambah_produsen/v_tambah_produsen_form', $data);
        $this->load->view('admin/template/footer', $data);

        

    }

    public function tambah_pembelian ($id_produsen = false) {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made
        $file ='';

        if ($id_produsen == false) {
            $data['title'] = "Pembelian barang";
            $data['data_produsen'] = json_encode($this->admin_model->list_produsen());
            $file = 'v_tambah_pembelian';
        } else {
            $data['title'] = "Pembelian barang";
            $data['data_barang'] = json_encode($this->admin_model->produsen_barang($id_produsen));
            $data['id_produsen'] = $id_produsen;
            $file = 'v_list_barang';
        }

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tambah_pembelian/'.$file, $data);
        $this->load->view('admin/template/footer', $data);

    }

    public function proses_pembelian () {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made
        $data_barang = $this->input->post('data_barang');
        $data_transaksi = $this->input->post('data_transaksi');

        $data_barang = json_decode($data_barang);
        $data_transaksi = json_decode($data_transaksi);

        $beli = array(
            'total_harga' => $data_transaksi->total_harga_beli,
            'total_barang' => $data_transaksi->total_barang
        );
        $id_transaksi_pembelian = $this->admin_model->transaksi_pembelian($beli);
        
        for($i=0;$i<count($data_barang);$i++) {

            $data_produsen = $data_barang[$i];

            for($j=0;$j<count($data_produsen);$j++) {
                $barang = $data_produsen[$j];
                $id_barang = $barang->id_barang;
                $id_produsen = $barang->id_produsen;
                $jumlah_barang = $barang->jumlah_barang;
                $jumlah_harga = $barang->jumlah_harga;

                $beli = array(
                    'id_transaksi_pembelian' => $id_transaksi_pembelian,
                    'id_barang' => $id_barang,
                    'id_produsen' => $id_produsen,
                    'jumlah_barang' => $jumlah_barang,
                    'jumlah_harga' => $jumlah_harga
                );

                $tugas = $this->admin_model->pembelian($beli);
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
            'id_produsen' => $id_produsen,
            'per_page' => '',
            'start_form' => ''
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
        $jumlah_record = $this->admin_model->jumlah_record_pembelian();
        $per_page = $this->paginator->get_perpage();
        $start_from = $this->paginator->get_start();
        $this->paginator->set_total($jumlah_record);

        $data['title'] = "Record Pembelian";
        $data['data_transaksi'] = $this->admin_model->data_transaksi_pembelian($per_page, $start_from);
        $data['page_links'] = $this->paginator->page_links();
        

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/record_pembelian/v_record_pembelian', $data);
        $this->load->view('admin/template/footer', $data);
        
    }

    public function detail_transaksi_pembelian () {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made

        $id_transaksi = $this->input->post('id_transaksi_pembelian');
        if ($id_transaksi) {
            $data['title'] = "Detail Transaksi";
            $data['data_transaksi'] = $this->admin_model->detail_transaksi_pembelian($id_transaksi);
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

        if (!empty($bulan)) {
            $data['bulan'] = $bulan;
            $data['laporan'] = $this->admin_model->laporan_bulanan_pembelian($bulan);
        } 
        
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/laporan_pembelian/v_laporan_pembelian', $data);
        $this->load->view('admin/template/footer', $data);
        
    }

    public function laporan_pembelian_barang() {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made
        
        $id_transaksi_pembelian = $this->input->post('id_transaksi_pembelian');
        
        if (isset($id_transaksi_pembelian)) {
            $data['barang'] = $this->admin_model->detail_transaksi_pembelian($id_transaksi_pembelian);
            echo json_encode($data['barang']);
        } else {
            echo 'id tidak diketahui';
        }
    }

    public function cetak_laporan_pembelian(){
        $this->load->library('pdfgenerator');
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made
        $bulan = $this->input->post("bulan");
        if (isset($bulan)) {
            $data['laporan'] = $this->admin_model->laporan_bulanan_pembelian($bulan);

            switch ($bulan) {
                case 1:
                    $bulan = 'januari';
                    break;
                case 2:
                    $bulan = 'februari';
                    break;
                case 3:
                    $bulan = 'maret';
                    break;
                case 4:
                    $bulan = 'april';
                    break;
                case 5:
                    $bulan = 'maret';
                    break;
                case 6:
                    $bulan = 'juni';
                    break;
                case 7:
                    $bulan = 'juli';
                    break;
                case 8:
                    $bulan = 'agustus';
                    break;
                case 9:
                    $bulan = 'september';
                    break;
                case 10:
                    $bulan = 'oktober';
                    break;
                case 11:
                    $bulan = 'november';
                    break;
                case 12:
                    $bulan = 'desember';
                    break;
                default:
                    # code...
                    break;
            }

            $html = $this->load->view('admin/laporan_pembelian/v_cetak', $data, TRUE);

            $this->pdfgenerator->generate($html,'laporan_pembelian_bulan_'.$bulan);

        } else {
            echo "tidak ada data";
        }

    }

    public function laporan_penjualan() {

        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made

        $bulan = $this->input->get('bulan');
        $data['title'] = "Laporan Penjualan";

        if (!empty($bulan)) {
            $data['bulan'] = $bulan;
            $data['laporan'] = $this->admin_model->laporan_bulanan_penjualan($bulan);
        } 
        
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/laporan_penjualan/v_laporan_penjualan', $data);
        $this->load->view('admin/template/footer', $data);

    }

    public function laporan_penjualan_barang() {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made
        
        $id_transaksi_penjualan = $this->input->post('id_transaksi_penjualan');
        
        if (isset($id_transaksi_penjualan)) {
            $data['barang'] = $this->admin_model->detail_transaksi_penjualan($id_transaksi_penjualan);
            echo json_encode($data['barang']);
        } else {
            echo 'id tidak diketahui';
        }
    }

    public function cetak_laporan_penjualan(){
        $this->load->library('pdfgenerator');
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made
        $bulan = $this->input->post("bulan");
        if (isset($bulan)) {
            $data['laporan'] = $this->admin_model->laporan_bulanan_penjualan($bulan);

            switch ($bulan) {
                case 1:
                    $bulan = 'januari';
                    break;
                case 2:
                    $bulan = 'februari';
                    break;
                case 3:
                    $bulan = 'maret';
                    break;
                case 4:
                    $bulan = 'april';
                    break;
                case 5:
                    $bulan = 'maret';
                    break;
                case 6:
                    $bulan = 'juni';
                    break;
                case 7:
                    $bulan = 'juli';
                    break;
                case 8:
                    $bulan = 'agustus';
                    break;
                case 9:
                    $bulan = 'september';
                    break;
                case 10:
                    $bulan = 'oktober';
                    break;
                case 11:
                    $bulan = 'november';
                    break;
                case 12:
                    $bulan = 'desember';
                    break;
                default:
                    # code...
                    break;
            }

            $html = $this->load->view('admin/laporan_penjualan/v_cetak', $data, TRUE);

            $this->pdfgenerator->generate($html,'laporan_penjualan_bulan_'.$bulan);

        } else {
            echo "tidak ada data";
        }

    }

    public function record_penjualan () {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made
        $jumlah_record = $this->admin_model->jumlah_record_penjualan();
        $per_page = $this->paginator->get_perpage();
        $start_from = $this->paginator->get_start();
        $this->paginator->set_total($jumlah_record);

        $data['title'] = "Record Penjualan";
        $data['data_transaksi'] = $this->admin_model->data_transaksi_penjualan($per_page, $start_from);
        $data['page_links'] = $this->paginator->page_links();
        

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/record_penjualan/v_record_penjualan', $data);
        $this->load->view('admin/template/footer', $data);
        
    }

    public function detail_transaksi_penjualan ($id_transaksi) {
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made

        if ($id_transaksi) {
            $data['title'] = "Detail Transaksi";
            $data['data_transaksi'] = $this->admin_model->detail_transaksi_penjualan($id_transaksi);
            $data['id_transaksi'] = $id_transaksi;
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/record_penjualan/v_detail_transaksi', $data);
            $this->load->view('admin/template/footer', $data);
        } else {
            echo "transaksi tidak diketahui";
        }
    }

    public function list_user (){
        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made

        $total_user = $this->admin_model->total_user();
        $per_page = $this->paginator->get_perpage();
        $start_form = $this->paginator->get_start();

        $this->paginator->set_total($total_user);

        $pagin = array(
            'per_page' => $per_page,
            'start_form' => $start_form
        );

        $data['all_user'] = $this->admin_model->get_user($pagin);
        $data['page_links'] = $this->paginator->page_links();
        $data['page'] = $this->paginator->get_page();

        $data['title'] = "List User";

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/list_user/v_list_user', $data);
        $this->load->view('admin/template/footer', $data);
    }

    public function tambah_user () {

        cek_bukan_admin(); //ini helper $this->load->helper('user'); home made

        $this->form_validation->set_rules('username', 'Username', array(
            'trim',
            'required',
            'alpha_numeric',
            array(
                'username_exists',
                array($this->user_model, 'username_exists')
            )
        ));
        
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_pw', 'Konfirmasi Password', 'trim|required|matches[password]');

        $this->form_validation->set_message(array(
            'username_exists' => '* {field} Sudah ada',
            'required' => '* {field} Harap diisi',
            'matches' => '* {field} Tidak sama',
            'alpha_numeric' => '* {field} Hanya terdiri dari angka dan alfabet saja'

        ));

        if($this->form_validation->run() == false) {
            $value = $this->exists_inputan_tambah_user(
                $this->input->post('username'),
                $this->input->post('password'),
                $this->input->post('confirm_pw')
            );
            
            $data = $this->data_form_tambah_user($value);
            $data['title'] = "Form Tambah User";
            
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $confirm_pw = $this->input->post('confirm_pw');
            $tugas = $this->user_model->create_user($username, $password);
            if ($tugas) {
                $value = $this->exists_inputan_tambah_user('', '', '');
                $data = $this->data_form_tambah_user($value);
                $data['title'] = "Tambah User Sukses";
            } else {
                $value = $this->exists_inputan_tambah_user($username, $password, $confirm_pw);
                $data = $this->data_form_tambah_user($value);
                $data['error'] = "* Error ketika mendaftarkan user!";
                $data['title'] = "Form Tambah User";
                
            }
        }

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tambah_user/v_tambah_user', $data);
        $this->load->view('admin/template/footer', $data);
    }

    public function average_cost() {
        
        $data['title'] = "Average Cost";
        $bulan = $this->input->get('bulan');
        if (!empty($bulan)) :
            $data['datanya'] = $this->admin_model->pembelian_penjualan($bulan);
        else :
            $data['datanya'] = '';
        endif;

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/average_cost/v_average_cost', $data);
        $this->load->view('admin/template/footer', $data);
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

    private function data_form_tambah_user($value) {
        $data['form_att'] = array(
            'id' => 'form_register'
        );
        $data['username_input'] = array(
            'type' => 'text',
            'name' => 'username',
            'placeholder' => 'Username',
            'value' => $value['username']
        );
        $data['password_input'] = array(
            'type' => 'password',
            'name' => 'password',
            'placeholder' => 'Password',
            'value' => $value['password']
        );
        $data['confirm_pw'] = array(
            'type' => 'password',
            'name' => 'confirm_pw',
            'placeholder' => 'Confirm Password',
            'value' => $value['confirm_pw']
        );
        $data['form_submit'] = array(
            'type' => 'submit',
            'value' => 'Register',
        );
        return $data;
    }

    private function exists_inputan_tambah_user ($username = '', $password = '', $confirm_pw = '') {
        $value['username'] = '';
        $value['password'] = '';
        $value['confirm_pw'] = '';

        if (!empty($username)) {
            $value['username'] = $username;
        } 
        if (!empty($password)) {
            $value['password'] = $password;
        } 
        if (!empty($confirm_pw)) {
            $value['confirm_pw'] = $confirm_pw;
        }

        return $value;
    }

}

/* End of file Admin.php */
