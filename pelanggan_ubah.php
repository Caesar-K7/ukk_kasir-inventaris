<?php $id = $_GET["id"]; 
if (isset($_POST["nama_pelanggan"])) { 
    $nama = $_POST["nama_pelanggan"]; 
    $alamat = $_POST["alamat"]; 
    $no_telepon = $_POST["no_telepon"]; $query = mysqli_query( $con, "UPDATE pelanggan SET nama_pelanggan='$nama', alamat='$alamat', no_telepon='$no_telepon' WHERE id_pelanggan='$id'" ) or die(mysqli_error($con)); if ($query) { echo '<script> alert("Berhasil Mengubah Data"); location.href="?page=pelanggan"; </script>'; } else { echo '<script> alert("Gagal Mengubah Data"); </script>'; } } $query = mysqli_query( $con, "SELECT * FROM pelanggan WHERE id_pelanggan='$id'" ) or die(mysqli_error($con)); $data = mysqli_fetch_array($query); ?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Pelanggan</h1>
            <ul class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Pelanggan</li>
            </ul>
            <a href="?page=pelanggan" class="btn btn-primary">Kembali</a>
        <hr>
        <form method="post">
            <table class="table">
                <tr>
                    <td width="200">Nama Pelanggan</td>
                    <td width="1">:</td>
                    <td><input type="text" class="form-control" name="nama_pelanggan" value="<?php echo $data['nama_pelanggan']; ?>"></td>
                </tr>
                <tr>
                    <td width="200">Alamat</td>
                    <td width="1">:</td>
                    <td><textarea rows="5" class="form-control" name="alamat" ><?php echo $data['alamat']; ?></textarea></td>
                </tr>
                <tr>
                    <td width="200">Nomor Telepon</td>
                    <td width="1">:</td>
                    <td><input type="text" step="0" class="form-control" name="no_telepon" value="<?php echo $data['no_telepon']; ?>"></td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</main>