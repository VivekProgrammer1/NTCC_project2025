CREATE DATABASE IF NOT EXISTS lost_found;
USE lost_found;

-- ----------------------------
-- Users Table
-- ----------------------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ----------------------------
-- Lost Items Table
-- ----------------------------
CREATE TABLE lost_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    item_name VARCHAR(200),
    description TEXT,
    location VARCHAR(200),
    date_lost DATE,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- ----------------------------
-- Found Items Table
-- ----------------------------
CREATE TABLE found_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    item_name VARCHAR(200),
    description TEXT,
    location VARCHAR(200),
    date_found DATE,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);