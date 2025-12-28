<?php
session_start();
// Cek apakah pengguna sudah login
if (!isset($_SESSION['level'])) { 
    header("location:index.php"); 
    exit(); 
}
include 'koneksi.php'; // Hubungkan ke db_kuliner
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - KULINER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <style>
        .sidebar { min-height: 100vh; background: #212529; color: white; position: fixed; width: 230px; }
        .main-content { margin-left: 230px; padding: 30px; background: #f8f9fa; min-height: 100vh; }
        .nav-link { color: #adb5bd; padding: 12px 20px; }
        .nav-link:hover, .nav-link.active { color: white; background: #343a40; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="sidebar p-3">
        <h3 class="text-center mb-4 fw-bold text-warning">KULINER</h3>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="dashboard.php" class="nav-link active"><i class="fas fa-home me-2"></i> Dashboard</a>
            </li>
            <li class="nav-item mb-2">
                <a href="menu.php" class="nav-link"><i class="fas fa-utensils me-2"></i> Menu</a>
            </li>
            <li class="nav-item mb-2">
                <a href="transaksi.php" class="nav-link"><i class="fas fa-shopping-cart me-2"></i> Transaksi</a>
            </li>
            <?php if($_SESSION['level'] == 'Admin' || $_SESSION['level'] == '1'): ?>
            <li class="nav-item mb-2">
                <a href="laporan.php" class="nav-link"><i class="fas fa-file-invoice-dollar me-2"></i> Laporan</a>
            </li>
            <?php endif; ?>
            <li class="nav-item mt-5">
                <a href="logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <h2 class="fw-bold mb-4">Selamat Datang, <?= $_SESSION['nama'] ?></h2>
        <p class="text-muted">Anda masuk sebagai: <strong><?= $_SESSION['level'] ?></strong></p>
        
        <div class="row g-4 text-center mt-2">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4">
                    <i class="fas fa-utensils fa-3x text-warning mb-3"></i>
                    <h5 class="text-muted">Total Menu</h5>
                    <h3 class="fw-bold"><?= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM daftar_menu")) ?></h3>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4">
                    <i class="fas fa-money-bill-wave fa-3x text-success mb-3"></i>
                    <h5 class="text-muted">Total Transaksi</h5>
                    <h3 class="fw-bold"><?= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pembayaran")) ?></h3>
                </div>
            </div>
        </div>
    </div>
</body>
</html>