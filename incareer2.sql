-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2022 at 09:36 AM
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
  `assignment_type` enum('exam','task','','') NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignment_id`, `assignment_name`, `assignment_start_date`, `assignment_end_date`, `assignment_desc`, `assignment_type`, `subject_id`) VALUES
(2, 'Membuat List', '2022-04-07 09:27:18', '2022-04-15 14:27:18', 'nmgkjxu saiuiu dcgudgdiug ', 'exam', 3),
(3, 'Membuat Linked List', '2022-04-07 09:27:18', '2022-04-15 14:27:18', 'sjkdh sdsoi osi oso', 'exam', 4),
(4, 'Membuat tugas 1', '2022-04-11 11:52:00', '2022-04-13 11:52:00', 'bbbbbb', 'exam', 3);

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
(1, 'Jadwal Latihan FG.xlsx', '2022-04-06 13:06:44', NULL),
(2, 'amar 2.jpg', '2022-04-11 11:52:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `assignment_submission_id` int(10) UNSIGNED NOT NULL,
  `submission_filename` varchar(255) NOT NULL,
  `submitted_date` datetime NOT NULL,
  `assignment_token` varchar(255) NOT NULL,
  `assignment_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignment_submissions`
--

INSERT INTO `assignment_submissions` (`assignment_submission_id`, `submission_filename`, `submitted_date`, `assignment_token`, `assignment_id`) VALUES
(44, 'Submissionhalaman rumah (2).jpg', '2022-04-08 14:08:33', '', 2),
(45, 'Submissionhalaman rumah (2).jpg', '2022-04-08 14:31:27', '', 3),
(46, 'B_L200180194_Alfianto Andy P.pdf', '2022-04-08 14:40:12', '', 2),
(47, 'SK_CPNS_196711221991122002.pdf', '2022-04-13 10:10:45', '', 2),
(48, 'SK_CPNS_196711221991122002.pdf', '2022-04-13 10:10:46', '', 2),
(49, 'SK_CPNS_196711221991122002.pdf', '2022-04-13 10:10:46', '', 2),
(50, 'SK_CPNS_196711221991122002.pdf', '2022-04-13 10:10:47', '', 2),
(51, 'SK_CPNS_196711221991122002.pdf', '2022-04-13 10:16:05', '', 2),
(52, 'SK_CPNS_196711221991122002.pdf', '2022-04-13 10:16:06', '', 2),
(53, 'B_L200180194_Alfianto Andy P.pdf', '2022-04-13 10:17:34', '', 2),
(54, 'B_L200180194_Alfianto Andy P.pdf', '2022-04-13 10:20:27', '', 2),
(55, 'B_L200180194_Alfianto Andy P.pdf', '2022-04-13 10:23:03', '', 2),
(56, 'amar 1.jpg', '2022-04-13 10:23:20', '', 2),
(57, 'B_L200180194_Alfianto Andy P.pdf', '2022-04-14 10:54:15', '', 2);

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
  `assignment_upload_id` int(10) UNSIGNED NOT NULL
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
(7, 'Alfianto', '1234', 1);

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
(6, 7, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `fk_subjects` (`subject_id`);

--
-- Indexes for table `assignment_questions`
--
ALTER TABLE `assignment_questions`
  ADD PRIMARY KEY (`assignment_question_id`),
  ADD KEY `fk_assign` (`assignment_id`);

--
-- Indexes for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD PRIMARY KEY (`assignment_submission_id`),
  ADD KEY `fk_assignment` (`assignment_id`);

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
  ADD KEY `assingment_up_id` (`assignment_upload_id`);

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
  MODIFY `assignment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `assignment_questions`
--
ALTER TABLE `assignment_questions`
  MODIFY `assignment_question_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `assignment_submission_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `score_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_assignments`
--
ALTER TABLE `user_assignments`
  MODIFY `user_assigment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `user_course_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `fk_subjects` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `assingment_up_id` FOREIGN KEY (`assignment_upload_id`) REFERENCES `assignment_submissions` (`assignment_submission_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
