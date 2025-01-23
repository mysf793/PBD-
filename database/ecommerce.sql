-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2025 at 01:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_produk`, `jumlah`, `harga`, `total`) VALUES
(1, 1, 10, 1, 12000000.00, 12000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(17, 'Elektronik'),
(18, 'Pakaian'),
(19, 'Perabot Rumah'),
(20, 'Kecantikan'),
(21, 'Makanan dan Minuman'),
(22, 'Olahraga dan Outdoor'),
(23, 'Mainan'),
(24, 'Aksesoris'),
(25, 'Buku dan Alat Tulis'),
(26, 'Kesehatan');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `tanggal_pembayaran` datetime DEFAULT current_timestamp(),
  `jumlah_pembayaran` decimal(10,2) NOT NULL,
  `metode_pembayaran` enum('Transfer Bank','Kartu Kredit','E-wallet','Cash On Delivery') NOT NULL,
  `status_pembayaran` enum('Pending','Lunas') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pesanan`, `tanggal_pembayaran`, `jumlah_pembayaran`, `metode_pembayaran`, `status_pembayaran`) VALUES
(1, 1, '2025-01-21 23:33:13', 12000000.00, 'E-wallet', 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE `pesan` (
  `id_pesan` int(11) NOT NULL,
  `id_pengirim` int(11) DEFAULT NULL,
  `id_penerima` int(11) DEFAULT NULL,
  `pesan` text NOT NULL,
  `tanggal_pesan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `tanggal_pesanan` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `status` enum('Dipesan','Dikirim','Selesai','Dibatalkan') DEFAULT 'Dipesan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_pelanggan`, `tanggal_pesanan`, `total`, `status`) VALUES
(1, 6, '2025-01-21 23:31:30', 12000000.00, 'Dikirim'),
(2, 20, '2025-01-23 19:05:41', 48000000.00, 'Dipesan'),
(3, 20, '2025-01-23 19:05:44', 48000000.00, 'Dipesan'),
(4, 20, '2025-01-23 19:06:00', 72000000.00, 'Dipesan'),
(5, 20, '2025-01-23 19:06:08', 96000000.00, 'Dipesan');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_penjual` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `deskripsi`, `harga`, `stok`, `id_kategori`, `id_penjual`) VALUES
(10, 'Laptop HP', 'Laptop HP dengan RAM 8GB dan SSD 512GB', 12000000.00, 9, NULL, 5),
(11, 'mie ayam', 'mie dengan toping ayam', 15000.00, 20, 23, 18),
(12, 'mobil', 'mobil ferrari', 99999999.99, 1, 23, 18),
(14, 'hp', 'hp', 20000.00, 2, 17, 18),
(15, 'car', '1', 99999999.99, 11, 17, 23);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Pembeli','Penjual') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `email`, `alamat`, `telepon`, `password`, `role`) VALUES
(5, 'a', 'a@a', 'Jl. Raya No. 10', '08234567890', '$2y$10$Ue.j0KEETTCvYwRR9/d/POBK/PNKHawxocdNohobSuqCoQ79ieZW6', 'Penjual'),
(6, 'b', 'b@b', 'b', '1', '$2y$10$0nj2bQoCpsvQOJ6R.07CRevzVAvzngj.PD3pMhsrr66t8XKP5XUQu', 'Pembeli'),
(14, 'John Doe', 'john@example.com', 'Jl. Merdeka No. 5', '08123456789', 'hashed_password_123', 'Pembeli'),
(15, 'ww', 'ww@w', 'w', 'w', '$2y$10$Roaqi0mf95o/9vv1NNAwyumA/pu3yH5tO1X/P1WzRsY6I7bQFKb7m', 'Penjual'),
(16, 'qq', 'q@q', 'q', 'q', '$2y$10$Nl5YOXxUpjolQ4iwH7rK7u7jXnFN8n756PLS4oIskFPrPbKUQINnC', 'Penjual'),
(17, 'yusuf', 'y@y', 'klaten', '111', '$2y$10$Bk/CfE81SN19/n7O8sBOkebE4FTJlt0UdKywo2LwIpxEy9xsxIed2', 'Penjual'),
(18, 'penjual', 'penjual@1', 'klaten', '11', '$2y$10$B8aO.pucigtuIw4HMG6wYevBVLNes2KPjA6LeMH8kSlhzm5X6hSJ6', 'Penjual'),
(19, 'penjual2', '2@1', 'yogya', '11', '$2y$10$F2urzYzXng55ZRlZzlCOdOiMo/HkXuDZIhcDjZ7EI5Q3xDFUYsNSq', 'Penjual'),
(20, 'pembeli', 'p@p', 'yogya', '12', '$2y$10$UYKzJaJYMpr7LAUZFrpVGeRXaK0fb3wHC.eFwsVjoCfB9GfCbW28O', 'Pembeli'),
(21, '1', '1@1', '1', '1', '$2y$10$VBhNAnkRIFsAO8xaaMYnEu01v4fnqTsGkuJyOKLgAfREQQRXva8f2', 'Pembeli'),
(22, 'penjual 01', 'p1@1', 'klaten', '1', '$2y$10$ADI33H7jHi34QKblqgZ4i.GOv7cmwUrXEKgvSQCv5ltK4C3HluU.a', 'Pembeli'),
(23, 'penjual0', '0@0', '0', '0', '$2y$10$Ecnv5YgsgEXhwTpGNkueceY2AklC5mNuwnSbQcHxnjQQw4qya/QbW', 'Penjual'),
(24, 'pembeli0', '0@1', '1', '0', '$2y$10$uMPf4Ph8xid.MUk6ExmF/OJ0nGS4Z.YuzIVZJ1h4pUceDR079/XQe', 'Pembeli');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id_pesan`),
  ADD KEY `id_pengirim` (`id_pengirim`),
  ADD KEY `id_penerima` (`id_penerima`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_penjual` (`id_penjual`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);

--
-- Constraints for table `pesan`
--
ALTER TABLE `pesan`
  ADD CONSTRAINT `pesan_ibfk_1` FOREIGN KEY (`id_pengirim`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesan_ibfk_2` FOREIGN KEY (`id_penerima`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL,
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`id_penjual`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
