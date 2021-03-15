CREATE DATABASE topsecurity;
USE topsecurity;

CREATE TABLE IF NOT EXISTS `commentaires` (
    `commentaire_id` int(11) NOT NULL AUTO_INCREMENT,
    `pseudo` varchar(250) NOT NULL,
    `commentaire` varchar(2000) NOT NULL,
    `date_commentaire` int(11) NOT NULL,
PRIMARY KEY (`commentaire_id`),
KEY `date_commentaire` (`date_commentaire`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `messages` (
    `message_id` int(11) NOT NULL AUTO_INCREMENT,
    `email_to` varchar(250) NOT NULL,
    `sujet` varchar(250) NOT NULL,
    `message` varchar(2000) NOT NULL,
    `headers` varchar(2000),
PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `utilisateurs` (
    `utilisateur_id` int(11) NOT NULL AUTO_INCREMENT,
    `usr_email` varchar(250) NOT NULL,
    `usr_pwd` varchar(250) NOT NULL,
    `usr_type` varchar(5) NOT NULL,
PRIMARY KEY (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

INSERT INTO commentaires(`pseudo`, `commentaire`, `date_commentaire`) VALUES("fabrice1618", CONCAT( 'I was here', "<script>alert('Hello XSS')</script>"), 0);

INSERT INTO messages(`email_to`, `sujet`, `message`) VALUES("fabrice1618@gmail.com", 'top security started', 'application top security started');

INSERT INTO utilisateurs(`usr_email`, `usr_pwd`, `usr_type`) VALUES("admin@example.com", "AWK", "admin");
INSERT INTO utilisateurs(`usr_email`, `usr_pwd`, `usr_type`) VALUES("user@example.com", "CAT", "user");

CREATE USER 'dba'@'localhost' IDENTIFIED BY 'pwd_dba';
GRANT ALL PRIVILEGES ON topsecurity.* TO 'dba'@'localhost' WITH GRANT OPTION;;

CREATE USER 'topsecurity'@'localhost' IDENTIFIED BY 'pwd_topsecurity';
GRANT SELECT,INSERT,UPDATE,DELETE ON topsecurity.* TO 'topsecurity'@'localhost';

CREATE USER 'topsecurity'@'%' IDENTIFIED BY 'pwd_topsecurity';
GRANT SELECT,INSERT,UPDATE,DELETE ON topsecurity.* TO 'topsecurity'@'%';

FLUSH PRIVILEGES;

SHOW databases;
USE topsecurity;
SHOW tables;
DESC commentaires;
DESC messages;
DESC utilisateurs;
SELECT * FROM utilisateurs;

SELECT user, host FROM mysql.user ORDER BY user;
SELECT user, host FROM mysql.user WHERE user NOT LIKE 'mysql%';

SHOW GRANTS FOR 'dba'@'localhost';
SHOW GRANTS FOR 'topsecurity'@'localhost';
SHOW GRANTS FOR 'topsecurity'@'%';