-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2023 at 06:46 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `f_absen_internal`
--

-- --------------------------------------------------------

--
-- Table structure for table `fai_absen`
--

CREATE TABLE `fai_absen` (
  `id_absen` varchar(255) NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `tgl_absen` date DEFAULT NULL,
  `absen_masuk` varchar(5) NOT NULL,
  `absen_pulang` varchar(5) NOT NULL,
  `pending` int(11) NOT NULL COMMENT '0 - live absen, 1 - pending, 2- pending acc,3 - pending ditolak, 4 - Cuti, 5 - unpaid leave, 6 - sakit, 7 - pending cuti, 8 - pending unpaid leave, 9 - pending sakit',
  `catatan_pending` text NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fai_akun`
--

CREATE TABLE `fai_akun` (
  `id_akun` varchar(255) NOT NULL,
  `nama_user` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_jabatan` varchar(255) NOT NULL,
  `id_lokasi` varchar(255) NOT NULL,
  `sisa_cuti` int(2) NOT NULL,
  `role_user` tinyint(1) NOT NULL COMMENT '1-user,2-admin, 3 - su admin',
  `role_pegawai` tinyint(1) NOT NULL COMMENT '1-staff,2-atasan',
  `no_telp` varchar(20) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fai_akun_lokasi`
--

CREATE TABLE `fai_akun_lokasi` (
  `id_al` varchar(255) NOT NULL,
  `id_akun` varchar(255) NOT NULL,
  `id_lokasi` varchar(255) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fai_jabatan`
--

CREATE TABLE `fai_jabatan` (
  `id_jabatan` varchar(255) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fai_lembur`
--

CREATE TABLE `fai_lembur` (
  `id_lembur` varchar(255) NOT NULL,
  `id_akun` varchar(255) NOT NULL,
  `tgl_lembur` date NOT NULL,
  `mulai_lembur` varchar(5) NOT NULL,
  `selesai_lembur` varchar(5) NOT NULL,
  `point_lembur` decimal(10,2) NOT NULL,
  `status_lembur` tinyint(1) NOT NULL COMMENT '0 - pending; 1 - acc',
  `keterangan` varchar(255) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fai_libur`
--

CREATE TABLE `fai_libur` (
  `id_libur` varchar(255) NOT NULL,
  `tgl_libur` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fai_log`
--

CREATE TABLE `fai_log` (
  `id_log` varchar(255) NOT NULL,
  `data_log` text NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fai_lokasi`
--

CREATE TABLE `fai_lokasi` (
  `id_lokasi` varchar(255) NOT NULL,
  `nama_lokasi` varchar(40) NOT NULL,
  `long_lokasi` varchar(200) NOT NULL,
  `lat_lokasi` varchar(200) NOT NULL,
  `batas_lokasi` int(9) NOT NULL COMMENT 'satuan meter; 60 meter - 0.2',
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fai_notif`
--

CREATE TABLE `fai_notif` (
  `id_notif` varchar(255) NOT NULL,
  `mode_notif` tinyint(1) NOT NULL COMMENT '1 - alert; 2 - success',
  `isi_notif` varchar(255) NOT NULL,
  `alasan` varchar(255) NOT NULL,
  `status_baca` tinyint(1) NOT NULL COMMENT '0 - unread; 1 - read',
  `id_user` varchar(255) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fai_pending_detail`
--

CREATE TABLE `fai_pending_detail` (
  `id_pending` int(5) NOT NULL,
  `nama_pending` varchar(100) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fai_pengumuman`
--

CREATE TABLE `fai_pengumuman` (
  `id_pengumuman` varchar(255) NOT NULL,
  `nama_pengumuman` varchar(200) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fai_absen`
--
ALTER TABLE `fai_absen`
  ADD PRIMARY KEY (`id_absen`);

--
-- Indexes for table `fai_akun`
--
ALTER TABLE `fai_akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indexes for table `fai_akun_lokasi`
--
ALTER TABLE `fai_akun_lokasi`
  ADD PRIMARY KEY (`id_al`);

--
-- Indexes for table `fai_jabatan`
--
ALTER TABLE `fai_jabatan`
  ADD PRIMARY KEY (`id_jabatan`),
  ADD UNIQUE KEY `nama_jabatan` (`nama_jabatan`);

--
-- Indexes for table `fai_lembur`
--
ALTER TABLE `fai_lembur`
  ADD PRIMARY KEY (`id_lembur`);

--
-- Indexes for table `fai_libur`
--
ALTER TABLE `fai_libur`
  ADD PRIMARY KEY (`id_libur`);

--
-- Indexes for table `fai_log`
--
ALTER TABLE `fai_log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `fai_lokasi`
--
ALTER TABLE `fai_lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `fai_notif`
--
ALTER TABLE `fai_notif`
  ADD PRIMARY KEY (`id_notif`);

--
-- Indexes for table `fai_pending_detail`
--
ALTER TABLE `fai_pending_detail`
  ADD PRIMARY KEY (`id_pending`);

--
-- Indexes for table `fai_pengumuman`
--
ALTER TABLE `fai_pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
