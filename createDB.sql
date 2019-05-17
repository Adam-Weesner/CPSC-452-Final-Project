DROP database IF EXISTS chat;
CREATE database chat;
use chat;

create table IF NOT EXISTS users (
    id INT AUTO_INCREMENT NOT NULL,
    username VARCHAR(255) NOT NULL,
    firstName VARCHAR(255),
    lastName VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    setUpDate VARCHAR(255),
    PRIMARY KEY (id)
);
