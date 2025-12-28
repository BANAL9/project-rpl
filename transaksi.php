<?php
session_start();
if (!isset($_SESSION['level'])) { header("location:index.php"); exit(); }
include 'koneksi.php';

if (isset($_POST['proses_transaksi'])) {
    // Ambil data dan sanitasi untuk keamanan
    $pelanggan = mysqli_real_escape_string($koneksi, $_POST['pelanggan']);
    $meja      = mysqli_real_escape_string($koneksi, $_POST['meja']);
    $pelayan   = mysqli_real_escape_string($koneksi, $_POST['pelayan']); 
    
    // 1. Generate Kode Order Otomatis
    $kode_order = "ORD-" . date('Ymd') . "-" . rand(1000, 9999);

    // Validasi menu
    if (!isset($_POST['menu_pilihan']) || empty($_POST['menu_pilihan'])) {
        echo "<script>alert('Pilih minimal satu menu!'); window.location='transaksi.php';</script>";
        exit();
    }

    $menu_pilihan = $_POST['menu_pilihan']; 

    // 2. Simpan ke tabel orders
    // Kolom pelayan sekarang bisa menerima teks (Nama) setelah Foreign Key dihapus
    $query_order = mysqli_query($koneksi, "INSERT INTO orders (kode_order, pelanggan, meja, pelayan, waktu_order) 
                                          VALUES ('$kode_order', '$pelanggan', '$meja', '$pelayan', NOW())");
    
    $id_order = mysqli_insert_id($koneksi);

    if ($query_order) {
        // 3. Simpan ke detail_order & Potong Stok
        foreach ($menu_pilihan as $id_menu) {
            // Simpan detail
            mysqli_query($koneksi, "INSERT INTO detail_order (id_order, menu, jumlah) 
                                   VALUES ('$id_order', '$id_menu', 1)");
            
            // Update stok menu (menggunakan kolom 'no' sebagai Primary Key)
            mysqli_query($koneksi, "UPDATE daftar_menu SET stok = stok - 1 WHERE no = '$id_menu'");
        }
        // Berhasil: Langsung ke halaman pembayaran
        header("location:bayar.php?id=$id_order");
        exit();
    } else {
        // Jika masih error, akan tampil pesan spesifik di sini
        die("Gagal Simpan Database: " . mysqli_error($koneksi));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Baru - KULINER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <style>
        body { background: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; color: white; position: fixed; width: 230px; z-index: 100; }
        .main-content { margin-left: 230px; padding: 30px; min-height: 100vh; }
        .nav-link { color: #adb5bd; padding: 12px 20px; }
        .nav-link:hover, .nav-link.active { color: white; background: #343a40; border-radius: 8px; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); background: white; }
    </style>
</head>
<body>
    <div class="sidebar p-3">
        <h3 class="text-center mb-4 fw-bold text-warning">KULINER</h3>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="dashboard.php" class="nav-link"><i class="fas fa-home me-2"></i> Dashboard</a></li>
            <li class="nav-item mb-2"><a href="menu.php" class="nav-link"><i class="fas fa-utensils me-2"></i> Menu</a></li>
            <li class="nav-item mb-2"><a href="transaksi.php" class="nav-link active"><i class="fas fa-shopping-cart me-2"></i> Transaksi</a></li>
            <li class="nav-item mt-5"><a href="logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <h3 class="fw-bold mb-4"><i class="fas fa-cash-register text-success me-2"></i>Input Pesanan Baru</h3>
            <form method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-custom p-4 mb-4">
                            <h5 class="fw-bold mb-3 border-bottom pb-2">Info Transaksi</h5>
                            <div class="mb-3">
                                <label class="fw-bold mb-1">Nama Pelanggan</label>
                                <input type="text" name="pelanggan" class="form-control" placeholder="Nama pembeli..." required>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold mb-1">Nomor Meja</label>
                                <input type="number" name="meja" class="form-control" placeholder="00" required>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold mb-1">Pilih Pelayan</label>
                                <select name="pelayan" class="form-select" required>
                                    <option value="">-- Pilih Nama Pelayan --</option>
                                    <option value="Suryani">Suryani</option>
                                    <option value="Siti">Siti</option>
                                    <option value="Aisa">Aisa</option>
                                    <option value="Ramdan">Ramdan</option>
                                </select>
                            </div>
                            <button type="submit" name="proses_transaksi" class="btn btn-primary w-100 fw-bold py-2 shadow-sm mt-2">
                                PROSES PEMBAYARAN <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card card-custom p-4">
                            <h5 class="fw-bold mb-3 border-bottom pb-2">Pilih Menu</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="50">Pilih</th>
                                            <th>Nama Menu</th>
                                            <th>Harga</th>
                                            <th class="text-center">Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $menu = mysqli_query($koneksi, "SELECT * FROM daftar_menu WHERE stok > 0");
                                        while($m = mysqli_fetch_array($menu)){
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="menu_pilihan[]" value="<?= $m['no'] ?>" style="transform: scale(1.3);">
                                            </td>
                                            <td>
                                                <div class="fw-bold"><?= $m['nama_menu'] ?></div>
                                                <small class="text-muted"><?= $m['keterangan'] ?></small>
                                            </td>
                                            <td class="text-success fw-bold">Rp <?= number_format($m['harga'], 0, ',', '.') ?></td>
                                            <td class="text-center"><span class="badge bg-info text-dark"><?= $m['stok'] ?></span></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>