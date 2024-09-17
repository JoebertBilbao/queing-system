-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2024 at 06:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mccsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'admin@gmail.com', '$2y$10$pW0sskaQoHP6hDiAgNn/zuyFWjfuj98hkBGjDyDF1SOchTxEXXHI.', '2024-08-03 06:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'admin@gmail.com', '$2y$10$IfEZxg8GU3o9gkaFTwRF3OgQOWAHC2MQWkqPv7Dd9xu3Q2xb62/Ty', '2024-07-04 05:18:18'),
(2, 'mccadmin@gmail.com', '$2y$10$NNyhGDRHGxKmV4d1Z4lmCekH.d5AyyrPgPg69gpvPSQQOQ7WYI9Bm', '2024-07-04 05:32:50'),
(4, 'adminmcc@gmail.com', '$2y$10$kwM/ht1tRakFrVwBtAS3cun7JFYy4H2YM.UqK1JNSQD/P6irPLKou', '2024-07-04 05:35:32'),
(5, 'john@gmail.com', '$2y$10$YmOhr04nTOBA6m4oJVSmXeYWzkHQI39Rwz1Nl252t21x6Eh0ai8Ie', '2024-07-04 05:39:34'),
(6, 'vince@gmail.com', '$2y$10$aZO9/LC0fTL7Kd8lJBZw6.tTIFiXJkX/KMoyb81ywRG9raACFeFi6', '2024-07-04 05:44:52'),
(7, 'ryan@gmail.com', '$2y$10$QPlYVBvufryI4OMOBF9lsu5ydGEidOkInAfeq5HwC.ZZwGvaIhUAK', '2024-07-04 05:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `clinic`
--

CREATE TABLE `clinic` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic`
--

INSERT INTO `clinic` (`id`, `email`, `password`, `registration_date`) VALUES
(4, 'clinic1@gmail.com', '$2y$10$wV2hY4DQxhf/Avv/b0xMn.lcS4YJaE9KGt..m4jTdqKG074GqUPam', '2024-07-23 06:55:07');

-- --------------------------------------------------------

--
-- Table structure for table `clinic_forms`
--

CREATE TABLE `clinic_forms` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `medical_history` text NOT NULL,
  `medications` text NOT NULL,
  `allergies` text NOT NULL,
  `symptoms` text NOT NULL,
  `appointment_date` date NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic_forms`
--

INSERT INTO `clinic_forms` (`id`, `fullname`, `dob`, `contact`, `email`, `address`, `medical_history`, `medications`, `allergies`, `symptoms`, `appointment_date`, `submission_date`) VALUES
(1, 'John Anthon De la Cruz', '2024-07-01', '09434333', 'asd@gmail.com', 'asdsadas', 'adasdasda', 'asdasd', 'asdasdas', 'dasdas', '2024-07-08', '2024-07-14 17:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `cor`
--

CREATE TABLE `cor` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cor`
--

INSERT INTO `cor` (`id`, `email`, `password`, `registration_date`) VALUES
(1, 'itlaboratory@gmail.com', '$2y$10$sVwonExKWsGCYTcHTTq5nexg8eN5zfhrk1sx/89leeJ0HHwS7bHwG', '2024-07-14 18:09:26'),
(2, 'cor123@gmail.com', '$2y$10$C2NbKsJzhIkpk0bockrHtezssgpxS5l71PNEyh20z8GGvvHpv.hLC', '2024-07-22 06:20:37');

-- --------------------------------------------------------

--
-- Table structure for table `cor_forms`
--

CREATE TABLE `cor_forms` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `need` varchar(100) NOT NULL,
  `message` text DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cor_forms`
--

INSERT INTO `cor_forms` (`id`, `firstname`, `lastname`, `email`, `need`, `message`, `submission_date`) VALUES
(1, 'asdasd', 'asd', 'asd@gmail.com', 'Request order status', 'asdasd', '2024-07-14 17:35:23');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `department` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `email`, `password`, `department`) VALUES
(4, 'bsit@gmail.com', '$2y$10$mTWO5OVnFMmC1zziLQvq4eLa2y/KMRPphEoGKiJ82Mo/tmlrM..vi', 'BSIT'),
(5, 'bshm@gmail.com', '$2y$10$txN0ochTjKDwyWH8Z4Mw7uYol7NY6fWk2v.zaB4oYnqYxnRaYPCUq', 'BSHM'),
(6, 'bsed@gmail.com', '$2y$10$EM2Qsv4XmC87QBECl4zH.uMm.oEEfaJBKtXn/UgGCLnbgZFCvkzk2', 'BEED'),
(7, 'bsit123@gmail.com', '$2y$10$BWg6H0IEYRsvGnpz6XXWiehFjXepE8Pnt9bWc4qYm.FccpOtThiwy', 'BSIT'),
(8, 'bshm123@gmail.com', '$2y$10$ag1ErqgHc.xWjA930quV4eTERsV.6K9h91Sl6869lxA4UHmmpzR2G', 'BSHM'),
(9, 'bsed123@gmail.com', '$2y$10$3em0sy2cgAiMcK9X4vkVpOMRLT5yl9VMa8LBeVh8duer4lDE4iYUm', 'BSED'),
(10, 'bsba123@gmail.com', '$2y$10$TOsvGCVYcs2j5ktaQAo7IOyK/YdFVFMDmmcyrYpwbv3dPqeG25wmq', 'BSBA'),
(11, 'beed123@gmail.com', '$2y$10$1iUunu3SgXpsXMejeuCGs.6c4kh5OTWCLDeOv8L95wVc/LcKzm.6q', 'BEED');

-- --------------------------------------------------------

--
-- Table structure for table `departmenthead`
--

CREATE TABLE `departmenthead` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `year_level` enum('1st_year','2nd_year','3rd_year','4th_year') NOT NULL,
  `status` enum('new_student','transferee') NOT NULL,
  `semester` enum('1st_semester','2nd_semester') NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `course` enum('bsit','bshm','bsba','bsed','beed') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departmenthead`
--

INSERT INTO `departmenthead` (`id`, `name`, `year_level`, `status`, `semester`, `email`, `password`, `course`, `created_at`) VALUES
(7, 'Joebert Bilbao', '1st_year', '', '1st_semester', 'jbbilbao80@gmail.com', '$2y$10$IVpXgCX4DUPygxM.x1DN2eXt60xhrZkVCk/i9A38jaeRatAR60kYq', 'bsit', '2024-07-21 07:23:50');

-- --------------------------------------------------------

--
-- Table structure for table `enroll_requests`
--

CREATE TABLE `enroll_requests` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `need` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enroll_requests`
--

INSERT INTO `enroll_requests` (`id`, `firstname`, `lastname`, `email`, `need`, `message`, `created_at`) VALUES
(23, 'asd', 'asd', 'bshm@gmail.com', 'Other', 'asd', '2024-07-14 16:54:15'),
(24, 'asdasd', 'asdasd', 'asd@gmail.com', 'Request order status', 'asdasd', '2024-07-14 17:29:46');

-- --------------------------------------------------------

--
-- Table structure for table `guidance`
--

CREATE TABLE `guidance` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guidance`
--

INSERT INTO `guidance` (`id`, `email`, `password`) VALUES
(1, 'guidance@gmail.com', '$2y$10$AbuxWEPB26juHwWeKT2HHuuSpCv87qXiI/ilsv2vLfU14AIlBVi9q');

-- --------------------------------------------------------

--
-- Table structure for table `mccea`
--

CREATE TABLE `mccea` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mccea`
--

INSERT INTO `mccea` (`id`, `email`, `password`, `registration_date`) VALUES
(1, 'mccea@gmail.com', '$2y$10$LTEIPOMSeEkjl5QBf3B31usZGuh3Rfpqrz/eRsMuKuX12te4CM1de', '2024-07-14 18:04:00'),
(2, 'mccea123@gmail.com', '$2y$10$d.SXuUCQWQASgkocc3gGC.G4nXi2DylTdP5vXaokiAc32FYWVBjBG', '2024-07-22 06:15:59');

-- --------------------------------------------------------

--
-- Table structure for table `registrar`
--

CREATE TABLE `registrar` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrar`
--

INSERT INTO `registrar` (`id`, `email`, `password`, `registration_date`) VALUES
(1, 'registrar@gmail.com', '$2y$10$pcpf.45SOwS2HtQdygSZPOLSbabeao8IOUDcO1ubOWtMkR0h/8Ese', '2024-07-14 17:25:19'),
(2, 'registrar123@gmail.com', '$2y$10$86wPtigMPGb/dcTniB2x.eWld9X3gjKIwRYLMGwzV7HhUnhBeNVV2', '2024-07-22 06:06:01');

-- --------------------------------------------------------

--
-- Table structure for table `registrarproceed`
--

CREATE TABLE `registrarproceed` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `year_level` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `course` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrarproceed`
--

INSERT INTO `registrarproceed` (`id`, `name`, `year_level`, `status`, `semester`, `email`, `password`, `course`, `created_at`) VALUES
(5, 'Joebert Bilbao', '1st_year', 'new_student', '1st_semester', 'jbbilbao80@gmail.com', '', 'bsit', '2024-07-21 08:05:46');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `need` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `firstname`, `lastname`, `email`, `need`, `message`, `created_at`) VALUES
(1, 'Vince Lauron', 'asd', 'asd@gmail.com', 'Request Invoice for order', 'asdasd', '2024-07-14 17:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `score` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `full_name`, `course`, `request_date`, `score`) VALUES
(19, 'Joebert Bilbao', 'bsit', '2024-07-14 14:35:24', 45),
(20, 'Vince Lauron', 'bshm', '2024-07-14 16:31:20', 42),
(21, 'John Anthon Dela Cruz', 'bsit', '2024-07-14 18:16:46', 43),
(22, 'Bryan James Desuyo', 'bsit', '2024-07-15 02:56:38', 45);

-- --------------------------------------------------------

--
-- Table structure for table `ssc`
--

CREATE TABLE `ssc` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ssc`
--

INSERT INTO `ssc` (`id`, `email`, `password`, `registration_date`) VALUES
(3, 'scc1@gmail.com', '$2y$10$SKrRlKOAMZWNo.qqb8c/ae119rl4mmqv2fMTzI4zlnE9HG64NQgoC', '2024-07-23 06:51:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `year_level` enum('1st_year','2nd_year','3rd_year','4th_year') NOT NULL,
  `status` enum('new_student','transferee') NOT NULL,
  `semester` enum('1st_semester','2nd_semester') NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `course` enum('bsit','bshm','bsba','bsed','beed') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `step_status` varchar(255) DEFAULT 'not started'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `year_level`, `status`, `semester`, `email`, `password`, `course`, `created_at`, `step_status`) VALUES
(44, 'Joebert Bilbao', '1st_year', 'new_student', '1st_semester', 'jbbilbao80@gmail.com', '$2y$10$d1ohlQfEcKWVVNUhCzh9v.nGnInjK5WXSF4Lr9ccVp3PehXLWOatS', 'bsit', '2024-07-30 16:00:55', 'step 4'),
(45, 'jonas dabalos', '1st_year', 'new_student', '1st_semester', 'jonas@gmail.com', '$2y$10$FTwL22Mv9UAKbHoliS1gruxXhmOfiSTikfvWkzkz1PFArpgbYBkGa', 'bshm', '2024-07-30 21:35:18', 'not started'),
(46, 'jasmine carascal', '1st_year', 'new_student', '1st_semester', 'jasmine@gmail.com', '$2y$10$XOhtL.W9k2Jz2uVQxQIazezk/8hRUqayo5tZW3/frD0pIOsrcA3US', 'beed', '2024-07-30 21:36:10', 'step 2'),
(47, 'ryan palana', '1st_year', 'new_student', '1st_semester', 'ryan@gmail.com', '$2y$10$2SWXN77fZJ0pPnkL4EOPzecdCJEHrdjumaTl9Wlrs1FXJc2tV29r6', 'bsed', '2024-07-30 21:37:08', 'not started'),
(48, 'joe gwapo', '1st_year', 'new_student', '1st_semester', 'joe@gmail.com', '$2y$10$rtG09trhTHdwKMI19WZtsurBygVgO3FAn9yhJalrYfmsRfo9AMfhW', 'beed', '2024-07-30 21:37:43', 'not started'),
(49, 'bryan james desuyo', '1st_year', 'new_student', '1st_semester', 'james@gmail.com', '$2y$10$4TR4QaH9Aw8ss4nJhV07lOp1iEMN3AXJGNdeXCe/rE1JBtKRwXlFe', 'bsit', '2024-07-30 21:38:22', 'not started'),
(50, 'james', '1st_year', 'new_student', '1st_semester', 'jamesgwapo@gmail.com', '$2y$10$ptAbzJcAFkfIx7SuAS9jn.GnFOX9aW9uWbSIxXNFxg4z1khpHlFVu', 'bsba', '2024-07-30 21:49:17', 'in process');

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL,
  `session_id` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `session_id`, `user_id`, `expires`) VALUES
(1, '9ebd478310e679fb70606097e6d8786f', 36, '2024-08-25 04:10:33'),
(2, '7a9617ae98e13133f248655b9b12e743', 36, '2024-08-25 04:16:58'),
(3, 'bbdc5fa9cbb213def01a249194f6158e', 35, '2024-08-25 04:23:44'),
(4, 'ebeaead97642f9ccf4fdedf63789525e', 36, '2024-08-25 04:23:53'),
(5, 'b2234c66e5d5678259876eea5997ffa4', 35, '2024-08-25 04:24:43'),
(6, '1f1d47e1d03ebe74c4d947cdc0fd56b4', 36, '2024-08-25 04:26:06'),
(7, '900b7f00b86a96f1bfce94b5a4337c80', 37, '2024-08-25 04:26:29'),
(8, '075de4452a8cf65fe58b75f61b345278', 37, '2024-08-25 04:27:20'),
(9, '01eee2e25ad9b5571a448b7244d9cfe4', 37, '2024-08-25 04:28:06'),
(10, '83cd429dd872cdb8649c290e81f6bcfd', 36, '2024-08-25 04:29:55'),
(11, '777705e268782b9a7d5e6d8c7774a6d4', 38, '2024-08-25 04:31:24'),
(12, '914304e155d25d64e25be270f44997a3', 38, '2024-08-25 04:33:11'),
(13, '4cd2c89b653b007aadd43b3c92d596f7', 39, '2024-08-25 04:35:13'),
(14, 'f5b2d75644c6193f000ef05acbc67c3d', 40, '2024-08-25 04:57:17'),
(15, '53b9b4b3bc87a06df8d808bed04b5458', 40, '2024-08-25 04:57:48'),
(16, '90974d8586e1410e7dec35083e675826', 18, '2024-08-25 22:40:59'),
(17, 'fd88d5fac4106ad8e41180b30c7152d8', 18, '2024-08-25 22:42:08'),
(18, '55aa44d4bb606fdd601c96aa145ff922', 43, '2024-08-27 23:10:04'),
(19, '3919b247ad648b632b289e69c670fc21', 44, '2024-08-29 18:01:03'),
(20, 'e1b25f7a0fef682b0ef94c6364d3fd8e', 44, '2024-08-29 23:06:21'),
(21, 'b225921858526f706a03013165180903', 44, '2024-08-29 23:10:58'),
(22, '523efb6484e9c5d679ebd6e783b12fea', 46, '2024-08-29 23:40:50'),
(23, 'da6659c3749cdec4b8dd5eecce68a8d5', 50, '2024-08-30 00:05:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `clinic`
--
ALTER TABLE `clinic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clinic_forms`
--
ALTER TABLE `clinic_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cor`
--
ALTER TABLE `cor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cor_forms`
--
ALTER TABLE `cor_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departmenthead`
--
ALTER TABLE `departmenthead`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `enroll_requests`
--
ALTER TABLE `enroll_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guidance`
--
ALTER TABLE `guidance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mccea`
--
ALTER TABLE `mccea`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrar`
--
ALTER TABLE `registrar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrarproceed`
--
ALTER TABLE `registrarproceed`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ssc`
--
ALTER TABLE `ssc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_id` (`session_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `clinic`
--
ALTER TABLE `clinic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clinic_forms`
--
ALTER TABLE `clinic_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cor`
--
ALTER TABLE `cor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cor_forms`
--
ALTER TABLE `cor_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `departmenthead`
--
ALTER TABLE `departmenthead`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `enroll_requests`
--
ALTER TABLE `enroll_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `guidance`
--
ALTER TABLE `guidance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mccea`
--
ALTER TABLE `mccea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registrar`
--
ALTER TABLE `registrar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registrarproceed`
--
ALTER TABLE `registrarproceed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ssc`
--
ALTER TABLE `ssc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
