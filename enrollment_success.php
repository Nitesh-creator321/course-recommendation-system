<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get the message from the session if it exists, otherwise provide a default
$message = $_SESSION['message'] ?? 'Your enrollment request has been processed successfully.';
unset($_SESSION['message']); // Clear the message after displaying it

// Determine if it's a success or error message for styling
$is_success = (strpos(strtolower($message), 'successful') !== false || strpos(strtolower($message), 'processed') !== false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Status | Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --primary: #3b82f6;
            --success: #10b981;
            --error: #ef4444;
            --bg-glass: rgba(15, 23, 42, 0.8);
            --border: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a url('images/Course_back_image.jpg') no-repeat center center fixed;
            background-size: cover;
            color: var(--text-main);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        /* Overlay for deep contrast */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.85);
            z-index: -1;
        }

        .container {
            background: var(--bg-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 50px 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            max-width: 550px;
            width: 90%;
            text-align: center;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Celebratory Icon Styles */
        .icon-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 40px;
            position: relative;
        }

        .success-icon {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
        }

        /* Subtle Pulse Animation for Success */
        .success-icon::after {
            content: '';
            position: absolute;
            width: 100%; height: 100%;
            border: 2px solid var(--success);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.5; }
            100% { transform: scale(1.6); opacity: 0; }
        }

        .error-icon {
            background: rgba(239, 68, 68, 0.15);
            color: var(--error);
        }

        h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 15px;
            letter-spacing: -0.02em;
        }

        .success-heading { color: #fff; }
        .error-heading { color: var(--error); }

        p {
            font-size: 1.1rem;
            color: var(--text-dim);
            line-height: 1.6;
            margin-bottom: 35px;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .button {
            display: block;
            padding: 14px 25px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .primary-button {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .primary-button:hover {
            transform: translateY(-3px);
            background: #2563eb;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        .secondary-button {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid var(--border);
        }

        .secondary-button:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Floating particles for celebration */
        .particle {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            pointer-events: none;
            opacity: 0;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); opacity: 0; }
            50% { opacity: 0.6; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="icon-wrapper <?= $is_success ? 'success-icon' : 'error-icon' ?>">
        <i class="fas <?= $is_success ? 'fa-check-circle' : 'fa-exclamation-triangle' ?>"></i>
    </div>

    <h1 class="<?= $is_success ? 'success-heading' : 'error-heading' ?>">
        <?= $is_success ? 'Congratulations!' : 'Wait a moment' ?>
    </h1>

    <p><?= htmlspecialchars($message) ?></p>

    <div class="button-group">
        <a href="my_courses.php" class="button primary-button">Access My Classroom</a>
        <a href="courses.php" class="button secondary-button">Explore More Courses</a>
    </div>

    <?php if ($is_success): ?>
        <script>
            function createParticle() {
                const colors = ['#3b82f6', '#10b981', '#8b5cf6', '#f59e0b'];
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                particle.style.animationDelay = Math.random() * 2 + 's';
                document.querySelector('.container').appendChild(particle);
                setTimeout(() => particle.remove(), 3000);
            }
            setInterval(createParticle, 400);
        </script>
    <?php endif; ?>
</div>

</body>
</html>