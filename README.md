# Master-System-MSTIP-2026

Develop a beginner system for IS105 - Enterprise Architecture subject.

# Attendance System Module

## Overview

This module handles employee time logs including time-in, time-out, and computed attendance metrics. It is part of a larger POS system with 5 modules: HR, Inventory, Point of Sales, Attendance, and Payroll.

---

## Dependencies (What I need from HR) HARDION SAYO TO MAN

### `employees` table

| Column          | Type     | Description                |
| --------------- | -------- | -------------------------- |
| employee_id     | INT (PK) | Unique employee identifier |
| full_name       | VARCHAR  | Employee full name         |
| department      | VARCHAR  | Employee department        |
| employment_type | ENUM     | regular or contractual     |
| status          | ENUM     | active or inactive         |

### `work_schedule` table (if available)

| Column            | Type     | Description                            |
| ----------------- | -------- | -------------------------------------- |
| schedule_id       | INT (PK) | Unique schedule identifier             |
| employee_id       | INT (FK) | References employees.employee_id       |
| time_in_expected  | TIME     | Expected clock-in time                 |
| time_out_expected | TIME     | Expected clock-out time                |
| work_days         | VARCHAR  | Days expected to report (e.g. Mon-Fri) |

---

## What This Module Outputs (to Payroll)

| Column               | Description                    |
| -------------------- | ------------------------------ |
| employee_id          | Employee reference             |
| total_days_worked    | Count of days present          |
| total_hours_worked   | Sum of hours per pay period    |
| total_overtime_hours | Hours beyond expected schedule |
| total_minutes_late   | Sum of late minutes            |
| total_absences       | Count of absent days           |

---

## What This Module Computes Internally

- `minutes_late` = actual time_in - time_in_expected
- `undertime` = time_out_expected - actual time_out
- `hours_worked` = time_out - time_in
- `overtime_hours` = hours_worked - standard hours
- `absence_flag` = expected to report but no time_in recorded

---

## Deadline

April 22

YUNG KILA EARL DI CONNECTED RITO YUN

eto na yung file structure ng attendance system ko

attendance/
├── timelog_clockin.php ← new: the bundy-clock UI (employee ID + password input)
├── timelog_process.php ← new: handles INSERT of time_in / time_out
├── timelogs.php ← existing: your main time logs list/report view
