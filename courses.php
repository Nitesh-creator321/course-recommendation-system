<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
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
    die("Connection failed: " . $conn->connect_error);
}

// Get user email & first letter
$user_email = $_SESSION['email'];
$first_letter = strtoupper(substr($user_email, 0, 1));

$interest = $_GET['interest'] ?? null;

// Interest mapping
$interest_mapping = [
    "Security" => ["Cybersecurity", "Ethical Hacking"],
    "Cloud Technology" => ["Cloud Computing"],
    "Database" => ["Database Management Systems"],
    "Blockchain" => ["Blockchain Technology"],
    "Networking" => ["Network Administration"],
    "Design" => ["UI/UX Design"],
    "Embedded Systems" => ["Internet of Things (IoT)"],
    "Data Science" => ["Big Data Analytics"],
    "Project Management" => ["Agile Project Management"],
    "Emerging Technology" => ["Augmented and Virtual Reality (AR/VR)"],
    "Development" => ["Development", "Software Development"],
    "Artificial Intelligence" => ["Machine Learning", "Artificial Intelligence", "Computer Vision"],
    "Computer Science" => ["Data Structures and Algorithms", "Operating Systems"]
];

$is_filter_active = ($interest && array_key_exists($interest, $interest_mapping));

if ($is_filter_active) {
    $stmt = $conn->prepare("SELECT * FROM courses WHERE category = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('s', $interest);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM courses");
}

