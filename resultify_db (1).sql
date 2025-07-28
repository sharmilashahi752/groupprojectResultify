-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2025 at 01:55 PM
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
-- Database: `resultify_db`
--

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
  `roll_no` varchar(50) NOT NULL,
  `class` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `roll_no`, `class`, `created_at`) VALUES
(1, 'Sharmila Shahi', 'sharmilashahi752@gmail.com', '14', 'BIT 4th Semester', '2025-06-24 01:31:59'),
(3, 'brij mohan', 'pasibrijmohan5@gmail.com', '4', 'BIT 4th Semester', '2025-06-24 05:32:12'),
(4, 'Supriya Chaudhary', 'supriya@gmail.com', '17', 'BIT 4th Semester', '2025-06-24 11:21:32');

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
(6, 'Susmita Thapa', 'susmita@gmail.com', '$2y$10$UkXoX5GYWtLXG1jVLyCfS.EEuai5KlEnmgLbm5AyzU2FjZn8IuLpe', 'student', '2025-06-26 04:05:41');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
