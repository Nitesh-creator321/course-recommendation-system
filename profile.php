<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// DB connection
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "course_recommender_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$stmt_user = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt_user->bind_param('i', $user_id);
$stmt_user->execute();
$user_data = $stmt_user->get_result()->fetch_assoc();
$stmt_user->close();

// Fetch total count
$stmt_applied_courses = $conn->prepare("SELECT COUNT(*) AS total_applied_courses FROM enrollments WHERE user_id = ?");
$stmt_applied_courses->bind_param('i', $user_id);
$stmt_applied_courses->execute();
$total_applied_courses = $stmt_applied_courses->get_result()->fetch_assoc()['total_applied_courses'];
$stmt_applied_courses->close();

// Fetch enrolled courses
$stmt_enrolled_courses = $conn->prepare("
    SELECT c.name AS course_name, e.status, e.course_id, e.rating
    FROM enrollments e
    JOIN courses c ON e.course_id = c.course_id
    WHERE e.user_id = ?
");
$stmt_enrolled_courses->bind_param('i', $user_id);
$stmt_enrolled_courses->execute();
$enrolled_courses = $stmt_enrolled_courses->get_result();
$stmt_enrolled_courses->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0a0a0a;
            --card-bg: rgba(25, 33, 50, 0.75);
            --text-light: #e0e0e0;
            --text-muted: #94a3b8;
            --accent-blue: #007bff;
            --accent-green: #28a745;
            --border-color: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-dark);
            background-image: url('images/courseback.jpg');
            background-size: cover;
            background-attachment: fixed;
            color: var(--text-light);
            margin: 0;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        .profile-container {
            background: var(--card-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            max-width: 700px;
            width: 90%;
            text-align: center;
            animation: fadeIn 1s ease-out;
            position: relative;
        }

        h1 { font-size: 2.5rem; margin-bottom: 40px; }

        .profile-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            text-align: left;
        }

        .info-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 25px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            min-height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .info-item strong { 
            display: block; 
            color: var(--text-muted); 
            font-size: 0.85rem; 
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .info-item span { font-size: 1.1rem; font-weight: 400; }

        h2 { margin-top: 60px; font-size: 2rem; color: var(--accent-blue); }

        ul { list-style: none; padding: 0; margin-top: 30px; }

        li {
            background: rgba(255, 255, 255, 0.05);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            text-align: left;
            border: 1px solid var(--border-color);
        }

        .course-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .btn-progress {
            background: var(--accent-blue);
            color: white;
            padding: 8px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-progress:hover { background: #0056b3; transform: translateY(-2px); }

        .status {
            font-weight: 700;
            font-size: 0.8rem;
            padding: 5px 15px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .status.completed { background: var(--accent-green); }
        .status.in-progress, .status.enrolled { background: var(--accent-blue); }

        .status-bar-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            height: 12px;
            width: 100%;
            margin-top: 20px;
            overflow: hidden;
        }

        .status-bar { background: var(--accent-green); height: 100%; transition: width 1s ease; }

        .button-group { margin-top: 50px; display: flex; gap: 20px; justify-content: center; }

        .back-button {
            padding: 14px 30px;
            background: var(--accent-blue);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
        }

        .back-button.green { background: var(--accent-green); }
        .back-button:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.3); }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 600px) { .profile-info { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1>Your Profile</h1>
        
        <div class="profile-info">
            <div class="info-item"><strong>Email</strong> <span><?= htmlspecialchars($user_data['email'] ?? 'N/A') ?></span></div>
            <div class="info-item"><strong>First Name</strong> <span><?= htmlspecialchars($user_data['first_name'] ?? 'N/A') ?></span></div>
            <div class="info-item"><strong>Last Name</strong> <span><?= htmlspecialchars($user_data['last_name'] ?? 'N/A') ?></span></div>
            <div class="info-item"><strong>Phone Number</strong> <span><?= htmlspecialchars($user_data['phone'] ?? 'N/A') ?></span></div>
            <div class="info-item"><strong>Organization</strong> <span><?= htmlspecialchars($user_data['school_college_company_name'] ?? 'N/A') ?></span></div>
            <div class="info-item"><strong>Study Level</strong> <span><?= htmlspecialchars($user_data['study'] ?? 'N/A') ?></span></div>
            <div class="info-item"><strong>Date of Birth</strong> <span><?= htmlspecialchars($user_data['dob'] ?? 'N/A') ?></span></div>
            <div class="info-item"><strong>Pincode</strong> <span><?= htmlspecialchars($user_data['pincode'] ?? 'N/A') ?></span></div>
            <div class="info-item"><strong>Total Applied</strong> <span><?= $total_applied_courses ?></span></div>
            <div class="info-item"><strong>Address</strong> <span><?= nl2br(htmlspecialchars($user_data['address'] ?? 'N/A')) ?></span></div>
        </div>

        <h2>Enrolled Courses</h2>
        <?php if ($enrolled_courses->num_rows > 0): ?>
            <ul>
                <?php while ($row = $enrolled_courses->fetch_assoc()): 
                    $c_id = $row['course_id'];
                    
                    // 1. Total steps in the roadmap
                    $count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM roadmaps WHERE course_id = ?");
                    $count_stmt->bind_param("i", $c_id);
                    $count_stmt->execute();
                    $total_steps = $count_stmt->get_result()->fetch_assoc()['total'];
                    $count_stmt->close();
                    
                    // 2. Completed steps from the USER PROGRESS table
                    $done_stmt = $conn->prepare("SELECT COUNT(*) as done FROM user_roadmap_progress WHERE user_id = ? AND course_id = ?");
                    $done_stmt->bind_param("ii", $user_id, $c_id);
                    $done_stmt->execute();
                    $done_steps = $done_stmt->get_result()->fetch_assoc()['done'];
                    $done_stmt->close();
                    
                    // 3. Calculate Percentage
                    $percentage = ($total_steps > 0) ? round(($done_steps / $total_steps) * 100) : 0;
                    
                    // Small progress fill before any mark (Initial 5%)
                    if ($percentage == 0) { $percentage = 5; }
                ?>
                    <li>
                        <div class="course-header">
                            <span style="font-weight: 600; font-size: 1.3rem;"><?= htmlspecialchars($row['course_name']) ?></span>
                            <a href="roadmap.php?course_id=<?= $row['course_id'] ?>" class="btn-progress">View Progress</a>
                        </div>
                        
                        <span class="status <?= strtolower(str_replace(' ', '-', $row['status'])) ?>">
                            <?= $row['status'] == 'In Progress' ? 'In Progress' : ucfirst($row['status']) ?>
                        </span>

                        <div class="status-bar-container">
                            <div class="status-bar" style="width: <?= $percentage ?>%;"></div>
                        </div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 5px; text-align: right;">
                            <?= ($percentage == 5 && $done_steps == 0) ? "0" : $percentage ?>% Completed
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No courses enrolled yet.</p>
        <?php endif; ?>

        <div class="button-group">
            <a href="my_courses.php" class="back-button green">Go to My Courses</a>
            <a href="courses.php" class="back-button">← Back to Courses</a>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>