-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2020 at 01:09 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `awebdes`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `course_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `department_id`, `course_name`) VALUES
(1, 1, 'Course1'),
(2, 2, 'Course2');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`) VALUES
(1, 'Department1'),
(2, 'Department2');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_name`) VALUES
(1, 'Room 111'),
(2, 'Room 101');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dpd_id` int(11) NOT NULL,
  `class_type` varchar(50) NOT NULL,
  `day` varchar(50) NOT NULL,
  `start_time_id` int(11) NOT NULL,
  `end_time_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `subject_id`, `room_id`, `user_id`, `dpd_id`, `class_type`, `day`, `start_time_id`, `end_time_id`) VALUES
(6, 1, 1, 15, 17, 'laboratory', 'monday', 7, 9),
(10, 1, 1, 15, 17, 'lecture', 'monday', 3, 5),
(13, 2, 1, 15, 17, 'laboratory', 'monday', 15, 17),
(14, 1, 2, 16, 17, 'lecture', 'monday', 1, 5),
(15, 2, 2, 16, 17, 'lecture', 'monday', 5, 11),
(16, 2, 1, 15, 17, 'lecture', 'monday', 17, 23),
(17, 1, 1, 15, 17, 'lecture', 'monday', 1, 3),
(18, 1, 1, 15, 17, 'lecture', 'monday', 1, 3),
(19, 1, 1, 15, 17, 'lecture', 'monday', 1, 3),
(20, 1, 1, 15, 17, 'lecture', 'monday', 1, 3),
(21, 1, 1, 15, 17, 'lecture', 'monday', 1, 3),
(22, 2, 1, 16, 17, 'laboratory', 'monday', 11, 13),
(23, 1, 2, 16, 17, 'laboratory', 'monday', 13, 15);

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `section_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `subject_lecture_hour` int(11) NOT NULL,
  `subject_lab_hour` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `year_level_id` int(11) NOT NULL,
  `subject_color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`, `subject_code`, `subject_lecture_hour`, `subject_lab_hour`, `department_id`, `course_id`, `semester_id`, `year_level_id`, `subject_color`) VALUES
(1, 'AWEBDES', 'AWEBDES', 2, 3, 1, 1, 1, 1, '#1c69e6'),
(2, 'INFOMAN', 'INFOMAN', 3, 3, 1, 1, 1, 1, '#07f22e');

-- --------------------------------------------------------

--
-- Table structure for table `time`
--

CREATE TABLE `time` (
  `time_id` int(11) NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time`
--

INSERT INTO `time` (`time_id`, `time`) VALUES
(1, '7:00 am'),
(2, '7:30 am'),
(3, '8:00 am'),
(4, '8:30 am'),
(5, '9:00 am'),
(6, '9:30 am'),
(7, '10:00 am'),
(8, '10:30 am'),
(9, '11:00 am'),
(10, '11:30 am'),
(11, '12:00 noon'),
(12, '12:30 pm'),
(13, '1:00 pm'),
(14, '1:30 pm'),
(15, '2:00 pm'),
(16, '2:30 pm'),
(17, '3:00 pm'),
(18, '3:30 pm'),
(19, '4:00 pm'),
(20, '4:30 pm'),
(21, '5:00 pm'),
(22, '5:30 pm'),
(23, '6:00 pm'),
(24, '6:30 pm'),
(25, '7:00 pm'),
(26, '7:30 pm'),
(27, '8:00 pm'),
(28, '8:30 pm'),
(29, '9:00 pm');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `department_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL COMMENT '1 = student'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_email`, `user_password`, `department_id`, `course_id`, `user_type`) VALUES
(15, 'yurelle624@gmail.com', '$2y$10$BEYL/.FLPP6J5UdPRngkvO/wmg3XCdT0XwyM7rc4806kMqmLwn3yu', 1, 1, 1),
(16, 'johndoe@gmail.com', '$2y$10$mbKiyg3hzM0Q7irekW2gXe2yCy.MM9hsgRFYGiE4eRKQZ4wS4Md2.', 1, 0, 2),
(17, 'janedoe@gmail.com', '$2y$10$rcgr6DrCjxF6LWh8GUQLbeJ5yYcByJXvb0dWGtcWbcL0b3aa8xu1e', 2, 0, 3),
(18, 'test@gmail.com', '$2y$10$NOuSgFH03vonDxTKylt.TeihSBHGgKQL54vrkyAGqbNV.w3uaQcPy', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_information`
--

CREATE TABLE `user_information` (
  `info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `info_first_name` varchar(250) NOT NULL,
  `info_last_name` varchar(250) NOT NULL,
  `info_address` varchar(250) NOT NULL,
  `info_gender` varchar(250) NOT NULL,
  `info_dob` date NOT NULL,
  `info_profile_picture` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_information`
--

INSERT INTO `user_information` (`info_id`, `user_id`, `info_first_name`, `info_last_name`, `info_address`, `info_gender`, `info_dob`, `info_profile_picture`) VALUES
(6, 15, 'Judge Yuri', 'Calumpang', 'Gomez St.', 'Male', '1997-01-01', 'img/Male.png'),
(7, 16, 'John', 'Doe', 'Dumaguete', 'Male', '1995-04-04', 'img/Male.png'),
(8, 17, 'Jane', 'Doe', 'Dumaguete', 'Female', '1997-03-21', 'img/Female.png'),
(9, 18, 'Yuri', 'Calz', 'Gomez St.', 'Male', '1995-01-01', 'img/Male.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`time_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_information`
--
ALTER TABLE `user_information`
  ADD PRIMARY KEY (`info_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `time`
--
ALTER TABLE `time`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_information`
--
ALTER TABLE `user_information`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
