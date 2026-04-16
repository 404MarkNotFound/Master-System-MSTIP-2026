CREATE TABLE attendance_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    emp_id INT NOT NULL,
    emp_num VARCHAR(50) NOT NULL,
    employee_name VARCHAR(150) NOT NULL,
    log_date DATE NOT NULL,
    time_in DATETIME NULL,
    time_out DATETIME NULL,
    status VARCHAR(20) DEFAULT 'IN',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL,

    UNIQUE KEY unique_daily_log (emp_id, log_date)
);

CREATE TABLE attendance_credentials (
    emp_num VARCHAR(50) PRIMARY KEY,
    password VARCHAR(100) NOT NULL,
    is_active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);