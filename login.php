<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

$login_heading = "Welcome Back!"; 

if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER['HTTP_REFERER'];
    if (strpos($referer, 'index.php') !== false) {
        $login_heading = "Start Your Journey!";
    } elseif (strpos($referer, 'register.php') !== false) {
        $login_heading = "Welcome Back!";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "course_recommender_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }

    $email = trim(htmlspecialchars($_POST['email'] ?? ''));
    $entered_password = $_POST['password'] ?? ''; 

    $error = "";

    if (empty($email) || empty($entered_password)) {
        $error = "Both email and password are required.";
    } else {
        $stmt = $conn->prepare("SELECT user_id, email, password FROM users WHERE email = ?");
        if ($stmt === false) {
            die("Prepare statement failed: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($entered_password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email'] = $user['email'];
                header("Location: courses.php"); 
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | ICR System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #3b82f6;
            --primary-glow: rgba(59, 130, 246, 0.5);
            /* Refined Transparent Alpha Values */
            --glass-bg: rgba(15, 23, 42, 0.65); 
            --glass-border: rgba(255, 255, 255, 0.12);
            --input-bg: rgba(255, 255, 255, 0.05);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: url('images/lock.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        /* Gradient overlay to ensure text legibility over any image */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at center, rgba(15, 23, 42, 0.4) 0%, rgba(15, 23, 42, 0.8) 100%);
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            padding: 55px 45px;
            border-radius: 28px;
            background: var(--glass-bg);
            /* Frosted Glass Effect */
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .back-nav {
            position: absolute;
            top: 25px;
            left: 25px;
        }

        .back-nav a {
            color: var(--text-dim);
            text-decoration: none;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
        }

        .back-nav a:hover {
            color: #fff;
            background: var(--primary);
            transform: translateX(-3px);
            box-shadow: 0 0 15px var(--primary-glow);
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: -1.5px;
            color: #fff;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-dim);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        input {
            width: 100%;
            padding: 15px 20px;
            background: var(--input-bg);
            border: 1px solid var(--glass-border);
            border-radius: 14px;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        input:focus {
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        button {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: white;
            border: none;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            border-radius: 14px;
            margin-top: 10px;
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }

        button:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.4);
        }

        .error {
            background: rgba(239, 68, 68, 0.15);
            color: #fda4af;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
            border: 1px solid rgba(239, 68, 68, 0.3);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .signup-link {
            text-align: center;
            margin-top: 35px;
            color: var(--text-dim);
            font-size: 0.95rem;
        }

        .signup-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            margin-left: 5px;
            transition: 0.2s;
        }

        .signup-link a:hover {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="back-nav">
        <a href="index.php" title="Back to Home"><i class="fas fa-arrow-left"></i></a>
    </div>
    
    <h2><?php echo $login_heading; ?></h2>

    <?php if (!empty($error)) echo "<div class='error'><i class='fas fa-exclamation-circle'></i> $error</div>"; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Account Email</label>
            <input type="email" id="email" name="email" placeholder="name@company.com" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
        </div>
        
        <button type="submit">Sign In</button>
    </form>

    <div class="signup-link">
        New to the system? <a href="register.php">Create Account</a>
    </div>
</div>

</body>
</html>