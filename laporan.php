<?php
session_start();
// Pastikan koneksi ke database benar
include 'koneksi.php';

// Cek login jika perlu
if (!isset($_SESSION['level'])) { header("location:index.php"); exit(); }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran - KULINER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <style>
        body { background: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; color: white; position: fixed; width: 230px; z-index: 100; }
        .main-content { margin-left: 230px; padding: 40px; }
        .card-report { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: white; }
        .table thead { background-color: #f1f3f5; }
        @media print { 
            .no-print { display: none !important; } 
            .main-content { margin-left: 0; padding: 0; }
            .card-report { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body>

    <div class="sidebar p-3 no-print">
        <h3 class="text-center mb-4 fw-bold text-warning">KULINER</h3>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="dashboard.php" class="nav-link text-white"><i class="fas fa-home me-2"></i> Dashboard</a></li>
            <li class="nav-item mb-2"><a href="transaksi.php" class="nav-link text-white"><i class="fas fa-cash-register me-2"></i> Transaksi</a></li>
            <li class="nav-item mb-2"><a href="laporan.php" class="nav-link text-warning active fw-bold"><i class="fas fa-file-invoice-dollar me-2"></i> Laporan</a></li>
            <li class="nav-item mt-5"><a href="logout.php" class="nav-link text-danger small"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-0">Laporan Pendapatan</h3>
                    <p class="text-muted">Rekapitulasi semua transaksi yang sudah dibayar</p>
                </div>
                <div class="no-print">
                    <button onclick="window.print()" class="btn btn-dark shadow-sm">
                        <i class="fas fa-print me-2"></i> CETAK LAPORAN
                    </button>
                </div>
            </div>

            <div class="card card-report p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="text-muted small text-uppercase">
                                <th>No</th>
                                <th>Waktu Transaksi</th>
                                <th>Kode</th>
                                <th>Pelanggan / Meja</th>
                                <th>Pelayan</th>
                                <th class="text-end">Tagihan</th>
                                <th class="text-end">Uang Bayar</th>
                                <th class="text-end">Kembali</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            $grand_total = 0;
                            // Mengambil data dari tabel orders yang sudah di-update total_bayarnya
                            $query = mysqli_query($koneksi, "SELECT * FROM orders WHERE total_bayar > 0 ORDER BY waktu_order DESC");
                            
                            if(mysqli_num_rows($query) > 0) {
                                while($d = mysqli_fetch_array($query)){
                                    $grand_total += $d['total_bayar'];
                            ?>
                            <tr>
                                <td class="text-muted"><?= $no++; ?></td>
                                <td><?= date('d M Y, H:i', strtotime($d['waktu_order'])) ?></td>
                                <td class="fw-bold"><?= $d['kode_order'] ?></td>
                                <td>
                                    <?= $d['pelanggan'] ?> 
                                    <span class="badge bg-light text-dark border ms-1">Meja <?= $d['meja'] ?></span>
                                </td>
                                <td><?= $d['pelayan'] ?></td>
                                <td class="text-end fw-bold">Rp <?= number_format($d['total_bayar'], 0, ',', '.') ?></td>
                                <td class="text-end text-success small">Rp <?= number_format($d['uang_diterima'], 0, ',', '.') ?></td>
                                <td class="text-end text-muted small">Rp <?= number_format($d['uang_kembali'], 0, ',', '.') ?></td>
                            </tr>
                            <?php 
                                } 
                            } else {
                                echo "<tr><td colspan='8' class='text-center py-5 text-muted small'>Belum ada data transaksi yang lunas.</td></tr>";
                            }
                            ?>
                        </tbody>
                        <?php if($grand_total > 0): ?>
                        <tfoot class="border-top-0">
                            <tr>
                                <td colspan="5" class="text-end fw-bold py-4">TOTAL PENDAPATAN :</td>
                                <td colspan="3" class="text-end py-4">
                                    <h4 class="fw-bold text-primary mb-0">Rp <?= number_format($grand_total, 0, ',', '.') ?></h4>
                                </td>
                            </tr>
                        </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
            
            <p class="text-center mt-4 text-muted small no-print italic">
                Sistem Kasir Kuliner &copy; <?= date('Y') ?>
            </p>

        </div>
    </div>

</body>
</html>