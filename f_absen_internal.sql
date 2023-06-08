-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2023 at 11:14 AM
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

--
-- Dumping data for table `fai_absen`
--

INSERT INTO `fai_absen` (`id_absen`, `id_user`, `tgl_absen`, `absen_masuk`, `absen_pulang`, `pending`, `catatan_pending`, `tgl_add`, `tgl_update`) VALUES
('3b73a7e0d0e756324fe73c5f11fc3312', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-10', '', '', 5, 'luar kota', '2023-06-05 14:28:51', '2023-06-06 16:36:23'),
('40009e913a976821f6ec110eaf27529c', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-16', '', '', 5, 'healing', '2023-06-07 08:44:51', '2023-06-08 10:51:08'),
('561dc377e3adcf16b94742b494cdf6af', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-07', '07:59', '', 2, 'Lupa guyyssss', '2023-06-07 08:50:06', '2023-06-07 09:14:57'),
('76f34d3307dc2144b9e9620daf63665d', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-05-31', '11:15', '', 0, '', '2023-05-25 11:15:53', '2023-05-31 17:09:25');

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
  `sisa_cuti` int(2) NOT NULL,
  `role_user` tinyint(1) NOT NULL COMMENT '1-user,2-admin',
  `role_pegawai` tinyint(1) NOT NULL COMMENT '1-staff,2-atasan',
  `no_telp` varchar(20) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fai_akun`
--

INSERT INTO `fai_akun` (`id_akun`, `nama_user`, `email`, `password`, `id_jabatan`, `sisa_cuti`, `role_user`, `role_pegawai`, `no_telp`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('4bc0c527a7c2a9053450a7fb8f92746f', 'Alfan', 'muhammad.alfan2000@gmail.com', '25f9e794323b453885f5181f1b624d0b', '056f1e0921dec47f2d7a5c99dc263c5e', 10, 2, 1, '085232998963', '2023-05-24 09:43:00', '2023-05-30 10:15:15', NULL),
('95ddf26fe5ead88db8b23936157aff0f', 'user2', 'ok2@ok.com', '25f9e794323b453885f5181f1b624d0b', 'f9c3eb7acc5cc81ba3ee91f0d96f1016', 12, 1, 2, '08222222222', '2023-05-29 17:06:21', '2023-05-30 09:44:26', '2023-05-30 09:44:26'),
('d366b0867097f7a0dc3d309cbbd3179e', 'user12', 'ok12@ok.com', '25f9e794323b453885f5181f1b624d0b', 'f9c3eb7acc5cc81ba3ee91f0d96f1016', 12, 1, 1, '08511111111111111', '2023-05-29 16:40:46', '2023-05-29 17:54:04', NULL);

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

--
-- Dumping data for table `fai_jabatan`
--

INSERT INTO `fai_jabatan` (`id_jabatan`, `nama_jabatan`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('056f1e0921dec47f2d7a5c99dc263c5e', 'IT Engineer', '2023-05-24 09:40:40', '2023-05-30 10:27:30', NULL),
('f9c3eb7acc5cc81ba3ee91f0d96f1016', 'Engineer', '2023-05-29 14:40:18', NULL, NULL);

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

--
-- Dumping data for table `fai_libur`
--

INSERT INTO `fai_libur` (`id_libur`, `tgl_libur`, `keterangan`, `tgl_add`, `tgl_update`) VALUES
('79beead82620fffa5cab09b118a4f5bd', '2023-06-17', 'tes libur', '2023-06-06 14:04:19', '2023-06-06 14:19:35');

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

--
-- Dumping data for table `fai_notif`
--

INSERT INTO `fai_notif` (`id_notif`, `mode_notif`, `isi_notif`, `alasan`, `status_baca`, `id_user`, `tgl_add`, `tgl_update`) VALUES
('0382b62171c51b16b3cee744575cb5df', 1, 'Pengajuan Absen Unpaid Leave tanggal 16/06/2023 ditolak', 'tgl salah', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 10:15:25', '2023-06-08 13:08:50'),
('154e613e96110dd697d8675493d0a515', 2, 'Pengajuan Absen Unpaid Leave ditolak', 'tgl salah', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 09:33:52', '2023-06-08 13:08:50'),
('3c7503f263b98fb5eec8c05c1a3673a7', 1, 'Pengajuan Absen Unpaid Leave tanggal 16/06/2023 ditolak', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 10:46:24', '2023-06-08 13:08:50'),
('4afaf84dcdc3dcc3adf070b62a4efa8d', 1, 'Pengajuan Absen Unpaid Leave tanggal 16/06/2023 ditolak', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 10:46:34', '2023-06-08 13:08:50'),
('4fe800e69e536937c4f4b729a4274969', 2, 'Pengajuan Absen Unpaid Leave tanggal 16/06/2023 disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 10:51:08', '2023-06-08 13:08:50'),
('8206489fafd22ba311ad7f3ae18988fc', 1, 'Pengajuan Absen Unpaid Leave tanggal 16/06/2023 ditolak', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 10:46:30', '2023-06-08 13:08:50'),
('af741923eaeb1b737e09eaca283e1e8a', 1, 'Pengajuan Absen Unpaid Leave tanggal  ditolak', 'tgl salah', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 10:14:53', '2023-06-08 13:08:50'),
('cb5f2838082e4b2f362dae2e693339c3', 2, 'Pengajuan Absen Unpaid Leave disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 10:48:56', '2023-06-08 13:08:50');

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

--
-- Dumping data for table `fai_pending_detail`
--

INSERT INTO `fai_pending_detail` (`id_pending`, `nama_pending`, `tgl_add`, `tgl_update`) VALUES
(0, 'Live Absen', '2023-06-05 09:11:16', NULL),
(1, 'Pending Absen', '2023-06-05 09:11:16', '2023-06-07 09:12:51'),
(2, 'Pending Acc', '2023-06-05 09:11:39', NULL),
(3, 'Pending Ditolak', '2023-06-05 09:11:39', NULL),
(4, 'Cuti', '2023-06-05 09:12:06', NULL),
(5, 'Unpaid Leave', '2023-06-05 09:12:06', '2023-06-07 08:49:06'),
(6, 'Sakit', '2023-06-05 09:12:25', NULL),
(7, 'Pending Cuti', '2023-06-05 09:12:25', NULL),
(8, 'Pending Unpaid Leave', '2023-06-05 09:12:44', '2023-06-07 08:49:00'),
(9, 'Pending Sakit', '2023-06-05 09:12:44', NULL);

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
-- Indexes for table `fai_jabatan`
--
ALTER TABLE `fai_jabatan`
  ADD PRIMARY KEY (`id_jabatan`),
  ADD UNIQUE KEY `nama_jabatan` (`nama_jabatan`);

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
