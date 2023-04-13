<?php
$id_peminjaman = $_GET['id_peminjaman'];
if (empty($id_peminjaman)) {
?>
    <script type="text/javascript">
        window.location.href = "?p=pengembalian";
    </script>
<?php
}
$hari = date('d-m-y');
$d_peminjaman = "SELECT *, detail_pinjam.jumlah as jml FROM detail_pinjam LEFT JOIN peminjaman ON peminjaman.id_peminjaman = detail_pinjam.id_peminjaman LEFT JOIN inventaris on inventaris.id_inventaris = detail_pinjam.id_inventaris LEFT JOIN pegawai ON pegawai.id_pegawai = peminjaman.id_pegawai WHERE peminjaman.id_peminjaman = '$id_peminjaman'";
$d_query = mysqli_query($koneksi, $d_peminjaman);
$data = mysqli_fetch_array($d_query)
?>

<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h4>Konfirmasi Pengembalian Inventaris</h4>
        </div>
        <div class="card-body">
            <?php
            if (isset($_POST['save'])) {
                $tgl_kembali = $_POST['tgl_kembali'];

                $sql_pengembalian = "UPDATE peminjaman SET tanggal_kembali = '$tgl_kembali', status_peminjaman = '2' WHERE id_peminjaman = '$id_peminjaman'";
                $q_pengembalian = mysqli_query($koneksi, $sql_pengembalian);

                if ($q_pengembalian) {
            ?>
                    <script type="text/javascript">
                        window.location.href = "?p=pengembalian";
                    </script>
                <?php
                } else {
                ?>
                    <div class="text-center alert alert-danger" role="alert">
                        Barang Gagal Untuk Diupdate
                    </div>
            <?php
                }
            }
            ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="" class="form-label">Kode Peminjaman</label>
                    <input type="text" name="id_peminjaman" class="form-control" value="<?= $data['id_peminjaman'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Tanggal Peminjaman</label>
                    <input type="text" name="tgl_pinjam" class="form-control" value="<?= $hari ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Nama Peminjam</label>
                    <input type="text" name="nama_pegawai" class="form-control" value="<?= $data['nama_pegawai'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Nama Barang</label>
                    <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Jumlah</label>
                    <input type="number" name="jml" class="form-control" value="<?= $data['jml'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Tanggal Pengembalian</label>
                    <input type="date" name="tgl_kembali" class="form-control">
                </div>
                <div class="mb-3">
                    <button type="submit" name="save" class="btn btn-md btn-primary">Simpan</button>
                    <a href="?p=pengembalian" class="btn btn-md btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>