-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: May 19, 2022 at 04:30 AM
-- Server version: 8.0.29
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignment_id` int UNSIGNED NOT NULL,
  `assignment_name` varchar(100) NOT NULL,
  `assignment_start_date` datetime NOT NULL,
  `assignment_end_date` datetime NOT NULL,
  `assignment_desc` text NOT NULL,
  `assignment_type` enum('exam','task','personality') NOT NULL,
  `subject_id` int UNSIGNED NOT NULL,
  `mentor_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_questions`
--

CREATE TABLE `assignment_questions` (
  `assignment_question_id` int UNSIGNED NOT NULL,
  `question_filename` varchar(255) NOT NULL,
  `question_upload_date` datetime NOT NULL,
  `assignment_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `assignment_submission_id` int UNSIGNED NOT NULL,
  `submission_filename` varchar(255) NOT NULL,
  `submitted_date` datetime NOT NULL,
  `submission_token` varchar(255) NOT NULL,
  `submission_status` enum('aktif','nonaktif') NOT NULL,
  `is_finish` tinyint UNSIGNED NOT NULL,
  `assignment_id` int UNSIGNED DEFAULT NULL,
  `student_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `score_id` int UNSIGNED NOT NULL,
  `score_value` int NOT NULL,
  `assignment_id` int UNSIGNED NOT NULL,
  `mentor_id` int UNSIGNED DEFAULT NULL,
  `student_id` int UNSIGNED NOT NULL,
  `component_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  ADD KEY `status` (`submission_status`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`score_id`),
  ADD KEY `fk_mentorscore` (`mentor_id`),
  ADD KEY `index_value` (`score_value`),
  ADD KEY `comp_index` (`component_id`) USING BTREE,
  ADD KEY `student_index` (`student_id`),
  ADD KEY `fkasign_id` (`assignment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `assignment_questions`
--
ALTER TABLE `assignment_questions`
  MODIFY `assignment_question_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `assignment_submission_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `score_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
