-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2025 at 11:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kuliner`
--

-- --------------------------------------------------------

--
-- Table structure for table `daftar_menu`
--

CREATE TABLE `daftar_menu` (
  `no` int(11) NOT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `kategori` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `daftar_menu`
--

INSERT INTO `daftar_menu` (`no`, `nama_menu`, `keterangan`, `kategori`, `harga`, `stok`) VALUES
(11, 'Mie Ayam', 'Mie Ayam Bakso', 1, 20000, 75),
(12, 'Nasi Goreng', 'Spesial', 1, 18000, 38),
(13, 'Siomay', 'Siomay Bandung', 1, 10000, 33),
(14, 'Kentang', 'Garlic', 2, 15000, 50),
(15, 'Puding', 'Buah', 2, 10000, 100),
(16, 'Pisang crispy', 'kering', 2, 15000, 70),
(17, 'Pancake', '-', 2, 12000, 75),
(18, 'Jus Alpukat', 'Buah', 3, 10000, 50),
(19, 'Sop Buah', 'Campur', 3, 18000, 20),
(20, 'Es krim', 'tiga rasa', 3, 15000, 40);

-- --------------------------------------------------------

--
-- Table structure for table `detail_order`
--

CREATE TABLE `detail_order` (
  `id_detail` int(11) NOT NULL,
  `id_order` int(11) DEFAULT NULL,
  `menu` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `detail_order`
--

INSERT INTO `detail_order` (`id_detail`, `id_order`, `menu`, `jumlah`, `catatan`, `status`) VALUES
(1, 4, 11, 1, NULL, NULL),
(2, 7, 11, 1, NULL, NULL),
(3, 8, 11, 1, NULL, NULL),
(4, 9, 11, 1, NULL, NULL),
(5, 10, 11, 1, NULL, NULL),
(6, 11, 13, 1, NULL, NULL),
(7, 12, 12, 1, NULL, NULL),
(8, 13, 12, 1, NULL, NULL),
(9, 14, 13, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `kategori_menu` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kategori_menu`) VALUES
(1, 'Makanan Berat'),
(2, 'Snack Ringan'),
(3, 'Minuman');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `kode_order` varchar(200) NOT NULL,
  `pelanggan` varchar(100) DEFAULT NULL,
  `meja` int(11) DEFAULT NULL,
  `pelayan` int(11) DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `uang_diterima` int(11) DEFAULT NULL,
  `uang_kembali` int(11) DEFAULT NULL,
  `waktu_order` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id_order`, `kode_order`, `pelanggan`, `meja`, `pelayan`, `total_bayar`, `uang_diterima`, `uang_kembali`, `waktu_order`) VALUES
(1, '', 'alfan', 1, NULL, NULL, NULL, NULL, '2025-12-28 08:32:09'),
(2, '', 'alfan', 1, NULL, NULL, NULL, NULL, '2025-12-28 08:32:30'),
(3, '', 'alfan as', 1, NULL, NULL, NULL, NULL, '2025-12-28 08:37:31'),
(4, '', 'alfan as', 1, NULL, NULL, NULL, NULL, '2025-12-28 08:39:34'),
(7, 'ORD-20251228-9885', 'alfan as', 1, 0, NULL, NULL, NULL, '2025-12-28 08:54:31'),
(8, 'ORD-20251228-3239', 'alfan as', 1, 0, NULL, NULL, NULL, '2025-12-28 08:54:35'),
(9, 'ORD-20251228-9336', 'alfan', 1, 0, NULL, NULL, NULL, '2025-12-28 08:57:50'),
(10, 'ORD-20251228-2600', 'RAFIF', 1, 0, NULL, NULL, NULL, '2025-12-28 08:58:50'),
(11, 'ORD-20251228-6609', 'RAFIF', 1, 0, NULL, NULL, NULL, '2025-12-28 09:01:01'),
(12, 'ORD-20251228-1184', 'RAFIF', 1, 0, NULL, NULL, NULL, '2025-12-28 09:05:45'),
(13, 'ORD-20251228-6809', 'RAFIF', 1, 0, 18000, 18000, 0, '2025-12-28 09:08:12'),
(14, 'ORD-20251228-7988', 'alfan', 1, 0, 10000, 10000, 0, '2025-12-28 09:52:17');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_order` int(11) DEFAULT NULL,
  `waktu_bayar` timestamp NOT NULL DEFAULT current_timestamp(),
  `metode_bayar` varchar(50) DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_order`, `waktu_bayar`, `metode_bayar`, `total_bayar`) VALUES
(1, 2, '2025-12-28 08:32:37', 'Tunai', 15);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `nomor_telepon`, `level`) VALUES
(1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', NULL, 'Admin'),
(2, 'Alfan', 'alfan', '1b0b0c715b03257541fe208cf251ef42', NULL, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `id_level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'kasir', 'c7911af3adbd14f013b283c05f05a730', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_menu`
--
ALTER TABLE `daftar_menu`
  ADD PRIMARY KEY (`no`),
  ADD KEY `kategori` (`kategori`);

--
-- Indexes for table `detail_order`
--
ALTER TABLE `detail_order`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `menu` (`menu`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `pelayan` (`pelayan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_menu`
--
ALTER TABLE `daftar_menu`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `detail_order`
--
ALTER TABLE `detail_order`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daftar_menu`
--
ALTER TABLE `daftar_menu`
  ADD CONSTRAINT `daftar_menu_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `detail_order`
--
ALTER TABLE `detail_order`
  ADD CONSTRAINT `detail_order_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_order_ibfk_2` FOREIGN KEY (`menu`) REFERENCES `daftar_menu` (`no`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
