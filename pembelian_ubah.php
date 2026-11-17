<?php
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
    echo "<script>
            alert('Fitur ini hanya dapat diakses oleh admin!');
            window.location.href='?page=pembelian';
          </script>";
    exit;
}
$id = $_GET['id'];

// aturan diskon (readonly)
$min_diskon = 100000;
$diskon_persen = 10;

$error = '';

if (isset($_POST['id_pelanggan'])) {
     $id_pelanggan = $_POST['id_pelanggan'];
     $produk = $_POST['produk'];
     $bayar = (int)$_POST['uang_bayar'];
     $total = 0;

     // ambil jumlah lama tiap produk
     $lama = array();
     $dl = mysqli_query($koneksi, "SELECT*FROM detail_penjualan WHERE id_penjualan=$id");
     while ($d = mysqli_fetch_array($dl)) {
          $lama[$d['id_produk']] = $d['jumlah_produk'];
     }

     // hitung total dulu & cek stok
     foreach ($produk as $key => $val) {
          $pr = mysqli_fetch_array(mysqli_query($koneksi, "SELECT*FROM produk where id_produk=$key"));
          $stok_tersedia = $pr['stok'] + (isset($lama[$key]) ? $lama[$key] : 0);

          if ($val > $stok_tersedia) {
               $error = 'Jumlah ' . $pr['nama_produk'] . ' melebihi stok (stok : ' . $stok_tersedia . ')';
               break;
          }
          if ($val > 0) {
               $total += $val * $pr['harga'];
          }
     }

     $diskon = ($total >= $min_diskon) ? $total * $diskon_persen / 100 : 0;
     $total_bayar = $total - $diskon;
     $kembalian = $bayar - $total_bayar;

     if ($error == '' && $total <= 0) {
          $error = 'Pilih minimal satu produk!';
     } elseif ($error == '' && $bayar < $total_bayar) {
          $error = 'Uang yang dibayar kurang RP. ' . number_format($total_bayar - $bayar, 0, ',', '.') . ' (Total Bayar : RP. ' . number_format($total_bayar, 0, ',', '.') . ')';
     }

     if ($error == '') {
          // kembalikan stok lama
          foreach ($lama as $key => $val) {
               $updateProduk = mysqli_query($koneksi, "UPDATE produk set stok=stok+$val WHERE id_produk=$key");
          }
          $query = mysqli_query($koneksi, "DELETE FROM detail_penjualan WHERE id_penjualan=$id");

          // simpan detail baru
          foreach ($produk as $key => $val) {
               $pr = mysqli_fetch_array(mysqli_query($koneksi, "SELECT*FROM produk where id_produk=$key"));

               if ($val > 0) {
                    $sub = $val * $pr['harga'];
                    $query = mysqli_query($koneksi, "INSERT INTO detail_penjualan(id_penjualan,id_produk,jumlah_produk,subtotal) values('$id', '$key', '$val', '$sub')");

                    $updateProduk = mysqli_query($koneksi, "UPDATE produk set stok=stok-$val WHERE id_produk=$key");
               }
          }

          $query = mysqli_query($koneksi, "UPDATE penjualan SET id_pelanggan='$id_pelanggan', total_harga=$total, diskon=$diskon, bayar=$bayar, kembalian=$kembalian WHERE id_penjualan=$id");

          if ($query) {
               echo '<script>alert("Ubah data berhasil"); location.href="?page=pembelian"</script>';
          } else {
               echo '<script>alert("Ubah data gagal")</script>';
          }
     }
}

$query = mysqli_query($koneksi, "SELECT*FROM penjualan WHERE id_penjualan=$id");
$data = mysqli_fetch_array($query);

?>
<div class="container-fluid">
     <h1 class="mt-4">Pembelian</h1>
     <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item active">Ubah Pembelian</li>
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
                                   <option value="<?php echo $pel['id_pelanggan']; ?>" <?php if ($pel['id_pelanggan'] == $data['id_pelanggan']) { echo 'selected'; } ?>><?php echo $pel['nama_pelanggan']; ?></option>
                              <?php
                              }
                              ?>
                         </select>
                    </td>
               </tr>
               <?php
               $pro = mysqli_query($koneksi, "SELECT*FROM produk");
               while ($produk = mysqli_fetch_array($pro)) {
                    $dj = mysqli_fetch_array(mysqli_query($koneksi, "SELECT*FROM detail_penjualan WHERE id_penjualan=$id AND id_produk=" . $produk['id_produk']));
                    $jumlah_lama = $dj ? $dj['jumlah_produk'] : 0;
                    $stok_tersedia = $produk['stok'] + $jumlah_lama;
               ?>
                    <tr>
                         <td><?php echo $produk['nama_produk'] . ' (stok : ' . $stok_tersedia . ')'; ?></td>
                         <td>:</td>
                         <td>
                              <input class="form-control" type="number"
                                   step="0" value="<?php echo $jumlah_lama; ?>" min="0" max="<?php echo $stok_tersedia; ?>" name="produk[<?php echo $produk['id_produk']; ?>]">
                         </td>
                    </tr>
               <?php
               }
               ?>
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
                         <input class="form-control" type="number" step="0" min="0" name="uang_bayar" value="<?php echo $data['bayar']; ?>" required>
                    </td>
               </tr>
               <tr>
                    <td>Kembalian</td>
                    <td>:</td>
                    <td>
                         <input class="form-control" type="text" value="RP. <?php echo number_format($data['kembalian'], 0, ',', '.'); ?> (dihitung ulang setelah disimpan)" readonly>
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