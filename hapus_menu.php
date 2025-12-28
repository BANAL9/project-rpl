<?php
session_start();
// Memastikan hanya pengguna yang sudah login yang bisa mengakses
if (!isset($_SESSION['level'])) { 
    header("location:index.php"); 
    exit(); 
}

include 'koneksi.php'; // Menghubungkan ke database db_kuliner

// Mengambil ID (no) menu yang akan dihapus dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Perintah SQL untuk menghapus data berdasarkan kolom 'no'
    $query = mysqli_query($koneksi, "DELETE FROM daftar_menu WHERE no = '$id'");

    if ($query) {
        // Jika berhasil, munculkan pesan dan kembali ke halaman menu
        echo "<script>
                alert('Menu berhasil dihapus!');
                window.location='menu.php';
              </script>";
    } else {
        // Jika gagal, tampilkan pesan error dari MySQL
        echo "<script>
                alert('Gagal menghapus menu: " . mysqli_error($koneksi) . "');
                window.location='menu.php';
              </script>";
    }
} else {
    // Jika diakses tanpa ID, arahkan kembali ke menu.php
    header("location:menu.php");
}
?>