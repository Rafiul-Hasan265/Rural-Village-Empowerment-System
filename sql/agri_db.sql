-- AgriLand Ecosystem - Clean Database Schema
-- MySQL / MariaDB / phpMyAdmin
-- No demo/sample records are included.

CREATE DATABASE IF NOT EXISTS `agri_db`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `agri_db`;

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `instrument_purchases`;
DROP TABLE IF EXISTS `rental_requests`;
DROP TABLE IF EXISTS `hire_requests`;
DROP TABLE IF EXISTS `farmer_profiles`;
DROP TABLE IF EXISTS `instruments`;
DROP TABLE IF EXISTS `users`;

SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','landowner','farmer','company') NOT NULL,
  `district` varchar(100) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `availability_status` enum('available','busy') NOT NULL DEFAULT 'available',
  `reset_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `farmer_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `skills` text DEFAULT NULL,
  `experience_years` int(11) NOT NULL DEFAULT 0,
  `daily_wage` decimal(10,2) NOT NULL DEFAULT 0.00,
  `bio` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `farmer_profiles_ibfk_1`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `hire_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `landowner_id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `work_date` date DEFAULT NULL,
  `work_description` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `landowner_id` (`landowner_id`),
  KEY `farmer_id` (`farmer_id`),
  CONSTRAINT `hire_requests_ibfk_1`
    FOREIGN KEY (`landowner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hire_requests_ibfk_2`
    FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `instruments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `rental_price` decimal(10,2) DEFAULT 0.00,
  `selling_price` decimal(10,2) DEFAULT 0.00,
  `availability` enum('available','out_of_stock') NOT NULL DEFAULT 'available',
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `instruments_ibfk_1`
    FOREIGN KEY (`company_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `instrument_purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instrument_id` int(11) NOT NULL,
  `landowner_id` int(11) NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `instrument_id` (`instrument_id`),
  KEY `landowner_id` (`landowner_id`),
  CONSTRAINT `instrument_purchases_ibfk_1`
    FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `instrument_purchases_ibfk_2`
    FOREIGN KEY (`landowner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rental_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instrument_id` int(11) NOT NULL,
  `landowner_id` int(11) NOT NULL,
  `rental_date` date NOT NULL,
  `status` enum('pending','approved','rejected','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `instrument_id` (`instrument_id`),
  KEY `landowner_id` (`landowner_id`),
  CONSTRAINT `rental_requests_ibfk_1`
    FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rental_requests_ibfk_2`
    FOREIGN KEY (`landowner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- The project currently uses session-based cart handling,
-- so no separate cart table is required.


-- Initial administrator account
-- Email: admin@gmail.com
-- Password: admin123
INSERT INTO users (full_name, email, password, role, district, phone, status, availability_status)
VALUES (
  'System Admin',
  'admin@gmail.com',
  '$2y$12$FKUelJGU20wUofTgPjDaZ.yVGXyhEiFCM/7XwcYKHZigO060JHQkK',
  'admin',
  'N/A',
  NULL,
  'active',
  'available'
);
