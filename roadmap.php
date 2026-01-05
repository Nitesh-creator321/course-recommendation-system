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

// --- ENROLLMENT CHECK ---
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

$status_data = [
    'completed' => ['color' => '#16a34a', 'icon' => 'fa-check-circle'],
    'active'    => ['color' => '#f59e0b', 'icon' => 'fa-hourglass-half'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($course['name']) ?> Roadmap</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" />
<style>
:root { --bg-color: #f3f4f6; --card-bg-primary: #ffffff; --text-dark: #1f2937; --text-muted: #6b7280; --primary-accent: #3b82f6; --timeline-line: #e5e7eb; }
* { box-sizing: border-box; font-family: 'Poppins', sans-serif; }
body { background: var(--bg-color) url('images/roadmap2.jpg') no-repeat center center fixed; background-size: cover; color: var(--text-dark); margin: 0; padding: 50px 20px; }
.container { background: rgba(255, 255, 255, 0.50); max-width: 850px; margin: auto; border-radius: 12px; padding: 50px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1); }
h1 { text-align: center; margin-bottom: 60px; font-size: 2.2rem; border-bottom: 2px solid var(--timeline-line); padding-bottom: 15px; }
.roadmap-container { position: relative; padding-left: 50px; }
.roadmap-container::before { content: ''; position: absolute; top: 0; bottom: 0; left: 20px; width: 2px; background: var(--timeline-line); }
.roadmap-step { position: relative; background: var(--card-bg-primary); margin: 40px 0; padding: 20px 25px; border-radius: 8px; border: 1px solid var(--timeline-line); transition: 0.3s ease-in-out; cursor: pointer; }
.roadmap-step:hover { background: #fcfcfc; }
.roadmap-step::before { content: attr(data-step); position: absolute; left: -42px; top: 50%; transform: translateY(-50%); width: 28px; height: 28px; background: var(--timeline-line); color: #fff; border: 3px solid var(--card-bg-primary); border-radius: 50%; text-align: center; line-height: 22px; font-size: 13px; z-index: 10; }
.step-header { display: flex; justify-content: space-between; align-items: center; }
.step-title { font-weight: 600; font-size: 1.1rem; }
.step-status-tag { font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 4px; color: #fff; text-transform: uppercase; min-width: 80px; text-align: center; background: #16a34a; }
.toggle-icon { font-size: 20px; color: var(--text-muted); transition: transform 0.3s; }
.roadmap-step.active .toggle-icon { transform: rotate(45deg); color: var(--primary-accent); }
.step-description { margin-top: 15px; color: var(--text-muted); max-height: 0; overflow: hidden; transition: max-height 0.4s ease-in-out, opacity 0.4s; opacity: 0; border-top: 1px dashed #eee; }
.roadmap-step.active .step-description { max-height: 1000px; opacity: 1; padding-top: 15px; }
.btn-complete { background-color: #16a34a; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 600; margin-top: 20px; font-family: 'Poppins', sans-serif; transition: background 0.2s; display: inline-block; }
.btn-complete:hover { background-color: #15803d; }
.button-row { display: flex; justify-content: space-between; align-items: center; margin-top: 50px; }
.back-btn, .profile-btn { display: inline-block; color: #fff; padding: 12px 25px; text-decoration: none; border-radius: 8px; transition: 0.3s ease-in-out; font-weight: 500; }
.back-btn { background-color: var(--text-muted); }
.profile-btn { background-color: var(--primary-accent); }
</style>
</head>
<body>
<div class="container">
    <h1><i class="fas fa-map-marked-alt"></i> <?= htmlspecialchars($course['name']) ?> Roadmap</h1>
    <div class="roadmap-container">
        <?php while ($row = $result->fetch_assoc()): 
            $step_num = $row['step_number'];
            // Check individual user progress
            $prog_stmt = $conn->prepare("SELECT progress_id FROM user_roadmap_progress WHERE user_id = ? AND course_id = ? AND step_number = ?");
            $prog_stmt->bind_param("iii", $user_id, $course_id, $step_num);
            $prog_stmt->execute();
            $is_completed = $prog_stmt->get_result()->num_rows > 0;
            $prog_stmt->close();
        ?>
            <div id="step-<?= $step_num ?>" class="roadmap-step <?= $is_completed ? 'status-completed' : '' ?>" data-step="<?= $step_num ?>">
                <div class="step-header">
                    <span class="step-title"><?= $step_num ?>. <?= htmlspecialchars($row['step_title']) ?></span>
                    <?php if ($is_completed): ?>
                        <span class="step-status-tag"><i class="fas fa-check-circle"></i> Completed</span>
                    <?php endif; ?>
                    <span class="toggle-icon">+</span>
                </div>
                <div class="step-description">
                    <p><?= nl2br(htmlspecialchars($row['step_description'])) ?></p>
                    <?php if (!$is_completed): ?>
                        <?php if ($is_user_enrolled): ?>
                            <form action="update_step.php" method="POST">
                                <input type="hidden" name="course_id" value="<?= $course_id ?>">
                                <input type="hidden" name="step_number" value="<?= $step_num ?>">
                                <button type="submit" class="btn-complete">Mark as Complete</button>
                            </form>
                        <?php else: ?>
                            <div style="margin-top: 15px; color: #dc3545; font-weight: 600;"><i class="fas fa-lock"></i> Enroll to mark as complete.</div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div style="margin-top: 15px; color: #16a34a; font-weight: 700;"><i class="fas fa-check-double"></i> MODULE FINISHED</div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <div class="button-row">
        <a href="course_details.php?course_id=<?= $course_id ?>" class="back-btn">← Back to Details</a>
        <a href="profile.php" class="profile-btn">Go to Profile →</a>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Scroll and Expand last module if redirected with anchor
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
            steps.forEach(s => { if (s !== step) s.classList.remove('active'); s.querySelector('.toggle-icon').textContent = '+'; });
            const isActive = step.classList.toggle('active');
            step.querySelector('.toggle-icon').textContent = isActive ? '×' : '+';
        });
    });
});
</script>
</body>
</html>