<?php
$id_inventaris = $_GET['id_inventaris'];
if (empty($id_inventaris)) {
?>
    <script type="text/javascript">
        window.location.href = "?p=list_barang";
    </script>
<?php
}
$sql = "SELECT *, inventaris.keterangan as ket FROM inventaris LEFT JOIN ruang ON ruang.id_ruang = inventaris.id_ruang LEFT JOIN jenis ON jenis.id_jenis = inventaris.id_jenis
    WHERE id_inventaris = '$id_inventaris'";
$query = mysqli_query($koneksi, $sql);
$test = mysqli_num_rows($query);

if ($test > 0) {
    $data = mysqli_fetch_array($query);
} else {
    $data = null;
}

?>

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit Inventaris</div>
            </div>
            <div class="card-body">
                <?php
                if (isset($_POST['save'])) {
                    $kode_inventaris = $_POST['kode_inventaris'];
                    $nama = $_POST['nama'];
                    $kondisi = $_POST['kondisi'];
                    $jumlah = $_POST['jumlah'];
                    $id_jenis = $_POST['id_jenis'];
                    $id_ruang = $_POST['id_ruang'];
                    $ket = $_POST['ket'];

                    $sql_update = "UPDATE inventaris SET 
                    kode_inventaris='$kode_inventaris',
                    nama='$nama', kondisi='$kondisi',
                    jumlah='$jumlah', 
                    id_jenis='$id_jenis', 
                    id_ruang='$id_ruang', 
                    keterangan='$ket' WHERE id_inventaris = '$id_inventaris'";

                    $q_update = mysqli_query($koneksi, $sql_update);
                    if ($q_update) {
                ?>
                        <script type="text/javascript">
                            window.location.href = "?p=list_barang";
                        </script>
                    <?php
                    } else {

                    ?>
                        <div class="text-center alert alert-danger d-flex align-items-center" role="alert">
                            Barang Gagal Diupdate
                        </div>
                <?php
                    }
                }
                ?>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="kd_inventaris" class="form-label">Kode Inventaris</label>
                        <input type="text" class="form-control" name="kode_inventaris" id="kd_inventaris" value="<?= $data['kode_inventaris'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nm_inventaris" class="form-label">Nama Inventaris</label>
                        <input type="text" class="form-control" name="nama" id="nm_inventaris" value="<?= $data['nama'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="barang" class="form-label">Kondisi</label>
                        <select class="form-select" name="kondisi" aria-label="">
                            <option name="kondisi" value="<?= $data['kondisi'] ?>"> <?= $data['kondisi'] ?> </option>
                            <option name="kondisi" value="Baik">Baik</option>
                            <option name="kondisi" value="Buruk">Buruk</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="qty" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" id="qty" value="<?= $data['jumlah'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis Inventaris</label>
                        <select name="id_jenis" id="jenis" class="form-select">
                            <option value="<?= $data['id_jenis'] ?>"> <?= $data['nama_jenis'] ?> </option>
                            <?php
                            $sql_jenis = "SELECT * FROM jenis";
                            $q_jenis = mysqli_query($koneksi, $sql_jenis);
                            while ($jenis = mysqli_fetch_array($q_jenis)) {
                            ?>
                                <option value="<?= $jenis['id_jenis'] ?>"><?= $jenis['nama_jenis'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ruang" class="form-label">Nama Ruang</label>
                        <select name="id_ruang" id="ruang" class="form-select">
                            <option value="<?= $data['id_ruang'] ?>"> <?= $data['nama_ruang'] ?> </option>
                            <?php
                            $sql_ruang = "SELECT * FROM ruang";
                            $q_ruang = mysqli_query($koneksi, $sql_ruang);
                            while ($ruang = mysqli_fetch_array($q_ruang)) {
                            ?>
                                <option value="<?= $ruang['id_ruang'] ?>"><?= $ruang['nama_ruang'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" name="ket" id="keterangan" value="<?= $data['ket'] ?>"><?= $data['ket'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <button class="button btn btn-primary" name="save" type="submit">Save</button>
                        <a href="?p=list_barang" class="btn btn-info">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>