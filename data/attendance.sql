-- Disable checks for clean import
SET FOREIGN_KEY_CHECKS = 0;

-- Drop tables if existing
DROP TABLE IF EXISTS attendance_logs;
DROP TABLE IF EXISTS attendance_credentials;

-- =========================
-- TABLE: attendance_credentials
-- =========================
CREATE TABLE attendance_credentials (
    emp_num VARCHAR(50) PRIMARY KEY,
    password VARCHAR(100) NOT NULL,
    is_active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO attendance_credentials (emp_num, password, is_active, created_at) VALUES
('2021-001', '1111', 1, '2026-04-19 17:02:08'),
('2021-003', '1111', 1, '2026-04-16 15:18:27'),
('2021-005', '1111', 1, '2026-04-19 17:03:13'),
('2021-007', '1111', 1, '2026-04-19 20:56:29'),
('2021-012', '1111', 1, '2026-04-19 20:56:51'),
('2021-018', '1111', 1, '2026-04-19 20:56:17'),
('2021-019', '1111', 1, '2026-04-19 20:56:05'),
('2021-030', '1111', 1, '2026-04-19 20:57:49'),
('2021-033', '1111', 1, '2026-04-19 20:57:57'),
('2021-035', '1111', 1, '2026-04-19 16:58:22'),
('2021-036', '1111', 1, '2026-04-19 20:58:05'),
('2021-043', '1111', 1, '2026-04-19 20:57:40'),
('2021-045', '1111', 1, '2026-04-19 20:56:59'),
('2021-089', '1111', 1, '2026-04-19 16:56:59'),
('2021-096', '1111', 1, '2026-04-19 20:56:44'),
('2021-098', '1111', 1, '2026-04-16 15:05:00');

-- =========================
-- TABLE: attendance_logs
-- =========================
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

INSERT INTO attendance_logs 
(id, emp_id, emp_num, employee_name, log_date, time_in, time_out, status, created_at, updated_at) 
VALUES
(1, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-19', '2026-04-19 10:59:03', '2026-04-19 20:51:26', 'Late', '2026-04-19 16:59:03', NULL),
(2, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-19', '2026-04-19 10:59:14', '2026-04-19 14:37:50', 'Late', '2026-04-19 16:59:14', NULL),
(3, 119, '2021-089', 'AILONA LIPIT', '2026-04-19', '2026-04-19 10:59:26', '2026-04-19 14:37:43', 'Late', '2026-04-19 16:59:26', NULL),
(4, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-19', '2026-04-19 10:59:37', '2026-04-19 14:37:35', 'Late', '2026-04-19 16:59:37', NULL),
(5, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-19', '2026-04-19 11:03:23', '2026-04-19 14:37:23', 'Late', '2026-04-19 17:03:23', NULL),
(6, 205, '2021-019', 'MARK ELABA', '2026-04-19', '2026-04-19 20:58:49', '2026-04-20 06:37:45', 'Late', '2026-04-19 20:58:49', NULL),
(7, 193, '2021-018', 'KYLA MARIE PASTORAL', '2026-04-19', '2026-04-19 20:58:56', '2026-04-20 06:37:45', 'Late', '2026-04-19 20:58:56', NULL),
(8, 183, '2021-007', 'JUDY SIBAYAN', '2026-04-19', '2026-04-19 20:59:02', '2026-04-20 06:37:45', 'Late', '2026-04-19 20:59:02', NULL),
(9, 171, '2021-012', 'IRIS FRANI', '2026-04-19', '2026-04-19 20:59:15', '2026-04-20 06:37:45', 'Late', '2026-04-19 20:59:15', NULL),
(10, 138, '2021-045', 'CHERRY ROSE TAGUIAM', '2026-04-19', '2026-04-19 21:17:48', '2026-04-20 06:37:45', 'Late', '2026-04-19 21:17:48', NULL),
(11, 122, '2021-001', 'ALLYSZA DATU', '2026-04-19', '2026-04-19 21:51:29', '2026-04-19 21:51:33', 'Late', '2026-04-19 21:51:29', NULL),
(12, 142, '2021-043', 'CLARISSA LICUAN', '2026-04-19', '2026-04-19 21:52:37', '2026-04-20 04:52:13', 'Late', '2026-04-19 21:52:37', NULL),
(13, 144, '2021-030', 'DANDY BONETE', '2026-04-19', '2026-04-19 21:52:45', '2026-04-20 04:52:13', 'Late', '2026-04-19 21:52:45', NULL),
(14, 147, '2021-033', 'DAVETTE JOHANA GARCIA', '2026-04-19', '2026-04-19 21:52:52', '2026-04-20 04:52:13', 'Late', '2026-04-19 21:52:52', NULL),
(15, 153, '2021-036', 'EDUARD JOSEPH', '2026-04-19', '2026-04-19 21:52:59', '2026-04-20 04:52:13', 'Late', '2026-04-19 21:52:59', NULL);

-- Re-enable checks
SET FOREIGN_KEY_CHECKS = 1;