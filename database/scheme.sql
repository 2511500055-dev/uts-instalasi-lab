-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 01, 2026 at 02:47 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instalasi_lab`
--

-- --------------------------------------------------------

--
-- Table structure for table `form_instalasi`
--

CREATE TABLE `form_instalasi` (
  `no_instalasi` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_software` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `form_instalasi`
--

INSERT INTO `form_instalasi` (`no_instalasi`, `id_mahasiswa`, `id_software`, `created_at`, `status`) VALUES
(1, 1, 5, '2026-11-01 02:45:29', 'Selesai'),
(2, 2, 4, '2026-11-01 02:45:29', 'Diproses'),
(3, 3, 2, '2026-11-01 02:46:20', 'Diproses'),
(4, 4, 4, '2026-11-01 02:46:20', 'Diproses'),
(5, 5, 3, '2026-11-01 02:46:57', 'Belum diproses');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `nim` varchar(11) NOT NULL,
  `nama_mahasiswa` varchar(30) NOT NULL,
  `prodi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nim`, `nama_mahasiswa`, `prodi`) VALUES
(1, '2511500020', 'Widya Serena Mulyaputeri', 'Teknik Informatika'),
(2, '2511500030', 'Monika Aldesia Plaron', 'Teknik Informatika'),
(3, '2511500007', 'Jeffrey Deryata', 'Teknik Informatika'),
(4, '2511500055', 'Aditya Ihsani Wijaya', 'Teknik Informatika'),
(5, '2322500077', 'Ahza Seprian Pratama', 'Sistem Informasi');

-- --------------------------------------------------------

--
-- Table structure for table `software`
--

CREATE TABLE `software` (
  `id_software` int(11) NOT NULL,
  `kd_software` varchar(11) NOT NULL,
  `nama_software` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `software`
--

INSERT INTO `software` (`id_software`, `kd_software`, `nama_software`) VALUES
(1, 'LRG6', 'Laragon 6'),
(2, 'ADPS6', 'Adobe Photoshop CS6'),
(3, 'MCSOFC', 'Microsoft Office'),
(4, 'VSC', 'Visual Studio Code'),
(5, 'VB', 'Virtual Box');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form_instalasi`
--
ALTER TABLE `form_instalasi`
  ADD PRIMARY KEY (`no_instalasi`),
  ADD KEY `detail_mhs` (`id_mahasiswa`),
  ADD KEY `detail_sfw` (`id_software`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD UNIQUE KEY `nim_2` (`nim`);

--
-- Indexes for table `software`
--
ALTER TABLE `software`
  ADD PRIMARY KEY (`id_software`),
  ADD UNIQUE KEY `kd_software` (`kd_software`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form_instalasi`
--
ALTER TABLE `form_instalasi`
  MODIFY `no_instalasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `software`
--
ALTER TABLE `software`
  MODIFY `id_software` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `form_instalasi`
--
ALTER TABLE `form_instalasi`
  ADD CONSTRAINT `detail_mhs` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `detail_sfw` FOREIGN KEY (`id_software`) REFERENCES `software` (`id_software`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
