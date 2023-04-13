<?php
session_start();
include "config/koneksi.php";
if (!empty($_SESSION['username'])) {
    $user = $_SESSION['username'];
    $level = $_SESSION['level'];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi Inventaris</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/main.css">
    <!-- BOOTSTRAP 5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- BOOTSTRAP ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;700&display=swap" rel="stylesheet">

</head>

<body>
    <!-- NAVBAR START -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-dark fixed-top shadow">
        <div class="container">
            <a class="navbar-brand" href="#">Inventaris</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <?php
                    if (@$level == "1") {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?p=list_barang">Daftar Peminjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?p=peminjaman">Peminjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?p=pengembalian">Pengembalian</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?p=laporan">Laporan</a>
                        </li>
                    <?php
                    }
                    ?>

                    <?php
                    if (@$level == "2") {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?p=peminjaman">Peminjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?p=pengembalian">Pengembalian</a>
                        </li>
                    <?php
                    }
                    ?>

                    <?php
                    if (@$level == "3") {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?p=peminjaman">Peminjaman</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
                <?php
                if (!empty($user)) {
                ?>
                    <div class="nav-item dropdown text-white">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $user ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="page/logout.php">Logout</a></li>
                        </ul>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>
    <!-- NAVBAR END -->

    <!-- content -->
    <div class="container">
        <?php

        if (!empty($_SESSION['username'])) {
            $user = $_SESSION['username'];

            @$p = $_GET['p'];
            switch ($p) {

                case 'login';
                    include "page/login.php";
                    break;

                case 'list_barang';
                    include "page/list_barang.php";
                    break;

                case 'tambah_barang';
                    include "page/tambah_barang.php";
                    break;

                case 'edit_barang';
                    include "page/edit_barang.php";
                    break;

                case 'peminjaman';
                    include "page/peminjaman.php";
                    break;

                case 'pengembalian';
                    include "page/pengembalian.php";
                    break;

                case 'detail_pengembalian';
                    include "page/detail_peminjaman.php";
                    break;

                case 'laporan';
                    include "page/laporan.php";
                    break;

                case 'home';
                    include "page/home.php";
                    break;

                case 'hapus';
                    include "page/hapus.php";
                    break;

                default:
                    include "page/login.php";
                    break;
            }
        } else {
            include "page/login.php";
        }
        ?>
    </div>

    <!-- end content -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>

<script type="text/javascript">
    $(document).on('click', '#cetak', function() {
        var tgl_awal = $("#tgl_awal").val();
        var tgl_sampai = $("#tgl_sampai").val();
        window.open('page/cetak_laporan.php?tgl_awal= ' + tgl_awal + "&tgl_sampai=" + tgl_sampai, '_blank ');
    });
</script>