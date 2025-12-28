# Aplikasi Kasir Kuliner - Tugas RPL

Aplikasi kasir berbasis web sederhana menggunakan **PHP Native** dan **MySQL**. Fitur utama meliputi input transaksi, cetak struk otomatis, dan rekapitulasi laporan pendapatan.

## Fitur Utama
- **Kasir:** Perhitungan total belanja, input uang bayar, dan hitung kembalian otomatis.
- **Cetak Struk:** Integrasi fungsi `window.print()` untuk cetak langsung setelah simpan data.
- **Laporan:** Data transaksi otomatis masuk ke tabel laporan pendapatan.

## Cara Instalasi (Localhost)
1. Download/Clone repositori ini.
2. Pindahkan folder ke `C:/xampp/htdocs/`.
3. Jalankan XAMPP (Apache & MySQL).
4. Buat database baru bernama `db_kuliner` (sesuaikan dengan file koneksi Anda).
5. Import file `.sql` yang tersedia ke dalam database.
6. Buka di browser: `http://localhost/project-rpl/`

## Teknologi yang Digunakan
- PHP Native
- MySQL
- Bootstrap 5 (CSS)
- FontAwesome (Icon)
