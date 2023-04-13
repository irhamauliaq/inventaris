<div class="listbarang_page">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h4>Daftar Peminjaman</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="tambah_barang d-flex justify-content-between mb-2">
                <a href="?p=tambah_barang" class="btn btn-md btn-primary mb-2">Tambah Barang</a>
                <form class="d-flex" role="search" method="get">
                    <input type="hidden" name="p" value="list_barang">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
            </div>
            <table id="ngecheat" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Inventaris</th>
                        <th>Nama Barang</th>
                        <th>Kondisi</th>
                        <th>Jumlah</th>
                        <th>Ruang</th>
                        <th>Tanggal Register</th>
                        <th>Keterangan</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    @$search = $_GET['search'];
                    $q_search = "";
                    if (!empty($search)) {
                        $q_search .= "and nama like '%" . $search . "%'";
                    }

                    $pembagian = 5;
                    $page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                    $mulai = $page > 1 ? $page * $pembagian - $pembagian : 0;

                    $sql = "SELECT *, inventaris.keterangan as ket FROM inventaris LEFT JOIN ruang ON  ruang.id_ruang = inventaris.id_ruang WHERE 1=1 $q_search LIMIT $mulai, $pembagian";
                    $query = mysqli_query($koneksi, $sql);
                    $test = mysqli_num_rows($query);
                    // echo $test;

                    // mencari total halaman
                    $sql_total = "SELECT * FROM inventaris";
                    $q_total = mysqli_query($koneksi, $sql_total);
                    $total = mysqli_num_rows($q_total);

                    $jumlahHalaman = ceil($total / $pembagian);

                    if ($test > 0) {
                        $no = $mulai + 1;
                        while ($data = mysqli_fetch_array($query)) {
                            $tgl = $data['tanggal_register'];
                    ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data['kode_inventaris'] ?></td>
                                <td><?= $data['nama'] ?></td>
                                <td><?= $data['kondisi'] ?></td>
                                <td><?= $data['jumlah'] ?></td>
                                <td><?= $data['nama_ruang'] ?></td>
                                <td><?= date("d-m-y", strtotime($tgl)) ?></td>
                                <td><?= $data['ket'] ?></td>
                                <td>
                                    <a onclick="return confirm('Apakah anda yakin untuk menghapusnya?')" href="page/hapus_barang.php?id_inventaris=<?= $data['id_inventaris'] ?>" class="btn btn-sm btn-danger me-2">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                    <a href="?p=edit_barang&id_inventaris=<?= $data['id_inventaris'] ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="pagination_menu justify-content-between d-flex">
                <p>Jumlah : <?= $total ?></p>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="?p=list_barang&halaman=<?= $page - 1 ?>">Previous</a></li>
                        <?php
                        for ($i = 1; $i <= $jumlahHalaman; $i++) {
                        ?>
                            <li class="page-item">
                                <a href="?p=list_barang&halaman=<?= $i ?>" class="page-link"><?= $i ?></a>
                            </li>
                        <?php
                        }
                        ?>
                        <li class="page-item"><a class="page-link" href="?p=list_barang&halaman=<?= $page + 1 ?>">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>