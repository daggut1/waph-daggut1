-- database-data.sql
USE waph;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    username VARCHAR(50) PRIMARY KEY,
    password CHAR(32) NOT NULL    -- MD5 hash length
);

-- change the plaintext password below to whatever you want
INSERT INTO users(username, password)
VALUES ('daggut1', MD5('Thanooj@2621'));

