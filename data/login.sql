-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    accesslevel VARCHAR(50) NOT NULL
);

-- Insert records with different access levels
INSERT INTO users (username, password, accesslevel) VALUES
('admin', 'admin', 'Admin'),
('user1', '12345678', 'student'),
('user2', '12345678', 'POS'),
('user3', '12345678', 'Inventory'),
('user4', '12345678', 'HR');