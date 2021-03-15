DROP DATABASE topsecurity;

REVOKE ALL PRIVILEGES ON topsecurity.* FROM dba;
REVOKE ALL PRIVILEGES ON topsecurity.* FROM topsecurity;

DROP USER 'dba'@'localhost';
DROP USER 'topsecurity'@'localhost';
DROP USER 'topsecurity'@'%';
