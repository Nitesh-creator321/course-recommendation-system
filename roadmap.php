<?php
session_start();

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
    die("DB Connection Failed: " . $conn->connect_error);
}

$course_id = $_GET['course_id'] ?? null;
if (!$course_id) {
    header("Location: courses.php");
    exit;
}

// Fetch course details
$course_stmt = $conn->prepare("SELECT name FROM courses WHERE course_id = ?"); 
$course_stmt->bind_param("i", $course_id);
$course_stmt->execute();
$course = $course_stmt->get_result()->fetch_assoc();
$course_stmt->close();

if (!$course) { die("Course not found!"); }

$user_id = $_SESSION['user_id'];
$is_user_enrolled = false;
$stmt_check = $conn->prepare("SELECT enrollment_id FROM enrollments WHERE user_id = ? AND course_id = ?");
$stmt_check->bind_param("ii", $user_id, $course_id);
$stmt_check->execute();
if ($stmt_check->get_result()->num_rows > 0) {
    $is_user_enrolled = true;
}
$stmt_check->close();

// Fetch Steps
$stmt = $conn->prepare("SELECT step_number, step_title, step_description FROM roadmaps WHERE course_id = ? ORDER BY step_number ASC");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($course['name']) ?> Roadmap</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
<style>
    :root {
        --primary: #3b82f6;
        --success: #10b981;
        --bg-glass: rgba(15, 23, 42, 0.7);
        --border: rgba(255, 255, 255, 0.1);
        --text-main: #f8fafc;
        --text-dim: #94a3b8;
    }

    body {
        background: url('images/roadmap2.jpg') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Inter', sans-serif;
        color: var(--text-main);
        margin: 0;
        padding: 80px 20px;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.85);
        z-index: -1;
    }

    .container {
        max-width: 900px;
        margin: auto;
        padding: 40px;
    }

    h1 {
        text-align: center;
        font-size: 2.8rem;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 60px;
        background: linear-gradient(to right, #fff, var(--text-dim));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .roadmap-container {
        position: relative;
        padding-left: 60px;
    }

    /* Vertical Line */
    .roadmap-container::before {
        content: '';
        position: absolute;
        top: 0; bottom: 0; left: 25px;
        width: 2px;
        background: linear-gradient(to bottom, var(--primary), transparent);
        box-shadow: 0 0 15px var(--primary);
    }

    .roadmap-step {
        position: relative;
        background: var(--bg-glass);
        backdrop-filter: blur(12px);
        margin: 30px 0;
        padding: 25px 30px;
        border-radius: 16px;
        border: 1px solid var(--border);
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
    }

    .roadmap-step:hover {
        border-color: var(--primary);
        background: rgba(30, 41, 59, 0.9);
        transform: scale(1.02);
    }

    /* Step Circle */
    .roadmap-step::before {
        content: attr(data-step);
        position: absolute;
        left: -53px;
        top: 25px;
        width: 34px;
        height: 34px;
        background: #0f172a;
        color: var(--text-main);
        border: 2px solid var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        z-index: 10;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
    }

    .roadmap-step.status-completed::before {
        background: var(--success);
        border-color: var(--success);
        box-shadow: 0 0 15px var(--success);
    }

    .step-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .step-title {
        font-weight: 600;
        font-size: 1.2rem;
        letter-spacing: -0.5px;
    }

    .step-status-tag {
        font-size: 10px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 6px;
        color: var(--success);
        text-transform: uppercase;
        border: 1px solid var(--success);
        background: rgba(16, 185, 129, 0.1);
    }

    .toggle-icon {
        font-size: 1.5rem;
        color: var(--text-dim);
        transition: transform 0.3s;
    }

    .roadmap-step.active .toggle-icon { transform: rotate(45deg); color: var(--primary); }

    .step-description {
        margin-top: 20px;
        color: var(--text-dim);
        max-height: 0;
        overflow: hidden;
        transition: all 0.5s ease;
        opacity: 0;
        font-size: 0.95rem;
        line-height: 1.7;
    }

    .roadmap-step.active .step-description {
        max-height: 1000px;
        opacity: 1;
        padding-top: 20px;
        border-top: 1px solid var(--border);
    }

    .btn-complete {
        background: linear-gradient(135deg, var(--success), #059669);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 700;
        margin-top: 20px;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-complete:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }

    .button-row {
        display: flex;
        justify-content: space-between;
        margin-top: 60px;
        gap: 20px;
    }

    .nav-btn {
        padding: 14px 28px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
        text-align: center;
        flex: 1;
        border: 1px solid var(--border);
    }

    .back-btn { background: var(--bg-glass); color: var(--text-main); }
    .profile-btn { background: var(--primary); color: #fff; border: none; }

    .nav-btn:hover {
        transform: translateY(-3px);
        filter: brightness(1.2);
    }

    .lock-notice {
        margin-top: 15px;
        background: rgba(239, 68, 68, 0.1);
        color: #f87171;
        padding: 10px;
        border-radius: 8px;
        font-size: 0.85rem;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
</style>
</head>
<body>
<div class="container">
    <h1><i class="fas fa-route"></i> Roadmap Overview</h1>
    
    <div class="roadmap-container">
        <?php while ($row = $result->fetch_assoc()): 
            $step_num = $row['step_number'];
            $prog_stmt = $conn->prepare("SELECT progress_id FROM user_roadmap_progress WHERE user_id = ? AND course_id = ? AND step_number = ?");
            $prog_stmt->bind_param("iii", $user_id, $course_id, $step_num);
            $prog_stmt->execute();
            $is_completed = $prog_stmt->get_result()->num_rows > 0;
            $prog_stmt->close();
        ?>
            <div id="step-<?= $step_num ?>" class="roadmap-step <?= $is_completed ? 'status-completed' : '' ?>" data-step="<?= $step_num ?>">
                <div class="step-header">
                    <span class="step-title"><?= htmlspecialchars($row['step_title']) ?></span>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <?php if ($is_completed): ?>
                            <span class="step-status-tag"><i class="fas fa-check"></i> Passed</span>
                        <?php endif; ?>
                        <span class="toggle-icon">+</span>
                    </div>
                </div>
                <div class="step-description">
                    <p><?= nl2br(htmlspecialchars($row['step_description'])) ?></p>
                    
                    <?php if (!$is_completed): ?>
                        <?php if ($is_user_enrolled): ?>
                            <form action="update_step.php" method="POST">
                                <input type="hidden" name="course_id" value="<?= $course_id ?>">
                                <input type="hidden" name="step_number" value="<?= $step_num ?>">
                                <button type="submit" class="btn-complete">Mark Module Complete</button>
                            </form>
                        <?php else: ?>
                            <div class="lock-notice"><i class="fas fa-lock"></i> Please enroll in the course to track your progress.</div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div style="margin-top: 15px; color: var(--success); font-weight: 700;"><i class="fas fa-award"></i> MODULE ACHIEVED</div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="button-row">
        <a href="course_details.php?course_id=<?= $course_id ?>" class="nav-btn back-btn"><i class="fas fa-arrow-left"></i> Course Info</a>
        <a href="profile.php" class="nav-btn profile-btn">My Dashboard <i class="fas fa-user"></i></a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Handle specific step expansion from URL hash
    const hash = window.location.hash;
    if (hash) {
        const target = document.querySelector(hash);
        if (target) {
            target.classList.add('active');
            target.querySelector('.toggle-icon').textContent = '×';
            target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    const steps = document.querySelectorAll('.roadmap-step');
    steps.forEach(step => {
        step.querySelector('.step-header').addEventListener('click', () => {
            // Optional: Close other steps when opening one (Accordion effect)
            steps.forEach(s => { 
                if (s !== step) {
                    s.classList.remove('active'); 
                    s.querySelector('.toggle-icon').textContent = '+';
                }
            });
            
            const isActive = step.classList.toggle('active');
            step.querySelector('.toggle-icon').textContent = isActive ? '×' : '+';
        });
    });
});
</script>
</body>
</html>