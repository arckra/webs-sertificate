-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 03 Feb 2026 pada 13.57
-- Versi server: 8.0.30
-- Versi PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `sertifikat_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `acara`
--

CREATE TABLE `acara` (
  `id` int NOT NULL,
  `nama_acara` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `acara`
--

INSERT INTO `acara` (`id`, `nama_acara`, `created_at`) VALUES
(1, 'Seminar Nasional Teknologi', '2026-02-03 04:12:40'),
(2, 'Workshop Pemrograman Web', '2026-02-03 04:12:40'),
(3, 'Pelatihan Data Science', '2026-02-03 04:12:40'),
(4, 'Lomba Inovasi Digital', '2026-02-03 04:12:40'),
(5, 'Webinar Kewirausahaan', '2026-02-03 04:12:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nim`, `nama`, `created_at`) VALUES
(1, '312410248', 'Administrator Utama', '2026-02-03 04:12:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sertifikat`
--

CREATE TABLE `sertifikat` (
  `id` int NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama_peserta` varchar(100) NOT NULL,
  `id_acara` int NOT NULL,
  `tanggal_pelaksana` date NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sertifikat`
--

INSERT INTO `sertifikat` (`id`, `nim`, `nama_peserta`, `id_acara`, `tanggal_pelaksana`, `nama_file`, `created_at`) VALUES
(1, '312410001', 'Ahmad Fauzi', 1, '2025-01-15', '312410001.pdf', '2026-02-03 04:12:40'),
(2, '312410002', 'Budi Santoso', 2, '2025-02-20', '312410002.pdf', '2026-02-03 04:12:40'),
(3, '312410003', 'Citra Dewi', 3, '2025-03-10', '312410003.pdf', '2026-02-03 04:12:40'),
(4, '312410248', 'Ari Cakra Kurniawan', 1, '2025-04-05', '312410248.pdf', '2026-02-03 04:12:40');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `acara`
--
ALTER TABLE `acara`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indeks untuk tabel `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_acara` (`id_acara`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `acara`
--
ALTER TABLE `acara`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `sertifikat`
--
ALTER TABLE `sertifikat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD CONSTRAINT `sertifikat_ibfk_1` FOREIGN KEY (`id_acara`) REFERENCES `acara` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
