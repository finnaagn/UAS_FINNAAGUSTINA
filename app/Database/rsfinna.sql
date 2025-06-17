-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 08:56 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rsfinna`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `terakhir_login` datetime DEFAULT NULL,
  `status_aktif` enum('aktif','nonaktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_lengkap`, `terakhir_login`, `status_aktif`) VALUES
(4, 'admin', '$2y$10$q.4DJEWrPaAb5fMMXC/y4.4M2QdmQeYsVLRRl7r5ulIoAD2sCc67q', 'Administrator', '2025-06-17 06:23:50', 'aktif'),
(5, 'Julian Arwansah', '$2y$10$7ORQ7UM8uu9LX3KUosaiF.kn8yabWGgJesrNvuR8ckT2Cj0EKIwe6', 'Julian Arwansah', NULL, 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id_dokter` int(11) NOT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `spesialisasi` varchar(50) NOT NULL,
  `jadwal_praktek` text DEFAULT NULL,
  `status_aktif` enum('aktif','cuti','nonaktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id_dokter`, `nama_dokter`, `spesialisasi`, `jadwal_praktek`, `status_aktif`) VALUES
(1, 'Dr. Ahmad Fauzi', 'Penyakit Hati', 'Senin-Rabu, 08:00-15:00', 'aktif'),
(2, 'Dr. Siti Rahayu', 'Anak', 'Selasa-Kamis, 09:00-16:00', 'aktif'),
(3, 'Dr. Bambang Prasetyo', 'Bedah', 'Rabu-Jumat, 10:00-17:00', 'aktif'),
(4, 'Julian Arwansah', 'Dokter Dokteran', 'Senin-Jumat, 08:00-15:00', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_pendaftaran`
--

CREATE TABLE `laporan_pendaftaran` (
  `id_laporan` int(11) NOT NULL,
  `jenis_laporan` enum('harian','mingguan','bulanan','tahunan','kustom') NOT NULL,
  `periode_mulai` date NOT NULL,
  `periode_selesai` date NOT NULL,
  `total_pendaftar` int(11) NOT NULL,
  `total_disetujui` int(11) NOT NULL,
  `total_ditolak` int(11) NOT NULL,
  `total_dibatalkan` int(11) NOT NULL,
  `tanggal_generate` datetime DEFAULT current_timestamp(),
  `generated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan_pendaftaran`
--

INSERT INTO `laporan_pendaftaran` (`id_laporan`, `jenis_laporan`, `periode_mulai`, `periode_selesai`, `total_pendaftar`, `total_disetujui`, `total_ditolak`, `total_dibatalkan`, `tanggal_generate`, `generated_by`) VALUES
(1, 'harian', '2025-06-17', '2025-06-17', 0, 0, 0, 0, '2025-06-17 12:41:53', 4),
(2, 'harian', '2025-06-17', '2025-06-17', 0, 0, 0, 0, '2025-06-17 12:41:53', 4),
(3, 'tahunan', '2022-01-31', '2025-12-30', 3, 1, 1, 0, '2025-06-17 12:42:23', 4),
(4, 'harian', '2025-06-17', '2025-06-17', 0, 0, 0, 0, '2025-06-17 13:29:52', 4),
(5, 'harian', '2025-06-16', '2025-06-18', 1, 1, 0, 0, '2025-06-17 13:30:04', 4);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tanggal_daftar` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `nik`, `nama_lengkap`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `no_telepon`, `email`, `tanggal_daftar`) VALUES
(1, '1234567890123456', 'Budi Santoso', '1985-05-15', 'L', 'Jl. Merdeka No. 123, Jakarta', '081234567890', 'budi@email.com', '2025-06-17 00:51:43'),
(2, '2345678901234567', 'Ani Ani', '1990-08-20', 'P', 'Jl. Sudirman No. 45, Bandung', '082345678901', 'ani@email.com', '2025-06-17 00:51:43'),
(4, '7778889996667711', 'Julian Arwansah', '2004-07-18', 'L', 'Perum Griya pasir jaya tahap 3 blok E14', '089661770123', 'julianarwansahh@gmail.com', '2025-06-17 13:20:27');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `keluhan` text NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `jam_kunjungan` time NOT NULL,
  `status` enum('pending','disetujui','ditolak','dibatalkan') DEFAULT 'pending',
  `catatan_admin` text DEFAULT NULL,
  `tanggal_didaftarkan` datetime DEFAULT current_timestamp(),
  `tanggal_diproses` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id_pendaftaran`, `id_pasien`, `id_dokter`, `keluhan`, `tanggal_kunjungan`, `jam_kunjungan`, `status`, `catatan_admin`, `tanggal_didaftarkan`, `tanggal_diproses`) VALUES
(1, 1, 1, 'Demam tinggi dan batuk sudah 3 hari', '2023-12-01', '09:00:00', 'disetujui', 'Pasien dipersilakan datang 15 menit sebelum jadwal', '2023-11-28 10:15:00', '2023-11-28 14:30:00'),
(2, 2, 2, 'Anak saya panas dan tidak mau makan', '2023-12-02', '10:30:00', 'pending', NULL, '2023-11-29 11:20:00', NULL),
(3, 1, 3, 'Kontrol pasca operasi', '2023-12-03', '14:00:00', 'ditolak', 'Jadwal dokter tidak tersedia, silakan pilih tanggal lain', '2023-11-30 09:45:00', '2023-11-30 10:15:00'),
(4, 4, 1, 'nggak tau sakit hati aja gitu', '2025-06-18', '08:00:00', 'disetujui', 'tolong datang tepat waktu', '2025-06-17 13:20:27', '2025-06-17 06:29:40'),
(5, 4, 2, 'anak saya sakit donk bagaiman ini', '2025-06-19', '08:00:00', 'pending', NULL, '2025-06-17 13:54:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pendaftaran`
--

