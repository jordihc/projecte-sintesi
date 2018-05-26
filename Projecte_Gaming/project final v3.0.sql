-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Temps de generació: 26-05-2018 a les 23:22:58
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
-- Estructura de la taula `comments_noticia`
--

CREATE TABLE IF NOT EXISTS `comments_noticia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_noticia` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `comment` varchar(9999) NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `comments_post`
--

CREATE TABLE IF NOT EXISTS `comments_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `comment` varchar(9999) NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `follow`
--

CREATE TABLE IF NOT EXISTS `follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_community` int(11) DEFAULT NULL,
  `followdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- Bolcant dades de la taula `follow`
--

INSERT INTO `follow` (`id`, `id_user`, `id_community`, `followdate`) VALUES
(1, 3, 1, '2018-05-26 23:07:36');

-- --------------------------------------------------------

--
-- Estructura de la taula `info_community`
--

CREATE TABLE IF NOT EXISTS `info_community` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(999) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `description` varchar(9999) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `img_avatar` varchar(999) DEFAULT 'uploads/community/avatardefault.png',
  `img_title` varchar(200) DEFAULT 'uploads/community/avatardefault.png',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- Bolcant dades de la taula `info_community`
--

INSERT INTO `info_community` (`id`, `name`, `id_admin`, `description`, `create_date`, `img_avatar`, `img_title`) VALUES
(1, 'Falcomers', 3, 'community of falcom game', '2018-05-26 23:00:00', 'uploads/community/avatardefault.png', 'uploads/community/avatardefault.png');

-- --------------------------------------------------------

--
-- Estructura de la taula `info_usuario`
--

CREATE TABLE IF NOT EXISTS `info_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(999) NOT NULL,
  `password` varchar(999) NOT NULL,
  `name` varchar(999) DEFAULT NULL,
  `email` varchar(999) DEFAULT NULL,
  `active` int(11) DEFAULT '0',
  `icona` varchar(999) DEFAULT 'uploads/usericona/avatardefault.png',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=5 ;

--
-- Bolcant dades de la taula `info_usuario`
--

INSERT INTO `info_usuario` (`id`, `user`, `password`, `name`, `email`, `active`, `icona`) VALUES
(3, 'kasutera', 'dc22e7f32c5c56975c519f23283057006b354a68c2751226f04ecb88ebb6aedd', 'Bin Liu', 'qq623433228@gmail.com', 0, 'uploads/usericona/2a35c8f18f9c3eef5679f339bfaae052.jpeg');

-- --------------------------------------------------------

--
-- Estructura de la taula `noticia`
--

CREATE TABLE IF NOT EXISTS `noticia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_community` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `title` varchar(999) DEFAULT NULL,
  `img_route` varchar(999) DEFAULT NULL,
  `img_alt` varchar(999) DEFAULT 'img of noticia',
  `message` varchar(999) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- Bolcant dades de la taula `noticia`
--

INSERT INTO `noticia` (`id`, `id_community`, `create_date`, `title`, `img_route`, `img_alt`, `message`) VALUES
(1, 1, '2018-05-26 23:06:57', 'My first gaming nocticia', 'uploads/noticiaimg/5e06a765bdc7111767dc4a1f089bf611.jpeg', 'img of noticia', ' My first gaming nocticia');

-- --------------------------------------------------------

--
-- Estructura de la taula `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `create_date` datetime DEFAULT NULL,
  `img_route` varchar(999) DEFAULT NULL,
  `messages` varchar(999) DEFAULT NULL,
  `img_alt` varchar(999) DEFAULT 'img of post',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=5 ;

--
-- Bolcant dades de la taula `post`
--

INSERT INTO `post` (`id`, `id_user`, `create_date`, `img_route`, `messages`, `img_alt`) VALUES
(4, 3, '2018-05-26 23:08:51', 'uploads/userpostimg/e310b38e528371f8f321ff3c1540e3c1.jpeg', 'My first user post', 'img of post');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
