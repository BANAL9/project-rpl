<?php
session_start();
include 'koneksi.php';

$id_order = $_GET['id'];

// --- PROSES SIMPAN KE DATABASE (DIJALANKAN OLEH FETCH/AJAX) ---
if (isset($_POST['update_laporan'])) {
    $bayar   = $_POST['bayar'];
    $kembali = $_POST['kembali'];
    $total   = $_POST['total'];
    
    $update = mysqli_query($koneksi, "UPDATE orders SET 
                total_bayar='$total', 
                uang_diterima='$bayar', 
                uang_kembali='$kembali' 
              WHERE id_order='$id_order'");
    exit; 
}

// --- AMBIL DATA ORDER ---
$query_order = mysqli_query($koneksi, "SELECT * FROM orders WHERE id_order = '$id_order'");
$data_order  = mysqli_fetch_array($query_order);

// --- AMBIL DETAIL MENU ---
$query_detail = mysqli_query($koneksi, "SELECT detail_order.*, daftar_menu.nama_menu, daftar_menu.harga 
                                        FROM detail_order 
                                        JOIN daftar_menu ON detail_order.menu = daftar_menu.no 
                                        WHERE detail_order.id_order = '$id_order'");

$total = 0;
$items = [];
while($row = mysqli_fetch_array($query_detail)) {
    $total += ($row['harga'] * $row['jumlah']);
    $items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk - <?= $data_order['kode_order'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <style>
        body { background: #f0f2f5; }
        .receipt-paper { 
            background: #fff; padding: 25px; box-shadow: 0 0 20px rgba(0,0,0,0.1); 
            font-family: 'Courier New', Courier, monospace; min-height: 500px;
        }
        .line { border-top: 1px dashed #000; margin: 10px 0; }
        @media print { 
            .no-print { display: none !important; } 
            .receipt-paper { box-shadow: none; padding: 0; margin: 0; width: 100%; }
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        
        <div class="col-md-5 no-print mb-4">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 20px;">
                <h5 class="fw-bold mb-4 text-primary">KASIR PEMBAYARAN</h5>
                
                <div class="mb-3 text-center bg-light p-3 rounded">
                    <label class="small text-muted d-block">TOTAL TAGIHAN</label>
                    <h1 class="fw-bold text-danger">Rp <?= number_format($total, 0, ',', '.') ?></h1>
                </div>

                <div class="mb-4">
                    <label class="fw-bold mb-2">Uang Diterima (Tanpa Titik/Koma)</label>
                    <input type="number" id="input_bayar" class="form-control form-control-lg border-2 border-primary" 
                           placeholder="Contoh: 50000" oninput="hitungOtomatis(this.value, <?= $total ?>)" autofocus>
                    <div id="pesan_status" class="mt-2 fw-bold"></div>
                </div>

                <button id="btn_cetak" onclick="simpanDanCetak(<?= $total ?>)" class="btn btn-secondary btn-lg w-100 fw-bold py-3 shadow" disabled>
                    <i class="fas fa-print me-2"></i> CETAK & SELESAI
                </button>
                <a href="transaksi.php" class="btn btn-link w-100 mt-3 no-print">Kembali</a>
            </div>
        </div>

        <div class="col-md-5">
            <div class="receipt-paper">
                <div class="text-center">
                    <h5 class="fw-bold mb-0">KULINER RESTO</h5>
                    <p class="small">Nota Transaksi</p>
                </div>

                <div class="small mt-3">
                    <div>No: <?= $data_order['kode_order'] ?></div>
                    <div>Meja: <?= $data_order['meja'] ?> | Cust: <?= $data_order['pelanggan'] ?></div>
                </div>

                <div class="line"></div>

                <table class="table table-borderless table-sm small">
                    <?php foreach($items as $item) { ?>
                    <tr>
                        <td><?= $item['nama_menu'] ?> (x<?= $item['jumlah'] ?>)</td>
                        <td class="text-end"><?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?></td>
                    </tr>
                    <?php } ?>
                </table>

                <div class="line"></div>

                <div class="small fw-bold">
                    <div class="d-flex justify-content-between"><span>TOTAL:</span><span>Rp <?= number_format($total, 0, ',', '.') ?></span></div>
                    <div class="d-flex justify-content-between text-primary"><span>BAYAR:</span><span id="struk_bayar">Rp 0</span></div>
                    <div class="d-flex justify-content-between text-success"><span>KEMBALI:</span><span id="struk_kembali">Rp 0</span></div>
                </div>

                <div class="line mt-4"></div>
                <div class="text-center small text-muted italic">*** LUNAS ***</div>
            </div>
        </div>

    </div>
</div>

<script>
let globalKembali = 0;
let globalBayar = 0;

function hitungOtomatis(val, total) {
    // Pastikan input adalah angka
    globalBayar = parseInt(val) || 0;
    
    const btn = document.getElementById('btn_cetak');
    const sBayar = document.getElementById('struk_bayar');
    const sKembali = document.getElementById('struk_kembali');
    const pStatus = document.getElementById('pesan_status');
    const fmt = new Intl.NumberFormat('id-ID');

    // Update tampilan struk di kanan secara real-time
    sBayar.innerText = "Rp " + fmt.format(globalBayar);

    if (globalBayar >= total) {
        // Jika uang cukup atau lebih
        globalKembali = globalBayar - total;
        sKembali.innerText = "Rp " + fmt.format(globalKembali);
        
        btn.disabled = false;
        btn.classList.replace('btn-secondary', 'btn-success');
        pStatus.innerText = "✓ Uang cukup.";
        pStatus.className = "mt-2 fw-bold text-success";
    } else {
        // Jika uang kurang
        sKembali.innerText = "Rp 0";
        btn.disabled = true;
        btn.classList.replace('btn-success', 'btn-secondary');
        pStatus.innerText = "⚠ Uang kurang!";
        pStatus.className = "mt-2 fw-bold text-danger";
    }
}

function simpanDanCetak(total) {
    let fd = new FormData();
    fd.append('update_laporan', true);
    fd.append('bayar', globalBayar);
    fd.append('kembali', globalKembali);
    fd.append('total', total);

    // Simpan ke DB dulu, baru print
    fetch(window.location.href, {
        method: 'POST',
        body: fd
    }).then(() => {
        window.print();
        // Redirect ke laporan setelah print selesai (opsional)
        // window.location.href = 'laporan.php';
    }).catch(err => alert("Error: " + err));
}
</script>

</body>
</html>