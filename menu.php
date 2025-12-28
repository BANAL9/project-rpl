<?php 
session_start();
if (!isset($_SESSION['level'])) { header("location:index.php"); exit(); }
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Menu - KULINER</title>
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
            <li class="nav-item mb-2"><a href="dashboard.php" class="nav-link"><i class="fas fa-home me-2"></i> Dashboard</a></li>
            <li class="nav-item mb-2"><a href="menu.php" class="nav-link active"><i class="fas fa-utensils me-2"></i> Menu</a></li>
            <li class="nav-item mb-2"><a href="transaksi.php" class="nav-link"><i class="fas fa-shopping-cart me-2"></i> Transaksi</a></li>
            <?php if($_SESSION['level'] == 'Admin' || $_SESSION['level'] == '1'): ?>
            <li class="nav-item mb-2"><a href="laporan.php" class="nav-link"><i class="fas fa-file-invoice-dollar me-2"></i> Laporan</a></li>
            <?php endif; ?>
            <li class="nav-item mt-5"><a href="logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Daftar Menu Kuliner</h2>
            <a href="tambah_menu.php" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Tambah Menu
            </a>
        </div>

        <div class="card border-0 shadow-sm p-4">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Menu</th>
                        <th>Keterangan</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = mysqli_query($koneksi, "SELECT daftar_menu.*, kategori.kategori_menu 
                                                 FROM daftar_menu 
                                                 LEFT JOIN kategori ON daftar_menu.kategori = kategori.id_kategori");
                    $no = 1;
                    while($d = mysqli_fetch_array($sql)){
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><span class="fw-bold"><?= $d['nama_menu']; ?></span></td>
                        <td><?= $d['keterangan']; ?></td>
                        <td>Rp <?= number_format($d['harga'], 0, ',', '.'); ?></td>
                        <td>
                            <?php if($d['stok'] <= 5): ?>
                                <span class="badge bg-danger">Sisa <?= $d['stok']; ?></span>
                            <?php else: ?>
                                <span class="badge bg-success"><?= $d['stok']; ?></span>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge bg-info text-dark"><?= $d['kategori_menu']; ?></span></td>
                        <td class="text-center">
                            <a href="edit_menu.php?id=<?= $d['no']; ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <a href="hapus_menu.php?id=<?= $d['no']; ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>