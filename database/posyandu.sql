-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 25, 2022 at 07:04 PM
-- Server version: 5.7.34
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posyandu`
--

-- --------------------------------------------------------

--
-- Table structure for table `bayi`
--

CREATE TABLE `bayi` (
  `id` int(11) NOT NULL,
  `posyandu_id` int(11) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `anak_ke` int(11) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `berat_badan` int(11) NOT NULL,
  `tinggi_badan` int(11) NOT NULL,
  `nama_ayah` varchar(128) NOT NULL,
  `nama_ibu` varchar(225) NOT NULL,
  `no_telp_ortu` varchar(128) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `rt_rw` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bayi`
--

INSERT INTO `bayi` (`id`, `posyandu_id`, `nama`, `tanggal_lahir`, `anak_ke`, `jenis_kelamin`, `berat_badan`, `tinggi_badan`, `nama_ayah`, `nama_ibu`, `no_telp_ortu`, `alamat`, `rt_rw`) VALUES
(4, 5, 'nama', '2020-12-17', 8, 'Laki-laki', 3, 5, 'Ayah', 'sapardi', '9872', 'haha', '07/5'),
(8, 5, 'Nama Lengkap', '2021-12-31', 2, 'Perempuan', 2, 10, 'Ayah', 'Nama Ibu', '0852365', 'Alamat Lengkap', '04/01'),
(13, 1, 'Nama Lengkap', '2021-12-31', 2, 'Perempuan', 2, 10, 'Ayah', 'Nama Ibu', '0852365', 'Alamat Lengkap', '04/01');

-- --------------------------------------------------------

--
-- Table structure for table `pengukuran`
--

CREATE TABLE `pengukuran` (
  `id` int(11) NOT NULL,
  `bayi_id` int(11) NOT NULL,
  `tinggi_badan` double NOT NULL,
  `berat_badan` double NOT NULL,
  `status_berat_badan` enum('b','t','n','o') NOT NULL,
  `asi` tinyint(1) NOT NULL,
  `tanggal_ukur` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pengukuran`
--

INSERT INTO `pengukuran` (`id`, `bayi_id`, `tinggi_badan`, `berat_badan`, `status_berat_badan`, `asi`, `tanggal_ukur`) VALUES
(4, 13, 12.3, 12.2, '', 0, '2022-02-21 10:41:13'),
(10, 4, 1.1, 2.3, 'o', 1, '2022-02-22 04:49:27'),
(14, 4, 12.1, 12.5, 'o', 1, '2022-02-22 08:33:17'),
(18, 8, 1.1, 2.3, 'o', 1, '2022-01-22 08:38:56'),
(19, 8, 1.1, 2.3, 't', 1, '2022-02-22 08:42:23'),
(20, 13, 12.3, 12.2, 't', 1, '2022-02-21 10:41:13');

-- --------------------------------------------------------

--
-- Table structure for table `posyandu`
--

CREATE TABLE `posyandu` (
  `id` int(11) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `puskesmas` varchar(225) NOT NULL,
  `provinsi` varchar(225) NOT NULL,
  `kabupaten` varchar(225) NOT NULL,
  `kecamatan` varchar(225) NOT NULL,
  `desa` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posyandu`
--

INSERT INTO `posyandu` (`id`, `nama`, `puskesmas`, `provinsi`, `kabupaten`, `kecamatan`, `desa`) VALUES
(2, 'Coba', 'Nama Puskesmas', 'jawa tengah', 'Batang', 'blado', 'Kalisari'),
(3, 'Apa Ya', 'mekar sari', 'jawa tengah', 'Batang', 'blado', 'Kalisari'),
(4, 'Merdeka', 'Puskesmbak', 'Jawa Tengah', 'Batang', 'Blado', 'Kalisari'),
(5, 'Posyandu Baru', 'Puskembak', 'Kajkhs', 'khg', 'lkglkgh', 'kgjlkghg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `posyandu_id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(225) NOT NULL,
  `tempat_lahir` varchar(128) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `posyandu` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `posyandu_id`, `nama`, `email`, `password`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `posyandu`) VALUES
(1, 5, 'Muhammad Asrul Aji Pangestu', 'test@gmail.com', '$2y$10$ffGT1p/46oFoJZxtL7Rp7OcbTzBVcB/4j2I317ylMQeSXp3oDetVK', 'Batang', '1999-02-23', 'Kalisari, Blado, Batang', 'Mekar Sari'),
(3, 5, 'coba', 'coba@gmail.com', '$2y$10$LjiTv0EP6WHTiGwT7gxAX.EDuuSCLrtI4LmaAz.DG2zihCj/pIC.a', 'batang', '0000-00-00', 'batang', 'posyandu'),
(4, 5, 'Nama Lengkap', 'baru@gmail.com', '$2y$10$ZvlEHx0B2g3ifyJzWS.xbuFMwxlK809bSx.r.tFY1iZ3ZCwfFas7u', 'Tembpat Lahi', '0000-00-00', 'Alamat', 'Posyandu Baru'),
(5, 5, 'Nama ansdkjh', 'email@gmail.com', '$2y$10$xbulV.uG/dqU99doiWK7.u6x9KV4HGvVzJyUa9/0vwe0aLr2P3DPO', 'kjaghsjdgba', '0000-00-00', 'asda', 'Posyandu Baru');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bayi`
--
ALTER TABLE `bayi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengukuran`
--
ALTER TABLE `pengukuran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posyandu`
--
ALTER TABLE `posyandu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bayi`
--
ALTER TABLE `bayi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pengukuran`
--
ALTER TABLE `pengukuran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `posyandu`
--
ALTER TABLE `posyandu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
