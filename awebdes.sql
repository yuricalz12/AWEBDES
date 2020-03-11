-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2020 at 08:58 AM
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
(1, 1, 'Information Technology'),
(2, 2, 'Computer Science');

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
(2, 'Room 101'),
(3, 'Room 104'),
(6, 'SPN'),
(8, 'Room 204');

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
(36, 1, 1, 15, 17, 'lecture', 'monday', 1, 3),
(37, 2, 1, 15, 17, 'lecture', 'monday', 5, 9),
(38, 1, 1, 15, 17, 'laboratory', 'monday', 3, 5),
(39, 1, 1, 15, 17, 'lecture', 'monday', 9, 11),
(40, 1, 1, 15, 17, 'laboratory', 'monday', 13, 17),
(41, 2, 1, 15, 17, 'laboratory', 'monday', 17, 23),
(42, 1, 1, 23, 17, 'lecture', 'monday', 1, 3),
(43, 2, 1, 23, 17, 'lecture', 'monday', 5, 9),
(44, 1, 1, 23, 17, 'laboratory', 'monday', 3, 5),
(45, 1, 1, 23, 17, 'lecture', 'monday', 9, 11),
(46, 1, 1, 23, 17, 'laboratory', 'monday', 13, 17),
(47, 2, 1, 23, 17, 'laboratory', 'monday', 17, 23),
(48, 1, 1, 24, 17, 'lecture', 'monday', 1, 3),
(49, 2, 1, 24, 17, 'lecture', 'monday', 5, 9),
(50, 1, 1, 24, 17, 'laboratory', 'monday', 3, 5),
(51, 1, 1, 24, 17, 'lecture', 'monday', 9, 11),
(52, 1, 1, 24, 17, 'laboratory', 'monday', 13, 17),
(53, 2, 1, 24, 17, 'laboratory', 'monday', 17, 23),
(82, 1, 1, 18, 17, 'lecture', 'monday', 1, 3),
(83, 1, 1, 18, 17, 'laboratory', 'monday', 3, 5),
(84, 1, 1, 18, 17, 'lecture', 'monday', 9, 11),
(85, 1, 1, 18, 17, 'laboratory', 'monday', 13, 17),
(86, 2, 1, 18, 17, 'lecture', 'monday', 5, 9),
(87, 2, 1, 18, 17, 'laboratory', 'monday', 17, 23),
(88, 3, 1, 15, 17, 'lecture', 'tuesday', 1, 3),
(89, 3, 1, 15, 17, 'lecture', 'wednesday', 1, 3),
(90, 3, 1, 15, 17, 'laboratory', 'thursday', 7, 13),
(115, 1, 1, 16, 17, 'lecture', 'monday', 1, 3),
(116, 1, 1, 16, 17, 'laboratory', 'monday', 3, 5),
(117, 1, 1, 16, 17, 'lecture', 'monday', 9, 11),
(118, 1, 1, 16, 17, 'laboratory', 'monday', 13, 17);

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `section_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `section_name`) VALUES
(1, 'BSIT-191'),
(2, 'BSIT-192'),
(3, 'BSIT-181'),
(4, 'BSIT-182'),
(5, 'BSIT-171'),
(6, 'BSIT-172'),
(7, 'BSIT-161'),
(8, 'BSIT-162');

-- --------------------------------------------------------

--
-- Table structure for table `section_schedule`
--

CREATE TABLE `section_schedule` (
  `schedule_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `dpd_id` int(11) NOT NULL,
  `class_type` varchar(50) NOT NULL,
  `day` varchar(50) NOT NULL,
  `start_time_id` int(11) NOT NULL,
  `end_time_id` int(11) NOT NULL,
  `between_time_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section_schedule`
--

