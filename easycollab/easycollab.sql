-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2022 at 04:55 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easycollab`
--

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

CREATE TABLE `board` (
  `board_id` varchar(255) NOT NULL,
  `board_name` varchar(100) NOT NULL,
  `board_owner` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `board`
--

INSERT INTO `board` (`board_id`, `board_name`, `board_owner`) VALUES
('12a8599e382fe711df1cd3a43ce16984', 'welcome    a', 4),
('2ff20110445cc3e120b4550471f85e3d', 'managing stuff', 5),
('41323ac7af02bf3724c27edffff5a954', 'a', 4),
('54f1f076b8593943072e6831b0e229ca', 'test', 4),
('560b9d34b32da164d5f46ecbb4fe8033', 'finaltest', 17),
('61b701fc570a8b353fd7992018563a55', 'dafs', 5),
('867c911f70c6e4bc9f52501603d6125a', '543', 4),
('bc37d94e9b0a47cdc56f6f2cd280d18b', 'by testing 2', 5),
('e9a4afba26057b669401df7a7eb324d7', 'new', 15);

-- --------------------------------------------------------

--
-- Table structure for table `invite`
--

CREATE TABLE `invite` (
  `invite_id` int(255) NOT NULL,
  `invite_board` varchar(255) NOT NULL,
  `invite_to` varchar(255) NOT NULL,
  `invite_from` varchar(255) NOT NULL,
  `invite_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invite`
--

INSERT INTO `invite` (`invite_id`, `invite_board`, `invite_to`, `invite_from`, `invite_datetime`) VALUES
(33, '2ff20110445cc3e120b4550471f85e3d', 'testing@testing.com', 'testing2@testing2.com', '2022-11-11 11:00:33'),
(34, '61b701fc570a8b353fd7992018563a55', 'testing@testing.com', 'testing2@testing2.com', '2022-11-11 11:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(255) NOT NULL,
  `task_creator` varchar(255) NOT NULL,
  `task_editor` varchar(255) NOT NULL,
  `task_title` varchar(255) NOT NULL,
  `task_content` longtext NOT NULL,
  `task_time_modified` datetime NOT NULL,
  `board_id` varchar(255) NOT NULL,
  `task_status` varchar(255) NOT NULL,
  `task_assigned` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_creator`, `task_editor`, `task_title`, `task_content`, `task_time_modified`, `board_id`, `task_status`, `task_assigned`) VALUES