$no_courses_message = "";
if ($result) {
    if ($is_filter_active && $result->num_rows === 0) {
        $no_courses_message = "<p class='no-courses-message'>No courses found for: " . htmlspecialchars($interest) . "</p>";
    } elseif (!$is_filter_active && $result->num_rows === 0) {
        $no_courses_message = "<p class='no-courses-message'>No courses available at this time.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Courses | Learning Platform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #3b82f6;
            --secondary: #10b981;
            --dark-glass: rgba(15, 23, 42, 0.8);
            --light-glass: rgba(255, 255, 255, 0.05);
            --border: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        body {
            background: url('images/Course_back_image.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            margin: 0;
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* Overlay for professional legibility */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at center, rgba(15, 23, 42, 0.7) 0%, rgba(15, 23, 42, 0.9) 100%);
            z-index: -1;
        }

        /* Navigation Bar Appearance */
        .user-container {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1.5rem 3rem;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 1.5rem;
            background: rgba(15, 23, 42, 0.3);
            backdrop-filter: blur(10px);
            z-index: 1000;
            box-sizing: border-box;
            border-bottom: 1px solid var(--border);
        }

        .user-icon {
            background: linear-gradient(135deg, var(--primary), #6366f1);
            color: #fff;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transition: 0.3s;
        }

        .logout-btn {
            background: var(--light-glass);
            color: #fff;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            border: 1px solid var(--border);
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: #ef4444;
        }

        /* Hero Header */
        .header-container {
            text-align: center;
            padding: 180px 20px 60px;
        }

        #course-title {
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: -0.05em;
            margin-bottom: 1.5rem;
            background: linear-gradient(to bottom, #fff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Filter Controls */
        .filter-buttons-wrapper {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .filter-btn, .filter-btn-clear {
            padding: 0.8rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .filter-btn {
            background: var(--primary);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .filter-btn-clear {
            background: var(--light-glass);
            color: var(--text-main);
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
        }

        /* Dropdown Box */
        .filter-dropdown form {
            background: var(--dark-glass);
            backdrop-filter: blur(15px);
            padding: 1.5rem;
            border-radius: 16px;
            border: 1px solid var(--border);
            margin: 2rem auto;
            max-width: 500px;
            display: flex;
            gap: 0.8rem;
        }

        select {
            flex: 1;
            background: #0f172a;
            color: white;
            border: 1px solid var(--border);
            padding: 0.8rem;
            border-radius: 8px;
            outline: none;
        }

        /* Course Grid Layout */
        .courses-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2.5rem;
            padding: 0 4rem 100px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .course-card {
            background: var(--light-glass);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 1.5rem;
            transition: 0.4s ease;
            display: flex;
            flex-direction: column;
        }

        .course-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary);
        }

        .course-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 14px;
            margin-bottom: 1.2rem;
        }

        .course-card h3 {
            font-size: 1.4rem;
            margin: 0.5rem 0;
            color: #fff;
        }

        .course-card p {
            font-size: 0.95rem;
            color: var(--text-dim);
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .enroll-btn {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
            padding: 0.8rem;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .enroll-btn:hover {
            background: var(--primary);
            color: #fff;
        }

        /* Professional Footer */
        .cw-footer {
            background: #020617;
            padding: 60px 20px;
            text-align: center;
            border-top: 1px solid var(--border);
        }

        .cw-footer h2 {
            color: #fff;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .tagline { color: var(--text-dim); margin-bottom: 2rem; }

        .cw-socials { display: flex; justify-content: center; gap: 2rem; margin-bottom: 2rem; }
        .cw-socials svg { width: 22px; fill: var(--text-dim); transition: 0.3s; }
        .cw-socials a:hover svg { fill: var(--primary); transform: translateY(-3px); }

        @media (max-width: 768px) {
            #course-title { font-size: 2.2rem; }
            .courses-container { padding: 0 20px 60px; }
            .user-container { padding: 1rem 1.5rem; }
        }
    </style>
</head>
<body>

<div class="user-container">
    <a href="profile.php" class="user-icon" title="<?php echo htmlspecialchars($user_email); ?>">
        <?php echo htmlspecialchars($first_letter); ?>
    </a>
    <a href="logout.php" class="logout-btn">Sign Out</a>
</div>

<div class="header-container">
    <h2 id="course-title">
        <?php echo $is_filter_active ? htmlspecialchars($interest) . " Programs" : "Elevate Your Career"; ?>
    </h2>
    <div class="filter-buttons-wrapper">
        <button class="filter-btn" onclick="toggleDropdown()"><i class="fas fa-filter mr-2"></i> Categories</button>
        <?php if ($is_filter_active): ?>
            <a href="?" class="filter-btn-clear">Reset View</a>
        <?php endif; ?>
    </div>
    
    <div class="filter-dropdown" id="filterDropdown" style="display: none;">
        <form method="GET" action="">
            <select name="interest" required>
                <option value="">Choose a path...</option>
                <?php foreach ($interest_mapping as $key => $value): ?>
                    <option value="<?php echo htmlspecialchars($key); ?>" <?php if ($interest === $key) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($key); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="filter-btn">Apply</button>
        </form>
    </div>
</div>

<div class="courses-container">
    <?php
    if (!empty($no_courses_message)) {
        echo "<div style='grid-column: 1/-1; text-align: center; padding: 4rem;'>" . $no_courses_message . "</div>";
    } elseif ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
        <div class="course-card">
            <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Course">
            <span style="font-size: 0.75rem; color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                <?php echo htmlspecialchars($row['category']); ?>
            </span>
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars(substr($row['short_intro'], 0, 120))); ?>...</p>
            <a href="course_details.php?course_id=<?php echo htmlspecialchars($row['course_id']); ?>" class="enroll-btn">Explore Course</a>
        </div>
    <?php
        }
    }
    if ($conn) { $conn->close(); }
    ?>
</div>

<footer class="cw-footer">
    <h2>Learning Reimagined</h2>
    <p class="tagline">Providing intelligent guidance for modern education.</p>
    <div class="cw-socials">
        <a href="#"><i class="fab fa-github"></i></a>
        <a href="#"><i class="fab fa-linkedin"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
    </div>
    <small style="color: #475569;">&copy; 2026 Course Recommendation System. Developed for Excellence.</small>
</footer>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('filterDropdown');
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }
</script>
</body>
</html>