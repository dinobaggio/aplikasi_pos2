<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= $this->assets->get_assets()?>
    <title><?= $title ?></title>
</head>

<nav class="navbar navbar-light bg-light">
    <span>
        <span class="navbar-brand mb-0 h1">Navbar</span>
        <a class="navbar-brand" href="<?= base_url('user')?>">Home</a>
        <a class="navbar-brand" href="<?= base_url('barang/katalog_barang')?>">Katalog Barang</a>
        <a id='tombol_keranjang' class="navbar-brand" href="<?= base_url('barang/keranjang_barang')?>">Keranjang Barang</a>
        <?php if($this->session->user_login) : ?>
            <a class="navbar-brand" onclick="profil()" href='javascript:void(0)'>Profil</a>
            <a class="navbar-brand" onclick="logout()" href='javascript:void(0)'>Logout</a>
        <?php else : ?>
            <a class="navbar-brand" href="<?= base_url('user/login')?>">Login</a>
            <a class="navbar-brand" href="<?= base_url('user/register')?>">Register</a>
        <?php endif; ?>
    </span>
    
</nav>

<br>
<body class='container-fluid'>
