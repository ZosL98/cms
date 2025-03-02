-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 02. mar 2025 ob 21.11
-- Različica strežnika: 10.4.28-MariaDB
-- Različica PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `cms`
--

-- --------------------------------------------------------

--
-- Struktura tabele `posts`
--

CREATE TABLE `posts` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `author` int(11) NOT NULL,
  `date` date NOT NULL,
  `added` datetime NOT NULL DEFAULT current_timestamp(),
  `Image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `author`, `date`, `added`, `Image`) VALUES
(1, 'New title', '<p>Some content dwasd</p>', 1, '2025-01-30', '2025-01-31 13:40:38', NULL),
(2, 'My second post123', '<p>we <strong>can </strong>do a lot here..</p>\r\n<p>&nbsp;</p>\r\n<p>Adjust</p>', 6, '2025-01-31', '2025-01-31 14:05:04', 'RZ7nfx.jpg'),
(20, 'My Title', '<p>Content with image</p>', 6, '2025-03-02', '2025-03-02 15:03:12', 'video-game-daxter-wallpaper-preview.jpg');

-- --------------------------------------------------------

--
-- Struktura tabele `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `active`, `added`) VALUES
(2, 'david', 'david@gmail.com', 'e5e9fa1ba31ecd1ae84f75caaa474f3a663f05f4', 1, '2025-01-27 14:35:03'),
(5, 'John12', 'john@gmail.com', '8f44d00edadbf357a00d6fbd60e3b78bb1b3a8ee', 1, '2025-01-27 16:58:58'),
(6, 'admin', 'admin@email.com', 'e5e9fa1ba31ecd1ae84f75caaa474f3a663f05f4', 1, '2025-01-29 15:13:52');

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indeksi tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT tabele `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
