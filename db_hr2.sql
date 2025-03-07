-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2025 at 02:48 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_hr2`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `user_id`, `admin_name`) VALUES
(1, 2, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chat_messages`
--

CREATE TABLE `tbl_chat_messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_chat_messages`
--

INSERT INTO `tbl_chat_messages` (`message_id`, `sender_id`, `receiver_id`, `message`, `timestamp`, `is_read`) VALUES
(1, 1, 2, 'test', '2025-03-06 04:57:32', 0),
(2, 2, 1, 'test', '2025-03-06 05:03:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chat_permissions`
--

CREATE TABLE `tbl_chat_permissions` (
  `permission_id` int(11) NOT NULL,
  `sender_role` varchar(50) NOT NULL,
  `receiver_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_chat_permissions`
--

INSERT INTO `tbl_chat_permissions` (`permission_id`, `sender_role`, `receiver_role`) VALUES
(4, 'admin', 'employee'),
(3, 'admin', 'supervisor'),
(2, 'admin', 'super_admin'),
(7, 'employee', 'admin'),
(8, 'employee', 'supervisor'),
(5, 'supervisor', 'admin'),
(6, 'supervisor', 'employee'),
(1, 'super_admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employees`
--

CREATE TABLE `tbl_employees` (
  `employee_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `employee_name` varchar(256) NOT NULL,
  `employee_hire_date` date NOT NULL,
  `employee_position` varchar(256) NOT NULL,
  `employee_department` varchar(256) NOT NULL,
  `employee_soft_skills` varchar(256) NOT NULL,
  `employee_hard_skills` varchar(256) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_employees`
--

INSERT INTO `tbl_employees` (`employee_id`, `user_id`, `employee_name`, `employee_hire_date`, `employee_position`, `employee_department`, `employee_soft_skills`, `employee_hard_skills`, `is_active`) VALUES
(1, 7, 'Employee 2', '2025-03-05', 'IT', 'IT1', 'ewanx ko, ewanx mo, ewanx natin', 'ewan ko, ewan mo, ewan natin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_module_progress`
--

CREATE TABLE `tbl_employee_module_progress` (
  `progress_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `progress_status` enum('In Progress','Completed','Missing') NOT NULL DEFAULT 'In Progress'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_employee_module_progress`
--

INSERT INTO `tbl_employee_module_progress` (`progress_id`, `employee_id`, `module_id`, `progress_status`) VALUES
(3, 1, 2, 'In Progress');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_forgot_requests`
--

CREATE TABLE `tbl_forgot_requests` (
  `forgot_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `forgot_reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_missed_tasks`
--

CREATE TABLE `tbl_missed_tasks` (
  `missed_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_modules`
--

CREATE TABLE `tbl_modules` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(256) NOT NULL,
  `module_description` text NOT NULL,
  `module_content` text NOT NULL,
  `module_position` varchar(256) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_modules`
--

INSERT INTO `tbl_modules` (`module_id`, `module_name`, `module_description`, `module_content`, `module_position`, `is_active`) VALUES
(2, 'Test Module', 'Module Description', '&lt;p&gt;&lt;i&gt;&lt;strong&gt;test&lt;/strong&gt;&lt;/i&gt;&lt;/p&gt;', 'IT', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_module_tasks`
--

CREATE TABLE `tbl_module_tasks` (
  `task_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `task_name` varchar(256) NOT NULL,
  `task_description` text NOT NULL,
  `task_expiration_date` date NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_module_tasks`
--

INSERT INTO `tbl_module_tasks` (`task_id`, `module_id`, `task_name`, `task_description`, `task_expiration_date`, `is_active`) VALUES
(1, 2, 'Task 1', 'Task Description', '2025-03-08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supervisor`
--

CREATE TABLE `tbl_supervisor` (
  `supervisor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `supervisor_name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_supervisor`
--

INSERT INTO `tbl_supervisor` (`supervisor_id`, `user_id`, `supervisor_name`) VALUES
(1, 3, 'Supervisor');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_task_questions`
--

CREATE TABLE `tbl_task_questions` (
  `question_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_answer` enum('A','B','C','D') NOT NULL,
  `question_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_task_questions`
--

INSERT INTO `tbl_task_questions` (`question_id`, `task_id`, `question_text`, `question_answer`, `question_data`) VALUES
(5, 1, 'Question 1', 'B', '{\"A\":\"Ewan\",\"B\":\"Ko\",\"C\":\"Sa\",\"D\":\"Iyo\"}');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(256) NOT NULL,
  `user_password` varchar(256) NOT NULL,
  `user_role` enum('super_admin','admin','supervisor','employee') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_username`, `user_password`, `user_role`) VALUES
(1, 'super_admin@gmail.com', '$2y$10$phoAv7E6aEoI.QISHRjLk.mKvGA4vTO9ehd/wnOqKI7DcO6V9rgTu', 'super_admin'),
(2, 'admin@gmail.com', '$2y$10$kmEK/wzwdZn/96kFuAD7memrphGwgOLxagTTT9htITLDbHwnRxSUG', 'admin'),
(3, 'supervisor@gmail.com', '$2y$10$LUjg1VwfbgYh/9.EBDKP.OszIAmJjVy8uJEzxatGrfmH3aLZ/a1Te', 'supervisor'),
(7, 'employee1@gmail.com', '$2a$12$Pc8/3dsr5B0gNgEHaIpAd.SCGQmNPpQiABMEfA8LxKl5j47qxe20S', 'employee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `FK_tbl_admin` (`user_id`);

--
-- Indexes for table `tbl_chat_messages`
--
ALTER TABLE `tbl_chat_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `tbl_chat_permissions`
--
ALTER TABLE `tbl_chat_permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD UNIQUE KEY `unique_permission` (`sender_role`,`receiver_role`);

--
-- Indexes for table `tbl_employees`
--
ALTER TABLE `tbl_employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `tbl_employee_module_progress`
--
ALTER TABLE `tbl_employee_module_progress`
  ADD PRIMARY KEY (`progress_id`),
  ADD KEY `FK_tbl_employee_module_progress1` (`employee_id`),
  ADD KEY `FK_tbl_employee_module_progress2` (`module_id`);

--
-- Indexes for table `tbl_forgot_requests`
--
ALTER TABLE `tbl_forgot_requests`
  ADD PRIMARY KEY (`forgot_id`);

--
-- Indexes for table `tbl_missed_tasks`
--
ALTER TABLE `tbl_missed_tasks`
  ADD PRIMARY KEY (`missed_id`),
  ADD KEY `FK_tbl_missed_tasks1` (`employee_id`),
  ADD KEY `FK_tbl_missed_tasks2` (`task_id`);

--
-- Indexes for table `tbl_modules`
--
ALTER TABLE `tbl_modules`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `tbl_module_tasks`
--
ALTER TABLE `tbl_module_tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `FK_tbl_module_tasks` (`module_id`);

--
-- Indexes for table `tbl_supervisor`
--
ALTER TABLE `tbl_supervisor`
  ADD PRIMARY KEY (`supervisor_id`),
  ADD KEY `FK_tbl_supervisor` (`user_id`);

--
-- Indexes for table `tbl_task_questions`
--
ALTER TABLE `tbl_task_questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `FK_tbl_task_questions` (`task_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_chat_messages`
--
ALTER TABLE `tbl_chat_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_chat_permissions`
--
ALTER TABLE `tbl_chat_permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_employees`
--
ALTER TABLE `tbl_employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_employee_module_progress`
--
ALTER TABLE `tbl_employee_module_progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_forgot_requests`
--
ALTER TABLE `tbl_forgot_requests`
  MODIFY `forgot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_missed_tasks`
--
ALTER TABLE `tbl_missed_tasks`
  MODIFY `missed_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_modules`
--
ALTER TABLE `tbl_modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_module_tasks`
--
ALTER TABLE `tbl_module_tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_supervisor`
--
ALTER TABLE `tbl_supervisor`
  MODIFY `supervisor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_task_questions`
--
ALTER TABLE `tbl_task_questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD CONSTRAINT `FK_tbl_admin` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_chat_messages`
--
ALTER TABLE `tbl_chat_messages`
  ADD CONSTRAINT `tbl_chat_messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `tbl_users` (`user_id`),
  ADD CONSTRAINT `tbl_chat_messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `tbl_users` (`user_id`);

--
-- Constraints for table `tbl_employee_module_progress`
--
ALTER TABLE `tbl_employee_module_progress`
  ADD CONSTRAINT `FK_tbl_employee_module_progress1` FOREIGN KEY (`employee_id`) REFERENCES `tbl_employees` (`employee_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_tbl_employee_module_progress2` FOREIGN KEY (`module_id`) REFERENCES `tbl_modules` (`module_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_missed_tasks`
--
ALTER TABLE `tbl_missed_tasks`
  ADD CONSTRAINT `FK_tbl_missed_tasks1` FOREIGN KEY (`employee_id`) REFERENCES `tbl_employees` (`employee_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_tbl_missed_tasks2` FOREIGN KEY (`task_id`) REFERENCES `tbl_module_tasks` (`task_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_module_tasks`
--
ALTER TABLE `tbl_module_tasks`
  ADD CONSTRAINT `FK_tbl_module_tasks` FOREIGN KEY (`module_id`) REFERENCES `tbl_modules` (`module_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_supervisor`
--
ALTER TABLE `tbl_supervisor`
  ADD CONSTRAINT `FK_tbl_supervisor` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_task_questions`
--
ALTER TABLE `tbl_task_questions`
  ADD CONSTRAINT `FK_tbl_task_questions` FOREIGN KEY (`task_id`) REFERENCES `tbl_module_tasks` (`task_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
