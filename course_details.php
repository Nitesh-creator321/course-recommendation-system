<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Enable error reporting for development (disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB connection
$servername = "localhost";
$username = "root";
$password = ""; // <--- YOUR DB PASSWORD IF ANY
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
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $course_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Course not found.");
}
$course = $res->fetch_assoc();
$stmt->close();

// --- Check if user is already enrolled in this course ---
$user_id = $_SESSION['user_id'];
$is_enrolled = false;
$stmt_check_enrollment = $conn->prepare("SELECT enrollment_id FROM enrollments WHERE user_id = ? AND course_id = ?");
if ($stmt_check_enrollment === false) {
    die("Prepare failed (check enrollment): " . $conn->error);
}
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
    <title><?= htmlspecialchars($course['course_name'] ?? $course['name'] ?? 'Course') ?> – Course Details</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.7.40/css/intlTelInput.css"/>

    <style>
        :root {
            --pri: #007bff;
            --pri-dark: #0056b3;
            --radius: 16px;
            --shadow-subtle: rgba(0, 0, 0, 0.08);
        }

        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f4f4f4 url('images/coursebackground.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 40px 50px;
        }

        .course-details {
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: var(--radius);
            max-width: 800px;
            margin: auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: #fff;
            text-align: center;
        }

        .course-details img {
            max-width: 100%;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .course-details h1 {
            font-size: 32px;
            margin-bottom: 15px;
            font-weight: 600;
            color: #fff;
        }

        .course-details p {
            font-size: 16px;
            margin-bottom: 10px;
            text-align: left;
        }

        .btn-row {
            margin-top: 30px;
            text-align: center;
        }

        .back-btn, .enroll-btn, .enrolled-btn {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s ease-in-out;
        }

        .back-btn {
            background-color: #6c757d;
            color: #fff;
        }

        .back-btn:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px var(--shadow-subtle);
        }

        .enroll-btn {
            background-color: var(--pri);
            color: #fff;
            cursor: pointer;
            border: none;
        }

        .enroll-btn:hover {
            background-color: var(--pri-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px var(--shadow-subtle);
        }

        .enrolled-btn {
            background-color: #28a745;
            color: #fff;
            cursor: default;
            opacity: 0.8;
            border: none;
        }
        
        /* Modal Styles */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .75);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 200;
            opacity: 0;
            pointer-events: none;
            transition: .4s ease-out;
        }

        .modal.show {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-card {
            background: #fff;
            width: min(90vw, 480px);
            padding: 35px;
            border-radius: var(--radius);
            box-shadow: 0 15px 40px rgba(0,0,0,0.25);
            max-height: 90vh;
            overflow: auto;
            animation: pop .5s ease forwards;
            color: #333;
        }

        @keyframes pop {
            from { transform: scale(.9); opacity: .6; }
            to { transform: scale(1); opacity: 1; }
        }
        
        .fg {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
            text-align: left;
        }

        .fg label {
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .fg input, .fg textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 100%;
        }

        .submit {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: var(--pri);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit:hover {
            background-color: var(--pri-dark);
        }

        .close-x {
            position: absolute;
            top: 18px;
            right: 18px;
            font-size: 30px;
            cursor: pointer;
            color: #aaa;
            background: none;
            border: none;
        }

        .close-x:hover {
            color: #555;
            transform: rotate(90deg);
        }
    </style>
</head>
<body>

<div class="course-details" id="card">
    <h1><?= htmlspecialchars($course['course_name'] ?? $course['name'] ?? 'N/A') ?></h1>

    <img src="<?= htmlspecialchars($course['image_path'] ?? 'path/to/default_image.jpg') ?>" alt="Course Image">
    <p><strong>Category:</strong> <?= htmlspecialchars($course['category'] ?? 'N/A') ?></p>
    <p><strong>Duration:</strong> <?= htmlspecialchars($course['duration'] ?? 'N/A') ?></p>
    <p><strong>Instructor:</strong> <?= htmlspecialchars($course['Instructor_name'] ?? 'N/A') ?></p>
    <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($course['description'] ?? 'No description available.')) ?></p>

    <div class="btn-row">
        <a href="courses.php" class="back-btn">← Back to courses</a>

        <?php if ($is_enrolled): ?>
            <span class="enrolled-btn">Already Enrolled</span>
            <a href="my_courses.php" class="enroll-btn" style="background-color: #3498db;">Go to My Courses</a>
        <?php else: ?>
            <a href="#" class="enroll-btn" id="enrollBtn">Enroll Now</a>
        <?php endif; ?>

        <?php 
        if (!empty($course_id)): ?>
            <a href="roadmap.php?course_id=<?= urlencode($course_id) ?>" 
                class="enroll-btn" style="background-color: #6f42c1;">
                View Roadmap
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if (!$is_enrolled): ?>
<div class="modal" id="enrollModal">
    <div class="modal-card">
        <button class="close-x" id="closeX">&times;</button>
        <h2>Enrolling for <?= htmlspecialchars($course['course_name'] ?? $course['name'] ?? 'this course') ?></h2>

        <form action="enroll_course.php" method="POST" autocomplete="off">
            <input type="hidden" name="course_id" value="<?= htmlspecialchars($course_id) ?>">
            <div class="fg"><label for="first_name">First Name</label><input type="text" id="first_name" name="first_name" required></div>
            <div class="fg"><label for="last_name">Last Name</label><input type="text" id="last_name" name="last_name" required></div>
            <div class="fg"><label for="phone">Phone Number</label><input type="tel" id="phone" name="phone" required></div>
            <div class="fg"><label for="school_college_company_name">School / College / Company Name</label><input type="text" id="school_college_company_name" name="school_college_company_name" required></div>
            <div class="fg"><label for="email">Email</label><input type="email" id="email" name="email" required></div>
            <div class="fg"><label for="address">Address</label><textarea id="address" name="address" rows="3" required></textarea></div>
            <div class="fg"><label for="pincode">Pincode</label><input type="text" id="pincode" name="pincode" required></div>
            <div class="fg"><label for="referral">Referral Code</label><input type="text" id="referral" name="referral"></div>
            <button class="submit" type="submit">Submit Enrollment</button>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
<?php if (!$is_enrolled): ?>
const modal = document.getElementById('enrollModal');
const openBtn = document.getElementById('enrollBtn');
const closeX = document.getElementById('closeX');
if (openBtn) openBtn.onclick = e => { e.preventDefault(); modal.classList.add('show'); };
if (closeX) closeX.onclick = () => modal.classList.remove('show');
window.onclick = e => { if (e.target === modal) modal.classList.remove('show'); };
<?php endif; ?>
</script>

</body>
</html>