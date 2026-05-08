<?php
$host = "localhost";
$user = "root";
$password = "";
$dbName = "hospital_management_db";

// Connect to MySQL
$conn = mysqli_connect($host, $user, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}
mysqli_select_db($conn, $dbName);

// -------------------- CREATE TABLES --------------------
$employeeTable = "CREATE TABLE IF NOT EXISTS employees (
    employee_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    gender ENUM('Male','Female','Other') NOT NULL,
    date_of_birth DATE NOT NULL,
    role VARCHAR(50) NOT NULL,
    department VARCHAR(50) NOT NULL,
    qualification VARCHAR(100),
    phone VARCHAR(15),
    email VARCHAR(100) UNIQUE,
    address TEXT,
    salary DECIMAL(10,2) NOT NULL,
    joining_date DATE NOT NULL,
    status ENUM('Active','Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($employeeTable);

$registrationTable = "CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'parent', 'teacher', 'professional') NOT NULL,
    track ENUM('creative-coding', 'ui-ux', 'ai-fundamentals', 'foundations') NOT NULL,
    start_date DATE NOT NULL,
    notes TEXT,
    terms_accepted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($registrationTable);

// -------------------- INSERT SAMPLE DATA (only if empty) --------------------

// Check if employees table already has data
$result = $conn->query("SELECT COUNT(*) as count FROM employees");
$row = $result->fetch_assoc();
if ($row['count'] == 0) {
    $insertEmployees = "INSERT INTO employees
        (full_name, gender, date_of_birth, role, department, qualification, phone, email, address, salary, joining_date)
        VALUES
        ('Rahim Uddin', 'Male', '1990-05-12', 'Doctor', 'Cardiology', 'MBBS', '01711111111', 'rahim@example.com', 'Dhaka', 80000, '2020-01-10'),
        ('Karima Begum', 'Female', '1988-09-25', 'Nurse', 'Emergency', 'BSc Nursing', '01822222222', 'karima@example.com', 'Khulna', 40000, '2021-03-15'),
        ('Hasan Mahmud', 'Male', '1995-07-18', 'Technician', 'Lab', 'Diploma', '01933333333', 'hasan@example.com', 'Chittagong', 30000, '2022-06-01'),
        ('Nusrat Jahan', 'Female', '1992-11-05', 'Admin', 'HR', 'MBA', '01644444444', 'nusrat@example.com', 'Dhaka', 50000, '2019-09-20')";
    $conn->query($insertEmployees);
}

// Check if registrations table already has data
$result = $conn->query("SELECT COUNT(*) as count FROM registrations");
$row = $result->fetch_assoc();
if ($row['count'] == 0) {
    $hashedPassword = password_hash("123456", PASSWORD_DEFAULT);
    $insertRegistrations = "INSERT INTO registrations
        (full_name, email, phone, password, role, track, start_date, notes, terms_accepted)
        VALUES
        ('Asif Mahmud', 'asif@example.com', '01700000000', '$hashedPassword', 'student', 'ai-fundamentals', '2026-05-01', 'Interested in AI', TRUE),
        ('Sadia Islam', 'sadia@example.com', '01800000000', '$hashedPassword', 'teacher', 'ui-ux', '2026-05-03', 'UI expert', TRUE),
        ('Tanvir Hasan', 'tanvir@example.com', '01900000000', '$hashedPassword', 'professional', 'creative-coding', '2026-05-05', 'Works in IT', TRUE),
        ('Mim Akter', 'mim@example.com', '01600000000', '$hashedPassword', 'student', 'foundations', '2026-05-07', 'Beginner', TRUE)";
    $conn->query($insertRegistrations);
}

echo "Database, tables, and sample data are ready (no duplicates inserted).";
?>