<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "course_recommender_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }

    $first_name = trim(htmlspecialchars($_POST['first_name'] ?? ''));
    $last_name = trim(htmlspecialchars($_POST['last_name'] ?? ''));
    $email = trim(htmlspecialchars($_POST['email'] ?? ''));
    $raw_password = $_POST['password'] ?? ''; 
    $phone = trim(htmlspecialchars($_POST['phone'] ?? ''));
    $school_college_company_name = trim(htmlspecialchars($_POST['school_college_company_name'] ?? ''));
    $address = trim(htmlspecialchars($_POST['address'] ?? ''));
    $pincode = trim(htmlspecialchars($_POST['pincode'] ?? ''));
    $study = trim(htmlspecialchars($_POST['study'] ?? ''));
    $dob = trim(htmlspecialchars($_POST['dob'] ?? ''));
    
    $errors = [];

    if (empty($first_name)) { $errors[] = "First name is required."; }
    if (empty($last_name)) { $errors[] = "Last name is required."; }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }
    if (empty($raw_password) || strlen($raw_password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    if (empty($phone)) { $errors[] = "Phone number is required."; }
    if (empty($school_college_company_name)) { $errors[] = "Institution name is required."; }
    if (empty($address)) { $errors[] = "Address is required."; }
    if (empty($pincode)) { $errors[] = "Pincode is required."; }
    if (empty($study)) { $errors[] = "Study level is required."; }
    if (empty($dob)) { $errors[] = "Date of birth is required."; }


    if (empty($errors)) {
        $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, phone, school_college_company_name, address, pincode, study, dob) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssssssssss", $first_name, $last_name, $email, $hashed_password, $phone, $school_college_company_name, $address, $pincode, $study, $dob);

        try {
            if ($stmt->execute()) {
                header("Location: login.php"); 
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $errors[] = "This email is already registered.";
            } else {
                $errors[] = "Registration error: " . $e->getMessage();
            }
        }
        $stmt->close();
    }

    if (!empty($errors)) {
        $_SESSION['registration_errors'] = $errors;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account | ICR System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #10b981; /* Professional Emerald Green */
            --primary-hover: #059669;
            --glass-bg: rgba(15, 23, 42, 0.75);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: url('images/signup.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
        }

        /* Overlay */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.8);
            z-index: 0;
        }

        .signup-container {
            position: relative;
            z-index: 1;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 50px;
            border-radius: 28px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 700px;
            border: 1px solid var(--glass-border);
            color: var(--text-main);
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
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
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            transition: 0.3s;
        }

        .back-nav a:hover {
            background: var(--primary);
            color: #fff;
            transform: translateX(-3px);
        }

        h2 {
            text-align: center;
            margin-bottom: 35px;
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: -1px;
            background: linear-gradient(to bottom, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .full-width { grid-column: span 2; }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dim);
            margin-left: 4px;
        }

        input, select, textarea {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--glass-border);
            padding: 12px 16px;
            border-radius: 12px;
            color: #fff;
            font-size: 0.95rem;
            transition: 0.3s;
            outline: none;
            width: 100%;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--primary);
            background: rgba(15, 23, 42, 0.9);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }

        /* Clean Dropdown Styling */
        select option {
            background: #1e293b;
            color: #fff;
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
            margin-top: 20px;
            transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
        }

        button:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(16, 185, 129, 0.4);
        }

        .session-errors {
            background: rgba(239, 68, 68, 0.15);
            color: #fda4af;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            border: 1px solid rgba(239, 68, 68, 0.3);
            font-size: 0.9rem;
        }

        .session-errors p { margin: 5px 0; }

        @media (max-width: 650px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
            .signup-container { padding: 40px 25px; }
        }
    </style>
</head>
<body>

<div class="signup-container">
    <div class="back-nav">
        <a href="login.php" title="Back to Login"><i class="fas fa-arrow-left"></i></a>
    </div>

    <h2>Join the System</h2>

    <?php
    if (isset($_SESSION['registration_errors']) && !empty($_SESSION['registration_errors'])) {
        echo "<div class='session-errors'>";
        foreach ($_SESSION['registration_errors'] as $err) {
            echo "<p><i class='fas fa-exclamation-circle'></i> $err</p>";
        }
        unset($_SESSION['registration_errors']);
        echo "</div>";
    }
    ?>

    <form method="POST" action="" class="form-grid">
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" placeholder="John" required>
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" placeholder="Doe" required>
        </div>

        <div class="form-group full-width">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="john@example.com" required>
        </div>

        <div class="form-group full-width">
            <label>Password</label>
            <input type="password" name="password" placeholder="Minimum 6 characters" required>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="tel" name="phone" placeholder="+91..." required>
        </div>

        <div class="form-group">
            <label>Institution / Company</label>
            <input type="text" name="school_college_company_name" placeholder="Organization name" required>
        </div>

        <div class="form-group full-width">
            <label>Address</label>
            <textarea name="address" rows="2" placeholder="Full residential address" required></textarea>
        </div>

        <div class="form-group">
            <label>Area Pincode</label>
            <input type="text" name="pincode" placeholder="600001" required>
        </div>

        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="dob" required>
        </div>

        <div class="form-group full-width">
            <label>Current Study Level</label>
            <select name="study" required>
                <option value="">Select Level</option>
                <option value="SSC">SSC</option>
                <option value="HSC">HSC</option>
                <option value="Diploma">Diploma</option>
                <option value="Bachelor's">Undergraduate</option>
                <option value="Master's">Postgraduate</option>
                <option value="Engineering">Engineering</option>
            </select>
        </div>

        <div class="full-width">
            <button type="submit">Create Account</button>
        </div>
    </form>
</div>

</body>
</html>