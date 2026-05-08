<?php
require_once 'db_connect.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $role = $_POST['role'];
    $track = $_POST['track'];
    $start_date = $_POST['start_date'];
    $notes = trim($_POST['notes']);
    $terms = isset($_POST['terms']) ? 1 : 0;

    // Validation
    if (empty($full_name) || empty($email) || empty($password) || empty($role) || empty($track) || empty($start_date) || !$terms) {
        $error = "All fields marked with * are required, including terms acceptance.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Check if email exists
        $stmt = mysqli_prepare($conn, "SELECT id FROM registrations WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Email already registered.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO registrations (full_name, email, phone, password, role, track, start_date, notes, terms_accepted)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssssi", $full_name, $email, $phone, $hashed, $role, $track, $start_date, $notes, $terms);
            if (mysqli_stmt_execute($stmt)) {
                $success = "Registration successful! You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Registration failed. Try again.";
            }
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 35px rgba(0,0,0,0.2);
            padding: 40px;
            width: 100%;
            max-width: 550px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #1e3c72;
            border-bottom: 3px solid #f39c12;
            display: inline-block;
            padding-bottom: 8px;
            width: auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            color: #2c3e50;
            font-weight: 500;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s;
            font-family: inherit;
        }
        textarea {
            resize: vertical;
        }
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #f39c12;
            box-shadow: 0 0 0 2px rgba(243,156,18,0.2);
        }
        button {
            width: 100%;
            padding: 12px;
            background: #f39c12;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
        }
        button:hover {
            background: #e67e22;
        }
        .checkbox {
            display: flex;
            align-items: center;
        }
        .checkbox label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            margin-bottom: 0;
        }
        .checkbox input {
            width: auto;
            margin: 0;
        }
        .error {
            background: #fee2e2;
            color: #c53030;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
        .success {
            background: #e0f2e9;
            color: #2b7a4b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
        .links {
            text-align: center;
            margin-top: 25px;
        }
        .links a {
            color: #2193b0;
            text-decoration: none;
            font-weight: 500;
        }
        .links a:hover {
            text-decoration: underline;
            color: #f39c12;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Create Account</h2>
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label>Full Name *</label>
            <input type="text" name="full_name" required>
        </div>
        <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone">
        </div>
        <div class="form-group">
            <label>Password * (min 6 characters)</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label>Confirm Password *</label>
            <input type="password" name="confirm_password" required>
        </div>
        <div class="form-group">
            <label>Role *</label>
            <select name="role" required>
                <option value="">Select Role ▼</option>
                <option value="student">Student</option>
                <option value="parent">Parent</option>
                <option value="teacher">Teacher</option>
                <option value="professional">Professional</option>
            </select>
        </div>
        <div class="form-group">
            <label>Track *</label>
            <select name="track" required>
                <option value="">Select Track ▼</option>
                <option value="creative-coding">Creative Coding</option>
                <option value="ui-ux">UI/UX</option>
                <option value="ai-fundamentals">AI Fundamentals</option>
                <option value="foundations">Foundations</option>
            </select>
        </div>
        <div class="form-group">
            <label>Start Date *</label>
            <input type="date" name="start_date" required>
        </div>
        <div class="form-group">
            <label>Any additional information...</label>
            <textarea name="notes" rows="3"></textarea>
        </div>
        <div class="form-group checkbox">
            <label>
                <input type="checkbox" name="terms" required> I accept the terms and conditions *
            </label>
        </div>
        <button type="submit" name="register">Register</button>
    </form>
    <div class="links">
        Already have an account? <a href="login.php">Login here</a>
    </div>
</div>
</body>
</html>