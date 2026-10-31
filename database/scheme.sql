-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 30, 2026 at 11:40 AM
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
-- Table structure for table `detail_instalasi`
--

CREATE TABLE `detail_instalasi` (
  `kd` int(11) NOT NULL,
  `id_mhs` int(11) NOT NULL,
  `id_sfw` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nim` varchar(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `prodi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nim`, `nama`, `prodi`) VALUES
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
  `id` int(11) NOT NULL,
  `kd_software` varchar(11) NOT NULL,
  `nama_software` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `software`
--

INSERT INTO `software` (`id`, `kd_software`, `nama_software`) VALUES
(1, 'LRG6', 'Laragon 8'),
(2, 'ADPS6', 'Adobe Photoshop CS6'),
(3, 'MCSOFC', 'Microsoft Office'),
(4, 'VSC', 'Visual Studio Code'),
(5, 'VB', 'Virtual Box');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_instalasi`
--
ALTER TABLE `detail_instalasi`
  ADD PRIMARY KEY (`kd`),
  ADD KEY `detail_mhs` (`id_mhs`),
  ADD KEY `detail_sfw` (`id_sfw`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `software`
--
ALTER TABLE `software`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kd_software` (`kd_software`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_instalasi`
--
ALTER TABLE `detail_instalasi`
  MODIFY `kd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `software`
--
ALTER TABLE `software`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_instalasi`
--
ALTER TABLE `detail_instalasi`
  ADD CONSTRAINT `detail_mhs` FOREIGN KEY (`id_mhs`) REFERENCES `mahasiswa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `detail_sfw` FOREIGN KEY (`id_sfw`) REFERENCES `software` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
