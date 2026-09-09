                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Pelanggan</h1>
                        <ul class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Pelanggan</li>
                        </ul>
                    <a href="?page=pelanggan_tambah" class="btn btn-primary">+ Tambah Data</a>
                    <hr>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>No Telepon</th>
                            <th>Aksi</th>
                        </tr>

                        <?php 
                        $query = mysqli_query($con,"SELECT*FROM pelanggan") or die(mysqli_error($con));
                        while ($row = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?php echo $row['nama_pelanggan'] ?></td>
                                <td><?php echo $row['alamat'] ?></td>
                                <td><?php echo $row['no_telepon'] ?></td>
                                <td>
                                    <a href="?page=pelanggan_ubah&&id=<?php echo $row['id_pelanggan'] ?>"    class="btn btn-secondary">Edit</a>
                                    <a href="?page=pelanggan_hapus&&id=<?php echo $row['id_pelanggan'] ?>"    class="btn btn-danger">Hapus</a>

                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    </div>
                </main>