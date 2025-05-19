-- Create the database
CREATE DATABASE IF NOT EXISTS hospital_db;
USE hospital_db;

-- Drop tables if they exist (for clean reset)
DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS doctors;
DROP TABLE IF EXISTS users;

-- Users Table (admin + normal users)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user', 'admin') DEFAULT 'user'
);

-- Doctors Table
CREATE TABLE doctors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  specialty VARCHAR(100) NOT NULL,
  contact VARCHAR(100)
);

-- Appointments Table
CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  doctor_id INT NOT NULL,
  appointment_date DATE NOT NULL,
  status ENUM('Pending', 'Confirmed') DEFAULT 'Pending',
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
);

-- Insert default admin user
-- Password: admin123
INSERT INTO users (name, email, password, role) VALUES (
  'Admin',
  'admin@hospital.com',
  '$2y$10$3Zp7EpkxVzlvAFn8PjAnE.qzvOP9eMfGfPLNBi8kjoRY9RDO5bN/q', -- hashed "admin123"
  'admin'
);

-- Insert sample doctors
INSERT INTO doctors (name, specialty, contact) VALUES
('Dr. James Smith', 'Cardiology', '555-111-2222'),
('Dr. Emily Johnson', 'Pediatrics', '555-333-4444'),
('Dr. Alex Brown', 'Neurology', '555-555-6666');