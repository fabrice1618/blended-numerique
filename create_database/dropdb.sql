DROP DATABASE blended;

REVOKE ALL PRIVILEGES ON blended.* FROM dba;
REVOKE ALL PRIVILEGES ON blended.* FROM blended;

DROP USER 'dba'@'localhost';
DROP USER 'blended'@'localhost';
DROP USER 'blended'@'%';
