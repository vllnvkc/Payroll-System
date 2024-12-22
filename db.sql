-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 17, 2024 at 10:03 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `photo` varchar(45) DEFAULT NULL,
  `created_on` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `created_on`, `type`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Mary', 'Hernandez', 'demo/b6.jpg', 'August 31, 2019', 'Administrator'),
(2, 'siteboss', '81dc9bdb52d04dc20036dbd8313ed055', 'Jelah', 'Quintana', 'demo/b6.jpg', 'August 31, 2019', 'Secretary'),
(3, 'timekeeper', '81dc9bdb52d04dc20036dbd8313ed055', 'Irish Kate', 'Arcilla III', 'demo/b6.jpg', 'August 31, 2019', 'Timekeeper');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int NOT NULL,
  `employee_id` int DEFAULT NULL,
  `attendance_id` varchar(45) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  `time_in_morning` varchar(45) DEFAULT NULL,
  `time_out_morning` varchar(45) DEFAULT NULL,
  `time_in_afternoon` varchar(45) DEFAULT NULL,
  `time_out_afternoon` varchar(45) DEFAULT NULL,
  `status_morning` int DEFAULT NULL,
  `status_afternoon` int DEFAULT NULL,
  `num_hr_morning` double DEFAULT NULL,
  `num_hr_afternoon` double DEFAULT NULL,
  `month` varchar(45) DEFAULT NULL,
  `year` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `attendance_id`, `date`, `time_in_morning`, `time_out_morning`, `time_in_afternoon`, `time_out_afternoon`, `status_morning`, `status_afternoon`, `num_hr_morning`, `num_hr_afternoon`, `month`, `year`) VALUES
(76, 24, '0134562', '2024-11-30', '11:15:00', '12:00:00', '13:00:00', '17:30:00', 0, 1, 0.75, 4.5, 'November', '2024'),
(79, 25, NULL, '2024-11-30', '2024-11-30 17:40:16', '11:45:00', '12:00:00', NULL, NULL, 1, 18.066666666667, NULL, NULL, NULL),
(80, 25, '1532406', '2024-12-01', '23:00:00', '23:00:00', '23:00:00', '23:00:00', 0, NULL, 0, 0, 'December', '2024'),
(96, 24, '1532409', '2024-12-02', '01:45:00', '03:45:00', '13:45:00', '15:45:00', 1, 1, 2, 2, 'December', '2024'),
(97, 25, '1532410', '2024-12-02', '15:47:43', '15:48:14', NULL, NULL, 1, NULL, 0, NULL, 'December', '2024'),
(98, 26, '1532411', '2024-12-02', '17:26:34', '19:29:50', NULL, NULL, 1, NULL, 0, NULL, 'December', '2024'),
(99, 24, '4056321', '2024-12-12', '08:00:00', NULL, NULL, '16:20:02', 0, 0, NULL, 0, 'December', '2024'),
(100, 24, '0154236', '2024-12-07', '09:00:00', '11:00:00', '13:00:00', '22:46:35', 0, 0, 9.78, 4, 'December', '2024'),
(101, 26, '1', '2024-12-07', '21:12:02', '21:45:48', NULL, NULL, NULL, NULL, 0, NULL, 'December', '2024'),
(102, 25, '4056322', '2024-12-07', '21:20:08', NULL, '21:49:44', '22:49:16', NULL, 0, 0.98, 0.99, 'December', '2024'),
(104, 26, NULL, '2024-12-08', '10:17:56', '10:18:37', NULL, NULL, 1, NULL, 0.26, NULL, 'December', '2024'),
(109, 25, '4056323', '2024-12-08', '11:05:11', '11:07:15', '11:28:16', '11:29:14', 0, 0, 0.034444444444444, 0.016111111111111, 'December', '2024'),
(110, 24, '4056324', '2024-12-08', NULL, NULL, '12:48:24', '12:48:52', NULL, 0, NULL, 0.0077777777777778, 'December', '2024'),
(113, 24, '4056326', '2024-12-10', '23:33:29', NULL, '23:24:09', NULL, 0, 0, NULL, NULL, 'December', '2024'),
(117, 25, '4056328', '2024-12-11', '00:07:12', '00:07:32', '00:17:29', '00:17:55', 1, 1, 0.0055555555555556, 0.0072222222222222, 'December', '2024'),
(118, 26, '4056329', '2024-12-11', '00:26:46', NULL, '00:25:23', '00:26:16', 1, 1, NULL, 0.014722222222222, 'December', '2024'),
(119, 26, '4056330', '2024-12-12', '11:53:29', NULL, NULL, NULL, 0, NULL, NULL, NULL, 'December', '2024'),
(120, 25, '4056331', '2024-12-12', '12:16:33', '16:27:05', NULL, '16:20:55', 0, 0, 4.1755555555556, 0, 'December', '2024'),
(122, 27, '4056333', '2024-12-12', '15:32:15', NULL, '15:57:36', '16:17:06', 0, 0, NULL, 0.325, 'December', '2024'),
(123, 28, '4056334', '2024-12-12', '15:43:06', '16:30:26', '16:09:17', '16:18:28', 0, 0, 0.78888888888889, 0.15305555555556, 'December', '2024'),
(124, 28, '4056335', '2024-12-13', '08:43:14', NULL, NULL, NULL, 0, NULL, NULL, NULL, 'December', '2024'),
(125, 26, '4056336', '2024-12-13', '09:39:10', NULL, NULL, NULL, 0, NULL, NULL, NULL, 'December', '2024'),
(126, 30, '4056337', '2024-12-13', '09:47:47', '09:48:33', NULL, NULL, 0, NULL, 0.012777777777778, NULL, 'December', '2024'),
(127, 28, '4056338', '2024-12-18', '05:48:20', NULL, NULL, NULL, 1, NULL, NULL, NULL, 'December', '2024');

