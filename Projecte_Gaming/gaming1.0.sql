-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Temps de generació: 17-04-2018 a les 14:31:52
-- Versió del servidor: 5.5.59-0ubuntu0.14.04.1
-- Versió de PHP: 5.5.9-1ubuntu4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de dades: `gaming`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `groupchat`
--

CREATE TABLE IF NOT EXISTS `groupchat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `missage` varchar(9999) NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_group` (`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `group_list`
--

CREATE TABLE IF NOT EXISTS `group_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `join_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_group` (`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `info_community`
--

CREATE TABLE IF NOT EXISTS `info_community` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `description` varchar(999) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `game_id` (`game_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `info_game`
--

CREATE TABLE IF NOT EXISTS `info_game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `description` int(11) NOT NULL,
  `type` varchar(99) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `info_group`
--

CREATE TABLE IF NOT EXISTS `info_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(999) CHARACTER SET utf8mb4 NOT NULL,
  `name` varchar(99) CHARACTER SET utf8mb4 NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `info_usuario`
--

CREATE TABLE IF NOT EXISTS `info_usuario` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `user` varchar(99) CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(99) CHARACTER SET utf8mb4 NOT NULL,
  `name` varchar(99) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(99) CHARACTER SET utf8mb4 NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `img_route` varchar(999) CHARACTER SET utf8mb4 NOT NULL,
  `video_route` varchar(999) CHARACTER SET utf8mb4 NOT NULL,
  `missage` varchar(999) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `userchat`
--

CREATE TABLE IF NOT EXISTS `userchat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_e` int(11) NOT NULL,
  `id_user_r` int(11) NOT NULL,
  `missage` varchar(999) CHARACTER SET utf8mb4 NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_e` (`id_user_e`),
  KEY `id_user_e_2` (`id_user_e`),
  KEY `id_user_e_3` (`id_user_e`),
  KEY `id_user_r` (`id_user_r`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Restriccions per taules bolcades
--

--
-- Restriccions per la taula `groupchat`
--
ALTER TABLE `groupchat`
  ADD CONSTRAINT `group_chat` FOREIGN KEY (`id_group`) REFERENCES `info_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_chat` FOREIGN KEY (`id_user`) REFERENCES `info_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriccions per la taula `group_list`
--
ALTER TABLE `group_list`
  ADD CONSTRAINT `member_groups` FOREIGN KEY (`id_group`) REFERENCES `info_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_users` FOREIGN KEY (`id_user`) REFERENCES `info_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriccions per la taula `info_community`
--
ALTER TABLE `info_community`
  ADD CONSTRAINT `admin_user` FOREIGN KEY (`admin_id`) REFERENCES `info_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `game_community` FOREIGN KEY (`game_id`) REFERENCES `info_game` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriccions per la taula `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `user_post` FOREIGN KEY (`id_user`) REFERENCES `info_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriccions per la taula `userchat`
--
ALTER TABLE `userchat`
  ADD CONSTRAINT `user_receive` FOREIGN KEY (`id_user_r`) REFERENCES `info_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_send` FOREIGN KEY (`id_user_e`) REFERENCES `info_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
