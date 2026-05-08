<?php
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'];
$prev_login = $_SESSION['prev_login'] ?? null;
$last_login_display = $prev_login ? date("F j, Y, g:i a", $prev_login) : "This is your first time logging in.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
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
            max-width: 500px;
            text-align: center;
        }
        h2 {
            color: #1e3c72;
            margin-bottom: 20px;
            border-bottom: 3px solid #f39c12;
            display: inline-block;
            padding-bottom: 8px;
        }
        .info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: left;
            border-left: 4px solid #f39c12;
        }
        .info p {
            margin: 10px 0;
            color: #2c3e50;
        }
        .logout-btn {
            background: #e74c3c;
            margin-top: 10px;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            color: white;
        }
        .logout-btn:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome, <?= htmlspecialchars($user_name) ?>!</h2>
    <div class="info">
        <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['user_email']) ?></p>
        <p><strong>Last Login Time:</strong> <?= htmlspecialchars($last_login_display) ?></p>
        <p>✅ You are logged in. This dashboard is session‑protected.</p>
    </div>
    <a href="logout.php"><button class="logout-btn">Logout</button></a>
</div>
</body>
</html>