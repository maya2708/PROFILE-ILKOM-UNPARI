-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2025 at 01:04 PM
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
-- Database: `db_ilkom`
--

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `lingkup` enum('Lokal','Nasional','Internasional') NOT NULL,
  `jenis_kegiatan` enum('Seminar','Workshop','Pelatihan','Akademik','Non Akademik') NOT NULL,
  `tanggal_awal` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `foto` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`foto`)),
  `link_laporan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `judul`, `deskripsi`, `lingkup`, `jenis_kegiatan`, `tanggal_awal`, `tanggal_akhir`, `foto`, `link_laporan`) VALUES
(20, 'PERACANGAN SISTEM INFORMASI PROFILE KELURAHAN BERBASIS WEBSITE BERBASIS WEB MOBILE', 'nnn', 'Internasional', 'Seminar', '2024-12-30', '2025-01-24', '[\"uploads/WhatsApp Image 2024-11-01 at 3.05.19 PM.jpeg\",\"uploads/logo_unpari2.png\"]', 'http://localhost/phpmyadmin/index.php?route=/database/sql&db=db_ilkom');

-- --------------------------------------------------------

--
-- Table structure for table `kerjasama`
--

CREATE TABLE `kerjasama` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `level` enum('lokal','nasional','internasional') NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `pihak1` varchar(255) NOT NULL,
  `pihak2` varchar(255) NOT NULL,
  `tgl` date NOT NULL,
  `durasi` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kerjasama`
--

INSERT INTO `kerjasama` (`id`, `nama`, `level`, `jenis`, `pihak1`, `pihak2`, `tgl`, `durasi`, `link`) VALUES
(6, 'MAYA ANUGRAH LESTARI', 'nasional', 'yy', 'maya', 'tt', '2024-12-13', '89', 'https://www.bing.com/ck/a?!&&p=27f85354da90a921JmltdHM9MTcyOTM4MjQwMCZpZ3VpZD0yMmE3NWQ1MS1lNmQ5LTY4NzItMGMwNC00OTQwZTc4ZjY5MmMmaW5zaWQ9NTIwOA&ptn=3&ver=2&hsh=3&fclid=22a75d51-e6d9-6872-0c04-4940e78f692c&psq=prabowo&u=a1aHR0cHM6Ly9uYXNpb25hbC5rb21wYXMuY29t'),
(7, 'MAYA ANUGRAH LESTARI', 'lokal', 'yy', 'maya', 'tt', '2025-01-11', '33', 'https://www.bing.com/ck/a?!&&p=27f85354da90a921JmltdHM9MTcyOTM4MjQwMCZpZ3VpZD0yMmE3NWQ1MS1lNmQ5LTY4NzItMGMwNC00OTQwZTc4ZjY5MmMmaW5zaWQ9NTIwOA&ptn=3&ver=2&hsh=3&fclid=22a75d51-e6d9-6872-0c04-4940e78f692c&psq=prabowo&u=a1aHR0cHM6Ly9uYXNpb25hbC5rb21wYXMuY29t'),
(8, 'MAYA ANUGRAH LESTARI', 'lokal', 'yy', 'maya', 'tt', '2024-12-03', '33', 'https://www.bing.com/ck/a?!&&p=27f85354da90a921JmltdHM9MTcyOTM4MjQwMCZpZ3VpZD0yMmE3NWQ1MS1lNmQ5LTY4NzItMGMwNC00OTQwZTc4ZjY5MmMmaW5zaWQ9NTIwOA&ptn=3&ver=2&hsh=3&fclid=22a75d51-e6d9-6872-0c04-4940e78f692c&psq=prabowo&u=a1aHR0cHM6Ly9uYXNpb25hbC5rb21wYXMuY29t'),
(9, 'MAYA ANUGRAH LESTARI', 'lokal', 'yy', 'maya', 'tt', '2024-12-03', '33', 'https://www.bing.com/ck/a?!&&p=27f85354da90a921JmltdHM9MTcyOTM4MjQwMCZpZ3VpZD0yMmE3NWQ1MS1lNmQ5LTY4NzItMGMwNC00OTQwZTc4ZjY5MmMmaW5zaWQ9NTIwOA&ptn=3&ver=2&hsh=3&fclid=22a75d51-e6d9-6872-0c04-4940e78f692c&psq=prabowo&u=a1aHR0cHM6Ly9uYXNpb25hbC5rb21wYXMuY29t'),
(10, 'MAYA ANUGRAH LESTARI', 'lokal', 'yy', 'maya', 'tt', '2024-12-03', '38', 'https://www.bing.com/ck/a?!&&p=27f85354da90a921JmltdHM9MTcyOTM4MjQwMCZpZ3VpZD0yMmE3NWQ1MS1lNmQ5LTY4NzItMGMwNC00OTQwZTc4ZjY5MmMmaW5zaWQ9NTIwOA&ptn=3&ver=2&hsh=3&fclid=22a75d51-e6d9-6872-0c04-4940e78f692c&psq=prabowo&u=a1aHR0cHM6Ly9uYXNpb25hbC5rb21wYXMuY29t'),
(11, 'MAYA ANUGRAH LESTARI', 'lokal', 'yy', 'maya', 'tt', '2024-12-03', '38', 'https://www.bing.com/ck/a?!&&p=27f85354da90a921JmltdHM9MTcyOTM4MjQwMCZpZ3VpZD0yMmE3NWQ1MS1lNmQ5LTY4NzItMGMwNC00OTQwZTc4ZjY5MmMmaW5zaWQ9NTIwOA&ptn=3&ver=2&hsh=3&fclid=22a75d51-e6d9-6872-0c04-4940e78f692c&psq=prabowo&u=a1aHR0cHM6Ly9uYXNpb25hbC5rb21wYXMuY29t'),
(12, 'MAYA ANUGRAH LESTARI', 'lokal', 'yy', 'maya', 'tt', '2024-12-03', '38', 'https://www.bing.com/ck/a?!&&p=27f85354da90a921JmltdHM9MTcyOTM4MjQwMCZpZ3VpZD0yMmE3NWQ1MS1lNmQ5LTY4NzItMGMwNC00OTQwZTc4ZjY5MmMmaW5zaWQ9NTIwOA&ptn=3&ver=2&hsh=3&fclid=22a75d51-e6d9-6872-0c04-4940e78f692c&psq=prabowo&u=a1aHR0cHM6Ly9uYXNpb25hbC5rb21wYXMuY29t'),
(13, 'MAYA ANUGRAH LESTARI', 'lokal', 'yy', 'maya', 'tt', '2024-12-03', '38', 'https://www.bing.com/ck/a?!&&p=27f85354da90a921JmltdHM9MTcyOTM4MjQwMCZpZ3VpZD0yMmE3NWQ1MS1lNmQ5LTY4NzItMGMwNC00OTQwZTc4ZjY5MmMmaW5zaWQ9NTIwOA&ptn=3&ver=2&hsh=3&fclid=22a75d51-e6d9-6872-0c04-4940e78f692c&psq=prabowo&u=a1aHR0cHM6Ly9uYXNpb25hbC5rb21wYXMuY29t'),
(14, 'MAYA ANUGRAH LESTARI', 'lokal', 'yy', 'maya', 'tt', '2024-12-03', '38', 'https://www.bing.com/ck/a?!&&p=27f85354da90a921JmltdHM9MTcyOTM4MjQwMCZpZ3VpZD0yMmE3NWQ1MS1lNmQ5LTY4NzItMGMwNC00OTQwZTc4ZjY5MmMmaW5zaWQ9NTIwOA&ptn=3&ver=2&hsh=3&fclid=22a75d51-e6d9-6872-0c04-4940e78f692c&psq=prabowo&u=a1aHR0cHM6Ly9uYXNpb25hbC5rb21wYXMuY29t'),
(15, 'MAYA ANUGRAH LESTARI', 'lokal', 'yy', 'maya', 'tt', '2024-12-03', '38', 'https://www.bing.com/ck/a?!&&p=27f85354da90a921JmltdHM9MTcyOTM4MjQwMCZpZ3VpZD0yMmE3NWQ1MS1lNmQ5LTY4NzItMGMwNC00OTQwZTc4ZjY5MmMmaW5zaWQ9NTIwOA&ptn=3&ver=2&hsh=3&fclid=22a75d51-e6d9-6872-0c04-4940e78f692c&psq=prabowo&u=a1aHR0cHM6Ly9uYXNpb25hbC5rb21wYXMuY29t'),
(18, 'kaila anggraini cantik imut lucu cute :)', 'internasional', 'PT.digigit nyamuk ', 'FAMILY KUCING : mom : uty  / abang 1 : ', '86', '2024-12-01', '38', 'https://chatgpt.com/c/675d5f31-fc40-800b-a3ed-b3f27f4e0d8d');

