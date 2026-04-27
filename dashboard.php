<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | Session Demo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        nav {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 20px;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .logout-btn {
            background: #ff4757;
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: #ff6b81;
            transform: scale(1.05);
        }
        
        .dashboard-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 70px);
            padding: 20px;
        }
        
        .card {
            background: white;
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            padding: 50px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .welcome-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
        
        .welcome-text {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }
        
        .username {
            color: #667eea;
            font-weight: bold;
            font-size: 32px;
            margin-bottom: 20px;
        }
        
        .message {
            background: #f0f4ff;
            padding: 20px;
            border-radius: 15px;
            margin: 25px 0;
            color: #555;
            line-height: 1.6;
        }
        
        .session-info {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            font-size: 13px;
            color: #888;
            margin-top: 20px;
        }
        
        .badge {
            display: inline-block;
            background: #27ae60;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo"> Session Demo</div>
        <a href="logout.php" class="logout-btn"> Logout</a>
    </nav>
    
    <div class="dashboard-container">
        <div class="card">
            <div class="welcome-icon"></div>
            <div class="welcome-text">Welcome back,</div>
            <div class="username"><?php echo htmlspecialchars($username); ?>!</div>
            
            <div class="message">
                 You have successfully logged in!<br>
                Your session is maintaining your login state.
            </div>
            
            <div class="session-info">
                 Session ID: <?php echo session_id(); ?><br>
                 Logged in as: <strong><?php echo htmlspecialchars($username); ?></strong><br>
                 You are viewing the secured dashboard
            </div>
            
            <div class="badge">
                ✓ Authenticated via Session
            </div>
        </div>
    </div>
</body>
</html>