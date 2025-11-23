-- dump_mysql.sql
CREATE DATABASE IF NOT EXISTS xor_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE xor_db;

DROP TABLE IF EXISTS messages;
CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) DEFAULT 'Anonymous',
  encrypted_text TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