(30, 'testing', 'testing', 'fdasdfadfa', 'fdafdadfsafdsa', '2022-10-21 23:19:26', '12a8599e382fe711df1cd3a43ce16984', 'not_started', ''),
(31, 'testing', 'testing', 'assign', 'dsa', '2022-10-22 11:22:01', '12a8599e382fe711df1cd3a43ce16984', 'not_started', ''),
(35, 'testing3', 'testing', 'testing3', 'edited by: testing', '2022-10-22 21:33:22', '12a8599e382fe711df1cd3a43ce16984', 'not_started', 'testing2@testing2.com'),
(36, 'testing2', 'testing', 'fdsa', 'fdsafdsafdsa', '2022-10-27 16:29:48', 'bc37d94e9b0a47cdc56f6f2cd280d18b', 'completed', 'testing@testing.com'),
(42, 'testing', 'testing2', 'assign to testing 2', 'dafd 1111111111111111', '2022-11-01 15:40:36', '12a8599e382fe711df1cd3a43ce16984', 'not_started', ''),
(43, 'testing', 'testing', 'assigning to testing 2', 'vcxzvcxz', '2022-10-27 12:16:17', '12a8599e382fe711df1cd3a43ce16984', 'in_progress', ''),
(44, 'testing', 'testing', 'vcxzzzzz', 'vcxz', '2022-10-27 12:19:14', '12a8599e382fe711df1cd3a43ce16984', 'in_review', 'testing2@testing2.com'),
(45, 'testing', 'testing', 'zzz', 'zzz', '2022-10-27 12:22:06', '12a8599e382fe711df1cd3a43ce16984', 'in_progress', ''),
(46, 'testing2', 'testing2', 'made by testing 2', 'lkjhlkjh', '2022-10-27 12:29:12', '12a8599e382fe711df1cd3a43ce16984', 'completed', 'testing3@testing3.com'),
(47, 'testing2', 'testing2', 'testing sessions', 'lhlkh', '2022-10-27 12:38:38', '12a8599e382fe711df1cd3a43ce16984', 'in_review', ''),
(48, 'testing2', 'testing2', 'session', 'lkjlkjkl', '2022-10-27 12:40:47', '12a8599e382fe711df1cd3a43ce16984', 'completed', ''),
(49, 'testing2', 'testing2', 'xxxxxxxxxxxx', 'xxxx', '2022-10-27 13:33:19', '12a8599e382fe711df1cd3a43ce16984', 'in_review', 'testing2@testing2.com'),
(54, 'testing', 'testing2', '10', '456', '2022-10-28 23:44:24', '12a8599e382fe711df1cd3a43ce16984', 'not_started', 'testing2@testing2.com'),
(58, 'testing', 'testing', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '', '2022-11-10 12:39:20', '12a8599e382fe711df1cd3a43ce16984', 'not_started', ''),
(59, 'testing', 'testing', 'dsa    d', '', '2022-11-10 12:43:21', '12a8599e382fe711df1cd3a43ce16984', 'not_started', 'testing2@testing2.com'),
(61, 'testing', 'testing', 'fdsa', 'fdsa', '2022-11-11 16:29:57', '12a8599e382fe711df1cd3a43ce16984', 'not_started', ''),
(62, 'testing', 'testing', 'fdsafdsafdsa', 'fdsafdsa', '2022-11-11 16:30:00', '12a8599e382fe711df1cd3a43ce16984', 'not_started', ''),
(63, 'testing', 'testing', 'fdasfdsa', 'afdsdfsadfsa', '2022-11-11 16:30:04', '12a8599e382fe711df1cd3a43ce16984', 'not_started', ''),
(64, 'testing', 'testing', 'fdsafdsa', 'dasfdsfasdfa', '2022-11-11 16:30:06', '12a8599e382fe711df1cd3a43ce16984', 'not_started', ''),
(65, 'testing', 'testing', 'adfsdfasdsfa', 'afsdsadfsadfsadf', '2022-11-11 16:30:09', '12a8599e382fe711df1cd3a43ce16984', 'not_started', ''),
(66, 'testing', 'testing', '321312231', '123213231', '2022-11-11 16:30:15', '12a8599e382fe711df1cd3a43ce16984', 'not_started', ''),
(67, 'testing', 'testing', '32132231231', '321123321', '2022-11-11 16:30:21', '12a8599e382fe711df1cd3a43ce16984', 'not_started', ''),
(68, 'new', 'new', 'new', 'new', '2022-11-11 16:40:38', 'e9a4afba26057b669401df7a7eb324d7', 'in_progress', 'new2@new2.com'),
(69, 'finaltest', 'finaltest', 'finaltest/.,', 'finaltest\r\n', '2022-11-11 23:46:50', '560b9d34b32da164d5f46ecbb4fe8033', 'not_started', ''),
(70, 'finaltest', 'finaltest2', '321!#@!', 'do these in steps:\r\n\r\n1. 1\r\n2. 2\r\n3. 3', '2022-11-11 23:50:36', '560b9d34b32da164d5f46ecbb4fe8033', 'not_started', 'finaltest2@finaltest2.com'),
(71, 'finaltest2', 'finaltest2', 'made by finaltest2', 'alsjsdlkjh$!#%@#$^/.,/.,/.,./,', '2022-11-11 23:48:36', '560b9d34b32da164d5f46ecbb4fe8033', 'in_progress', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES
(2, 'dsa', 'fds@dsa', 'dsa'),
(4, 'testing', 'testing@testing.com', 'testing'),
(5, 'testing2', 'testing2@testing2.com', 'testing2'),
(6, 'testing3', 'testing3@testing3.com', 'testing3'),
(8, 'testing4', 'testing4@testing4.com', 'testing4'),
(9, 'testing5', 'testing5@testing5.com', 'testing5'),
(10, 'testing6', 'testing6@testing6.com', 'testing6'),
(11, 'hello', 'hello@hello.com', ',./'),
(12, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '321@321', '1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111'),
(13, '/.,/.,', 'dsa@dsa', '/.,/.,'),
(14, 'testing10', 'testing10@testing10.com', 'testing10'),
(15, 'new', 'new@new.com', 'new'),
(16, 'new2', 'new2@new2.com', 'new2'),
(17, 'finaltest', 'finaltest@finaltest.com', 'finaltest'),
(18, 'finaltest2', 'finaltest2@finaltest2.com', 'finaltest2');

-- --------------------------------------------------------

--
-- Table structure for table `users_board`
--

CREATE TABLE `users_board` (
  `id` int(11) NOT NULL,
  `user_id` int(255) NOT NULL,
  `board_id` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_board`
--

INSERT INTO `users_board` (`id`, `user_id`, `board_id`, `user_email`) VALUES
(4, 5, '12a8599e382fe711df1cd3a43ce16984', 'testing2@testing2.com'),
(6, 4, 'bc37d94e9b0a47cdc56f6f2cd280d18b', 'testing@testing.com'),
(15, 5, '867c911f70c6e4bc9f52501603d6125a', 'testing2@testing2.com'),
(22, 16, 'e9a4afba26057b669401df7a7eb324d7', 'new2@new2.com'),
(23, 6, '12a8599e382fe711df1cd3a43ce16984', 'testing3@testing3.com'),
(24, 18, '560b9d34b32da164d5f46ecbb4fe8033', 'finaltest2@finaltest2.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`board_id`),
  ADD KEY `board_owner` (`board_owner`);

--
-- Indexes for table `invite`
--
ALTER TABLE `invite`
  ADD PRIMARY KEY (`invite_id`),
  ADD KEY `invite_board` (`invite_board`),
  ADD KEY `invite_to` (`invite_to`),
  ADD KEY `invite_from` (`invite_from`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `task_creator` (`task_creator`),
  ADD KEY `task_editor` (`task_editor`),
  ADD KEY `board_id` (`board_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `users_board`
--
ALTER TABLE `users_board`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `board_id` (`board_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invite`
--
ALTER TABLE `invite`
  MODIFY `invite_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users_board`
--
ALTER TABLE `users_board`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
