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
        <a class="navbar-brand" href="<?= base_url('admin')?>">Home</a>
        <?php if($this->session->user_login) : ?>
            <a class="navbar-brand" href="<?= base_url('user/logout')?>">Logout</a>
        <?php endif; ?>
    </span>
    
</nav>


<body class='container-fluid'>