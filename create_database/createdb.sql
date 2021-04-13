SELECT "Création de la base de données" FROM dual;
CREATE DATABASE blended;
USE blended;

CREATE TABLE IF NOT EXISTS contacts(
   contact_id int(11) NOT NULL AUTO_INCREMENT,
   date_contact DATETIME NOT NULL,
   email VARCHAR(250) NOT NULL,
   nom VARCHAR(250) NOT NULL,
   prenom VARCHAR(250) NOT NULL,
   telephone VARCHAR(250),
   adresse VARCHAR(250),
   code_postal VARCHAR(250),
   ville VARCHAR(250),
   contact_message VARCHAR(4096),
   CONSTRAINT PK_contacts PRIMARY KEY(contact_id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS formations(
   formation_id int(11) NOT NULL AUTO_INCREMENT,
   formation VARCHAR(250) NOT NULL,
   form_active varchar(6) NOT NULL,
   CONSTRAINT PK_formations PRIMARY KEY(formation_id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS motifs(
   motif_id int(11) NOT NULL AUTO_INCREMENT,
   motif VARCHAR(250) NOT NULL,
   motif_active varchar(6) NOT NULL,
   CONSTRAINT PK_motifs PRIMARY KEY(motif_id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS contact_formations(
   contact_id int(11),
   formation_id int(11),
   CONSTRAINT PK_contact_formations PRIMARY KEY(contact_id, formation_id),
   CONSTRAINT FK_contact_formations_contacts FOREIGN KEY(contact_id) REFERENCES contacts(contact_id),
   CONSTRAINT FK_contact_formations_formations FOREIGN KEY(formation_id) REFERENCES formations(formation_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS contact_motifs(
   contact_id int(11),
   motif_id int(11),
   CONSTRAINT PK_contact_motifs PRIMARY KEY(contact_id, motif_id),
   CONSTRAINT FK_contact_motifs_contacts FOREIGN KEY(contact_id) REFERENCES contacts(contact_id),
   CONSTRAINT FK_contact_motifs_motifs FOREIGN KEY(motif_id) REFERENCES motifs(motif_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
    `usr_pwd` varchar(250),
    `usr_nom` varchar(250),
    `usr_prenom` varchar(250),
    `usr_type` varchar(5),
    `usr_active` varchar(8),
PRIMARY KEY (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE UNIQUE INDEX u_usr_email ON utilisateurs (usr_email);
 
SELECT "Insertion de données" FROM dual;
INSERT INTO messages(`email_to`, `sujet`, `message`) VALUES("fabrice1618@gmail.com", 'blended started', 'application blended started');

INSERT INTO utilisateurs(`usr_email`, `usr_pwd`, `usr_nom`, `usr_prenom`, `usr_type`, `usr_active`) VALUES("admin@mips.science", "AWK", "Administrateur", "Demo", "admin", "active");
INSERT INTO utilisateurs(`usr_email`, `usr_pwd`, `usr_nom`, `usr_prenom`, `usr_type`, `usr_active`) VALUES("user@mips.science", "CAT", "Utilisateur", "Demo", "user", "active");

SELECT "Création des utilisateurs" FROM dual;
CREATE USER 'dba'@'localhost' IDENTIFIED BY 'pwd_dba';
GRANT ALL PRIVILEGES ON blended.* TO 'dba'@'localhost' WITH GRANT OPTION;

CREATE USER 'blended'@'localhost' IDENTIFIED BY 'pwd_blended';
GRANT SELECT,INSERT,UPDATE,DELETE ON blended.* TO 'blended'@'localhost';

CREATE USER 'blended'@'%' IDENTIFIED BY 'pwd_blended';
GRANT SELECT,INSERT,UPDATE,DELETE ON blended.* TO 'blended'@'%';

FLUSH PRIVILEGES;

SELECT "Vérification des résultats" FROM dual;
SHOW databases;
USE blended;
SHOW tables;
DESC contacts;
DESC formations;
DESC motifs;
DESC contact_formations;
DESC contact_motifs;
DESC messages;
DESC utilisateurs;
SELECT * FROM utilisateurs;

SELECT user, host FROM mysql.user ORDER BY user;
SELECT user, host FROM mysql.user WHERE user NOT LIKE 'mysql%';

SHOW GRANTS FOR 'dba'@'localhost';
SHOW GRANTS FOR 'blended'@'localhost';
SHOW GRANTS FOR 'blended'@'%';
