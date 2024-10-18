CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'employee') NOT NULL
);

INSERT INTO users (username, password, role) VALUES ('Dean', MD5('123'), 'user');
INSERT INTO users (username, password, role) VALUES ('Bryx', MD5('123'), 'employee');
