-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2023 at 03:34 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `block_3c`
--

-- --------------------------------------------------------

--
-- Table structure for table `admininfo`
--

CREATE TABLE `admininfo` (
  `user_id` int(6) UNSIGNED ZEROFILL NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admininfo`
--

INSERT INTO `admininfo` (`user_id`, `username`, `password`, `email`, `fname`, `phone`, `type`) VALUES
(000001, 'admin', 'admin', 'admin@gmail.com', 'admin', '0976789124', 'admin'),
(000002, 'Jed', 'password', 'jeddycolon.certifico@bicol-u.e', 'Jeddy Certifico', '0976347328', 'employee'),
(000003, 'rj', 'password2', 'russeljamescute@gmail.com', 'Russel James	Recamunda', '0938854115', 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `atlog`
--

CREATE TABLE `atlog` (
  `atlog_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `atlog_date` date DEFAULT NULL,
  `am_in` time DEFAULT NULL,
  `am_out` time DEFAULT NULL,
  `pm_in` time DEFAULT NULL,
  `pm_out` time DEFAULT NULL,
  `am_late` int(11) DEFAULT NULL,
  `am_undertime` int(11) DEFAULT NULL,
  `pm_late` int(11) DEFAULT NULL,
  `pm_undertime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `atlog`
--

INSERT INTO `atlog` (`atlog_id`, `emp_id`, `atlog_date`, `am_in`, `am_out`, `pm_in`, `pm_out`, `am_late`, `am_undertime`, `pm_late`, `pm_undertime`) VALUES
(2, 1, '2023-12-16', '06:40:00', '10:33:00', '13:30:00', '17:00:00', 31, 27, 30, 30),
(4, 3, '2023-12-16', '00:00:00', '00:00:00', '15:27:00', '17:00:00', 0, 0, 27, 0),
(5, 7, '2023-12-16', '06:42:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, 0, 0),
(6, 9, '2023-12-17', '00:00:00', '06:10:00', '22:00:00', '00:00:00', 0, 50, 0, 0),
(8, 10, '2023-12-18', '00:00:00', '08:00:00', '20:00:00', '00:00:00', 0, 0, 0, 0),
(9, 11, '2023-12-18', '00:00:00', '00:00:00', '16:45:00', '19:00:00', 0, 0, 45, 0),
(11, 2, '2023-12-01', '07:51:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, 0, 0),
(12, 5, '2023-11-30', '06:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, 0, 0),
(13, 7, '2023-12-18', '00:00:00', '00:00:00', '20:00:00', '00:00:00', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(6) NOT NULL,
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `middle_name` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(20) NOT NULL DEFAULT '',
  `work_status` varchar(50) NOT NULL DEFAULT '',
  `birthdate` varchar(50) NOT NULL DEFAULT '',
  `emp_pic` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `first_name`, `last_name`, `middle_name`, `address`, `email`, `phone`, `work_status`, `birthdate`, `emp_pic`) VALUES
(1, 'Russel James ', 'Recamunda', 'Ricafort', 'Burgos St. Burabod Sorsogon City 4700', 'russeljamesrecamunda@gmail.com', '09388541155', 'Onsite Work', '04 - 09 - 2002', ''),
(2, 'Jeddy', 'Certifico', 'M.', 'Masbate', 'jeddycolon.certifico@bicol-u.edu.ph', '09763473284', 'Night Shift', '25 - 12 - 2023', ''),
(3, 'Alice', 'Johnson', 'Marie', '123 Main Street, Cityville, State, ZIP', 'alice.johnson@email.com', '(555) 555-1234', 'Work From Home', '', ''),
(4, 'Robert', 'Smith', 'Michael', '456 Oak Avenue, Townsville, State, ZIP', 'robert.smith@email.com', '(555) 555-5678', 'Night Shift', '', ''),
(5, 'Robert', 'Smith', 'Michael', '456 Oak Avenue, Townsville, State, ZIP', 'robert.smith@email.com', '(555) 555-5678', 'Night Shift', '', ''),
(6, 'Emily', 'Davis', 'Ann', '789 Pine Road, Villagetown, State, ZIP', 'emily.davis@email.com', '(555) 555-9012', 'Work From Home', '', ''),
(7, 'Juan', 'Santos', 'Miguel', '123 Sampaguita St., Makati City, Metro Manila, 1234', 'juan.santos@email.com', '63 912 345 6789', 'Onsite Work', '', ''),
(8, 'Allen Marchel', 'Novero', 'Lacra', 'Bibincahan Sorsogon', 'allenmarchellacra.novero@bicol-u.edu.ph', '0953719532', 'Work From Home', '2001-07-15', ''),
(9, 'Maria', 'Reyes', 'Cruz', '456 Narra Ave., Quezon City, Metro Manila, 5678', 'maria.reyes@email.com', '63 912 987 6543', 'Onsite Work', '', ''),
(10, 'Bernard', 'Onsenia', 'Alcantara', ' 503 Jamaica St., Quezon City, Quezon, 1412', 'bernard.onsenia@gmail.com', '63 962 825 0562', 'Night Shift', '', ''),
(11, 'Jose', 'Lim', 'Rizal', ' 789 Acacia St., Cebu City, Cebu, 9012', 'jose.lim@email.com', '63 912 345 0123', 'Work From Home', '', ''),
(12, 'Lea', 'Gonzales', 'Fernandez', '101 Sampaloc Rd., Davao City, Davao del Sur, 3456', ' lea.gonzales@email.com', '63 912 789 5678', 'Night Shift', '', ''),
(13, 'Ramon', 'Cruz', ' Dela Paz', '202 Gumamela St., Baguio City, Benguet, 7890', 'ramon.cruz@email.com', '63 912 012 3456', 'Onsite Work', '', ''),
(14, 'Katrina', 'Santos', 'Flores', '303 Molave Ave., Iloilo City, Iloilo, 2345', ' katrina.santos@email.com', '63 912 678 9012', 'Onsite Work', '', ''),
(15, 'Miguel', 'Reyes', 'Antonio', '404 Sampaguita Rd., Zamboanga City, Zamboanga del Sur, 5678', 'miguel.reyes@email.com', '63 912 901 2345', 'Work From Home', '', ''),
(16, 'Grace', 'Tan', 'Victoria', '505 Ylang-Ylang St., Tagaytay City, Cavite, 6789', 'grace.tan@email.com', '63 912 234 5678', 'Night Shift', '', ''),
(17, 'Eduardo', 'Garcia', 'Santos', '606 Balayong Ave., Tacloban City, Leyte, 9012', 'eduardo.garcia@email.com', '63 912 567 8901', 'Onsite Work', '', ''),
(18, 'Rosa', 'Perez', 'Magtanggol', '707 Dama de Noche St., Bacolod City, Negros Occidental, 1234', ' rosa.perez@email.com', '63 912 890 1234', 'Work From Home', '', ''),
(19, 'Lauren', 'Foster', 'Marie', '765 Oak Avenue, Laketown, State, ZIP', 'lauren.foster@email.com', '555) 555-6789', 'Onsite Work', '', ''),
(20, 'Renz Ury', 'Cordero', 'Mira', 'Anislag Daraga', 'renzurymira.cordero@bicol-u.edu.ph', '09963837518', 'Onsite Work', '07 - 02 - 2003', ''),
(21, 'John', 'Doe', 'Matthew', '123 Main St', 'john.doe@email.com', '555-1234', 'Onsite Work', '1990-05-15', ''),
(22, 'Jane', 'Smith', 'Anne', '456 Oak Ave', 'jane.smith@email.com', '555-5678', 'Work From Home', '1985-08-22', ''),
(23, 'Alex', 'Johnson', 'Brian', '789 Pine Rd', 'alex.johnson@email.com', '555-8765', 'Nightshift', '1992-02-10', ''),
(24, 'Sarah', 'Davis', 'Clark', '101 Elm Blvd', 'sarah.davis@email.com', '555-4321', 'Onsite Work', '1988-11-30', ''),
(25, 'Michael', 'White', 'David', '202 Cedar Ln', 'michael.white@email.com', '555-9876', 'Work From Home', '1995-07-03', ''),
(26, 'Emily', 'Brown', 'Elizabeth', '303 Maple Ct', 'emily.brown@email.com', '555-6789', 'Nightshift', '1997-04-18', ''),
(27, 'Brian', 'Miller', 'Frank', '404 Birch St', 'brian.miller@email.com', '555-3456', 'Onsite Work', '1983-09-25', ''),
(28, 'Olivia', 'Taylor', 'Grace', '505 Spruce Rd', 'olivia.taylor@email.com', '555-2345', 'Work From Home', '1994-01-12', ''),
(29, 'Daniel', 'Wilson', 'Henry', '606 Pine Ave', 'daniel.wilson@email.com', '555-7890', 'Nightshift', '1980-06-28', ''),
(30, 'Aaron Jan', 'Alpay', 'Durana', 'Castilla Sorsogon', 'aaronjandurana.alpay@bicol-u.edu.ph', '0945492681', 'Onsite Work', '12 - 01 - 2002', ''),
(31, 'Jea', 'Obanon', 'Caila', 'Guinobatan Albay', 'jcmo2022-8970-68897@bicol-u.edu.ph', '09479158495', 'Onsite Work', '15 - 07 - 2004', ''),
(33, 'Janjan', 'Alberto', 'Arimado', 'Estanza Legazpi', 'janjan9925@gmail.com', '096593061958', 'Work From Home', '16 - 01 - 2002', ''),
(36, 'sample', 'sample', 'sample', 'sample', 'sample', 'sample', 'Onsite Work', '10 - 12 - 2023', ''),
(37, 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'Night Shift', '10 - 02 - 2010', ''),
(40, 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'Night Shift', '10 - 02 - 2010', ''),
(41, 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'Night Shift', '10 - 02 - 2010', ''),
(42, 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'Night Shift', '10 - 02 - 2010', ''),
(43, 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'Night Shift', '10 - 02 - 2010', ''),
(44, 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'Night Shift', '10 - 02 - 2010', ''),
(45, 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'Night Shift', '10 - 02 - 2010', ''),
(46, 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'Night Shift', '10 - 02 - 2010', ''),
(47, 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'Night Shift', '10 - 02 - 2010', ''),
(48, 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'Night Shift', '10 - 02 - 2010', ''),
(49, 'sample', 'sample', 'sample1', 'Castilla Sorsogon', 'sample', 'sample', 'Onsite Work', '04 - 09 - 2002', ''),
(50, 'sample', 'sample', 'sample1', 'Castilla Sorsogon', 'sample', 'sample', 'Onsite Work', '04 - 09 - 2002', ''),
(51, 'sample', 'sample', 'sample1', 'Castilla Sorsogon', 'sample', 'sample', 'Onsite Work', '04 - 09 - 2002', ''),
(52, 'sample', 'sample', 'sample1', 'Castilla Sorsogon', 'sample', 'sample', 'Onsite Work', '04 - 09 - 2002', ''),
(53, 'sample', 'sample', 'sample1', 'Castilla Sorsogon', 'sample', 'sample', 'Onsite Work', '04 - 09 - 2002', ''),
(54, 'sample', 'sample', 'sample1', 'Castilla Sorsogon', 'sample', 'sample', 'Onsite Work', '04 - 09 - 2002', ''),
(56, 'Yelena', 'Belova', 'Scarlet', 'New York City', 'yelena@gmail.com', '0948568016', 'Onsite Work', '19 - 08 - 1981', ''),
(61, 'Eren', 'Yeager', 'Titan', 'Wall Maria', 'eren@gmail.com', '0956897851', 'Onsite Work', '10 - 10 - 2001', 'eren.jpg'),
(64, 'Eren', 'Yeager', 'Titan', 'Wall Maria', 'eren@gmail.com', '0956897851', 'Work From Home', '01 - 12 - 2023', 'eren.jpg'),
(65, 'Michael', 'Cuela', 'Garrido', 'Estanza Legazpi CIty', 'cuela@gmail.com', '096749251950', 'Night Shift', '12 - 05 - 2003', '2X2-Recamunda.png');

-- --------------------------------------------------------

--
-- Table structure for table `log_report`
--

CREATE TABLE `log_report` (
  `log_id` int(11) NOT NULL,
  `user_id` int(6) UNSIGNED ZEROFILL NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `login_date` date DEFAULT NULL,
  `login_time` time DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `logout_date` date DEFAULT NULL,
  `logout_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_report`
--

INSERT INTO `log_report` (`log_id`, `user_id`, `full_name`, `login_date`, `login_time`, `status`, `logout_date`, `logout_time`) VALUES
(48, 000002, 'Jeddy Certifico', '2023-12-12', '11:32:24', 'Logout', '2023-12-12', '11:33:02'),
(49, 000001, 'admin', '2023-12-12', '22:06:38', 'Logout', '2023-12-12', '22:06:42'),
(51, 000003, 'Russel James Recamunda', '2023-12-12', '22:07:38', 'Logout', '2023-12-12', '22:07:42'),
(52, 000001, 'admin', '2023-12-12', '22:11:13', 'Logout', '2023-12-12', '22:11:22'),
(59, 000001, 'admin', '2023-12-12', '22:15:53', 'Logout', '2023-12-12', '22:15:55'),
(60, 000001, 'admin', '2023-12-12', '22:19:50', 'Logout', '2023-12-12', '22:19:55'),
(61, 000002, 'Jeddy Certifico', '2023-12-12', '22:20:35', 'Logout', '2023-12-12', '22:20:37'),
(63, 000001, 'admin', '2023-12-12', '22:21:11', 'Logout', '2023-12-13', '01:02:49'),
(64, 000002, 'Jeddy Certifico', '2023-12-13', '01:03:12', 'Logout', '2023-12-13', '01:03:21'),
(65, 000001, 'admin', '2023-12-13', '01:03:30', 'Logout', '2023-12-13', '12:06:01'),
(66, 000001, 'admin', '2023-12-13', '12:06:37', 'Login', NULL, NULL),
(67, 000001, 'admin', '2023-12-14', '12:32:12', 'Login', NULL, NULL),
(68, 000001, 'admin', '2023-12-16', '12:05:18', 'Login', NULL, NULL),
(69, 000002, 'Jeddy Certifico', '2023-12-16', '12:14:32', 'Login', NULL, NULL),
(70, 000002, 'Jeddy Certifico', '2023-12-16', '12:19:17', 'Logout', '2023-12-16', '12:37:00'),
(71, 000002, 'Jeddy Certifico', '2023-12-17', '17:06:55', 'Login', NULL, NULL),
(72, 000001, 'admin', '2023-12-17', '17:07:07', 'Login', NULL, NULL),
(73, 000001, 'admin', '2023-12-17', '17:10:48', 'Login', NULL, NULL),
(74, 000002, 'Jeddy Certifico', '2023-12-17', '17:11:00', 'Logout', '2023-12-17', '20:07:28'),
(75, 000002, 'Jeddy Certifico', '2023-12-17', '21:02:40', 'Login', NULL, NULL),
(76, 000002, 'Jeddy Certifico', '2023-12-18', '21:34:30', 'Login', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admininfo`
--
ALTER TABLE `admininfo`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `atlog`
--
ALTER TABLE `atlog`
  ADD PRIMARY KEY (`atlog_id`),
  ADD KEY `fk_atlog_employee` (`emp_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `log_report`
--
ALTER TABLE `log_report`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admininfo`
--
ALTER TABLE `admininfo`
  MODIFY `user_id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `atlog`
--
ALTER TABLE `atlog`
  MODIFY `atlog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `log_report`
--
ALTER TABLE `log_report`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `atlog`
--
ALTER TABLE `atlog`
  ADD CONSTRAINT `fk_atlog_employee` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`);

--
-- Constraints for table `log_report`
--
ALTER TABLE `log_report`
  ADD CONSTRAINT `log_report_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `admininfo` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
