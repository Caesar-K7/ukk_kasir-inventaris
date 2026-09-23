<?php
// Cek akses admin
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
    echo "<script>
            alert('Halaman ini hanya dapat diakses oleh admin!');
            window.location.href='index.php';
          </script>";
    exit;
}
?>

<div class="container-fluid">
    <h1 class="mt-4">User</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">User</li>
    </ol>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Alamat</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM user");

            while ($data = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td><?php echo $data['id_user']; ?></td>

                    <td>
                        <?php echo ($data['nama']); ?>
                    </td>

                    <td>
                        <?php echo ($data['username']); ?>
                    </td>

                    <td>
                        <?php echo ($data['alamat']); ?>
                    </td>

                    <td>
                        <?php echo $data['level']; ?>
                    </td>

                    <td>
                        <a href="?page=user_edit&id=<?php echo $data['id_user']; ?>"
                            class="btn btn-secondary">
                            Ubah Level
                        </a>

                        <a href="?page=user_hapus&id=<?php echo $data['id_user']; ?>"
                            class="btn btn-danger"
                            onclick="return confirm('Yakin ingin menghapus user ini?');">
                            Hapus
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>