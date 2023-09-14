CREATE DATABASE showplace;

CREATE TABLE showplace (
                         id INT NOT NULL AUTO_INCREMENT,
                         name VARCHAR(128) NOT NULL,
                         distance INT NOT NULL DEFAULT 0,
                         is_available BOOLEAN NOT NULL DEFAULT FALSE,
                         PRIMARY KEY (id)
);