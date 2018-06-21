-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 21-Ago-2017 às 01:56
-- Versão do servidor: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs_social`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `comments`
--

CREATE TABLE `comments` (
  `id` int(12) NOT NULL,
  `text` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(12) NOT NULL,
  `post_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `comments`
--

INSERT INTO `comments` (`id`, `text`, `image`, `created`, `user_id`, `post_id`) VALUES
(1, 'just testing', NULL, '2017-08-19 01:12:12', 1, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorites`
--

CREATE TABLE `favorites` (
  `user_id` int(12) NOT NULL,
  `post_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `favorites`
--

INSERT INTO `favorites` (`user_id`, `post_id`) VALUES
(10, 7),
(10, 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `posts`
--

CREATE TABLE `posts` (
  `id` int(12) NOT NULL,
  `text` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `posts`
--

INSERT INTO `posts` (`id`, `text`, `image`, `created`, `user_id`) VALUES
(1, 'Testing the post from User 1', NULL, '2017-08-18 13:10:43', 1),
(2, 'Testing the post from User 2. Lorem Isp', NULL, '2017-08-18 13:11:08', 2),
(3, 'User 3. Lorem Isp', NULL, '2017-08-18 13:11:26', 3),
(4, 'just testing the new function with image', 'posts/Screen_Shot_2017-08-17_at_30300_PM.png', '2017-08-20 18:34:04', 11),
(7, 'let''s teste a new post', NULL, '2017-08-20 18:41:52', 11),
(8, 'test a post with an image', NULL, '2017-08-20 18:47:33', 10),
(9, 'one more, come on', 'posts/Screen_Shot_2017-07-30_at_42413_PM.png', '2017-08-20 18:50:24', 10),
(15, 'zulu', NULL, '2017-08-21 01:21:27', 1),
(16, 'post 3\r\n', NULL, '2017-08-21 01:22:00', 1),
(17, 'more for pagination', NULL, '2017-08-21 01:22:07', 1),
(18, 'a few more', NULL, '2017-08-21 01:22:14', 1),
(19, 'huhhuuuuu', NULL, '2017-08-21 01:22:45', 10),
(21, 'huhhuu', 'posts/the_yellow_booklet-2_1503300256.jpg', '2017-08-21 01:24:16', 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `f_name`, `l_name`, `email`, `password`, `avatar`, `created`) VALUES
(1, 'Paulo', 'Andrade', 'martinsp@uregina.ca', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2017-08-18 12:28:14'),
(2, 'Jhon', 'Snow', 'js@got.ca', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2017-08-18 13:09:09'),
(3, 'Jack', 'Bauer', 'jb@uregina.ca', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2017-08-18 13:09:32'),
(10, 'Paulo R', 'Andrade', 'paulo85br@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'users/The_Yellow_Booklet-2.jpg', '2017-08-20 16:33:03'),
(11, 'Jey', 'Low', 'jl@uregina.ca', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2017-08-20 18:16:59'),
(12, 'CS', '215', 'test@test.com', 'e10adc3949ba59abbe56e057f20f883e', 'NULL', '2017-08-21 01:55:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_post` (`post_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `fk_post_fav` (`post_id`),
  ADD KEY `fk_user_fav` (`user_id`) USING BTREE;

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `text` (`text`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `fk_post_fav` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_fav` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
