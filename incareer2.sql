-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2022 at 02:08 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `incareer2`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignment_id` int(10) UNSIGNED NOT NULL,
  `assignment_name` varchar(100) NOT NULL,
  `assignment_start_date` datetime NOT NULL,
  `assignment_end_date` datetime NOT NULL,
  `assignment_desc` text NOT NULL,
  `assignment_type` enum('exam','task','','') NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `mentor_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignment_id`, `assignment_name`, `assignment_start_date`, `assignment_end_date`, `assignment_desc`, `assignment_type`, `subject_id`, `mentor_id`) VALUES
(9, 'Membuat ASD', '2022-04-24 23:37:00', '2022-04-27 23:37:00', 'ASDASDASDASD', 'exam', 5, 6),
(10, 'Mengenal Pemrograman PHP', '2022-04-25 04:40:00', '2022-04-27 04:40:00', 'Mari mengenal php', 'task', 2, 2),
(11, 'Task 1', '2022-04-25 04:45:00', '2022-04-29 04:45:00', 'Task 1', 'exam', 15, 2),
(12, 'Task 2', '2022-04-25 04:46:00', '2022-04-26 04:46:00', 'asdf', 'task', 15, 2),
(13, 'Task 3', '2022-04-25 04:46:00', '2022-04-26 04:46:00', 'zxc', 'task', 15, 2),
(14, 'Test Task', '2022-04-25 04:49:00', '2022-04-28 04:49:00', 'zxcv', 'task', 2, 2),
(15, 'Test Task 2', '2022-04-25 04:49:00', '2022-04-28 04:49:00', 'zxcv', 'task', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `assignment_questions`
--

CREATE TABLE `assignment_questions` (
  `assignment_question_id` int(10) UNSIGNED NOT NULL,
  `question_filename` varchar(255) NOT NULL,
  `question_upload_date` datetime NOT NULL,
  `assignment_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignment_questions`
--

INSERT INTO `assignment_questions` (`assignment_question_id`, `question_filename`, `question_upload_date`, `assignment_id`) VALUES
(7, 'Command Git.txt', '2022-04-24 23:37:20', 9),
(8, 'Command Git.txt', '2022-04-25 04:41:15', 10),
(9, 'Jadwal Latihan FG.xlsx', '2022-04-25 04:45:19', 11),
(10, 'Command Git.txt', '2022-04-25 04:46:42', 12),
(11, 'Command Git.txt', '2022-04-25 04:48:14', 13),
(12, 'Jadwal Latihan FG.xlsx', '2022-04-25 04:50:14', 14),
(13, 'Jadwal Latihan FG.xlsx', '2022-04-25 04:50:43', 15);

-- --------------------------------------------------------

--
-- Table structure for table `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `assignment_submission_id` int(10) UNSIGNED NOT NULL,
  `submission_filename` varchar(255) NOT NULL,
  `submitted_date` datetime NOT NULL,
  `submission_token` varchar(255) NOT NULL,
  `assignment_id` int(10) UNSIGNED DEFAULT NULL,
  `student_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignment_submissions`
--

INSERT INTO `assignment_submissions` (`assignment_submission_id`, `submission_filename`, `submitted_date`, `submission_token`, `assignment_id`, `student_id`) VALUES
(168, '', '2022-04-24 23:46:14', '6e92a241f5b5b3e080f1a8e43784cbf9', 9, 5),
(169, '', '2022-04-25 00:00:18', '8c9ffe6f9f2faf86570f90cd40106f6e', 9, 5),
(170, '', '2022-04-25 00:03:38', '7da77c7d973e2c9c7dcedad4750f27ea', 9, 5),
(171, '', '2022-04-25 00:07:12', '037526d37e3aa0b3e8ed470062cdc632', 9, 5),
(172, '', '2022-04-25 00:07:12', '037526d37e3aa0b3e8ed470062cdc632', 9, 5),
(173, '', '2022-04-25 00:09:09', '2c64f2ca87563d1388448d92160bb951', 9, 5),
(174, '', '2022-04-25 00:11:12', '6ab9f01b7e80a971ea2fa6734003351f', 9, 5),
(175, '', '2022-04-25 00:11:44', '105f61fce24d176c70d434df9136e0a2', 9, 5),
(176, '', '2022-04-25 00:12:52', '7db86808e2b8d3171edb395e65e59b19', 9, 5),
(177, 'Jadwal Latihan FG.xlsx', '2022-04-25 00:14:01', 'c0c4bf04f48bc9fe20160fb24ece03b3', 9, 5),
(178, 'matkul sem 6.txt', '2022-04-25 00:15:33', '4a599eb7e4449868dda3f7a5f57fea7a', 9, 5),
(186, 'Jadwal Latihan FG.xlsx', '2022-04-25 04:59:43', '468678b3b5dd0f298c9432b4bba7700d', 10, 4),
(187, 'matkul sem 6.txt', '2022-04-25 05:00:24', '379565573ebb04eecd37cb96d11a9387', 10, 4),
(188, 'Command Git.txt', '2022-04-25 05:00:24', '379565573ebb04eecd37cb96d11a9387', 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(10) UNSIGNED NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_desc`) VALUES
(1, 'Algoritma Struktur Data', 'sjgfdkafjdkvbdigfiowebfvkjdubcvfdv fukdnoigdvsdvdv'),
(2, 'Database Development', 'safkhsafmwpbonut9w0 Y E8FRYE PIFEFYEWP UGUEIWF J\'iyg[9aer yioew fuopeu y ye9gywei fhioqe foiwe'),
(3, 'Algoritma Pemrograman', 'kjshfiue  ureiuy ey ey uyweiu yifiufgkjfhkfjh euyruew iueriu e giuegiehiuiufueif   ufudhfkjdfdhfkhgiguriugyrruiywy;a;ggkdfj'),
(4, 'Matematika Diskret', 'xlkjfdiorjew eio jioerurioe o oieewoi dkjhfkjdhj oihfld hodhforywrojgio o ohohfsdkjhvkjfshvjk ds hfodsh guirhfogi wo hwhwuih ho   hofhfhdllsdd sfhf  hldsllksfslk j   flkjljsfjfslkd    sfjldjldfl');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `score_id` int(10) UNSIGNED NOT NULL,
  `score_value` int(11) NOT NULL,
  `submission_id` int(10) UNSIGNED NOT NULL,
  `mentor_id` int(10) UNSIGNED NOT NULL,
  `component_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`score_id`, `score_value`, `submission_id`, `mentor_id`, `component_id`) VALUES
