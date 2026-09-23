<?php

// Hanya admin yang boleh mengakses halaman ini
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
     echo "<script>
          alert('Halaman ini hanya dapat diakses oleh admin!');
          window.location='index.php';
     </script>";
     exit;
}

// Ambil ID user
$id = $_GET['id'];

// Ambil data user
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id'");
$data = mysqli_fetch_array($query);

// Proses perubahan level
if (isset($_POST['ubah'])) {

     $level = $_POST['level'];

     $update = mysqli_query(
          $koneksi,
          "UPDATE user SET level='$level' WHERE id_user='$id'"
     );

     if ($update) {
          echo "<script>
               alert('Level berhasil diubah!');
               window.location='?page=user';
          </script>";
     } else {
          echo "<script>
               alert('Level gagal diubah!');
          </script>";
     }
}
?>

<div class="container-fluid">
     <h1 class="mt-4">User</h1>

     <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item active">User</li>
     </ol>

     <a href="?page=user" class="btn btn-danger">Kembali</a>

     <hr>

     <form method="post">
          <table class="table table-bordered">

               <tr>
                    <td width="200">Nama</td>
                    <td width="1">:</td>
                    <td>
                         <input
                              class="form-control"
                              value="<?php echo htmlspecialchars($data['nama']); ?>"
                              type="text"
                              readonly>
                    </td>
               </tr>

               <tr>
                    <td>Username</td>
                    <td>:</td>
                    <td>
                         <input
                              class="form-control"
                              value="<?php echo htmlspecialchars($data['username']); ?>"
                              type="text"
                              readonly>
                    </td>
               </tr>

               <tr>
                    <td>Level</td>
                    <td>:</td>
                    <td>
                         <select name="level" class="form-control" required>
                              <option value="admin"
                                   <?php echo ($data['level'] == 'admin') ? 'selected' : ''; ?>>
                                   Admin
                              </option>

                              <option value="petugas"
                                   <?php echo ($data['level'] == 'petugas') ? 'selected' : ''; ?>>
                                   Petugas
                              </option>
                         </select>
                    </td>
               </tr>

               <tr>
                    <td></td>
                    <td></td>
                    <td>
                         <button type="submit" name="ubah" class="btn btn-primary">
                              Simpan
                         </button>

                         <button type="reset" class="btn btn-danger">
                              Reset
                         </button>
                    </td>
               </tr>

          </table>
     </form>

</div>