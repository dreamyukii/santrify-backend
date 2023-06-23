-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jun 2023 pada 08.51
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pemro-web`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `username_admin` varchar(15) NOT NULL,
  `nama_admin` text NOT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `pass_admin` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `birthDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`username_admin`, `nama_admin`, `email`, `pass_admin`, `address`, `birthDate`) VALUES
('keii', 'RFaizal', 'iliveinspain@gmail.com', 'capek', 'Jalan Coconut Adalah No.1', '2000-01-01'),
('yaehiko', 'Yae Hiko', 'gataumauisiapa@gmail.com', 'wkwkwk10x', 'Jalan Mantan No.1', '2001-08-05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `history`
--

CREATE TABLE `history` (
  `id_santri` int(2) NOT NULL,
  `pass_santri` varchar(8) NOT NULL,
  `nama_santri` text NOT NULL,
  `sex` varchar(1) NOT NULL,
  `status` text NOT NULL,
  `kamar` varchar(18) NOT NULL,
  `divisi` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kamar`
--

CREATE TABLE `kamar` (
  `id_kamar` int(2) NOT NULL,
  `nama_kamar` varchar(28) NOT NULL,
  `max_capacity` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kamar`
--

INSERT INTO `kamar` (`id_kamar`, `nama_kamar`, `max_capacity`) VALUES
(1, 'Keren', 30),
(2, 'Gokil', 25);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int(2) NOT NULL,
  `nama_mapel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `santri`
--

CREATE TABLE `santri` (
  `id_santri` int(2) NOT NULL,
  `pass_santri` varchar(8) NOT NULL,
  `nama_santri` text NOT NULL,
  `sex` varchar(1) NOT NULL,
  `status` text NOT NULL,
  `kamar` varchar(18) NOT NULL,
  `divisi` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `santri`
--

INSERT INTO `santri` (`id_santri`, `pass_santri`, `nama_santri`, `sex`, `status`, `kamar`, `divisi`) VALUES
(1, 'oAsjD', 'Faizal', 'L', 'Aktif', 'Keren', 'Gatau apa'),
(2, 'dDjGs', 'Jo', 'L', 'Aktif', 'Keren', 'Gabud'),
(3, 'DasMu', 'Prima', 'L', 'Aktif', 'Keren', 'Valhem tros'),
(4, 'WbSdA', 'Ahmad', 'L', 'Non-aktif', 'Keren', 'Wibu'),
(5, 'SfiFs', 'Fatah', 'L', 'Aktif', 'Keren', 'Gatau males');

--
-- Trigger `santri`
--
DELIMITER $$
CREATE TRIGGER `after_update_santri` AFTER UPDATE ON `santri` FOR EACH ROW BEGIN
	INSERT INTO history(id_santri, pass_santri, nama_santri, sex, status, kamar, divisi)
	VALUES (OLD.id_santri, OLD.pass_santri, OLD.nama_santri, OLD.sex, OLD.status, OLD.kamar, OLD.divisi);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `id_santri` int(2) NOT NULL,
  `status` text NOT NULL,
  `nominal` int(11) NOT NULL,
  `bulan_pembayaran` int(11) NOT NULL,
  `jumlah_pembayaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username_admin`);

--
-- Indeks untuk tabel `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id_santri`);

--
-- Indeks untuk tabel `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id_kamar`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indeks untuk tabel `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id_santri`);

--
-- Indeks untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD UNIQUE KEY `id_santri` (`id_santri`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id_kamar` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `santri`
--
ALTER TABLE `santri`
  MODIFY `id_santri` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
