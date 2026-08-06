-- Create Database
CREATE DATABASE IF NOT EXISTS laundry_db;
USE laundry_db;

-- Table: machines
CREATE TABLE machines (
    machine_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    machine_name VARCHAR(20) NOT NULL,
    status ENUM('free', 'busy') DEFAULT 'free',
    current_mode VARCHAR(50),
    time_remaining INT(11) DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: services (modes)
CREATE TABLE services (
    service_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    service_name VARCHAR(50) NOT NULL,
    duration_minutes INT(11) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

-- Table: customers
CREATE TABLE customers (
    customer_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: bookings (orders)
CREATE TABLE bookings (
    booking_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    customer_id INT(11),
    machine_id INT(11),
    service_id INT(11),
    cloth_type VARCHAR(50),
    quantity INT(11) DEFAULT 1,
    total_cost DECIMAL(10,2),
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    completion_time TIMESTAMP NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
    FOREIGN KEY (machine_id) REFERENCES machines(machine_id),
    FOREIGN KEY (service_id) REFERENCES services(service_id)
);

-- Insert sample machines (6 machines)
INSERT INTO machines (machine_name, status) VALUES
('Machine 1', 'free'),
('Machine 2', 'busy'),
('Machine 3', 'free'),
('Machine 4', 'busy'),
('Machine 5', 'free'),
('Machine 6', 'free');

-- Insert sample services
INSERT INTO services (service_name, duration_minutes, price) VALUES
('Washing - Bedding', 30, 80),
('Washing - Shirt', 25, 60),
('Drying Only', 20, 40),
('Washing + Drying', 45, 120);

-- Insert sample customers
INSERT INTO customers (name, phone, email, address) VALUES
('Raj Kumar', '9876543210', 'raj@gmail.com', 'Delhi'),
('Priya Sharma', '9876543211', 'priya@gmail.com', 'Mumbai'),
('Amit Singh', '9876543212', 'amit@gmail.com', 'Bangalore');

-- Insert sample bookings
INSERT INTO bookings (customer_id, machine_id, service_id, cloth_type, quantity, total_cost, status) VALUES
(1, 2, 4, 'Shirt', 3, 360, 'processing'),
(2, 4, 3, 'Jeans', 2, 80, 'pending'),
(1, 1, 2, 'T-Shirt', 5, 300, 'completed');

-- Update machine status
UPDATE machines SET status = 'busy', current_mode = 'Washing + Drying', time_remaining = 25 WHERE machine_id = 2;
UPDATE machines SET status = 'busy', current_mode = 'Drying Only', time_remaining = 10 WHERE machine_id = 4;