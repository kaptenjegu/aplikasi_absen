<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>e-Absen PT Falcon Prima Tehnik</title>

    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="<?= base_url('assets/images/ikon.ico') ?>" rel="icon">
    <link href="<?= base_url('assets/images/ikon.ico') ?>" rel="apple-touch-icon">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />
    <!--link rel="stylesheet" href="<? //= base_url() 
                                    ?>assets/css/fonts.googleapis.com.css" /-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/ace-skins.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url() ?>assets/js/ace-extra.min.js"></script>
    <style>
        .blink_me {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        .lds-ring {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 64px;
            height: 64px;
            margin: 8px;
            border: 8px solid #fff;
            border-radius: 50%;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: #fff transparent transparent transparent;
        }

        .lds-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }

        .lds-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }

        .lds-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }

        @keyframes lds-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

</head>

<body class="no-skin" <?php if ($page == 'Absen') {
                            echo 'onload="getLocation()"';
                        } ?>>
    <!--div class="lds-ring"><div></div><div></div><div></div><div></div></div-->
    <div id="navbar" class="navbar navbar-default          ace-save-state">
        <div class="navbar-container ace-save-state" id="navbar-container">
            <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                <span class="sr-only">Toggle sidebar</span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>
            </button>

            <div class="navbar-header pull-left">
                <a href="<?= base_url() ?>" class="navbar-brand">
                    <small>
                        <i class="fa fa-leaf"></i>
                        e-Absen
                    </small>
                </a>
            </div>

            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">

                    <!-- pengumuman header -->
                    <li class="grey dropdown-modal">
                        <a class="dropdown-toggle" href="<?= base_url('Pengumuman') ?>">
                            <i class="ace-icon fa fa-bullhorn"></i>
                            <!--i class="ace-icon fa fa-bullhorn icon-animated-vertical"></i-->
                            <!--span class="badge badge-warning">5</span-->
                        </a>
                    </li>
                    <!-- pengumuman header -->

                    <!-- user header -->
                    <li class="light-blue dropdown-modal">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            <img class="nav-user-photo" src="<?= base_url() ?>assets/images/avatars/avatar2.png" alt="Jason's Photo" />
                            <span class="user-info">
                                <small>Welcome,</small>
                                <?= $_SESSION['nama_user'] ?>
                            </span>

                            <i class="ace-icon fa fa-caret-down"></i>
                        </a>

                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <!--li>
                                <a href="#">
                                    <i class="ace-icon fa fa-cog"></i>
                                    Settings
                                </a>
                            </li>

                            <li>
                                <a href="profile.html">
                                    <i class="ace-icon fa fa-user"></i>
                                    Profile
                                </a>
                            </li>

                            <li class="divider"></li-->

                            <li>
                                <a href="<?= base_url('Login/keluar/') ?>">
                                    <i class="ace-icon fa fa-power-off"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- user header -->

                </ul>
            </div>
        </div><!-- /.navbar-container -->
    </div>

    <div class="main-container ace-save-state" id="main-container">
        <script type="text/javascript">
            try {
                ace.settings.loadState('main-container')
            } catch (e) {}
        </script>

        <div id="sidebar" class="sidebar responsive ace-save-state">


            <ul class="nav nav-list">
                <li class="<?php if ($page == 'Absen') {
                                echo "active";
                            } ?>">
                    <a href="<?= base_url() ?>">
                        <i class="menu-icon glyphicon glyphicon-check"></i>
                        <span class="menu-text"> Absen </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="<?php if ($page == 'Riwayat') {
                                echo "active";
                            } ?>">
                    <a href="<?= base_url('Riwayat') ?>">
                        <i class="menu-icon fa fa-book"></i>
                        <span class="menu-text"> Riwayat Absen </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="<?php if ($page == 'Absen_tertunda') {
                                echo "active";
                            } ?>">
                    <a href="<?= base_url('Absen/tertunda') ?>">
                        <i class="menu-icon glyphicon glyphicon-tag"></i>
                        <span class="menu-text"> Ajukan Absen </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="<?php if ($page == 'Pengumuman') {
                                echo "active";
                            } ?>">
                    <a href="<?= base_url('Pengumuman') ?>">
                        <i class="menu-icon fa fa-bullhorn"></i>
                        <span class="menu-text">
                            Pengumuman
                            <!--span class="badge badge-warning">8</span-->
                        </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="<?php if ($page == 'Akun') {
                                echo "active";
                            } ?>">
                    <a href="<?= base_url('Akun') ?>">
                        <i class="menu-icon glyphicon glyphicon-user"></i>
                        <span class="menu-text"> Akun </span>
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul><!-- /.nav-list -->
        </div>

        <div class="main-content">
            <div class="main-content-inner">


                <div class="page-content">

                    <div class="page-header">
                        <h1>
                            <a href="<?= $url ?>"><b><?= $judul ?></b></a>
                        </h1>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">