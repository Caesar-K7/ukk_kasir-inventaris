<?php
session_start();
$con = mysqli_connect("localhost","root","","kasir");
if (mysqli_connect_errno()) {
    echo "gagal". mysqli_connect_error();
    exit();
}
?>