CREATE DATABASE IF NOT EXISTS `logowanie`;
USE `logowanie`;

GRANT ALL PRIVILEGES ON `logowanie`.* TO 'root'@'%' WITH GRANT OPTION;

CREATE TABLE IF NOT EXISTS `uzytkownicy` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `user` varchar(255) NOT NULL,
    `pass` varchar(255) NOT NULL,
    `email` varchar(20),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;