CREATE TABLE `riwayat_pendaftaran` (
  `id_riwayat` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `status_sebelumnya` enum('pending','disetujui','ditolak','dibatalkan') DEFAULT NULL,
  `status_baru` enum('pending','disetujui','ditolak','dibatalkan') NOT NULL,
  `diubah_oleh` varchar(50) NOT NULL,
  `timestamp_perubahan` datetime DEFAULT current_timestamp(),
  `catatan_perubahan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_pendaftaran`
--

INSERT INTO `riwayat_pendaftaran` (`id_riwayat`, `id_pendaftaran`, `status_sebelumnya`, `status_baru`, `diubah_oleh`, `timestamp_perubahan`, `catatan_perubahan`) VALUES
(1, 1, 'pending', 'disetujui', 'admin1', '2025-06-17 00:51:43', 'Pendaftaran disetujui sesuai jadwal'),
(2, 3, 'pending', 'ditolak', 'admin2', '2025-06-17 00:51:43', 'Jadwal dokter tidak tersedia'),
(3, 4, 'pending', 'disetujui', 'admin', '2025-06-17 13:29:40', 'tolong datang tepat waktu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`);

--
-- Indexes for table `laporan_pendaftaran`
--
ALTER TABLE `laporan_pendaftaran`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `generated_by` (`generated_by`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- Indexes for table `riwayat_pendaftaran`
--
ALTER TABLE `riwayat_pendaftaran`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `laporan_pendaftaran`
--
ALTER TABLE `laporan_pendaftaran`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `riwayat_pendaftaran`
--
ALTER TABLE `riwayat_pendaftaran`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  ADD CONSTRAINT `pendaftaran_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`);

--
-- Constraints for table `riwayat_pendaftaran`
--
ALTER TABLE `riwayat_pendaftaran`
  ADD CONSTRAINT `riwayat_pendaftaran_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
