<?php
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
    echo "<script>
            alert('Halaman ini hanya dapat diakses oleh admin!');
            window.location.href='?page=pembelian';
          </script>";
    exit;
}

// aturan diskon (readonly)
$min_diskon = 100000;
$diskon_persen = 10;

$error = '';

if (isset($_POST['id_pelanggan'])) {
     $id_pelanggan = $_POST['id_pelanggan'];
     $produk = $_POST['produk'];
     $bayar = (int)$_POST['uang_bayar'];
     $total = 0;
     $tanggal = date('Y/m/d');

     // hitung total dulu
     foreach ($produk as $key => $val) {
          $pr = mysqli_fetch_array(mysqli_query($koneksi, "SELECT*FROM produk where id_produk=$key"));
          if ($val > 0) {
               $total += $val * $pr['harga'];
          }
     }

     $diskon = ($total >= $min_diskon) ? $total * $diskon_persen / 100 : 0;
     $total_bayar = $total - $diskon;
     $kembalian = $bayar - $total_bayar;

     if ($total <= 0) {
          $error = 'Pilih minimal satu produk!';
     } elseif ($bayar < $total_bayar) {
          $error = 'Uang yang dibayar kurang RP. ' . number_format($total_bayar - $bayar, 0, ',', '.') . ' (Total Bayar : RP. ' . number_format($total_bayar, 0, ',', '.') . ')';
     } else {
          $query = mysqli_query($koneksi, "INSERT INTO penjualan(tanggal_penjualan,id_pelanggan) values('$tanggal','$id_pelanggan')");

          $idTerakhir = mysqli_fetch_array(mysqli_query($koneksi, "SELECT*FROM penjualan ORDER BY id_penjualan DESC"));
          $id_penjualan = $idTerakhir['id_penjualan'];

          foreach ($produk as $key => $val) {
               $pr = mysqli_fetch_array(mysqli_query($koneksi, "SELECT*FROM produk where id_produk=$key"));

               if ($val > 0) {
                    $sub = $val * $pr['harga'];
                    $query = mysqli_query($koneksi, "INSERT INTO detail_penjualan(id_penjualan,id_produk,jumlah_produk,subtotal) values('$id_penjualan', '$key', '$val', '$sub')");

                    $updateProduk = mysqli_query($koneksi, "UPDATE produk set stok=stok-$val WHERE id_produk=$key");
               }
          }

          $query = mysqli_query($koneksi, "UPDATE penjualan SET total_harga=$total, diskon=$diskon, bayar=$bayar, kembalian=$kembalian WHERE id_penjualan=$id_penjualan");

          if ($query) {
               echo '<script>alert("Tambah data berhasil"); location.href="?page=pembelian"</script>';
          } else {
               echo '<script>alert("Tambah data gagal")</script>';
          }
     }
}
?>
<div class="container-fluid">
     <h1 class="mt-4">Pembelian</h1>
     <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item active">Pembelian</li>
     </ol>
     <a href="?page=pembelian" class="btn btn-danger">Kembali</a>
     <hr>

     <?php if ($error != '') { ?>
          <div class="alert alert-danger"><?php echo $error; ?></div>
     <?php } ?>

     <form method="post">
          <table class="table table-bordered">
               <tr>
                    <td width="200">Nama Pelanggan</td>
                    <td width="1">:</td>
                    <td>
                         <select class="form-control form-select" name="id_pelanggan">
                              <?php
                              $p = mysqli_query($koneksi, "SELECT*FROM pelanggan");
                              while ($pel = mysqli_fetch_array($p)) {
                              ?>
                                   <option value="<?php echo $pel['id_pelanggan']; ?>"><?php echo $pel['nama_pelanggan']; ?></option>
                              <?php
                              }
                              ?>
                         </select>
                    </td>
               </tr>
               <?php
               $pro = mysqli_query($koneksi, "SELECT*FROM produk");
               while ($produk = mysqli_fetch_array($pro)) {
               ?>
                    <tr>
                         <td><?php echo $produk['nama_produk'] . ' (stok : ' . $produk['stok'] . ')'; ?></td>
                         <td>:</td>
                         <td>
                              <input class="form-control" type="number"
                                   step="0" value="0" max="<?php echo $produk['stok']; ?>" name="produk[<?php echo $produk['id_produk']; ?>]">
                         </td>
                    </tr>
               <?php
               }
               ?>
               </table>
               <hr>
               <table class="table table-bordered">
               <tr>
                    <td>Diskon</td>
                    <td>:</td>
                    <td>
                         <input class="form-control" type="text" value="<?php echo $diskon_persen; ?>% (jika total belanja minimal RP. <?php echo number_format($min_diskon, 0, ',', '.'); ?>)" readonly>
                    </td>
               </tr>
               <tr>
                    <td>Uang Dibayar</td>
                    <td>:</td>
                    <td>
                         <input class="form-control" type="number" step="0" min="0" name="uang_bayar" required>
                    </td>
               </tr>
               <tr>
                    <td>Kembalian</td>
                    <td>:</td>
                    <td>
                         <input class="form-control" type="text" value="Dihitung otomatis setelah disimpan" readonly>
                    </td>
               </tr>

               <tr>
                    <td></td>
                    <td></td>
                    <td>
                         <button type="submit" class="btn btn-primary">Simpan</button>
                         <button type="reset" class="btn btn-danger">Reset</button>
                    </td>
               </tr>
          </table>
     </form>

</div>