<?php
$hari_ini = date('y-m-d');
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h4>Laporan Peminjaman Inventaris</h4>
                </div>
            </div>
            <div class="card-body">
                <form action="" class="d-flex align-items-center">
                    <input type="hidden" name="p" value="laporan">
                    <div class="mb-3 d-flex align-items-center mx-2">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" class="form-control" id="tgl_awal" name="tglDari" value="<?= !empty($_GET['tglDari']) ? $_GET['tglDari'] : $hari_ini ?>">
                    </div>
                    <div class="mb-3 d-flex align-items-center mx-2">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tgl_sampai" name="tglSampai" value="<?= !empty($_GET['tglSampai']) ? $_GET['tglSampai'] : $hari_ini ?>">
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-sm btn-primary" name="search" value="Filter">
                        <button class="btn btn-sm btn-success" id="cetak">Cetak Laporan</button>
                    </div>
                </form>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peminjam</th>
                            <th>Nama Inventaris</th>
                            <th>Jumlah</th>
                            <th>Tanggal Peminjam</th>
                            <th>Tanggal Pengembalian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $search = '';
                        @$tglDari = $_GET['tglDari'];
                        @$tglSampai = $_GET['tglSampai'];

                        if (!empty($tglDari)) {
                            $search .= "and tanggal_pinjam >= '" . $tglDari . "' ";
                        }

                        if (!empty($tglSampai)) {
                            $search .= "and tanggal_pinjam <= '" . $tglSampai . "' ";
                        }

                        if (empty($tglDari) && ($tglSampai)) {
                            $search .= "and tanggal_pinjam >= '" . $tglDari . "' and tanggal_pinjam <= '" . $tglSampai . "'";
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
</div>