INSERT INTO `section_schedule` (`schedule_id`, `subject_id`, `room_id`, `section_id`, `dpd_id`, `class_type`, `day`, `start_time_id`, `end_time_id`, `between_time_id`) VALUES
(1, 1, 1, 1, 17, 'lecture', 'monday', 1, 3, '2'),
(3, 2, 1, 1, 17, 'lecture', 'monday', 5, 9, '6,7,8'),
(5, 1, 1, 1, 17, 'laboratory', 'monday', 3, 5, '4'),
(6, 1, 1, 1, 17, 'lecture', 'monday', 9, 11, '10'),
(7, 1, 1, 1, 17, 'laboratory', 'monday', 13, 17, '14,15,16'),
(8, 2, 1, 1, 17, 'laboratory', 'monday', 17, 23, '18,19,20,21,22'),
(9, 1, 2, 2, 17, 'lecture', 'monday', 1, 5, '2,3,4,'),
(10, 1, 2, 2, 17, 'laboratory', 'monday', 5, 11, '6,7,8,9,10'),
(11, 2, 2, 2, 17, 'lecture', 'monday', 13, 19, '14,15,16,17,18'),
(12, 2, 2, 2, 17, 'laboratory', 'monday', 19, 25, '20,21,22,23,24'),
(13, 2, 3, 3, 17, 'lecture', 'monday', 1, 7, '2,3,4,5,6'),
(16, 2, 3, 3, 17, 'laboratory', 'monday', 7, 13, '8,9,10,11,12'),
(21, 1, 3, 3, 17, 'lecture', 'monday', 15, 19, '16,17,18'),
(22, 1, 2, 3, 17, 'laboratory', 'monday', 19, 25, '20,21,22,23,24'),
(23, 3, 1, 1, 17, 'lecture', 'tuesday', 1, 3, '2'),
(28, 3, 1, 1, 17, 'lecture', 'wednesday', 1, 3, '2'),
(30, 3, 1, 1, 17, 'laboratory', 'thursday', 7, 13, '8,9,10,11,12');

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
(2, 'INFOMAN', 'INFOMAN', 3, 3, 1, 1, 1, 1, '#07f22e'),
(3, 'IPTECH', 'IPTECH', 2, 3, 1, 1, 1, 1, '#4287f5');

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
(18, 'test@gmail.com', '$2y$10$NOuSgFH03vonDxTKylt.TeihSBHGgKQL54vrkyAGqbNV.w3uaQcPy', 1, 1, 1),
(23, 'student1@gmail.com', '$2y$10$TUrOwpFXOERLfjzBzKBaZ.Nf71Dk.Y4JKDG9nsoT5gvNanhmBH.1O', 1, 1, 1),
(24, 'student2@gmail.com', '$2y$10$EQjQ2kJrEXYTINcIa.4/0un6kmN91nCuwOR9B9rni1eBmI7j8Wd2G', 1, 1, 1),
(25, 'admin@gmail.com', '$2y$10$uuGu97PGlVxbqL3D/VSqKOaKyqB1uioIT6wVkugq7XjT6KjQf3Qi2', 1, 1, 4),
(29, 'teacher1@gmail.com', '$2y$10$trDylTAWXXxBlO9yaXzWCuB.36iBYDIQH9uwL.0IFggAeUn8PP9My', 0, 0, 2);

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
(6, 15, 'Judge Yuri', 'Calumpang', 'Dumaguete', 'Male', '1997-01-01', 'img/Male.png'),
(7, 16, 'John', 'Doe', 'Tanjay', 'Male', '1997-01-01', 'img/Male.png'),
(8, 17, 'Jane', 'Doe', 'Bais City', 'Male', '1997-01-01', 'img/Female.png'),
(9, 18, 'Sean', 'Holmes', 'Pamplona', 'Male', '1997-01-01', 'img/Male.png'),
(10, 23, 'Mark', 'Reyes', 'Bacong', 'Male', '1997-01-01', 'img/Male.png'),
(11, 24, 'Steve', 'Jobs', 'Valencia', 'Male', '1997-01-01', 'img/Male.png'),
(12, 25, 'Admin', 'Admin', 'Dumaguete', 'Male', '1997-01-01', 'img/Male.png'),
(16, 29, 'Blake', 'Tyler', 'Amlan', 'Male', '1997-01-01', 'img/Male.png');

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
-- Indexes for table `section_schedule`
--
ALTER TABLE `section_schedule`
  ADD PRIMARY KEY (`schedule_id`);

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
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `section_schedule`
--
ALTER TABLE `section_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `time`
--
ALTER TABLE `time`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user_information`
--
ALTER TABLE `user_information`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
