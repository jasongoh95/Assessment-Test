-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2021 at 02:14 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'e99a18c428cb38d5f260853678922e03', 'ADMIN'),
(2, 'john95', '61bd60c60d9fb60cc8fc7767669d40a1', 'STUDENT'),
(8, 'johnny93', '61bd60c60d9fb60cc8fc7767669d40a1', 'STUDENT'),
(11, 'shawn97', '61bd60c60d9fb60cc8fc7767669d40a1', 'STUDENT'),
(13, 'MingWei99', '61bd60c60d9fb60cc8fc7767669d40a1', 'STUDENT');

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE `student_course` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `intake_date` date NOT NULL,
  `status` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`id`, `profile_id`, `course_name`, `intake_date`, `status`) VALUES
(4, 7, 'Degree in Law', '2019-03-31', 'Active'),
(5, 1, 'Diploma In Information Technology', '2018-12-28', 'Graduated'),
(6, 10, 'Degree In Mechanic Engineering', '2019-05-19', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `student_course_semester`
--

CREATE TABLE `student_course_semester` (
  `id` int(11) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `course_id` int(11) NOT NULL,
  `term` varchar(50) NOT NULL,
  `status` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_course_semester`
--

INSERT INTO `student_course_semester` (`id`, `semester`, `course_id`, `term`, `status`) VALUES
(1, 'semester-1', 5, 'Jan-2020', 'Active'),
(3, 'semester-2', 5, 'Jul-2020', 'Active'),
(4, 'semester-1', 4, 'Jul-2020', 'Active'),
(5, 'semester-2', 4, 'Jul-2020', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `student_course_semester_subject`
--

CREATE TABLE `student_course_semester_subject` (
  `id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `status` varchar(5) NOT NULL,
  `grade` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_course_semester_subject`
--

INSERT INTO `student_course_semester_subject` (`id`, `semester_id`, `subject`, `status`, `grade`) VALUES
(2, 1, 'module-c', 'Taken', 'A'),
(3, 1, 'module-b', 'Taken', 'C'),
(4, 1, 'module-a', 'Taken', 'B'),
(5, 1, 'module-d', 'Drop', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `student_profile`
--

CREATE TABLE `student_profile` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_profile`
--

INSERT INTO `student_profile` (`id`, `login_id`, `name`, `dob`, `nationality`, `phone`) VALUES
(1, 2, 'John Tan Ming Kiang', '1995-03-01', 'China', '0157778888'),
(7, 8, 'Johnny Chua Ming Chun', '1993-08-19', 'taiwan', '0127881234'),
(10, 11, 'Shawn Lee Jing Yi', '1997-05-20', 'Malaysian', '0157777888'),
(11, 13, 'Tan Ming Wei', '1999-12-29', 'United Kingdom', '0157778888');

-- --------------------------------------------------------

--
-- Table structure for table `ws_user`
--

CREATE TABLE `ws_user` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ws_user`
--

INSERT INTO `ws_user` (`id`, `login`, `password`) VALUES
(1, 'adminws', 'e99a18c428cb38d5f260853678922e03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_course`
--
ALTER TABLE `student_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_course_semester`
--
ALTER TABLE `student_course_semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_course_semester_subject`
--
ALTER TABLE `student_course_semester_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_profile`
--
ALTER TABLE `student_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ws_user`
--
ALTER TABLE `ws_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `student_course`
--
ALTER TABLE `student_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_course_semester`
--
ALTER TABLE `student_course_semester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_course_semester_subject`
--
ALTER TABLE `student_course_semester_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_profile`
--
ALTER TABLE `student_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ws_user`
--
ALTER TABLE `ws_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
