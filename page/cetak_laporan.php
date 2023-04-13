<?php
include "../config/koneksi.php";

@$tgl_awal = $_GET['tgl_awal'];
@$tgl_sampai = $_GET['tgl_sampai'];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="title text-center mt-5">
            <h2>Laporan Peminjaman</h2>
            <p>Periode : <?= date('d-m-y', strtotime($tgl_awal)) ?> <b>S/D</b> <?= date('d,m,y', strtotime($tgl_sampai)) ?></p>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12 text-center">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peminjaman</th>
                            <th>Nama Inventaris</th>
                            <th>Jumlah</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $search = '';
                        @$tgl_awal = $_GET['tgl_awal'];
                        @$tgl_sampai = $_GET['tgl_Sampai'];

                        if (!empty($tgl_awal)) {
                            $search .= "and tanggal_pinjam >= '" . $tgl_awal . "' ";
                        }

                        if (!empty($tgl_sampai)) {
                            $search .= "and tanggal_pinjam <= '" . $tgl_sampai . "' ";
                        }

                        if (empty($tgl_awal) && ($tgl_sampai)) {
                            $search .= "and tanggal_pinjam >= '" . $tgl_awal . "' and tanggal_pinjam <= '" . $tgl_sampai . "'";
                        }

                        $sql = "SELECT *, detail_pinjam.jumlah as jml FROM detail_pinjam LEFT JOIN peminjaman ON peminjaman.id_peminjaman = detail_pinjam.id_peminjaman LEFT JOIN inventaris on inventaris.id_inventaris = detail_pinjam.id_inventaris LEFT JOIN pegawai ON pegawai.id_pegawai = peminjaman.id_pegawai WHERE 1=1 $search";

                        $query = mysqli_query($koneksi, $sql);
                        $test = mysqli_num_rows($query);

                        if ($test > 0) {
                            $no = 1;
                            while ($data = mysqli_fetch_array($query)) {
                        ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['nama_pegawai'] ?></td>
                                    <td><?= $data['nama'] ?></td>
                                    <td><?= $data['jml'] ?></td>
                                    <td><?= $data['tanggal_pinjam'] ?></td>
                                    <td><?= $data['tanggal_kembali'] ?></td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak Ada Data</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>

<script type="text/javascript">
    window.print();
</script>