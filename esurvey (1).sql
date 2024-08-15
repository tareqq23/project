-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jul 2024 pada 11.00
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esurvey`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `cover_image`, `description`) VALUES
(9, 'Kebutuhan Air bagi tubuh', 'uploads/sehat.jpeg', 'Kebutuhan air bagi tubuh manusia perhari'),
(10, 'Pertambangan Kali timbang', 'uploads/tambang.jpeg', 'Respond masyarakat terkait kegiatan ini'),
(11, 'Lingkungan Hutan di Daerah Kalimantan Timur', 'uploads/hutan1.jpeg', 'Terdapat isu bahwa Hutan di Kalimantan Timur akan ditebang'),
(13, 'Ekosistem Pantai Merak', 'uploads/images (1).jpeg', 'Upaya meningkatkan kepedulian kebersihan pantai dari sampah dan limbah.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `question` text NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `question_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `questions`
--

INSERT INTO `questions` (`id`, `category_id`, `question`, `category_name`, `question_type`) VALUES
(11, 9, 'Saya merasa bahwa minum air dalam jumlah yang cukup setiap hari penting untuk kesehatan.', NULL, 'multiple_choice'),
(12, 9, 'Saya menyadari berapa banyak air yang harus saya minum setiap hari untuk menjaga kesehatan tubuh.', NULL, 'multiple_choice'),
(13, 9, 'Saya cenderung minum air lebih banyak ketika berolahraga atau beraktivitas fisik.', NULL, 'multiple_choice'),
(14, 9, 'Saya merasa lebih sehat ketika saya minum air yang cukup setiap hari.', NULL, 'rating_scale'),
(15, 9, 'Saya sering mengalami dehidrasi karena kurang minum air.', NULL, 'rating_scale'),
(16, 10, 'Aktivitas pertambangan di Kali Timbang memberikan dampak positif terhadap ekonomi lokal.', NULL, 'rating_scale'),
(17, 10, 'Saya khawatir dengan dampak lingkungan yang ditimbulkan oleh pertambangan di Kali Timbang.', NULL, 'rating_scale'),
(18, 10, 'Pertambangan di Kali Timbang sebaiknya terus dilakukan demi peningkatan ekonomi.', NULL, 'rating_scale'),
(19, 10, 'Saya merasa pertambangan di Kali Timbang perlu diawasi lebih ketat untuk mencegah kerusakan lingkungan.', NULL, 'rating_scale'),
(20, 10, 'Masyarakat lokal dilibatkan dalam pengambilan keputusan terkait pertambangan di Kali Timbang.', NULL, 'rating_scale'),
(21, 11, 'Saya mendukung upaya pelestarian hutan di Kalimantan Timur.', NULL, 'rating_scale'),
(22, 10, 'Aktivitas deforestasi di Kalimantan Timur mengkhawatirkan saya.', NULL, 'rating_scale'),
(23, 11, 'Hutan di Kalimantan Timur sangat penting untuk menjaga keseimbangan ekosistem.', NULL, 'rating_scale'),
(24, 11, 'aya merasa pemerintah perlu melakukan tindakan lebih tegas untuk melindungi hutan di Kalimantan Timur.', NULL, 'rating_scale'),
(25, 11, 'Penggunaan lahan hutan untuk industri di Kalimantan Timur harus diatur dengan ketat.', NULL, 'rating_scale'),
(26, 13, 'Seberapa puas Anda dengan upaya pemerintah dalam mengatasi masalah sampah dan limbah di pantai?', NULL, 'rating_scale'),
(27, 13, 'Flora di pantai Merak', NULL, 'rating_scale');

-- --------------------------------------------------------

--
-- Struktur dari tabel `responses`
--

