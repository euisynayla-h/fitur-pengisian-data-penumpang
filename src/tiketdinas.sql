-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 07:24 AM
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
-- Database: `tiketdinas`
--

-- --------------------------------------------------------

--
-- Table structure for table `kursi`
--

CREATE TABLE `kursi` (
  `id` int(11) NOT NULL,
  `id_penerbangan` int(11) DEFAULT NULL,
  `kode_kursi` varchar(10) NOT NULL,
  `status` enum('tersedia','terisi') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kursi`
--

INSERT INTO `kursi` (`id`, `id_penerbangan`, `kode_kursi`, `status`) VALUES
(1, 1, '1A', 'tersedia'),
(2, 1, '1B', 'tersedia'),
(3, 1, '1C', 'tersedia'),
(4, 1, '1D', 'tersedia'),
(5, 1, '2A', 'terisi'),
(6, 1, '2B', 'terisi'),
(7, 1, '2C', 'tersedia'),
(8, 1, '2D', 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `kursi_terisi`
--

CREATE TABLE `kursi_terisi` (
  `id` int(11) NOT NULL,
  `id_perjalanan` int(11) NOT NULL,
  `no_kursi` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`nip`, `nama`, `password`) VALUES
('D1041221023', 'Admin Sistem', 'reza');

-- --------------------------------------------------------

--
-- Table structure for table `penerbangan`
--

CREATE TABLE `penerbangan` (
  `id` int(11) NOT NULL,
  `maskapai` varchar(100) NOT NULL,
  `kode_penerbangan` varchar(50) NOT NULL,
  `tanggal_berangkat` date NOT NULL,
  `jam_berangkat` time NOT NULL,
  `jam_tiba` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penerbangan`
--

INSERT INTO `penerbangan` (`id`, `maskapai`, `kode_penerbangan`, `tanggal_berangkat`, `jam_berangkat`, `jam_tiba`) VALUES
(1, 'Garuda Indonesia', 'GA-123', '2025-05-20', '06:30:00', '08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_perjalanan`
--

CREATE TABLE `pengajuan_perjalanan` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `tanggal_keberangkatan` date DEFAULT NULL,
  `tanggal_kepulangan` date DEFAULT NULL,
  `kota_berangkat` varchar(100) DEFAULT NULL,
  `kota_tujuan` varchar(100) DEFAULT NULL,
  `jumlah_pegawai` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perjalanan`
--

CREATE TABLE `perjalanan` (
  `id` int(11) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `kota_berangkat` varchar(100) DEFAULT NULL,
  `kota_tujuan` varchar(100) DEFAULT NULL,
  `tgl_berangkat` date DEFAULT NULL,
  `tgl_pulang` date DEFAULT NULL,
  `jumlah_pegawai` int(11) DEFAULT NULL,
  `maskapai` varchar(100) DEFAULT NULL,
  `waktu_keberangkatan` time DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perjalanan`
--

INSERT INTO `perjalanan` (`id`, `nip`, `kota_berangkat`, `kota_tujuan`, `tgl_berangkat`, `tgl_pulang`, `jumlah_pegawai`, `maskapai`, `waktu_keberangkatan`, `harga`, `tanggal_input`) VALUES
(1, 'D1041221023', 'Pontianak', 'Ketapang', '2025-05-21', '2025-05-21', 1, NULL, NULL, NULL, '2025-05-21 05:01:38'),
(2, 'D1041221023', 'Pontianak', 'Ketapang', '2025-05-21', '2025-05-21', 1, NULL, NULL, NULL, '2025-05-21 05:01:52'),
(3, 'D1041221023', 'Pontianak', 'Ketapang', '2025-05-21', '2025-05-21', 1, 'Garuda Indonesia', '06:30:00', 3250000, '2025-05-21 05:05:22'),
(4, 'D1041221023', 'Pontianak', 'Ketapang', '2025-05-24', '2025-05-21', 1, 'Garuda Indonesia', '06:30:00', 3250000, '2025-05-21 05:15:00'),
(5, 'D1041221023', 'Pontianak', 'Ketapang', '2025-05-24', '2025-05-21', 1, 'Garuda Indonesia', '06:30:00', 3250000, '2025-05-21 05:22:25'),
(6, 'D1041221023', 'Pontianak', 'Ketapang', '2025-05-24', '2025-05-21', 1, 'Garuda Indonesia', '06:30:00', 3250000, '2025-05-21 05:22:36');

-- --------------------------------------------------------

--
-- Table structure for table `tiket_dinas`
--

CREATE TABLE `tiket_dinas` (
  `id` int(11) NOT NULL,
  `nomor_permohonan` varchar(30) NOT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `id_penerbangan` int(11) DEFAULT NULL,
  `kursi_yang_dipilih` varchar(10) DEFAULT NULL,
  `status` enum('Menunggu Persetujuan','Disetujui','Ditolak') DEFAULT 'Menunggu Persetujuan',
  `batas_konfirmasi` datetime DEFAULT NULL,
  `tanggal_pengajuan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kursi`
--
ALTER TABLE `kursi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_penerbangan` (`id_penerbangan`);

--
-- Indexes for table `kursi_terisi`
--
ALTER TABLE `kursi_terisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`nip`);

--
-- Indexes for table `penerbangan`
--
ALTER TABLE `penerbangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengajuan_perjalanan`
--
ALTER TABLE `pengajuan_perjalanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perjalanan`
--
ALTER TABLE `perjalanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tiket_dinas`
--
ALTER TABLE `tiket_dinas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nip` (`nip`),
  ADD KEY `id_penerbangan` (`id_penerbangan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kursi`
--
ALTER TABLE `kursi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kursi_terisi`
--
ALTER TABLE `kursi_terisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penerbangan`
--
ALTER TABLE `penerbangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengajuan_perjalanan`
--
ALTER TABLE `pengajuan_perjalanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perjalanan`
--
ALTER TABLE `perjalanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tiket_dinas`
--
ALTER TABLE `tiket_dinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kursi`
--
ALTER TABLE `kursi`
  ADD CONSTRAINT `kursi_ibfk_1` FOREIGN KEY (`id_penerbangan`) REFERENCES `penerbangan` (`id`);

--
-- Constraints for table `tiket_dinas`
--
ALTER TABLE `tiket_dinas`
  ADD CONSTRAINT `tiket_dinas_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `pegawai` (`nip`),
  ADD CONSTRAINT `tiket_dinas_ibfk_2` FOREIGN KEY (`id_penerbangan`) REFERENCES `penerbangan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
