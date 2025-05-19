-- Create database
CREATE DATABASE IF NOT EXISTS railway;
USE railway;

-- Users table to store user info
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bookings table to store ticket bookings
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    from_station VARCHAR(255) NOT NULL,
    to_station VARCHAR(255) NOT NULL,
    travel_date DATE NOT NULL,
    seats INT NOT NULL CHECK (seats > 0),
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Optional: Add indexes for performance if needed
CREATE INDEX idx_user_id ON bookings(user_id);
CREATE INDEX idx_travel_date ON bookings(travel_date);
