-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2022 at 04:45 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

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
  `assignment_type` enum('exam','task','personality') NOT NULL,
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
(15, 'Test Task 2', '2022-04-25 04:49:00', '2022-04-28 04:49:00', 'zxcv', 'task', 2, 2),
(16, 'TAsk 3', '2022-04-25 13:53:00', '2022-04-28 13:53:00', 'abcccccccc', 'exam', 2, 2),
(17, 'Contoh Task', '2022-04-25 14:50:00', '2022-04-28 14:50:00', 'test', 'task', 2, 2);

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
(8, '1 (1).txt', '2022-04-25 04:41:15', 10),
(9, 'Jadwal Latihan FG.xlsx', '2022-04-25 04:45:19', 11),
(10, 'Command Git.txt', '2022-04-25 04:46:42', 12),
(11, 'Command Git.txt', '2022-04-25 04:48:14', 13),
(12, 'Jadwal Latihan FG.xlsx', '2022-04-25 04:50:14', 14),
(13, 'Jadwal Latihan FG.xlsx', '2022-04-25 04:50:43', 15),
(14, '1 (1).txt', '2022-04-25 13:53:24', 16),
(15, '1619955613167.xlsx', '2022-04-25 14:50:56', 17);

-- --------------------------------------------------------

--
-- Table structure for table `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `assignment_submission_id` int(10) UNSIGNED NOT NULL,
  `submission_filename` varchar(255) NOT NULL,
  `submitted_date` datetime NOT NULL,
  `submission_token` varchar(255) NOT NULL,
  `assignment_status` enum('aktif','nonaktif') NOT NULL,
  `assignment_id` int(10) UNSIGNED DEFAULT NULL,
  `student_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `assignment_id` int(10) UNSIGNED NOT NULL,
  `mentor_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `component_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  ADD KEY `index_token` (`submission_token`) USING BTREE,
  ADD KEY `status` (`assignment_status`);

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
  ADD KEY `student_index` (`student_id`);

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
  MODIFY `assignment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `assignment_questions`
--
ALTER TABLE `assignment_questions`
  MODIFY `assignment_question_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `assignment_submission_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `score_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `fkasign_id` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`assignment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
