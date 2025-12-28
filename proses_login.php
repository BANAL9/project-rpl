<?php
session_start();
include 'koneksi.php';

// Menangkap data dari form login
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = md5($_POST['password']); 

// Query mencocokkan username dan password MD5
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($query);

if($cek > 0){
    $data = mysqli_fetch_assoc($query);
    $_SESSION['username'] = $data['username'];
    $_SESSION['nama'] = $data['nama']; // Session untuk menampilkan "Selamat Datang, Alfan"
    $_SESSION['level'] = $data['level'];
    header("location:dashboard.php");
} else {
    echo "<script>alert('Username atau Password Salah!'); window.location='index.php';</script>";
}
?>