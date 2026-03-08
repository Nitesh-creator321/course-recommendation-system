<?php
session_start();

// Ensure user is logged in
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

// Get course_id from URL
$course_id = $_GET['course_id'] ?? null;
if (!$course_id) {
    die("Error: No course ID provided.");
}

// Fetch course details
$stmt = $conn->prepare("SELECT * FROM courses WHERE course_id=?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Course not found.");
}
$course = $res->fetch_assoc();
$stmt->close();

$user_id = $_SESSION['user_id'];
$is_enrolled = false;
$stmt_check_enrollment = $conn->prepare("SELECT enrollment_id FROM enrollments WHERE user_id = ? AND course_id = ?");
$stmt_check_enrollment->bind_param('ii', $user_id, $course_id);
$stmt_check_enrollment->execute();
$result_check_enrollment = $stmt_check_enrollment->get_result();
if ($result_check_enrollment->num_rows > 0) {
    $is_enrolled = true;
}
$stmt_check_enrollment->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($course['course_name'] ?? $course['name'] ?? 'Course') ?> – Details</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* === PREVIOUS STYLES KEPT SAME === */
        :root {
            --primary: #3b82f6;
            --success: #10b981;
            --purple: #8b5cf6;
            --bg-glass: rgba(15, 23, 42, 0.75);
            --border: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        body {
            background: url('images/coursebackground.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 60px 20px;
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.85);
            z-index: -1;
        }

        .course-details {
            background: var(--bg-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 40px;
            border-radius: 24px;
            max-width: 900px;
            margin: auto;
            border: 1px solid var(--border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .header-area { text-align: center; margin-bottom: 35px; }
        .course-details h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0 0 10px;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .badge-container { display: flex; justify-content: center; gap: 15px; margin-bottom: 25px; }
        .badge {
            background: rgba(255,255,255,0.05);
            padding: 6px 16px;
            border-radius: 99px;
            font-size: 0.85rem;
            font-weight: 500;
            border: 1px solid var(--border);
            color: var(--primary);
        }

        .course-details img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 18px;
            margin-bottom: 30px;
            border: 1px solid var(--border);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
            text-align: left;
        }

        .info-item strong {
            display: block;
            color: var(--text-dim);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .description-box {
            text-align: left;
            background: rgba(255, 255, 255, 0.03);
            padding: 25px;
            border-radius: 16px;
            border: 1px solid var(--border);
            margin-bottom: 35px;
        }

        .btn-row { display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; }
        .action-btn {
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            border: none;
            cursor: pointer;
        }

        .back-btn { background: #334155; color: #fff; }
        .enroll-btn { background: var(--primary); color: #fff; }
        .roadmap-btn { background: var(--purple); color: #fff; }
        .enrolled-btn { background: var(--success); color: #fff; opacity: 0.9; cursor: default; }

        .action-btn:hover:not(.enrolled-btn) {
            transform: translateY(-3px);
            filter: brightness(1.1);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.3);
        }

        /* === NEW UPDATED MODAL & FORM STYLING === */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(2, 6, 23, 0.9);
            backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            pointer-events: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal.show { opacity: 1; pointer-events: auto; }

        .modal-card {
            background: #1e293b;
            width: min(95vw, 600px);
            padding: 40px;
            border-radius: 28px;
            position: relative;
            border: 1px solid var(--border);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.5);
            transform: translateY(20px);
            transition: transform 0.4s ease;
        }

        .modal.show .modal-card { transform: translateY(0); }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .full-width { grid-column: span 2; }

        .fg {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .fg label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dim);
            margin-left: 4px;
        }

        .fg input, .fg textarea {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--border);
            padding: 12px 16px;
            border-radius: 12px;
            color: #fff;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s ease;
            width: 100%;
            box-sizing: border-box;
        }

        .fg input:focus, .fg textarea:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(15, 23, 42, 0.9);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .fg textarea { resize: none; }

        .submit-enroll {
            grid-column: span 2;
            background: var(--primary);
            color: white;
            padding: 16px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .submit-enroll:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }

        .close-x {
            position: absolute;
            top: 25px;
            right: 25px;
            background: rgba(255,255,255,0.05);
            border: none;
            color: var(--text-dim);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .close-x:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
            .submit-enroll { grid-column: span 1; }
            .modal-card { padding: 30px 20px; }
        }
    </style>
</head>
<body>

<div class="course-details">
    <div class="header-area">
        <h1><?= htmlspecialchars($course['course_name'] ?? $course['name'] ?? 'N/A') ?></h1>
        <div class="badge-container">
            <span class="badge"><?= htmlspecialchars($course['category'] ?? 'General') ?></span>
            <span class="badge" style="color: var(--success);"><i class="far fa-clock"></i> <?= htmlspecialchars($course['duration'] ?? 'Self-paced') ?></span>
        </div>
    </div>

    <img src="<?= htmlspecialchars($course['image_path'] ?? 'path/to/default_image.jpg') ?>" alt="Course Header">
    
    <div class="info-grid">
        <div class="info-item">
            <strong>Lead Instructor</strong>
            <span><i class="fas fa-user-tie"></i> <?= htmlspecialchars($course['Instructor_name'] ?? 'Industry Expert') ?></span>
        </div>
        <div class="info-item">
            <strong>Learning Level</strong>
            <span>Professional Certification</span>
        </div>
    </div>

    <div class="description-box">
        <h3>About this course</h3>
        <p><?= nl2br(htmlspecialchars($course['description'] ?? 'No description available.')) ?></p>
    </div>

    <div class="btn-row">
        <a href="courses.php" class="action-btn back-btn"><i class="fas fa-arrow-left"></i> Back</a>

        <?php if ($is_enrolled): ?>
            <span class="action-btn enrolled-btn"><i class="fas fa-check-circle"></i> Enrolled</span>
            <a href="my_courses.php" class="action-btn" style="background: rgba(59, 130, 246, 0.2); color: var(--primary); border: 1px solid var(--primary);">Go to Classroom</a>
        <?php else: ?>
            <button class="action-btn enroll-btn" id="enrollBtn">Enroll Now <i class="fas fa-bolt"></i></button>
        <?php endif; ?>

        <?php if (!empty($course_id)): ?>
            <a href="roadmap.php?course_id=<?= urlencode($course_id) ?>" class="action-btn roadmap-btn">
                <i class="fas fa-map-signs"></i> Curriculum Roadmap
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if (!$is_enrolled): ?>
<div class="modal" id="enrollModal">
    <div class="modal-card">
        <button class="close-x" id="closeX"><i class="fas fa-times"></i></button>
        <h2 style="margin:0 0 5px; font-weight: 800;">Course Enrollment</h2>
        <p style="color: var(--text-dim); margin-bottom: 30px; font-size: 0.9rem;">Fill in the details below to start your learning journey.</p>

        <form action="enroll_course.php" method="POST" autocomplete="off" class="form-grid">
            <input type="hidden" name="course_id" value="<?= htmlspecialchars($course_id) ?>">
            
            <div class="fg"><label>First Name</label><input type="text" name="first_name" placeholder="John" required></div>
            <div class="fg"><label>Last Name</label><input type="text" name="last_name" placeholder="Doe" required></div>

            <div class="fg full-width"><label>School / College / Company</label><input type="text" name="school_college_company_name" placeholder="Enter institution name" required></div>
            
            <div class="fg"><label>Email Address</label><input type="email" name="email" placeholder="john@example.com" required></div>
            <div class="fg"><label>Phone Number</label><input type="tel" name="phone" placeholder="+91 XXXXX XXXXX" required></div>

            <div class="fg full-width"><label>Postal Address</label><textarea name="address" rows="2" placeholder="Enter your full address" required></textarea></div>
            
            <div class="fg"><label>Pincode</label><input type="text" name="pincode" placeholder="600001" required></div>
            <div class="fg"><label>Referral (Optional)</label><input type="text" name="referral" placeholder="CODE123"></div>

            <button class="submit-enroll" type="submit">Complete Registration</button>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
<?php if (!$is_enrolled): ?>
const modal = document.getElementById('enrollModal');
const openBtn = document.getElementById('enrollBtn');
const closeX = document.getElementById('closeX');

if (openBtn) openBtn.onclick = e => { 
    e.preventDefault(); 
    modal.classList.add('show'); 
};
if (closeX) closeX.onclick = () => modal.classList.remove('show');
window.onclick = e => { if (e.target === modal) modal.classList.remove('show'); };
<?php endif; ?>
</script>

</body>
</html>s