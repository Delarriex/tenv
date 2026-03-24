-- Tenvault Full Database Schema
-- Last Updated: 2026-03-23

CREATE DATABASE IF NOT EXISTS tenvault;
USE tenvault;

-- 1. Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    balance DECIMAL(15, 2) DEFAULT 0.00,
    profit DECIMAL(15, 2) DEFAULT 0.00,
    plan VARCHAR(50) DEFAULT 'Starter Plan',
    role ENUM('user', 'admin') DEFAULT 'user',
    is_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. Investments (Trading Plans) Table
CREATE TABLE IF NOT EXISTS investments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    plan_name VARCHAR(50),
    amount DECIMAL(15, 2),
    roi_percentage DECIMAL(5, 2) DEFAULT 1.00,
    duration_hours INT DEFAULT 24,
    status ENUM('active', 'completed', 'pending') DEFAULT 'active',
    end_date TIMESTAMP NULL,
    last_profit_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 3. Transactions (Deposits, Withdrawals, Transfers) Table
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('deposit', 'withdrawal', 'profit', 'investment') NOT NULL,
    amount DECIMAL(15, 2) NOT NULL,
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    method VARCHAR(50), -- e.g., 'Bitcoin', 'Ethereum', 'Internal'
    reference_id VARCHAR(100), -- Transaction Hash or Plan Name
    proof_image VARCHAR(255), -- Path to uploaded screenshot
    wallet_address VARCHAR(255), -- User's withdrawal wallet or Admin's deposit wallet
    admin_note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 4. KYC (Identity Verification) Table
CREATE TABLE IF NOT EXISTS kyc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    document_type VARCHAR(50), -- e.g., 'Passport', 'ID Card'
    document_front VARCHAR(255),
    document_back VARCHAR(255),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    admin_note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 5. Portfolio (Stock Holdings) Table
CREATE TABLE IF NOT EXISTS portfolio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    symbol VARCHAR(10) NOT NULL, -- e.g., 'AAPL', 'TSLA'
    shares DECIMAL(15, 6) NOT NULL,
    avg_price DECIMAL(15, 4) NOT NULL,
    purchased_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY user_symbol (user_id, symbol)
);

-- Admin User Seed (Optional/Reference)
-- INSERT INTO users (username, email, password, role, is_verified) VALUES ('admin', 'admin@tenvault.com', '$2y$10$YourHashedPassword', 'admin', 1);
