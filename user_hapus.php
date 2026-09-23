<?php
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
    echo "<script>
            alert('Fitur ini hanya dapat diakses oleh admin!');
            window.location.href='?page=pelanggan';
          </script>";
    exit;
}
$id = $_GET['id'];
$query = mysqli_query($koneksi, "DELETE FROM user WHERE id_user=$id");
if ($query) {
     echo '<script>alert("Hapus data berhasil"); location.href="?page=user"</script>';
} else {
     echo '<script>alert("Hapus data gagal")</script>';
}
