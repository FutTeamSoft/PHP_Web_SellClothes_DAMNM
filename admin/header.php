<?php
include '../config/config.php';

if (strpos(strtolower($_SERVER['REQUEST_URI']), 'admin') !== false && !isset($_SESSION['admin']))
    header('Location: ./login.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>FTeam - Admin</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/bootstrap-grid.css" rel="stylesheet" />
    <link href="../assets/css/bootstrap-reboot.css" rel="stylesheet" />
    <script src="../assets/js/modernizr-2.8.3.js"></script>
    <link href="../assets/css/base.css" rel="stylesheet" />
    <link href="../assets/fonts/fontawesome-free-6.1.1-web/css/all.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="../assets/css/style-admin.css" rel="stylesheet" />
</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-dark navbar-expand bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand" href="./">Admin FTeam</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 mr-xl-auto" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto mr-3 mr-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu   dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sidenav">
                <div class="sidenav-menu">
                    <div class="nav">
                        <div class="sidenav-menu-heading">Quản lý</div>
                        <a class="nav-link" href="product.php?act=add">
                            <div class="nav-link-icon"><i class="fa-solid fa-shirt"></i></div>
                            Thêm sản phẩm
                        </a>
                        <a class="nav-link" href="products.php">
                            <div class="nav-link-icon"><i class="fa-solid fa-shirt"></i></div>
                            Sản phẩm
                        </a>
                        <a class="nav-link" href="users.php">
                            <div class="nav-link-icon"><i class="fa-solid fa-users"></i></div>
                            Khách hàng
                        </a>
                        <a class="nav-link" href="invoices.php">
                            <div class="nav-link-icon"><i class="fa-solid fa-file-invoice"></i></div>
                            Hóa đơn
                        </a>
                    </div>
                </div>
                <div class="sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Admin FTeam
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>