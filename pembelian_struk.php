<?php
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM penjualan LEFT JOIN pelanggan ON pelanggan.id_pelanggan = penjualan.id_pelanggan WHERE id_penjualan=$id");
$data = mysqli_fetch_array($query);

$total = $data['total_harga'];
$diskon = $data['diskon'];
$total_bayar = $total - $diskon;
$bayar = $data['bayar'];
$kembalian = $data['kembalian'];
?>

<div class="container-fluid">
     <div class="d-print-none">
          <h1 class="mt-4">Struk Pembelian</h1>
          <ol class="breadcrumb mb-4">
               <li class="breadcrumb-item active">Struk Pembelian</li>
          </ol>
          <a href="?page=pembelian" class="btn btn-danger">Kembali</a>
          <button type="button" class="btn btn-success" onclick="window.print();">cetak</button>
          <hr>
     </div>
     <div class="row justify-content-center">
          <div class="col-12 col-md-6 col-xl-4">
               <div class="card font-monospace small">
                    <div class="card-body">
                         <div class="text-center">
                              <h5 class="mb-0">APLIKASI KASIR</h5>
                              <div>Struk Pembelian</div>
                         </div>
                         <hr class="my-2 border-dark">
                         <table class="table table-sm table-borderless mb-0">
                              <tr>
                                   <td width="90">No. Struk</td>
                                   <td width="1">:</td>
                                   <td><?php echo $data['id_penjualan']; ?></td>
                              </tr>
                              <tr>
                                   <td>Tanggal</td>
                                   <td>:</td>
                                   <td><?php echo $data['tanggal_penjualan']; ?></td>
                              </tr>
                              <tr>
                                   <td>Pelanggan</td>
                                   <td>:</td>
                                   <td><?php echo $data['nama_pelanggan']; ?></td>
                              </tr>
                              <tr>
                                   <td>Kasir</td>
                                   <td>:</td>
                                   <td><?php echo $_SESSION['user']['nama']; ?></td>
                              </tr>
                         </table>
                         <hr class="my-2 border-dark">
                         <table class="table table-sm table-borderless mb-0">
                              <?php
                              $pro = mysqli_query($koneksi, "SELECT*FROM detail_penjualan LEFT JOIN produk on produk.id_produk = detail_penjualan.id_produk WHERE id_penjualan=$id");
                              while ($produk = mysqli_fetch_array($pro)) {
                              ?>
                                   <tr>
                                        <td colspan="2"><?php echo $produk['nama_produk']; ?></td>
                                   </tr>
                                   <tr>
                                        <td><?php echo $produk['jumlah_produk']; ?> x <?php echo number_format($produk['harga'], 0, ',', '.'); ?></td>
                                        <td class="text-end"><?php echo number_format($produk['subtotal'], 0, ',', '.'); ?></td>
                                   </tr>
                              <?php
                              }
                              ?>
                         </table>
                         <hr class="my-2 border-dark">
                         <table class="table table-sm table-borderless mb-0">
                              <tr>
                                   <td>Total</td>
                                   <td class="text-end">RP. <?php echo number_format($total, 0, ',', '.'); ?></td>
                              </tr>
                              <tr>
                                   <td>Diskon</td>
                                   <td class="text-end">RP. <?php echo number_format($diskon, 0, ',', '.'); ?></td>
                              </tr>
                              <tr class="fw-bold">
                                   <td>Total Bayar</td>
                                   <td class="text-end">RP. <?php echo number_format($total_bayar, 0, ',', '.'); ?></td>
                              </tr>
                              <tr>
                                   <td>Bayar</td>
                                   <td class="text-end">RP. <?php echo number_format($bayar, 0, ',', '.'); ?></td>
                              </tr>
                              <tr>
                                   <td>Kembali</td>
                                   <td class="text-end">RP. <?php echo number_format(max($kembalian, 0), 0, ',', '.'); ?></td>
                              </tr>
                         </table>
                         <hr class="my-2 border-dark">
                         <div class="text-center">
                              <div>Terima Kasih</div>
                              <div>Atas Kunjungan Anda</div>
                         </div>
                    </div>
               </div>
          </div>
     </div>

</div>