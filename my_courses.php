<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB connection
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "course_recommender_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch enrolled courses for the current user
$stmt = $conn->prepare("
    SELECT c.course_id, c.name, c.description, e.enrollment_date, e.status, c.image_path
    FROM enrollments e
    JOIN courses c ON e.course_id = c.course_id
    WHERE e.user_id = ?
    ORDER BY e.enrollment_date DESC
");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param('i', $user_id);
$stmt->execute();
$enrolled_courses = $stmt->get_result();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Learning | Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <style>
        :root {
            --primary: #3b82f6;
            --success: #10b981;
            --error: #ef4444;
            --bg-glass: rgba(15, 23, 42, 0.7);
            --card-glass: rgba(30, 41, 59, 0.4);
            --border: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a url('images/coursebackground.jpg') no-repeat center center fixed;
            background-size: cover;
            color: var(--text-main);
            margin: 0;
            padding: 80px 20px;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.85);
            z-index: -1;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: var(--bg-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 50px 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 50px;
            text-align: center;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
        }

        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .course-card {
            background: var(--card-glass);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .course-card:hover {
            transform: translateY(-10px);
            background: rgba(30, 41, 59, 0.8);
            border-color: var(--primary);
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.5);
        }

        .course-card h3 {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0 0 12px;
            color: #fff;
            line-height: 1.3;
        }

        .course-card p {
            font-size: 0.95rem;
            color: var(--text-dim);
            line-height: 1.6;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .card-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .meta-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            margin-bottom: 20px;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 99px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 10px;
        }

        .status-active, .status-in-progress, .status-enrolled { 
            background: rgba(59, 130, 246, 0.15); 
            color: var(--primary); 
            border: 1px solid var(--primary);
        }
        .status-completed { 
            background: rgba(16, 185, 129, 0.15); 
            color: var(--success); 
            border: 1px solid var(--success);
        }

        .view-btn {
            display: block;
            text-align: center;
            background: var(--primary);
            color: white;
            text-decoration: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: 0.3s;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .view-btn:hover {
            background: #2563eb;
            transform: scale(1.02);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
        }

        .back-nav {
            display: block;
            text-align: center;
            margin-top: 60px;
        }

        .browse-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 40px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            color: #fff;
            text-decoration: none;
            border-radius: 14px;
            font-weight: 600;
            transition: 0.3s;
        }

        .browse-btn:hover {
            background: var(--success);
            border-color: var(--success);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 60px 0;
            color: var(--text-dim);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.4;
        }

        @media (max-width: 768px) {
            .container { padding: 30px 20px; }
            h1 { font-size: 2.2rem; }
            .course-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Learning Journey</h1>

        <?php if ($enrolled_courses->num_rows > 0): ?>
            <div class="course-grid">
                <?php while ($row = $enrolled_courses->fetch_assoc()): ?>
                    <div class="course-card">
                        <h3><?= htmlspecialchars($row['name']) ?></h3>
                        <p><?= htmlspecialchars(substr($row['description'], 0, 140)) . (strlen($row['description']) > 140 ? '...' : '') ?></p>
                        
                        <div class="card-footer">
                            <div class="meta-info">
                                <span><i class="far fa-calendar-alt"></i> <?= date('M d, Y', strtotime($row['enrollment_date'])) ?></span>
                                <span class="status-badge status-<?= strtolower(htmlspecialchars($row['status'])) ?>">
                                    <?= ucfirst(htmlspecialchars($row['status'])) ?>
                                </span>
                            </div>
                            <a href="roadmap.php?course_id=<?= $row['course_id'] ?>" class="view-btn">
                                <i class="fas fa-map"></i> Continue Learning
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-graduation-cap"></i>
                <p style="font-size: 1.2rem;">Your classroom is currently empty.</p>
                <p>Pick a discipline and start your journey today.</p>
            </div>
        <?php endif; ?>

        <div class="back-nav">
            <a href="courses.php" class="browse-btn">
                <i class="fas fa-plus"></i> Browse More Courses
            </a>
        </div>
    </div>
</body>
</html>