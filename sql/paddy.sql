-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2020 at 09:11 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paddy`
--
CREATE DATABASE IF NOT EXISTS `paddy` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `paddy`;

-- --------------------------------------------------------

--
-- Table structure for table `grouppairing`
--

CREATE TABLE `grouppairing` (
  `group_id` int(5) NOT NULL,
  `group_session_id` int(5) NOT NULL,
  `group_user1` int(5) NOT NULL,
  `group_user2` int(5) NOT NULL,
  `group_user3` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `recentpairings`
--

CREATE TABLE `recentpairings` (
  `pair_id` int(5) NOT NULL,
  `pair_user_id` int(5) NOT NULL,
  `pair_partner_id` int(5) NOT NULL,
  `pair_timestamp` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `session_id` int(5) NOT NULL,
  `session_start_time` time NOT NULL,
  `session_size` int(3) NOT NULL,
  `session_date` date NOT NULL,
  `session_name` varchar(128) NOT NULL DEFAULT 'Session'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`session_id`, `session_start_time`, `session_size`, `session_date`, `session_name`) VALUES
(2, '08:30:00', 50, '1992-03-24', 'Session'),
(3, '10:02:00', 50, '2020-04-12', 'Session'),
(4, '20:00:00', 50, '2020-10-10', 'Session');

-- --------------------------------------------------------

--
-- Table structure for table `sessionparticipants`
--

CREATE TABLE `sessionparticipants` (
  `participant_id` int(5) NOT NULL,
  `participant_session_id` int(5) NOT NULL,
  `participant_user_id` int(5) NOT NULL,
  `pair_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sessionparticipants`
--

INSERT INTO `sessionparticipants` (`participant_id`, `participant_session_id`, `participant_user_id`, `pair_id`) VALUES
(1, 4, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

CREATE TABLE `useraccount` (
  `user_id` int(5) NOT NULL,
  `user_name` varchar(32) NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `user_password` varchar(128) NOT NULL,
  `user_japanese_skill` int(1) NOT NULL,
  `user_english_skill` int(1) NOT NULL,
  `user_profile_picture_unimplemented` varchar(256) NOT NULL,
  `user_custom_description` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `useraccount`
--

INSERT INTO `useraccount` (`user_id`, `user_name`, `user_email`, `user_password`, `user_japanese_skill`, `user_english_skill`, `user_profile_picture_unimplemented`, `user_custom_description`) VALUES
(1, 'Organiser', 'Primary@Email.Com', '$2y$10$yYyowL856qxHBWwAt8/1yOB3Au66boJykrm4DIrODYY8ZDGcG0wte', 0, 3, '', ''),
(2, 'TheBestAccount', 'newEmail@MonkeyFoot.com', '$2y$10$dDtZvuliNDesp4F4cBFGM.xtiO.icOUwZd8jeTHRY5P6TF4fXYa8q', 0, 3, 'TheBestAccount.5f8bc902246b67.24023048.png', ''),
(3, 'Andrew', 'Burgo361@hotmail.com', '$2y$10$dGPOD27EEBU3eSl198SmsudFtupVxkakzt9OWqxa20pJ.4.FwjPO2', 0, 3, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `userquery`
--

CREATE TABLE `userquery` (
  `query_id` int(5) NOT NULL,
  `query_user_id` int(5) NOT NULL,
  `query_header` varchar(32) NOT NULL,
  `query_body` varchar(128) NOT NULL,
  `query_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userquery`
--

INSERT INTO `userquery` (`query_id`, `query_user_id`, `query_header`, `query_body`, `query_date`) VALUES
(1, 2, 'Pairing', 'Why don\'t I have friend', '2020-10-18 00:00:00'),
(2, 2, 'Technical Issue', 'I don\'t have a computer', '2020-10-18 16:04:00'),
(3, 2, 'Pairing', 'Why don\'t I have friend', '2020-10-18 16:06:54'),
(4, 2, 'Pairing', 'Why don\'t I have friend', '2020-10-18 16:07:09');

-- --------------------------------------------------------

--
-- Table structure for table `usersettings`
--

CREATE TABLE `usersettings` (
  `user_id_settings` int(5) NOT NULL,
  `user_settings_user_id` int(5) NOT NULL,
  `isOrganiser` tinyint(1) NOT NULL,
  `user_is_dummy` tinyint(1) NOT NULL,
  `user_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usersettings`
--

INSERT INTO `usersettings` (`user_id_settings`, `user_settings_user_id`, `isOrganiser`, `user_is_dummy`, `user_created`) VALUES
(1, 1, 1, 0, '2020-10-21'),
(2, 2, 1, 0, '2020-10-21'),
(3, 3, 0, 0, '2020-10-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grouppairing`
--
ALTER TABLE `grouppairing`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `group_session_id` (`group_session_id`),
  ADD KEY `group_user1` (`group_user1`),
  ADD KEY `group_user2` (`group_user2`),
  ADD KEY `group_user3` (`group_user3`);

