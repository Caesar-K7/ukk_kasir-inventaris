<?php
include 'koneksi.php';

if (isset($_POST['username'], $_POST['password'])) {

    $nama = $_POST['nama'];
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);
    $alamat = $_POST['alamat'];
    $level = 'petugas';

    $insert = mysqli_query(
        $koneksi,
        "INSERT INTO user(nama,username,password,alamat,level) VALUES ('$nama','$username','$password','$alamat','$level')
         "
    ) or die(mysqli_error($koneksi));

    if ($insert) {
       echo '<script>
                alert("Registrasi Berhasil");
                window.location.href = "index.php";
              </script>';
    } else {

        echo '<script>
                alert("Registrasi Gagal!");
              </script>';
    }

}
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-floating mb-3 form-group">
                                                <input class="form-control" id="nama" name="nama" type="text" placeholder="Masukan Nama Lengkap" required/>
                                                <label for="nama">Nama</label>
                                            </div>
                                            <div class="form-floating mb-3 form-group">
                                                <input class="form-control" id="username" name="username" type="text" placeholder="Masukan username" required/>
                                                <label for="username">Username</label>
                                            </div>
                                            <div class="form-floating mb-3 form-group">
                                                <input class="form-control" id="password" name="password" type="password" placeholder="Masukan Password" required/>
                                                <label for="password">Password</label>
                                            </div>
                                            <div class="form-floating mb-3 form-group" >
                                                <input class="form-control" id="alamat" name="alamat" type="text" placeholder="Masukan alamat" required/>
                                                <label for="alamat">Alamat</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary w-100" >Register</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.php">Sudah punya akun? Login!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
