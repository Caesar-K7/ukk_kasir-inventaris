<div class="container-fluid">
                          <h1 class="mt-4">Pembelian</h1>
                          <ol class="breadcrumb mb-4">
                               <li class="breadcrumb-item active">Pembelian</li>
                          </ol>
                          <a href="?page=pembelian_tambah" class="btn btn-primary"> + Tambah Pembelian </a>
                          <table class="table table-bordered">
                            <hr>
                            <tr>
                                <th>Tanggal Pembelian</th>
                                <th>Pelanggan</th>
                                <th>Total Harga</th>
                                <th>Aksi</th>
                            </tr>

                          <?php
                          $cari = isset($_GET['cari']) ?
                          $_GET['cari'] : '';
                              $query = mysqli_query($koneksi, "SELECT * FROM penjualan LEFT JOIN pelanggan ON pelanggan.id_pelanggan = penjualan.id_pelanggan WHERE nama_pelanggan LIKE '%$cari%'");
                              while($data = mysqli_fetch_array($query)){
                              ?>
                            <tr>
                                <td><?php echo $data['tanggal_penjualan']; ?></td>
                                <td><?php echo $data['nama_pelanggan']; ?></td>
                                <td><?php echo $data['total_harga']; ?></td>
                                <td>
                                    <a href="?page=pembelian_detail&&id=<?php echo $data['id_penjualan']; ?>" class="btn btn-secondary">Detail</a>
                                    <a href="?page=pembelian_hapus&&id=<?php echo $data['id_penjualan']; ?>" class="btn btn-danger">Hapus</a>

                                </td>
                            </tr>
                          <?php
                          }
                        ?>
                        
                          </table>
</div>