--
-- Indexes for table `recentpairings`
--
ALTER TABLE `recentpairings`
  ADD PRIMARY KEY (`pair_id`),
  ADD KEY `pair_user_id` (`pair_user_id`),
  ADD KEY `pair_partner_id` (`pair_partner_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `sessionparticipants`
--
ALTER TABLE `sessionparticipants`
  ADD PRIMARY KEY (`participant_id`),
  ADD KEY `participant_user_id` (`participant_user_id`),
  ADD KEY `sessionID` (`participant_session_id`);

--
-- Indexes for table `useraccount`
--
ALTER TABLE `useraccount`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `userquery`
--
ALTER TABLE `userquery`
  ADD PRIMARY KEY (`query_id`),
  ADD KEY `query_user_id` (`query_user_id`);

--
-- Indexes for table `usersettings`
--
ALTER TABLE `usersettings`
  ADD PRIMARY KEY (`user_id_settings`),
  ADD KEY `user_settings_for` (`user_settings_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grouppairing`
--
ALTER TABLE `grouppairing`
  MODIFY `group_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recentpairings`
--
ALTER TABLE `recentpairings`
  MODIFY `pair_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `session_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sessionparticipants`
--
ALTER TABLE `sessionparticipants`
  MODIFY `participant_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `useraccount`
--
ALTER TABLE `useraccount`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `userquery`
--
ALTER TABLE `userquery`
  MODIFY `query_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usersettings`
--
ALTER TABLE `usersettings`
  MODIFY `user_id_settings` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grouppairing`
--
ALTER TABLE `grouppairing`
  ADD CONSTRAINT `grouppairing_ibfk_1` FOREIGN KEY (`group_session_id`) REFERENCES `session` (`session_id`),
  ADD CONSTRAINT `grouppairing_ibfk_2` FOREIGN KEY (`group_user1`) REFERENCES `useraccount` (`user_id`),
  ADD CONSTRAINT `grouppairing_ibfk_3` FOREIGN KEY (`group_user2`) REFERENCES `useraccount` (`user_id`),
  ADD CONSTRAINT `grouppairing_ibfk_4` FOREIGN KEY (`group_user3`) REFERENCES `useraccount` (`user_id`);

--
-- Constraints for table `recentpairings`
--
ALTER TABLE `recentpairings`
  ADD CONSTRAINT `recentpairings_ibfk_1` FOREIGN KEY (`pair_user_id`) REFERENCES `useraccount` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `recentpairings_ibfk_2` FOREIGN KEY (`pair_partner_id`) REFERENCES `useraccount` (`user_id`);

--
-- Constraints for table `sessionparticipants`
--
ALTER TABLE `sessionparticipants`
  ADD CONSTRAINT `sessionID` FOREIGN KEY (`participant_session_id`) REFERENCES `session` (`session_id`),
  ADD CONSTRAINT `sessionparticipants_ibfk_1` FOREIGN KEY (`participant_user_id`) REFERENCES `useraccount` (`user_id`);

--
-- Constraints for table `userquery`
--
ALTER TABLE `userquery`
  ADD CONSTRAINT `userquery_ibfk_1` FOREIGN KEY (`query_user_id`) REFERENCES `useraccount` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `usersettings`
--
ALTER TABLE `usersettings`
  ADD CONSTRAINT `usersettings_ibfk_1` FOREIGN KEY (`user_settings_user_id`) REFERENCES `useraccount` (`user_id`) ON UPDATE CASCADE;
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
