<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Daftar Barang Yang Dipinjam
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Peminjaman</th>
                            <th>Tanggal Pinjam</th>
                            <th>Nama Peminjam</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $hari = date('d-m-y');
                        $d_peminjaman = "SELECT *, detail_pinjam.jumlah as jml FROM detail_pinjam LEFT JOIN peminjaman ON peminjaman.id_peminjaman = detail_pinjam.id_peminjaman LEFT JOIN inventaris on inventaris.id_inventaris = detail_pinjam.id_inventaris LEFT JOIN pegawai ON pegawai.id_pegawai = peminjaman.id_pegawai WHERE peminjaman.status_peminjaman = '1'";
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
                                        <a href="?p=detail_pengembalian&id_peminjaman=<?= $data_d['id_peminjaman'] ?>" class="btn btn-sm btn-primary">Proses</a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="9" class="text-centerp">Tidak Ada Data</td>
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