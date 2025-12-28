<?php
session_start();
if (!isset($_SESSION['level'])) { header("location:index.php"); exit(); }
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM daftar_menu WHERE no='$id'");
$d = mysqli_fetch_array($data);

if (isset($_POST['update'])) {
    $nama  = $_POST['nama_menu'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];
    
    $query = mysqli_query($koneksi, "UPDATE daftar_menu SET nama_menu='$nama', harga='$harga', stok='$stok' WHERE no='$id'");
    if($query) { echo "<script>alert('Data Berhasil Diupdate'); window.location='menu.php';</script>"; }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Menu - KULINER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 shadow-sm col-md-6 mx-auto">
            <h4 class="fw-bold mb-4">Edit Menu: <?= $d['nama_menu'] ?></h4>
            <form method="POST">
                <div class="mb-3">
                    <label>Nama Menu</label>
                    <input type="text" name="nama_menu" class="form-control" value="<?= $d['nama_menu'] ?>" required>
                </div>
                <div class="mb-3">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" class="form-control" value="<?= $d['harga'] ?>" required>
                </div>
                <div class="mb-3">
                    <label>Stok</label>
                    <input type="number" name="stok" class="form-control" value="<?= $d['stok'] ?>" required>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                <a href="menu.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>