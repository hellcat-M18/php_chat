CREATE DATABASE users;
USE users;
CREATE TABLE info(
    name CHAR(30) NOT NULL
    password CHAR(255) NOT NULL
);
CREATE DATABASE chat;
USE chat;
CREATE TABLE log(
    id DECIMAL(10,0) NOT NULL
    author CHAR(30) NOT NULL
    content CHAR(255) NOT NULL
    time DATETIME NOT NULL
);
