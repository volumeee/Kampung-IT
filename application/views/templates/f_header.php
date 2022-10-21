<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= $title; ?></title>

    <!-- load favico -->
    <link rel="icon" href="<?= base_url('assets/img/favicon/') . $identitas['favicon']; ?>" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="<?= base_url(); ?>assets/vendor/theme-indomarket/css/nucleo-icons.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/vendor/theme-indomarket/css/font-awesome.css" rel="stylesheet">

    <!-- Jquery UI -->
    <link type="text/css" href="<?= base_url(); ?>assets/vendor/theme-indomarket/css/jquery-ui.css" rel="stylesheet">

    <!-- Argon CSS -->
    <link type="text/css" href="<?= base_url(); ?>assets/vendor/theme-indomarket/css/argon-design-system.min.css" rel="stylesheet">

    <!-- Main CSS-->
    <link type="text/css" href="<?= base_url(); ?>assets/vendor/theme-indomarket/css/style.css" rel="stylesheet">

    <!-- Optional Plugins-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
    <header class="header clearfix">
        <div class="header-main border-top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-12 col-sm-6 text-center text-md-left mb-2 mb-sm-0">
                        <a class="navbar-brand mr-lg-5" href="<?= base_url(); ?>">
                            <i class="fa fa-shopping-bag fa-3x"></i> <span class="logo"><?= $identitas['nama_instansi']; ?></span>
                        </a>
                    </div>
                    <div class="col-lg-8 col-12 col-sm-6">
                        <form action="<?= base_url('home/searchNav'); ?>" method="POST" class="search">
                            <div class="input-group w-100">
                                <input type="text" class="form-control" placeholder="Search" name="search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-main navbar-expand-lg navbar-light border-top border-bottom">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav" aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="main_nav">
                    <div class="navbar-collapse-header">
                        <div class="row">
                            <div class="col-6 collapse-brand">
                                <a href="javascript:void(0)">
                                    <?php if ($identitas['logo'] != '') : ?>
                                        <img class="img-fluid" src="<?= base_url('assets/img/logo/') . $identitas['logo']; ?>" alt="<?= $identitas['nama_instansi']; ?>">
                                    <?php else : ?>
                                        <div class="font-weight-bold mt-2"><?= $identitas['nama_instansi']; ?></div>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="col-6 collapse-close">
                                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#main_nav" aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="<?= base_url(); ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('home/artikel'); ?>">Artikel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('home/contact'); ?>">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('home/artikel/about-us'); ?>">About Us</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-lg-auto">
                        <?php if ($this->session->userdata('email')) : ?>
                            <!-- logged in -->
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="<?= base_url('user'); ?>" title="Buka pengaturan akun">
                                    <i class="fa fa-user-circle-o"></i>
                                    <span class="nav-link-inner--text d-lg-none">My Account</span>
                                </a>
                            </li>
                        <?php else : ?>
                            <!-- not logged in -->
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="<?= base_url('auth'); ?>" title="Login">
                                    <i class="fa fa-power-off"></i>
                                    <span class="nav-link-inner--text d-lg-none">Log In</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div> <!-- collapse .// -->
            </div> <!-- container .// -->
        </nav>
    </header>