-- --------------------------------------------------------

--
-- Table structure for table `barcode`
--

CREATE TABLE `barcode` (
  `id` int NOT NULL,
  `employee_id` varchar(45) DEFAULT NULL,
  `generated_on` varchar(45) DEFAULT NULL,
  `path` varchar(45) DEFAULT NULL,
  `bool_gen` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barcode`
--

INSERT INTO `barcode` (`id`, `employee_id`, `generated_on`, `path`, `bool_gen`) VALUES
(5, '058379612', '2019-09-09', 'employee_barcode/058379612.png', 1),
(6, '017468523', '2019-09-09', 'employee_barcode/017468523.png', 1),
(7, '358041762', '2019-09-09', 'employee_barcode/358041762.png', 1),
(8, '074215963', '2019-09-09', 'employee_barcode/074215963.png', 1),
(9, '908326751', '2019-09-15', 'employee_barcode/908326751.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cashadvance`
--

CREATE TABLE `cashadvance` (
  `id` int NOT NULL,
  `cash_id` varchar(45) DEFAULT NULL,
  `date_advance` varchar(45) DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  `amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cashadvance`
--

INSERT INTO `cashadvance` (`id`, `cash_id`, `date_advance`, `employee_id`, `amount`) VALUES
(23, '0312564', '2024-11-30', 24, 500),
(24, '6052134', '2024-12-07', 24, 2000),
(25, '1506342', '2024-12-12', 28, 100),
(26, '4035126', '2024-12-13', 30, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int NOT NULL,
  `employee_id` int DEFAULT NULL,
  `attained` varchar(45) DEFAULT NULL,
  `year_graduated` varchar(45) DEFAULT NULL,
  `eid` varchar(45) DEFAULT NULL,
  `degree_received` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `employee_id`, `attained`, `year_graduated`, `eid`, `degree_received`) VALUES
(1, 22, 'Elementary', '2010', '074215963', 'Valedictorian'),
(2, 22, 'High School', '2014', '074215963', 'Third Honors'),
(3, 20, 'Elementary', '2016', '058379612', 'Third Honors'),
(4, 21, 'College', '2018', '017468523', 'Third Honors'),
(5, 24, 'Elementary', '1993', '', 'Valedictorian');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int NOT NULL,
  `employee_id` varchar(10) DEFAULT NULL,
  `position_id` int DEFAULT NULL,
  `schedule_id` int DEFAULT NULL,
  `created_on` varchar(45) DEFAULT NULL,
  `photo` longtext,
  `fullname` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phonenumber` varchar(45) DEFAULT NULL,
  `birthdate` varchar(45) DEFAULT NULL,
  `sex` varchar(45) DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
  `civil_status` varchar(45) DEFAULT NULL,
  `citizenship` varchar(45) DEFAULT NULL,
  `height` int DEFAULT NULL,
  `weight` int DEFAULT NULL,
  `religion` varchar(45) DEFAULT NULL,
  `spouse` varchar(45) DEFAULT NULL,
  `spouse_occupation` varchar(45) DEFAULT NULL,
  `father` varchar(45) DEFAULT NULL,
  `father_occupation` varchar(45) DEFAULT NULL,
  `mother` varchar(45) DEFAULT NULL,
  `mother_occupation` varchar(45) DEFAULT NULL,
  `parent_address` varchar(45) DEFAULT NULL,
  `emergency_name` varchar(45) DEFAULT NULL,
  `emergency_contact` varchar(45) DEFAULT NULL,
  `project_name` varchar(45) DEFAULT NULL,
  `site_location` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `position_id`, `schedule_id`, `created_on`, `photo`, `fullname`, `address`, `email`, `phonenumber`, `birthdate`, `sex`, `position`, `civil_status`, `citizenship`, `height`, `weight`, `religion`, `spouse`, `spouse_occupation`, `father`, `father_occupation`, `mother`, `mother_occupation`, `parent_address`, `emergency_name`, `emergency_contact`, `project_name`, `site_location`) VALUES
(24, 'E002', 12, 23, '2024-11-29', '1by1KC.png', 'KC Lopez Villanueva', 'Malaya, Naujan, Oriental Mindoro', 'kclpzvllnv@gmail.com', '09350363879', '2004-09-13', 'Female', '12', 'Single', 'Filipino', 135, 38, 'Catholic', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Malaya, Naujan, Oriental Mindoro', 'Jake Villanueva', '09350363879', NULL, NULL),
(25, 'E003', 10, 23, '2024-11-30', 'weevil.jpg', 'Luis Lopez Albufera', 'Oriental Mindoro', 'kesiriah.hola@gmail.com', '0987654321', '1963-09-14', 'Female', '10', 'Separated', 'FIlipino', 175, 100, 'Catholic', 'Ewan', 'N/A', 'Ewan', 'N/A', 'Ewan', 'N/A', 'Malaya, Naujan, Oriental Mindoro', 'Irish Andaya', '0987546789', 'Minsu Lab', 'Oriental Mindoro'),
(26, 'E004', 11, 24, '2024-12-02', 'a.png', 'Jake A Ewam', 'Ewam', 'kesiriah.hola@gmail.com', '00987', '2014-04-13', 'Female', '11', 'Single', 'Ewam', 45, 88, 'Ewam', 'Ewam', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Ewam', 'Ewam', '788558', NULL, NULL),
(27, 'E005', 12, 23, '2024-12-12', '6064e7ddced1498cf81eb9d143f16a6a.jpg', 'Irish Kate Andaya', 'Bayan', 'andayairishkate1@gmail.com', '0986234567', '1991-02-02', 'Female', '12', 'Single', 'FIlipino', 175, 60, 'Catholic', 'Ewam', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Ewam', 'Ewam', '123456789', NULL, NULL),
(28, 'E006', 11, 24, '2024-12-12', 'Death certificate of original account owner.jpg', 'Abe Kate Andaya', 'Bayan', 'andayairishkate1@gmail.com', '0986234567', '2009-02-13', 'Female', '11', 'Single', 'Filipino', 89, 89, 'Catholic', 'Ewam', 'N/A', 'N/A', 'N/A', 'Ewan', 'N/A', 'Ewam', 'Ewam', '3456789', NULL, NULL),
(29, 'E007', 11, 24, '2024-12-12', 'slides_1.jpg', 'Russel V Salazar', 'Malaya, Naujan, Oriental Mindoro', 'jrsalazar0420@gmail.com', '09876554333', '1963-02-12', 'Female', '11', 'Married', 'FIlipino', 89, 89, 'Catholic', 'Ewam', 'N/A', 'N/A', 'N/A', 'Ewan', 'N/A', 'Malaya, Naujan, Oriental Mindoro', 'Irish Andaya', '0986543', NULL, NULL),
(30, 'E008', 12, 23, '2024-12-13', '6064e7ddced1498cf81eb9d143f16a6a.jpg', 'Ace A Horlador', 'Malaya, Naujan, Oriental Mindoro', 'eysdgreyt@gmail.com', '09764567', '2009-04-12', 'Male', '12', 'Married', 'FIlipino', 175, 60, 'Protestante', 'Ewam', 'N/A', 'N/A', 'N/A', 'Ewan', 'N/A', 'Malaya, Naujan, Oriental Mindoro', 'Irish Andaya', '98876', NULL, NULL),
(31, 'E009', 12, 23, '2024-12-17', '133701514721335967.jpg', 'KLJ E HAHA', 'Malaya, Naujan, Oriental Mindoro', 'a@gmail.com', '09764567', '2013-04-16', 'Female', '12', 'Single', 'FIlipino', 175, 60, 'Protestante', 'Ewam', 'N/A', 'N/A', 'N/A', 'Ewan', 'N/A', 'Malaya, Naujan, Oriental Mindoro', 'Ewam', '567890', NULL, NULL);

--
-- Triggers `employees`
--
DELIMITER $$
CREATE TRIGGER `generate_employee_id` BEFORE INSERT ON `employees` FOR EACH ROW BEGIN
   DECLARE new_id INT;
   SELECT IFNULL(MAX(CAST(SUBSTRING(employee_id, 2, 4) AS UNSIGNED)), 0) + 1 INTO new_id FROM employees;
   SET NEW.employee_id = CONCAT('E', LPAD(new_id, 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `overtime`
--

CREATE TABLE `overtime` (
  `id` int NOT NULL,
  `employee_id` int DEFAULT NULL,
  `overtime_id` varchar(45) DEFAULT NULL,
  `hours` double DEFAULT NULL,
  `rate_hour` double DEFAULT NULL,
  `date_overtime` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `overtime`
--

INSERT INTO `overtime` (`id`, `employee_id`, `overtime_id`, `hours`, `rate_hour`, `date_overtime`) VALUES
(27, 24, '5102436', 3, 100, '2024-11-30'),
(28, 27, '3024516', 1, 35, '2024-12-11'),
(29, 27, '6105342', 2, 35, '2024-12-12'),
(30, 28, '4165023', 1.5, 25, '2024-12-12'),
(31, 31, '3642051', 1.5, 25, '2024-12-10');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `position_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `description`, `rate`, `position_id`) VALUES
(10, 'Timekeeper', 35, '463081975'),
(11, 'Mason', 35, '839401672'),
(12, 'Driver', 250, '236451087'),
(13, 'Labor', 47.5, '271459803'),
(14, 'Foreman', 43.75, '438725196'),
(15, 'Liason', 78, '470316298'),
(16, 'Skilled', 69, '798342506');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int NOT NULL,
  `schedule_id` varchar(45) DEFAULT NULL,
  `time_in_morning` varchar(45) DEFAULT NULL,
  `time_out_morning` varchar(45) DEFAULT NULL,
  `time_in_afternoon` varchar(45) DEFAULT NULL,
  `time_out_afternoon` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `schedule_id`, `time_in_morning`, `time_out_morning`, `time_in_afternoon`, `time_out_afternoon`) VALUES
(23, '2503614', '07:30:00', '11:30:00', '01:00:00', '05:00:00'),
(24, '2034615', '07:00:00', '11:00:00', '01:00:00', '05:00:00'),
(25, '1036542', '08:00:00', '12:00:00', '01:00:00', '05:00:00'),
(26, '0465123', '07:00:00', '11:30:00', '01:00:00', '05:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barcode`
--
ALTER TABLE `barcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashadvance`
--
ALTER TABLE `cashadvance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `barcode`
--
ALTER TABLE `barcode`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cashadvance`
--
ALTER TABLE `cashadvance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
