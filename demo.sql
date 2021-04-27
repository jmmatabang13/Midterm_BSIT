-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2021 at 01:58 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jj`
--

-- --------------------------------------------------------

--
-- Table structure for table `code`
--

CREATE TABLE `code` (
  `id_code` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `code`
--

INSERT INTO `code` (`id_code`, `user_id`, `code`, `created_at`, `expiration`) VALUES
(1, 25, '948256', '2021-04-23 18:41:49', '2021-04-23 18:43:49'),
(2, 27, '495168', '2021-04-23 18:42:51', '2021-04-23 18:44:51'),
(3, 27, '586904', '2021-04-23 18:44:06', '2021-04-23 18:46:06'),
(4, 25, '430168', '2021-04-23 18:48:37', '2021-04-23 18:50:37'),
(5, 30, '451069', '2021-04-23 18:54:20', '2021-04-23 18:56:20'),
(6, 30, '039184', '2021-04-23 18:59:52', '2021-04-23 19:01:52'),
(7, 30, '876935', '2021-04-23 19:06:54', '2021-04-23 19:08:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(25, 'ADMIN', '$2y$10$l/uxwHCmj8bcVbVwQsnI3.3nxckZWbNWVVXLTTuQBWZIT.P6FAwkK', 'admin@gmail.com', '2021-04-22 21:22:23'),
(26, 'JJM', '$2y$10$PIp/R/cTnWTBB8A/66n73uPy2Vze8tJp6HoORibXl7otew6QERb7i', 'JJM@GMAIL.COM', '2021-04-22 21:23:01'),
(27, 'jm', '$2y$10$HqWo8cWDxgSwz/hPiN7HM.D3hkndfkub8zIsNn6VNkrlc9ll6lByq', 'jm@gmail.com', '2021-04-22 21:23:26'),
(28, 'james', '$2y$10$VXxR.pwbNSreXFHiYdRb9On6vxJ0eGGd7ZZYtbozxYmgiR0dyT7Ou', 'james@gmail.com', '2021-04-22 23:14:52'),
(29, 'mama', '$2y$10$e60ThwxfyPqXHQ5rSk7V0ujK33Js/4cjtMoZV78183srtUKcH6adq', 'mama@gmal.com', '2021-04-23 17:37:05'),
(30, 'matabang', '$2y$10$nJWl3Uc.zwiwdM/4t8XzWO4CyDnW1oM8O6jTZIxnXA1wmtu1kkMH.', 'matabang@gmail.com', '2021-04-23 18:54:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `code`
--
ALTER TABLE `code`
  ADD PRIMARY KEY (`id_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `code`
--
ALTER TABLE `code`
  MODIFY `id_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
