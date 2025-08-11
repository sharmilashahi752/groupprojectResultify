-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2025 at 07:55 AM
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
-- Database: `ss`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` int(100) NOT NULL,
  `email` int(100) NOT NULL,
  `subject` int(255) NOT NULL,
  `message` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `subject`, `message`) VALUES
(0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
  `roll_no` varchar(20) DEFAULT NULL,
  `python` int(11) DEFAULT NULL,
  `web_tech` int(11) DEFAULT NULL,
  `mis` int(11) DEFAULT NULL,
  `sad` int(11) DEFAULT NULL,
  `research` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`id`, `roll_no`, `python`, `web_tech`, `mis`, `sad`, `research`) VALUES
(3, '13', 89, 95, 96, 97, 94),
(4, '4', 78, 67, 89, 90, 93),
(5, '2', 67, 99, 89, 89, 96),
(6, '231010', 89, 89, 90, 67, 89),
(7, '231011', 56, 78, 67, 89, 67);

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `posted_by` varchar(100) DEFAULT 'university',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `title`, `message`, `posted_by`, `created_at`) VALUES
(1, 'Result', 'Result of first semester and thrid semester of B.Tech in IT and B.Tech in CS&AI published', 'Hari Thapa', '2025-07-31 01:18:11'),
(2, 'Download Result', 'Now student can download their Marksheet', 'nisha thapa', '2025-07-31 01:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `marks` int(11) DEFAULT NULL,
  `grade` varchar(2) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `exam_year` year(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `student_id`, `subject`, `marks`, `grade`, `remarks`, `exam_year`, `created_at`) VALUES
(1, 1, 'Python', 91, 'A+', 'Excellent', '2024', '2025-06-22 02:06:19'),
(2, 1, 'Web Technology II', 85, 'A', 'Very Good', '2024', '2025-06-22 02:06:19'),
(3, 1, 'MIS', 78, 'B+', 'Good', '2024', '2025-06-22 02:06:19'),
(4, 1, 'SAD', 88, 'A', 'Very Good', '2024', '2025-06-22 02:06:19'),
(5, 1, 'Research Methodology', 82, 'A', 'Very Good', '2024', '2025-06-22 02:06:19');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `department` varchar(50) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `roll_no` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `department`, `year`, `roll_no`, `created_at`) VALUES
(11, 'Sharmila Shahi', 'sharmilashahi752@gmail.com', 'B.Tech in IT', '3rd year', '13', '2025-07-29 04:46:02'),
(12, 'Brij Mohan pasi', 'brijmohan@gmail.com', 'B.Tech in IT', '2nd Year', '4', '2025-07-29 05:01:04'),
(13, 'Samriddhi shah', 'samriddhi@gmail.com', 'B.Tech in CS&AI', '2nd Year', '2', '2025-07-29 06:07:28'),
(14, 'Sonu Shahi', 'sonu@gmail.com', 'B.Tech in IT', '2nd Year', '231010', '2025-07-29 13:31:28'),
(15, 'Esha Thapa', 'esha@gmail.com', 'B.Tech in CS&AI', '1st Year', '231011', '2025-07-30 15:23:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin','university') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'sharmila shahi', 'sharmilashahi752@gmail.com', '$2y$10$Sqs5QST4W8ePHnK.xjoFbe3d/mYlhz.NFku5qr4pndzg7kGSC1Vr6', 'student', '2025-06-21 05:19:47'),
(2, 'nisha thapa', 'nisha@gmail.com', '$2y$10$dnW.Pd6jxD0fG2QGsUjxE.NssorG9nBK1pFRqZFkdF1ar7LcMq4I.', 'admin', '2025-06-21 05:35:11'),
(3, 'student', 'studnet@gmail.com', '$2y$10$cA1nt/pELAWkBbWPBN66/OjUQzD.r1ULBe0fCAek8zDPputORSJuW', 'student', '2025-06-21 05:37:51'),
(4, 'saru', 'saur@gmail.com', '$2y$10$T58wF8lm9HmzqCL2lWQj3uoxF4Cxfw.ferTCUly1MJAWyIRmT/yii', 'university', '2025-06-21 06:15:28'),
(5, 'sonu shahi', 'sonu@gmail.com', '$2y$10$UX/BIJSY.eXUIdoc15XtVeG4d4wrOtkedCwsu2au2eTAiALU9pEhG', 'student', '2025-06-22 02:13:12'),
(6, 'Susmita Thapa', 'susmita@gmail.com', '$2y$10$UkXoX5GYWtLXG1jVLyCfS.EEuai5KlEnmgLbm5AyzU2FjZn8IuLpe', 'student', '2025-06-26 04:05:41'),
(7, 'sharmila shahi', 'sharmila@gmail.com', '$2y$10$VCJQkhiCh92GFOqtLhtRvO0JdQRd9s5Q5Vo0XVCXivmwDAiyYrrR6', 'student', '2025-07-04 15:32:41'),
(8, 'Brij Mohan ', 'brijmohan@gmail.com', '$2y$10$Ql78DfGLKNnwlCUyZcYYWeIKnuGg29lsHmokXr5y8hib5cHFPerXa', 'student', '2025-07-27 06:15:30'),
(9, 'Supriya Chaudhary', 'supriya@gmail.com', '$2y$10$jlqRG..kacYneM1X7SU8O.ReM5jgVSCqfUfOMaEhigwiXN1NAt2GW', 'student', '2025-07-27 09:38:06'),
(10, 'Abhishek Sharma', 'abhishek@gmail.com', '$2y$10$Z6vkAhdek9iWNCzffc.fmeLjhnSf6vzGRRTjscmAs69rdsRWNqK2y', 'student', '2025-07-27 09:45:38'),
(11, 'Admin', 'admin@gmail.com', '$2y$10$BMCmiALSwd/qOZDCMkF3M.Ga4ScptQbsjHCmIaXgZ/FxZg8Xt92l.', 'admin', '2025-07-27 09:55:05'),
(12, 'Ram Shahi', 'ram@gmail.com', '$2y$10$WCNNpA0uhUpGcu97/otksOnR56Bmje9/Ts0u7nid0b/erVZXZO1Ga', 'student', '2025-07-28 06:00:13'),
(14, 'Samriddhi Shahi', 'samriddhi@gmail.com', '$2y$10$vVIYCuD/qJ31SLIdvy.1ROMeXXtabdfpIH/fXeeYB5lYEIjoGQ9wO', 'student', '2025-07-29 12:23:36'),
(17, 'Laxmi Shahi', 'laxmi@gmail.com', '$2y$10$MGcGIr7dDT7Nw22YD4e3Ae4olk1HdOcyc1E6NdLYlcGxlP2dHGBSy', 'student', '2025-07-30 08:18:50'),
(18, 'Hari Thapa', 'hari@gmail.com', '$2y$10$WKO3Dl1rsq6JdTGJRXrju.h0YI5nXoNPX1LfcyJlLl4gZubgioS0W', 'university', '2025-07-30 13:30:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roll_no` (`roll_no`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `roll_no` (`roll_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_ibfk_1` FOREIGN KEY (`roll_no`) REFERENCES `students` (`roll_no`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
