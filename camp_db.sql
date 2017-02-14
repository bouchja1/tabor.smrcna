CREATE TABLE IF NOT EXISTS `current_year_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `year` int(255) NOT NULL,
  `text` longtext COLLATE utf8_czech_ci NOT NULL,
  `poster` varchar(500) COLLATE utf8_czech_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `current_year_info` (`id`, `year`, `text`, `poster`, `active`) VALUES
(1, 0, 'blahblah', 'poster.png', 1);

CREATE TABLE IF NOT EXISTS `email_receivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `email` varchar(255) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `email_receivers` (`id`, `email`) VALUES
(10, 'yourmail@something.com');

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `year` int(11) NOT NULL,
  `title` text COLLATE cp1250_czech_cs NOT NULL,
  `text` text COLLATE cp1250_czech_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1250 COLLATE=cp1250_czech_cs;

INSERT INTO `history` (`id`, `year`, `title`, `text`) VALUES
(18, 2016, 'Our super camp', '<p>Something</p>');

CREATE TABLE IF NOT EXISTS `history_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(256) COLLATE utf8_czech_ci NOT NULL,
  `history_year_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `text_about` longtext COLLATE utf8_czech_ci NOT NULL,
  `text_surroundings` longtext COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `location` (`id`, `text_about`, `text_surroundings`) VALUES
(1, 'blah', 'blah blah');

CREATE TABLE IF NOT EXISTS `location_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `location_type` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE IF NOT EXISTS `mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `email` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `message` longtext COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` text CHARACTER SET utf8 NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `text` text CHARACTER SET utf8 NOT NULL,
  `youtube_video` longtext CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=cp1250 COLLATE=cp1250_czech_cs;

INSERT INTO `news` (`id`, `title`, `datetime`, `text`, `youtube_video`) VALUES
(1, 'Title', '2013-07-14 22:00:00', 'Something', NULL);

CREATE TABLE IF NOT EXISTS `news_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(256) COLLATE utf8_czech_ci NOT NULL,
  `news_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE IF NOT EXISTS `salt` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `salt` varchar(255) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `salt` (`id`, `salt`) VALUES
(1, 'something_really_secret');

CREATE TABLE IF NOT EXISTS `securityAction` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `action` varchar(255) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `securityAction` (`id`, `username`, `password`, `action`) VALUES
(1, 'administrator', 'cGFzc3NvbWV0aGluZ19yZWFsbHlfc2VjcmV0', 'admin');

CREATE TABLE IF NOT EXISTS `warnings` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `text` varchar(500) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `warnings` (`id`, `title`, `text`) VALUES
(8, 'Hey!', 'blah');

ALTER TABLE `history_photos`
  ADD KEY `history_year_id` (`history_year_id`);


ALTER TABLE `news_photos`
  ADD KEY `news_id` (`news_id`);

ALTER TABLE `history_photos`
  ADD CONSTRAINT `history_photos_ibfk_1` FOREIGN KEY (`history_year_id`) REFERENCES `history` (`id`);

ALTER TABLE `news_photos`
  ADD CONSTRAINT `news_photos_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`);