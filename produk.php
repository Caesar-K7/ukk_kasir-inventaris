<div class="container-fluid">
  <h1 class="mt-4">Produk</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Produk</li>
  </ol>
  <a href="?page=produk_tambah" class="btn btn-primary"> + Tambah Data </a>
  <table class="table table-bordered">
    <hr>
    <tr>
      <th>Nama Produk</th>
      <th>Harga</th>
      <th>stok</th>
      <th>Aksi</th>
    </tr>

    <?php
    $cari = isset($_GET['cari']) ?
      $_GET['cari'] : '';
    $query = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama_produk LIKE '%$cari%'");
    while ($data = mysqli_fetch_array($query)) {
    ?>
      <tr>
        <td><?php echo $data['nama_produk']; ?></td>
        <td>RP. <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
        <td><?php echo $data['stok']; ?></td>
        <td>
          <?php if ($_SESSION['level'] == 'admin') { ?>
            <a href="?page=produk_ubah&&id=<?php echo $data['id_produk']; ?>" class="btn btn-secondary">Ubah</a>
            <a href="?page=produk_hapus&&id=<?php echo $data['id_produk']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin Mengahpus data ini?');">Hapus</a>
          <?php } ?>
        </td>
      </tr>
    <?php
    }
    ?>

  </table>
</div>