<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?></title>

    <?= $this->assets->get_assets()?>
   <link rel='stylesheet' href="<?= base_url('../assets/css/dashboard.css')?>">

  </head>

  <body>
      
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Admin</a>
      <!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> -->
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="<?= base_url('user/logout')?>">Sign out</a>
        </li>
      </ul>
    </nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link " href="<?= base_url('admin')?>">
                        <span data-feather="home"></span>
                        Home 
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <b class="pl-2" aria-haspopup="true" aria-expanded="false">Pembelian</b>
                        <ul class="nav pl-3">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/tambah_pembelian')?>">Tambah Pembelian</a>
                                <a class="nav-link" href="<?= base_url('admin/record_pembelian')?>">Record Pembelian</a>
                                <a class="nav-link" href="<?= base_url('admin/laporan_pembelian')?>">Cetak Laporan Pembelian</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <b class="pl-2" aria-haspopup="true" aria-expanded="false">Penjualan</b>
                        <ul class="nav pl-3">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/record_penjualan')?>">Record Penjualan</a>
                                <a class="nav-link" href="<?= base_url('admin/laporan_penjualan')?>">Cetak Laporan Penjualan</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <b class="pl-2" aria-haspopup="true" aria-expanded="false">Produsen</b>
                        <ul class="nav pl-3">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/list_produsen')?>">List Produsen</a>
                                <a class="nav-link" href="<?= base_url('admin/tambah_produsen')?>">Tambah Produsen</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <b class="pl-2" aria-haspopup="true" aria-expanded="false">User</b>
                        <ul class="nav pl-3">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/list_user')?>">List User</a>
                                <a class="nav-link" href="<?= base_url('admin/tambah_user')?>">Tambah User</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <b class="pl-2" aria-haspopup="true" aria-expanded="false">Barang</b>
                        <ul class="nav pl-3">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/list_barang')?>">List Barang</a>
                                <a class="nav-link" href="<?= base_url('admin/tambah_barang')?>">Tambah Barang</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <b class="pl-2" aria-haspopup="true" aria-expanded="false">Pencatatan</b>
                        <ul class="nav pl-3">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/average_cost')?>">Avarage Cost</a>
                            </li>
                        </ul>
                    </li>
                    
                </ul>
            </div>
        </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">