(18, 0, 177, 0, 1),
(19, 0, 178, 0, 1),
(20, 0, 0, 0, 1),
(21, 0, 0, 0, 1),
(22, 0, 0, 0, 1),
(23, 0, 0, 0, 1),
(24, 0, 0, 0, 1),
(25, 0, 0, 0, 1),
(26, 0, 0, 0, 1),
(27, 60, 186, 2, 1),
(28, 20, 187, 2, 1),
(29, 0, 188, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(10) UNSIGNED NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `subject_desc` text NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `subject_desc`, `course_id`) VALUES
(3, 'List', 'akldfkldajf dlkanflkdanfld klabdfljd', 1),
(4, 'Linked List', 'klafhkldhf\'odgfodnf', 1),
(5, 'Join', ',msfhkjdhfdahd hkf hdahd', 2),
(6, 'Mysql', 'dklfjldf dhodivjoid v vidpo d', 2),
(7, 'Tipe Data', 'safnkj;dfkdlnvkdn lkd jvioduvpods', 3),
(8, 'Dictionary', 'xmcndlkv dhvoidsj;lds pidupodsjsdpov udvpoW', 3),
(9, 'Matematika', 'mdnvlkd dihidslv dgvd\'ovhds\' vds', 4),
(10, 'Diskret', 'm,dnvlk dhiofh ldskhd vhdvhdjkv djv hduh dljkshlkshf lfshjvlhj vkvkjhvkjshvkjshs hvfkhfukhfuk ', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(5, 'Andy', '1234', 1),
(6, 'Ilham', '1234', 2),
(7, 'Alfianto', '1234', 1),
(8, 'AAAAA', '1234', 1),
(9, 'bbbb', '1234', 1),
(10, 'cccc', '1234', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_assignments`
--

CREATE TABLE `user_assignments` (
  `user_assigment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `assignment_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE `user_courses` (
  `user_course_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_courses`
--

INSERT INTO `user_courses` (`user_course_id`, `user_id`, `course_id`) VALUES
(1, 5, 1),
(2, 5, 2),
(3, 6, 1),
(4, 6, 2),
(5, 7, 1),
(6, 7, 2),
(7, 8, 1),
(8, 8, 2),
(11, 9, 1),
(12, 9, 4),
(13, 10, 2),
(14, 10, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `fk_subjects` (`subject_id`),
  ADD KEY `fk_mentor` (`mentor_id`),
  ADD KEY `index_name` (`assignment_name`),
  ADD KEY `tgl` (`assignment_start_date`,`assignment_end_date`) USING BTREE,
  ADD KEY `astype` (`assignment_type`);

--
-- Indexes for table `assignment_questions`
--
ALTER TABLE `assignment_questions`
  ADD PRIMARY KEY (`assignment_question_id`),
  ADD KEY `fk_assign` (`assignment_id`),
  ADD KEY `index_filenime` (`question_filename`),
  ADD KEY `index_upload` (`question_upload_date`);

--
-- Indexes for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD PRIMARY KEY (`assignment_submission_id`),
  ADD KEY `fk_assignment` (`assignment_id`),
  ADD KEY `fk_student` (`student_id`),
  ADD KEY `index_filename` (`submission_filename`),
  ADD KEY `index_date` (`submitted_date`),
  ADD KEY `index_token` (`submission_token`) USING BTREE;

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`score_id`),
  ADD KEY `fk_mentorscore` (`mentor_id`),
  ADD KEY `index_value` (`score_value`),
  ADD KEY `comp_index` (`component_id`) USING BTREE,
  ADD KEY `sub_id` (`submission_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `fk_courses` (`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_assignments`
--
ALTER TABLE `user_assignments`
  ADD PRIMARY KEY (`user_assigment_id`),
  ADD KEY `fk_assignments` (`assignment_id`),
  ADD KEY `fk_users` (`user_id`);

--
-- Indexes for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD PRIMARY KEY (`user_course_id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `assignment_questions`
--
ALTER TABLE `assignment_questions`
  MODIFY `assignment_question_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `assignment_submission_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `score_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_assignments`
--
ALTER TABLE `user_assignments`
  MODIFY `user_assigment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `user_course_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment_questions`
--
ALTER TABLE `assignment_questions`
  ADD CONSTRAINT `fk_assign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`assignment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD CONSTRAINT `fk_assignment` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`assignment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `fk_courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_assignments`
--
ALTER TABLE `user_assignments`
  ADD CONSTRAINT `fk_assignments` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`assignment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD CONSTRAINT `fk_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