CREATE TABLE `responses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `response` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `responses`
--

INSERT INTO `responses` (`id`, `user_id`, `question_id`, `response`) VALUES
(24, 10, 11, '3'),
(25, 10, 12, '3'),
(26, 10, 13, '2'),
(27, 10, 14, '2'),
(28, 10, 15, '3'),
(29, 10, 11, '2'),
(30, 10, 12, '2'),
(31, 10, 13, '3'),
(32, 10, 14, '3'),
(33, 10, 15, '3'),
(34, 8, 11, '1'),
(35, 8, 12, '2'),
(36, 8, 13, '3'),
(37, 8, 14, '4'),
(38, 8, 15, '5'),
(39, 16, 11, '1'),
(40, 16, 12, '2'),
(41, 16, 13, '2'),
(42, 16, 14, '2'),
(43, 16, 15, '2'),
(44, 16, 21, '4'),
(45, 16, 23, '4'),
(46, 16, 24, '5'),
(47, 16, 25, '5'),
(48, 16, 16, '2'),
(49, 16, 17, '4'),
(50, 16, 18, '1'),
(51, 16, 19, '3'),
(52, 16, 20, '3'),
(53, 16, 22, '4'),
(54, 23, 21, '5'),
(55, 23, 23, '5'),
(56, 23, 24, '5'),
(57, 23, 25, '5'),
(58, 23, 11, '1'),
(59, 23, 12, '2'),
(60, 23, 13, '4'),
(61, 23, 14, '3'),
(62, 23, 15, '5');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','responden') NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_confirmed` tinyint(1) DEFAULT 0,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `first_name`, `last_name`, `email`, `is_confirmed`, `token`) VALUES
(1, 'admin', '$2y$10$lYbSK7e6M5Lqq60/XAOjgOd2N9POcsfGrjfp7HGm.ghXfb7qLZx.K', 'admin', '', '', '', 0, NULL),
(2, 'admin', '$2y$10$UxV9KxshyoGLY0Wr8.PYHuSTDLTftdiJJ/221lwVofhLzWki04y2q', 'admin', '', '', '', 0, NULL),
(3, 'admin', '$2y$10$KLTipWnrUberfMUr8r6hwuxHRY0NPRVFi4Qte733PUTFLWCbXer36', 'admin', '', '', '', 0, NULL),
(4, 'admin', '$2y$10$ey5rZ6nlg.VS/fuBCc3oZ.i20sCLpGExmxlAj6drrKYjjjLICXYAS', 'admin', '', '', '', 0, NULL),
(5, 'modar', '$2y$10$LBiRgMrzn1aH1Q1HAm1u3OGVGBRMSK2MoqVSQoN9rAybvRhZ6P9vS', 'responden', '', '', '', 0, '09b450fe05afba4bd5198949e2d633fd71695cdf2d4b3082760f49e2604cc0e3cb2f84f6b423aef9313e4c651d2e393ef095'),
(6, 'modar', '$2y$10$jrUCwY37fvrFUU5VUMVagO1hxlPaEUV3YaE3FZF9DiCLpfDZYimi6', 'admin', '', '', '', 0, '09b450fe05afba4bd5198949e2d633fd71695cdf2d4b3082760f49e2604cc0e3cb2f84f6b423aef9313e4c651d2e393ef095'),
(7, 'modar', '$2y$10$TTgXQGz3kFlvnKPzDGcTx.1eLc17R9h/vB3JjZS73EcL4gwSU7E5K', 'admin', '', '', '', 0, '09b450fe05afba4bd5198949e2d633fd71695cdf2d4b3082760f49e2604cc0e3cb2f84f6b423aef9313e4c651d2e393ef095'),
(8, 'sadam', '$2y$10$H.NMOpQJZH6vcLUHQyQDoexu1Xu40phVJU8HaAiWkWwnAlyNp0KVm', 'responden', '', '', '', 0, NULL),
(9, 'sadam', '$2y$10$u1tpsW5rrhhO3X7LdOyeceJhv7kaJcyjkrqU7p9OF8bHCSAdtqsYu', 'admin', '', '', '', 0, NULL),
(10, 'hafi', '$2y$10$HesKtWqCRCCjKFK9IEUNMO0SrHC7ewSMFhYQkUgyUcpsu0HaWhZBu', 'responden', '', '', '', 0, NULL),
(11, 'sadam', '$2y$10$mChp9lXWWV1W62Nes08Rwe8N8tW8URcPCEZJdc8HEqJ6zjlCTH0G6', 'responden', '', '', '', 0, NULL),
(15, 'modar12', '$2y$10$n9IvxKlk.gRtpXZzeA8zj.PvhqmzSvm1xUl36Vv9xegqslC.c4nni', 'responden', 'Mohamad', 'Haidar ', 'frompag1928@gmail.com', 1, '04a73310fbb62225fec657348efa6dc877d935e1935563e273eb46a330f59452b2d4ca204fe39e00e2da3925915ad65e44b0'),
(16, 'hafi01', '$2y$10$8Ono4/W8CULkSaStJUnCt.6dFTxTAAElUo9IIHxioJyjsSFjyEqPa', 'responden', 'M. Hafi', 'Dimas', 'sriyatin0105@gmail.com', 1, '8181273f06032d6d863eb37ef520ccd149db32bf86c735841d4014cec3026d846aaf129ac4ef7ab7169cefece9f7ad6fcf1c'),
(17, 'dimas', '$2y$10$HrKun9Vt4zmCrcahmphyVOcWp41Rrd4FE/VbyN2/YUYvHaxUpRew2', 'responden', 'Dimas', 'Tama', 'dimastama.tama@gmail.com', 0, 'a300080b93b13fb94b1b4934d101d56708d12c2851348cf9c45a7a8a78c67980c31cad43ad8ae70f7c3ac08781e52b524b70'),
(18, 'dimas12', '$2y$10$wzL7UewJJIWpOlkbba1V6.wVRHCbpV/PiqtW/PvPOUnjrCuQDn6gS', 'responden', 'Dimas', 'Tama', 'dimastama.tamaaa@gmail.com', 0, '1a9a8ffa4b5e04f14b796e420495ee73dbd85ad6b577f8a62c500b0bb6f9769bbe368b419a0c4417d8b3c78a04afd20e5223'),
(19, 'sadam', '$2y$10$L/97e0u18pzwVXqSMzyjwe43Rp2iKyg3gZfHVQbUBi/vNH8hL1hlK', 'responden', 'sadam', 'alamsyah', 'sadamalamsyah04@gmail.com', 0, 'a6feb3d396a672e83348765947182bf4b418e2ebf277484a98859094e977a053de7ef438d10f3bac03bbbd63ba87ff1fe625'),
(21, 'sadam01', '$2y$10$fqLqTT4nVO66T/U2dckEv.FLoQ1lidMclWwZZkwrutLxf.B5g3k72', 'responden', 'Sadam', 'Alamsyah', 'sriyatin0105@gmail.com', 1, NULL),
(22, 'hafi01', '$2y$10$T4ANMQwAf1loOa6IQuZScOvKwwjtRgVDX/RWm5p33GK1XQ5nD4r3a', 'responden', 'Mohamad', 'Haidar ', 'frompag1928@gmail.com', 0, '04a73310fbb62225fec657348efa6dc877d935e1935563e273eb46a330f59452b2d4ca204fe39e00e2da3925915ad65e44b0'),
(23, 'sadam12', '$2y$10$CYffRm19SMhdq9YMP/IyIu377a/jIyw94eNwoIOZdijFcWiwS/ThG', 'responden', 'Sadamm', 'Alamsyah', 'sadam.alamsyah04@gmail.com', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indeks untuk tabel `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Ketidakleluasaan untuk tabel `responses`
--
ALTER TABLE `responses`
  ADD CONSTRAINT `responses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `responses_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
