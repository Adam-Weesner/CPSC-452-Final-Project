DROP DATABASE IF EXISTS chat;
CREATE DATABASE IF NOT EXISTS chat;

USE chat;

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT UNIQUE,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    status VARCHAR(255) default 'Offline',
    PRIMARY KEY (id)
);

INSERT INTO users (username, password) VALUES ("klaviam", "testing");
INSERT INTO users (username, password) VALUES ("battlegun", "testing");
INSERT INTO users (username, password) VALUES ("tester", "testing");
INSERT INTO users (username, password) VALUES ("adam", "testing");
INSERT INTO users (username, password) VALUES ("dog", "testing");