-- --------------------------------------------------------

--
-- Table structure for table `prestasi`
--

CREATE TABLE `prestasi` (
  `id` int(11) NOT NULL,
  `nama_prestasi` varchar(255) NOT NULL,
  `raihan_peringkat_prestasi` varchar(255) NOT NULL,
  `nama_peraih` varchar(255) NOT NULL,
  `status` enum('Dosen','Mahasiswa') NOT NULL,
  `tanggal_raih` date NOT NULL,
  `level_prestasi` enum('Lokal','Nasional','Internasional') NOT NULL,
  `penyelenggara` varchar(255) NOT NULL,
  `link_bukti_prestasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prestasi`
--

INSERT INTO `prestasi` (`id`, `nama_prestasi`, `raihan_peringkat_prestasi`, `nama_peraih`, `status`, `tanggal_raih`, `level_prestasi`, `penyelenggara`, `link_bukti_prestasi`) VALUES
(1, 'php-in anak orang', '3', 'hermu', 'Dosen', '2024-12-10', 'Internasional', 'universitas pgri silampari', 'https://chatgpt.com/c/675d5f31-fc40-800b-a3ed-b3f27f4e0d8d');

-- --------------------------------------------------------

--
-- Table structure for table `publikasi`
--

CREATE TABLE `publikasi` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `nama_jurnal` varchar(255) NOT NULL,
  `level_jurnal` varchar(255) NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `volume_jurnal` varchar(50) DEFAULT NULL,
  `edisi_jurnal` varchar(50) DEFAULT NULL,
  `halaman` varchar(50) DEFAULT NULL,
  `link_jurnal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publikasi`
--

INSERT INTO `publikasi` (`id`, `judul`, `penulis`, `nama_jurnal`, `level_jurnal`, `tanggal_terbit`, `volume_jurnal`, `edisi_jurnal`, `halaman`, `link_jurnal`) VALUES
(1, 'PERACANGAN SISTEM INFORMASI PROFILE KELURAHAN BERBASIS WEBSITE BERBASIS WEB MOBILE', 'MAYA ANUGRAH LESTARI, HERMU', 'PONCO', 'SCOPUS', '2025-04-01', '8', '3', '1-20', 'https://www.youtube.com/watch?v=ML0ccmxOHao');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kerjasama`
--
ALTER TABLE `kerjasama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publikasi`
--
ALTER TABLE `publikasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `kerjasama`
--
ALTER TABLE `kerjasama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `publikasi`
--
ALTER TABLE `publikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
