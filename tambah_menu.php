<?php
session_start();
if (!isset($_SESSION['level'])) { header("location:index.php"); exit(); }
include 'koneksi.php';

// Proses Simpan Data
if (isset($_POST['simpan'])) {
    $nama_menu  = mysqli_real_escape_string($koneksi, $_POST['nama_menu']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $harga      = $_POST['harga'];
    $stok       = $_POST['stok'];
    $kategori   = $_POST['kategori'];

    $query = mysqli_query($koneksi, "INSERT INTO daftar_menu (nama_menu, keterangan, harga, stok, kategori) 
                                     VALUES ('$nama_menu', '$keterangan', '$harga', '$stok', '$kategori')");

    if ($query) {
        echo "<script>alert('Menu Berhasil Ditambahkan!'); window.location='menu.php';</script>";
    } else {
        echo "<script>alert('Gagal Menambah Menu: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Menu - KULINER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <style>
        .sidebar { min-height: 100vh; background: #212529; color: white; position: fixed; width: 230px; }
        .main-content { margin-left: 230px; padding: 30px; background: #f8f9fa; min-height: 100vh; }
        .nav-link { color: #adb5bd; padding: 12px 20px; }
        .nav-link:hover { color: white; background: #343a40; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="sidebar p-3">
        <h3 class="text-center mb-4 fw-bold text-warning">KULINER</h3>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="dashboard.php" class="nav-link"><i class="fas fa-home me-2"></i> Dashboard</a></li>
            <li class="nav-item mb-2"><a href="menu.php" class="nav-link"><i class="fas fa-utensils me-2"></i> Menu</a></li>
            <li class="nav-item mb-2"><a href="transaksi.php" class="nav-link"><i class="fas fa-shopping-cart me-2"></i> Transaksi</a></li>
            <?php if($_SESSION['level'] == 'Admin'): ?>
            <li class="nav-item mb-2"><a href="laporan.php" class="nav-link"><i class="fas fa-file-invoice-dollar me-2"></i> Laporan</a></li>
            <?php endif; ?>
            <li class="nav-item mt-5"><a href="logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <h4 class="fw-bold mb-4"><i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Menu Baru</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Menu</label>
                        <input type="text" name="nama_menu" class="form-control" placeholder="Contoh: Mie Goreng Spesial" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan / Deskripsi</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Pedas sedang dengan telur"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" placeholder="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stok Awal</label>
                            <input type="number" name="stok" class="form-control" placeholder="0" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Kategori Menu</label>
                        <select name="kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php
                            $cat = mysqli_query($koneksi, "SELECT * FROM kategori");
                            while($c = mysqli_fetch_array($cat)){
                                echo "<option value='{$c['id_kategori']}'>{$c['kategori_menu']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" name="simpan" class="btn btn-primary px-4 fw-bold">SIMPAN MENU</button>
                        <a href="menu.php" class="btn btn-secondary px-4">BATAL</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>