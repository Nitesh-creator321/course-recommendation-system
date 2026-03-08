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
    <title>User Dashboard | Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --primary: #3b82f6;
            --success: #10b981;
            --warning: #f59e0b;
            --bg-glass: rgba(15, 23, 42, 0.7);
            --card-glass: rgba(30, 41, 59, 0.5);
            --border: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: url('images/courseback.jpg') no-repeat center center fixed;
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

        .profile-container {
            max-width: 900px;
            margin: auto;
            background: var(--bg-glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 50px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.8s ease-out;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 40px;
            text-align: center;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Information Grid */
        .profile-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 50px;
        }

        .info-item {
            background: var(--card-glass);
            padding: 20px;
            border-radius: 16px;
            border: 1px solid var(--border);
            transition: 0.3s;
        }

        .info-item:hover {
            border-color: var(--primary);
            background: rgba(30, 41, 59, 0.7);
        }

        .info-item strong {
            display: block;
            color: var(--primary);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .info-item span { 
    font-size: 1rem; 
    font-weight: 400; 
    color: #fff;
    
    /* FIX STARTS HERE */
    word-break: break-all;      
    overflow-wrap: break-word;  
    display: inline-block;      
    line-height: 1.4;          
}

        /* Course List */
        h2 {
            font-size: 1.8rem;
            margin-bottom: 25px;
            padding-left: 10px;
            border-left: 4px solid var(--primary);
        }

        ul { list-style: none; padding: 0; }

        li {
            background: var(--card-glass);
            padding: 25px;
            border-radius: 20px;
            margin-bottom: 20px;
            border: 1px solid var(--border);
            transition: 0.3s;
        }

        li:hover {
            border-color: rgba(255, 255, 255, 0.2);
        }

        .course-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 15px;
        }

        .course-title {
            font-weight: 700;
            font-size: 1.25rem;
            color: #fff;
        }

        .btn-progress {
            background: var(--primary);
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.3s;
            white-space: nowrap;
        }

        .btn-progress:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        /* Progress Bar */
        .status-pill {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
        }

        .status-pill.completed { background: rgba(16, 185, 129, 0.2); color: var(--success); border: 1px solid var(--success); }
        .status-pill.in-progress, .status-pill.enrolled { background: rgba(59, 130, 246, 0.2); color: var(--primary); border: 1px solid var(--primary); }

        .progress-container {
            background: rgba(15, 23, 42, 0.5);
            border-radius: 50px;
            height: 10px;
            width: 100%;
            margin: 15px 0 8px;
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .progress-bar {
            background: linear-gradient(to right, var(--primary), var(--success));
            height: 100%;
            border-radius: 50px;
            transition: width 1s ease;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
        }

        /* Rating System */
        .rating-box {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .star-rating i {
            cursor: pointer;
            font-size: 1.3rem;
            color: #334155;
            margin-right: 5px;
            transition: 0.2s;
        }

        .star-rating i.active {
            color: #fbbf24;
            text-shadow: 0 0 10px rgba(251, 191, 36, 0.5);
        }

        /* Footer Buttons */
        .button-group {
            margin-top: 60px;
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .nav-btn {
            min-width: 200px;
            padding: 14px 25px;
            text-align: center;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            font-size: 0.95rem;
        }

        .nav-btn-primary { background: var(--primary); color: white; }
        .nav-btn-outline { background: var(--card-glass); border: 1px solid var(--border); color: #fff; }

        .nav-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px -10px rgba(0,0,0,0.5);
            filter: brightness(1.1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .profile-container { padding: 30px 20px; }
            .button-group { flex-direction: column; }
            .nav-btn { width: 100%; }
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h1>Your Dashboard</h1>
    
    <div class="profile-info">
        <div class="info-item"><strong>First Name</strong> <span><?= htmlspecialchars($user_data['first_name'] ?? '—') ?></span></div>
        <div class="info-item"><strong>Last Name</strong> <span><?= htmlspecialchars($user_data['last_name'] ?? '—') ?></span></div>
        <div class="info-item"><strong>Email Address</strong> <span><?= htmlspecialchars($user_data['email'] ?? '—') ?></span></div>
        <div class="info-item"><strong>Phone</strong> <span><?= htmlspecialchars($user_data['phone'] ?? '—') ?></span></div>
        <div class="info-item"><strong>Institution</strong> <span><?= htmlspecialchars($user_data['school_college_company_name'] ?? '—') ?></span></div>
        <div class="info-item"><strong>Total Enrollments</strong> <span><?= $total_applied_courses ?></span></div>
    </div>

    <h2>Course Progress</h2>
    <?php if ($enrolled_courses->num_rows > 0): ?>
        <ul>
            <?php while ($row = $enrolled_courses->fetch_assoc()): 
                $c_id = $row['course_id'];
                $current_rating = $row['rating'] ?? 0;
                
                $count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM roadmaps WHERE course_id = ?");
                $count_stmt->bind_param("i", $c_id);
                $count_stmt->execute();
                $total_steps = $count_stmt->get_result()->fetch_assoc()['total'];
                $count_stmt->close();
                
                $done_stmt = $conn->prepare("SELECT COUNT(*) as done FROM user_roadmap_progress WHERE user_id = ? AND course_id = ?");
                $done_stmt->bind_param("ii", $user_id, $c_id);
                $done_stmt->execute();
                $done_steps = $done_stmt->get_result()->fetch_assoc()['done'];
                $done_stmt->close();
                
                $percentage = ($total_steps > 0) ? round(($done_steps / $total_steps) * 100) : 0;
                if ($percentage == 0) { $percentage = 5; } // Visual start
            ?>
                <li>
                    <div class="course-header">
                        <span class="course-title"><?= htmlspecialchars($row['course_name']) ?></span>
                        <a href="roadmap.php?course_id=<?= $row['course_id'] ?>" class="btn-progress">Access Roadmap</a>
                    </div>
                    
                    <span class="status-pill <?= strtolower(str_replace(' ', '-', $row['status'])) ?>">
                        <i class="fas <?= $percentage >= 100 ? 'fa-check-double' : 'fa-spinner fa-spin' ?>"></i>
                        <?= ($row['status'] == 'In Progress' || $row['status'] == 'enrolled') ? 'Active Learning' : ucfirst($row['status']) ?>
                    </span>

                    <div class="progress-container">
                        <div class="progress-bar" style="width: <?= $percentage ?>%;"></div>
                    </div>
                    <div style="font-size: 0.75rem; color: var(--text-dim); text-align: right;">
                        <?= ($percentage == 5 && $done_steps == 0) ? "0" : $percentage ?>% Curriculum Complete
                    </div>

                    <?php if ($percentage >= 100): ?>
                        <div class="rating-box">
                            <strong style="font-size: 0.7rem; color: var(--primary); text-transform: uppercase;">Review your experience:</strong>
                            <div class="star-rating" data-course="<?= $c_id ?>">
                                <?php for($i=1; $i<=5; $i++): ?>
                                    <i class="fa-star <?= ($i <= $current_rating) ? 'fas active' : 'far' ?>" 
                                       onclick="submitRating(<?= $c_id ?>, <?= $i ?>)"></i>
                                <?php endfor; ?>
                            </div>
                            <div id="rate-msg-<?= $c_id ?>" style="font-size: 0.7rem; color: var(--success); margin-top: 8px; font-weight: 600;">
                                <?= ($current_rating > 0) ? "Verified Feedback Received" : "" ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <div style="text-align: center; padding: 40px; color: var(--text-dim);">
            <i class="fas fa-book-open" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.5;"></i>
            <p>You haven't enrolled in any courses yet.</p>
        </div>
    <?php endif; ?>

    <div class="button-group">
        <a href="my_courses.php" class="nav-btn nav-btn-primary">My Active Learning</a>
        <a href="courses.php" class="nav-btn nav-btn-outline">Browse Catalog</a>
    </div>
</div>

<script>
function submitRating(courseId, ratingValue) {
    fetch('submit_rating.php', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest' 
        },
        body: `course_id=${courseId}&rating=${ratingValue}`
    })
    .then(response => response.text())
    .then(data => {
        if(data.trim() === "success") {
            const stars = document.querySelectorAll(`.star-rating[data-course="${courseId}"] i`);
            stars.forEach((star, index) => {
                if (index < ratingValue) {
                    star.classList.replace('far', 'fas');
                    star.classList.add('active');
                } else {
                    star.classList.replace('fas', 'far');
                    star.classList.remove('active');
                }
            });
            document.getElementById(`rate-msg-${courseId}`).innerText = "Rating updated successfully!";
        } else {
            alert("Rating Error: " + data);
        }
    });
}
</script>
</body>
</html>
<?php $conn->close(); ?>