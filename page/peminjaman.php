<?php
$sql = "SELECT max(id_peminjaman) as maxKode FROM peminjaman";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_array($query);
$id_peminjaman = $data['maxKode'];

@$noUrut = (int) substr($id_peminjaman, 3, 3);
$noUrut++;

$char = "PMJ";
$kodePeminjaman = $char . sprintf("%03s", $noUrut);
?>

<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-header">
                <h4>Peminjaman</h4>
            </div>
            <div class="card-body">
                <?php
                if (isset($_POST['save'])) {
                    $id_peminjaman = $_POST['id_peminjaman'];
                    $id_pegawai = $_POST['id_pegawai'];
                    $id_inventaris = $_POST['id_inventaris'];
                    $jumlah = $_POST['jumlah'];

                    $sql_peminjaman = "INSERT INTO peminjaman SET id_peminjaman = '$id_peminjaman', id_pegawai = '$id_pegawai', status_peminjaman = '0'";

                    $query_input = mysqli_query($koneksi, $sql_peminjaman);
                    if ($query_input) {
                        $detail_pinjam = "INSERT INTO detail_pinjam SET 
                        jumlah = '$jumlah',
                        id_inventaris = '$id_inventaris',
                        id_peminjaman = '$id_peminjaman'";

                        $q_detail_pinjam = mysqli_query($koneksi, $detail_pinjam);
                        if ($q_detail_pinjam) {
                ?>
                            <script type="text/javascript">
                                window.location.href = "?p=peminjaman";
                            </script>
                <?php
                        } else {
                            echo "gagal";
                        }
                    } else {
                        echo "gagal menyimpan";
                    }
                }
                ?>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="kd_pinjam" class="form-label">Kode Peminjaman</label>
                        <input type="text" class="form-control" name="id_peminjaman" value="<?= $kodePeminjaman ?>" id="kd_pinjam" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nama_pinjam" class="form-label">Nama Peminjam</label>
                        <select name="id_pegawai" class="form-select">
                            <option selected>Nama Pegawai</option>
                            <?php
                            $sql_pegawai = "SELECT * FROM pegawai";
                            $q_pegawai = mysqli_query($koneksi, $sql_pegawai);
                            while ($pegawai = mysqli_fetch_array($q_pegawai)) {
                            ?>
                                <option value="<?= $pegawai['id_pegawai'] ?>"><?= $pegawai['nama_pegawai'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="barang" class="form-label">Pilih Barang</label>
                        <select name="id_inventaris" id="barang" class="form-select">
                            <option selected>Nama Barang</option>
                            <?php
                            $sql_inventaris = "SELECT * FROM inventaris";
                            $q_inventaris = mysqli_query($koneksi, $sql_inventaris);
                            while ($inventaris = mysqli_fetch_array($q_inventaris)) {
                            ?>
                                <option value="<?= $inventaris['id_inventaris'] ?>"><?= $inventaris['nama'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="qty" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" id="qty">
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" name="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h4>Daftar Barang</h4>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Pinjam</th>
                            <th>Tgl.Pinjam</th>
                            <th>Nama Peminjam</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Tgl.Kembali</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $hari = date('d-m-y');
                        $d_peminjaman = "SELECT *, detail_pinjam.jumlah as jml FROM detail_pinjam LEFT JOIN peminjaman ON peminjaman.id_peminjaman = detail_pinjam.id_peminjaman LEFT JOIN inventaris on inventaris.id_inventaris = detail_pinjam.id_inventaris LEFT JOIN pegawai ON pegawai.id_pegawai = peminjaman.id_pegawai";
                        $d_query = mysqli_query($koneksi, $d_peminjaman);
                        $test = mysqli_num_rows($d_query);

                        if ($test > 0) {
                            $no = 1;
                            while ($data_d = mysqli_fetch_array($d_query)) {
                        ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data_d['id_peminjaman'] ?></td>
                                    <td><?= $hari ?></td>
                                    <td><?= $data_d['nama_pegawai'] ?></td>
                                    <td><?= $data_d['nama'] ?></td>
                                    <td><?= $data_d['jml'] ?></td>
                                    <td><?= $data_d['tanggal_kembali'] ?></td>
                                    <td>
                                        <?php
                                        if ($data_d['status_peminjaman'] == '0') {
                                        ?>
                                            <div class="badge bg-danger">Konfirmasi</div>
                                        <?php
                                        } else if ($data_d['status_peminjaman'] == '1') {
                                        ?>
                                            <div class="badge bg-warning">Dipinjam</div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="badge bg-success">Dikembalikan</div>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($data_d['status_peminjaman'] == '0') {
                                        ?>
                                            <a onclick="return confirm('Apakah anda yakin?')" href="page/proses_peminjaman.php?id_peminjaman=<?= $data_d['id_peminjaman'] ?>" class="btn btn-primary btn-sm">Proses</a>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>