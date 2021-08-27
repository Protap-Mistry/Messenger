-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2021 at 10:27 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `messenger`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `message` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `to_user_id`, `from_user_id`, `message`, `status`, `timestamp`) VALUES
(1, 1, 2, 'hi, pro...', 0, '2021-08-18 18:20:07'),
(2, 1, 2, 'how are u?', 0, '2021-08-18 18:20:38'),
(3, 3, 2, 'hi, taha...', 0, '2021-08-19 07:16:02'),
(4, 3, 2, 'hi, taha\n', 0, '2021-08-19 07:22:06'),
(5, 3, 2, 'how are you?', 0, '2021-08-19 07:22:33'),
(6, 2, 3, 'well', 1, '2021-08-19 07:22:58'),
(7, 2, 3, 'you?', 1, '2021-08-19 07:23:14'),
(8, 3, 2, 'good', 0, '2021-08-19 07:23:43'),
(9, 3, 2, 'hi, sarw', 0, '2021-08-19 07:25:29'),
(10, 2, 3, 'hello', 1, '2021-08-19 07:25:52'),
(11, 3, 2, 'hi\n', 0, '2021-08-19 07:28:23'),
(12, 2, 3, 'hello', 1, '2021-08-19 07:28:40'),
(13, 3, 2, 'how are u?', 0, '2021-08-19 07:30:29'),
(14, 2, 3, 'gd, you?', 1, '2021-08-19 07:32:13'),
(15, 3, 2, 'also gd', 0, '2021-08-19 07:32:40'),
(16, 3, 1, 'hiiii', 0, '2021-08-19 08:25:51'),
(17, 1, 3, 'hello', 0, '2021-08-19 08:26:04'),
(18, 4, 3, 'hi', 0, '2021-08-19 08:45:27'),
(19, 3, 1, 'how are you?', 0, '2021-08-19 08:56:57'),
(20, 1, 3, 'what are you doing?', 0, '2021-08-19 11:14:57'),
(21, 3, 1, 'Nothing', 0, '2021-08-19 11:15:25'),
(22, 3, 4, 'hello', 0, '2021-08-19 17:38:53'),
(23, 4, 3, 'first send 😎', 0, '2021-08-19 18:24:17'),
(24, 4, 3, 'Is it okay? ☹', 0, '2021-08-19 18:25:33'),
(25, 4, 3, 'already sent', 0, '2021-08-19 18:28:01'),
(26, 3, 4, 'Yep, done 😝', 0, '2021-08-19 18:28:31'),
(27, 0, 1, '', 2, '2021-08-20 09:35:31'),
(28, 0, 4, '', 1, '2021-08-20 09:35:48'),
(29, 0, 1, '', 2, '2021-08-20 09:36:09'),
(30, 0, 4, '', 1, '2021-08-20 09:36:53'),
(31, 0, 3, '', 1, '2021-08-20 09:37:23'),
(32, 0, 3, 'done', 1, '2021-08-20 09:41:03'),
(33, 0, 1, '😇😇😇', 2, '2021-08-20 09:48:54'),
(34, 0, 1, '\n<p><img src=\"images/loader.png\" class=\"img-responsive img-thumbnail\" width=\"500px\" height=\"300px\"></p><br>', 1, '2021-08-20 15:59:18'),
(35, 0, 1, '\nproblem                                    \n                                ', 1, '2021-08-20 16:03:14'),
(36, 0, 1, '\n<p><img src=\"images/loader.png\" class=\"img-responsive img-thumbnail\" width=\"200px\" height=\"200px\"></p><br>', 1, '2021-08-20 16:07:00'),
(37, 0, 1, '\n<p><img src=\"images/b3.jpg\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-20 16:07:37'),
(38, 0, 1, '\n<p><img src=\"images/django.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-20 16:13:26'),
(39, 0, 1, '\n<p><img src=\"images/bd.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-20 16:14:33'),
(40, 0, 1, '\nimage?                                    \n                                ', 1, '2021-08-20 16:27:45'),
(41, 0, 1, '\n<p><img src=\"images/google.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 2, '2021-08-20 16:27:55'),
(42, 0, 1, 'whoops', 2, '2021-08-20 16:28:21'),
(43, 0, 1, '\n<p><img src=\"images/laravel.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 2, '2021-08-20 17:51:35'),
(44, 2, 1, 'hello!! sarw', 2, '2021-08-21 07:06:36'),
(45, 2, 1, 'I am well, and u?', 0, '2021-08-21 07:06:53'),
(46, 0, 2, 'group chat', 1, '2021-08-21 07:51:13'),
(47, 0, 1, 'hm', 1, '2021-08-21 07:52:04'),
(48, 2, 1, 'gd', 0, '2021-08-21 07:53:39'),
(49, 0, 2, '😛', 2, '2021-08-21 11:42:06'),
(50, 0, 2, '\n<p><img src=\"images/b3.jpg\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-21 11:42:29'),
(51, 0, 2, 'is it work?', 1, '2021-08-21 11:46:00'),
(52, 0, 1, 'hm', 1, '2021-08-21 11:49:29'),
(53, 0, 2, '\n<p><img src=\"images/bd.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-25 06:56:49'),
(54, 0, 2, '\n<p><img src=\"images/bd.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-25 07:00:52'),
(55, 0, 2, '\n<p><img src=\"images/django.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-25 07:14:37'),
(56, 0, 2, '\n<p><img src=\"images/google.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-25 07:15:23'),
(57, 0, 2, 'hi', 1, '2021-08-25 07:18:53'),
(58, 0, 2, '', 1, '2021-08-25 08:07:22'),
(59, 0, 2, '', 1, '2021-08-25 08:08:51'),
(60, 0, 2, '\n<p><img src=\"images/google.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-25 08:11:09'),
(61, 0, 2, '\n<p><img src=\"images/laravel.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-25 08:17:37'),
(62, 0, 2, '', 1, '2021-08-25 08:20:10'),
(63, 0, 2, '', 1, '2021-08-25 08:22:17'),
(64, 0, 2, '', 1, '2021-08-25 08:24:46'),
(65, 0, 2, '\n<p><img src=\"images/bd.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-25 08:26:32'),
(66, 0, 2, '\n<p><img src=\"images/laravel2.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-25 08:41:54'),
(67, 0, 2, 'message', 1, '2021-08-25 08:42:25'),
(68, 0, 2, 'fvgbhnjmk,l', 2, '2021-08-25 08:42:42'),
(69, 0, 2, '\n<p><img src=\"images/django.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-25 08:46:06'),
(70, 0, 2, '\n<p><img src=\"images/google.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-25 08:50:11'),
(71, 0, 2, '\n<p><img src=\"images/django.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-25 08:50:43'),
(72, 0, 2, '\n<p><img src=\"images/protu.PNG\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-25 08:52:39'),
(73, 0, 2, 'hi', 1, '2021-08-25 08:55:54'),
(74, 0, 2, '\n<p><img src=\"images/b3.jpg\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-25 08:56:24'),
(75, 1, 4, 'wedrftgyuikopl', 1, '2021-08-25 17:17:47'),
(76, 1, 4, 'what ?', 1, '2021-08-25 17:18:03'),
(77, 0, 4, 'what', 1, '2021-08-25 17:18:25'),
(78, 0, 4, 'xdcfvgbhjnmkl', 1, '2021-08-25 17:18:34'),
(79, 1, 2, 'okay?', 1, '2021-08-25 18:30:23'),
(80, 0, 2, '\n<p><img src=\"images/laravel2.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 2, '2021-08-25 18:33:14'),
(81, 0, 2, 'sdfghbjkml', 2, '2021-08-25 18:44:14'),
(82, 0, 2, 'serftgyhjk', 2, '2021-08-26 05:35:39'),
(83, 0, 2, 'something 😜', 1, '2021-08-26 05:41:28'),
(84, 0, 2, '\n<p><img src=\"images/django.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 2, '2021-08-26 05:44:20'),
(85, 0, 2, '\n<p><img src=\"images/django.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 2, '2021-08-26 05:45:20'),
(86, 0, 2, '\n<p><img src=\"images/django.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 2, '2021-08-26 05:46:51'),
(87, 0, 2, '\n<p><img src=\"images/google.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 2, '2021-08-26 05:47:45'),
(88, 0, 2, 'srdtfgyhjkl', 2, '2021-08-26 05:50:03'),
(89, 0, 2, 'fjiokpo😜', 1, '2021-08-26 05:50:32'),
(90, 0, 2, '\n<p><img src=\"images/django.png\" class=\"img-responsive img-thumbnail\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-26 05:53:23'),
(91, 0, 2, 'something', 1, '2021-08-26 05:53:47'),
(92, 0, 2, 'xytsgiueajfoprg😋😜😝😝', 1, '2021-08-26 05:54:13'),
(93, 0, 2, '\n<p><img src=\"images/b3.jpg\" class=\"img-responsive img-thumbnail\" id=\"show\" width=\"150px\" height=\"150px\"></p>ftegduiwejod', 1, '2021-08-26 06:05:31'),
(94, 0, 2, '\n<p><img src=\"images/b3.jpg\" class=\"img-responsive img-thumbnail\" id=\"show\" width=\"150px\" height=\"150px\"></p>okay?', 1, '2021-08-26 06:06:56'),
(95, 0, 2, 'fdyuwhdoiwd', 1, '2021-08-26 06:12:20'),
(96, 0, 2, '\n<p><img src=\"images/laravel.png\" class=\"img-responsive img-thumbnail\" id=\"show\" width=\"150px\" height=\"150px\"></p><br>', 1, '2021-08-26 06:12:30'),
(97, 0, 2, '\n<p><img src=\"images/protu.PNG\" class=\"img-responsive img-thumbnail\" id=\"show\" width=\"150px\" height=\"150px\"></p>okay?', 1, '2021-08-26 06:12:48'),
(98, 0, 2, '', 1, '2021-08-26 06:17:58'),
(99, 0, 2, '', 1, '2021-08-26 06:18:00'),
(100, 0, 2, '\n<p><img src=\"images/google.png\" class=\"img-responsive img-thumbnail\" id=\"show\" width=\"150px\" height=\"150px\"></p>google', 1, '2021-08-26 06:19:30'),
(101, 0, 2, '🙂', 1, '2021-08-26 06:19:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `bio` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `image`, `bio`) VALUES
(1, 'Protap Mistry', 'The_PRO', 'pro.cse4.bu@gmail.com', 'cc7d744dd71d2f11276b6cf44a19efe0', 'images/5365c33cb9.png', 'Too interested?					    							    							    						    '),
(2, 'Sarwar Hossain', 'Sarw', 'sarwar.cse4.bu@gmail.com', '80e361830cffb4220e091bd58e1829d4', '', ''),
(3, 'Taha Hussain', 'Taha', 'taha.cse4.bu@gmail.com', '3499f5efb34d41d7edc25e115d2a6d94', '', ''),
(4, 'Pranta Biswas', 'Pranta', 'pranta.cse4.bu@gmail.com', '577d21f6b8640633a21ced43076a22b6', '', ''),
(5, 'Mehedi Hasan Choton', 'Choton', 'm@gmail.com', '8d8c903c70adf3675d319f8b2cae907c', '', ''),
(6, 'Palash Mondal', 'Palash', 'palash@gmail.com', '492beca490753d54cd71aa8e7707112d', '', ''),
(7, 'MD. Iqbal Hossain', 'Iqbal', 'iqbal@gmail.com', '1d506c48c0c1366aaeb437e455c1f7f3', '', ''),
(8, 'Armaan Hossain', 'Armaan', 'armaan@gmail.com', 'a048138e82257d2b17a06b5a58cb6499', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_login_info`
--

CREATE TABLE `users_login_info` (
  `users_login_info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `typing` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_login_info`
--

INSERT INTO `users_login_info` (`users_login_info_id`, `user_id`, `last_activity`, `typing`) VALUES
(1, 3, '2021-08-20 18:44:53', 'no'),
(2, 3, '2021-08-20 18:46:05', 'no'),
(3, 1, '2021-08-21 19:16:35', 'no'),
(4, 2, '2021-08-21 19:16:28', 'no'),
(5, 1, '2021-08-22 05:18:10', 'no'),
(6, 8, '2021-08-22 07:18:24', 'no'),
(7, 1, '2021-08-22 12:28:46', 'no'),
(8, 1, '2021-08-23 19:10:49', 'no'),
(9, 2, '2021-08-23 18:14:14', 'no'),
(10, 3, '2021-08-23 18:22:06', 'no'),
(11, 2, '2021-08-25 19:06:46', 'no'),
(12, 1, '2021-08-25 06:35:59', 'no'),
(13, 3, '2021-08-25 08:00:04', 'no'),
(14, 4, '2021-08-25 12:10:01', 'no'),
(15, 3, '2021-08-25 13:22:50', 'no'),
(16, 3, '2021-08-25 13:36:16', 'no'),
(17, 4, '2021-08-25 16:51:44', 'no'),
(18, 1, '2021-08-25 17:00:25', 'no'),
(19, 3, '2021-08-25 18:12:59', 'no'),
(20, 4, '2021-08-25 18:12:27', 'no'),
(21, 2, '2021-08-26 08:27:16', 'no'),
(22, 8, '2021-08-26 08:26:15', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_login_info`
--
ALTER TABLE `users_login_info`
  ADD PRIMARY KEY (`users_login_info_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users_login_info`
--
ALTER TABLE `users_login_info`
  MODIFY `users_login_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
