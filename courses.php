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
$password = ""; // <--- IMPORTANT: SET YOUR DATABASE ROOT PASSWORD HERE
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

// This boolean flag will determine if a valid filter is active
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
        $no_courses_message = "<p class='no-courses-message'>No courses found for the selected interest: " . htmlspecialchars($interest) . "</p>";
    } elseif (!$is_filter_active && $result->num_rows === 0) {
        $no_courses_message = "<p class='no-courses-message'>There are currently no courses available.</p>";
    }
} else {
    $no_courses_message = "<p class='no-courses-message error'>Error retrieving course data.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Courses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /*
         * Professional CSS Refactor for Course Page
         * ----------------------------------------
         * This style sheet provides a cleaner, more professional look
         * by using a consistent color palette, improved spacing,
         * and a more refined design language. It maintains the
         * original layout and functionality.
         */

        /* === General Styles & Variables === */
        :root {
            --background-dark: #0f172a; /* Slate background */
            --surface-card: rgba(30, 41, 59, 0.7); /* Dark semi-transparent card background */
            --text-light: #e2e8f0; /* Off-white text for dark backgrounds */
            --text-muted: #94a3b8; /* Muted text for descriptions */
            --primary-accent: #3b82f6; /* A clean, professional blue */
            --secondary-accent: #10b981; /* A friendly green for actions */
            --border-subtle: rgba(226, 232, 240, 0.1);
            --shadow-subtle: rgba(0, 0, 0, 0.2);
            --shadow-strong: rgba(0, 0, 0, 0.4);
            --font-poppins: 'Poppins', Arial, sans-serif;
        }

        body {
            background-color: var(--background-dark);
            font-family: var(--font-poppins);
            color: var(--text-light);
            margin: 0;
            line-height: 1.6;
            background-image: url('images/Course_back_image.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.85);
            z-index: -1;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 20px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .user-container {
            position: absolute;
            top: 25px;
            right: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            z-index: 100;
            animation: fadeIn 1s ease-out forwards;
        }

        .user-icon {
            background: linear-gradient(135deg, var(--secondary-accent), #34d399);
            color: white;
            font-weight: 600;
            font-size: 20px;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 4px 15px var(--shadow-strong);
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        .user-icon:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px var(--shadow-strong);
        }

        .user-icon::before {
            content: '';
            position: absolute;
            border-radius: 50%;
            animation: pulse 2s infinite;
            z-index: -1;
        }

        .logout-btn {
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            padding: 10px 22px;
            color: white;
            background: var(--primary-accent);
            border: none;
            border-radius: 9999px;
            box-shadow: 0 3px 10px var(--shadow-subtle);
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        }

        .logout-btn:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px var(--shadow-strong);
        }

        .header-container {
            text-align: center;
            margin: 100px auto 40px;
            animation: slideInUp 1s ease-out forwards;
            opacity: 0;
        }

        #course-title {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(90deg, #64748b, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            padding: 10px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        }

        .filter-buttons-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-top: 30px;
            animation: fadeIn 1.5s ease-out forwards;
            animation-delay: 0.5s;
            opacity: 0;
        }
        /* Shared styling for both filter buttons to ensure equal size */
.filter-btn, .filter-btn-clear {
    display: inline-flex; /* Use flex to center text regardless of element type */
    justify-content: center;
    align-items: center;
    width: 200px; /* Fixed equal width */
    height: 55px; /* Fixed equal height */
    font-size: 18px;
    font-weight: 600;
    color: white;
    background: var(--primary-accent);
    border: none;
    border-radius: 9999px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    text-decoration: none; /* Important for the <a> tag */
    box-shadow: 0 4px 10px var(--shadow-subtle);
    box-sizing: border-box;
}

.filter-btn:hover, .filter-btn-clear:hover {
    background: #2563eb;
    transform: translateY(-2px);
    color: white; /* Ensures text remains white for <a> tags */
}

        .filter-dropdown {
            display: none;
            margin-top: 20px;
            text-align: center;
            animation: fadeIn 1s ease-out forwards;
            animation-delay: 0.8s;
            opacity: 0;
        }

        .filter-dropdown form {
            display: inline-flex;
            gap: 15px;
            align-items: center;
            background: var(--surface-card);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 15px;
            border: 1px solid var(--border-subtle);
            box-shadow: 0 5px 20px var(--shadow-strong);
        }

        .filter-dropdown select, .filter-dropdown button {
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid var(--border-subtle);
        }

        .filter-dropdown select {
            background-color: rgba(0, 0, 0, 0.2);
            color: var(--text-light);
            appearance: none;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23e2e8f0%22%20d%3D%22M287%20197.6l-14.2%2014.2-128.8-128.8-128.8%20128.8-14.2-14.2L144%2068.8z%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
        }

        .filter-dropdown option {
            background-color: var(--background-dark);
            color: var(--text-light);
        }

        .filter-dropdown button {
            background: var(--secondary-accent);
            color: var(--background-dark);
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .filter-dropdown button:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        /* === Course Cards Grid === */
        .courses-container {
            display: grid;
            grid-template-columns: repeat(4, minmax(300px, 1fr));
            gap: 30px;
            padding: 40px;
            justify-content: center;
            min-height: 30vh; /* Ensure the container has a minimum height */
            align-items: center; /* Center content vertically */
        }
        
        /* New style for when there are no courses to display */
        .courses-container:has(> .no-courses-message) {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        
        .no-courses-message {
            text-align: center;
            color: var(--text-light);
            font-size: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
            font-weight: 600;
            margin: auto; /* Center the message */
        }
        
        .no-courses-message.error {
            color: #e74c3c;
        }

        .course-card {
            padding: 20px;
            border-radius: 15px;
            background: var(--surface-card);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-subtle);
            box-shadow: 0 8px 30px var(--shadow-strong);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            text-align: center;
            animation: slideInUp 0.8s ease-out forwards;
            opacity: 0;
            animation-delay: calc(0.1s * var(--card-index));
            position: relative;
            overflow: hidden;
        }

        .course-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 12px 40px var(--shadow-strong);
        }

        .course-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px var(--shadow-subtle);
        }

        .course-card h3 {
            font-size: 1.5rem;
            margin: 0 0 10px;
            font-weight: 700;
            color: white;
        }

        .course-card p {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .course-card p strong {
            color: var(--text-light);
        }

        .enroll-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background: var(--secondary-accent);
            color: var(--background-dark);
            border: none;
            border-radius: 9999px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 10px var(--shadow-subtle);
        }

        .enroll-btn:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .cw-footer {
            text-align: center;
            padding: 40px 20px 20px;
            background: rgba(226, 232, 240, 0.95);
            color: var(--background-dark);
            margin-top: 60px;
            border-top: 4px solid var(--primary-accent);
            box-shadow: 0 -4px 15px var(--shadow-strong);
        }

        .cw-footer__logo {
            width: 40px;
            margin: 0 auto 10px;
            display: block;
            fill: #4a5568;
        }

        .cw-footer h2 {
            margin: 0 0 5px;
            font-size: 1.8rem;
            font-weight: 800;
            color: #4a5568;
        }

        .cw-footer p.tagline {
            margin: 0 0 20px;
            font-size: 15px;
            color: #718096;
        }

        .cw-socials {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-bottom: 25px;
        }

        .cw-socials a svg {
            width: 28px;
            height: 28px;
            fill: #718096;
            transition: fill .25s, transform .25s;
        }

        .cw-socials a:hover svg {
            transform: translateY(-2px) scale(1.1);
        }

        .cw-socials a:nth-child(1) svg:hover { fill: #6e5494; }
        .cw-socials a:nth-child(2) svg:hover { fill: #0077b5; }
        .cw-socials a:nth-child(3) svg:hover { fill: #1DA1F2; }

        .cw-footer small {
            display: block;
            margin-top: 5px;
            font-size: 13px;
            color: #94a3b8;
        }

        .cw-footer a {
            color: var(--primary-accent);
            text-decoration: none;
            font-weight: 600;
        }

        .cw-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 1024px) {
            .courses-container {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .user-container {
                flex-direction: column;
                top: 20px;
                right: 20px;
                gap: 10px;
            }
            .logout-btn {
                font-size: 14px;
                padding: 8px 16px;
            }
            #course-title {
                font-size: 2.5rem;
            }
            .courses-container {
                padding: 20px;
                grid-template-columns: 1fr;
            }
            .filter-dropdown form {
                flex-direction: column;
                gap: 10px;
                padding: 15px;
            }
            .filter-dropdown select, .filter-dropdown button {
                width: 100%;
            }
        }
    </style>
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('filterDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const courseCards = document.querySelectorAll('.course-card');
            courseCards.forEach((card, index) => {
                card.style.setProperty('--card-index', index);
            });
        });
    </script>
</head>
<body>

<div class="user-container">
    <a href="profile.php" class="user-icon" title="<?php echo htmlspecialchars($user_email); ?>">
        <?php echo htmlspecialchars($first_letter); ?>
    </a>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<div class="header-container">
    <h2 id="course-title">
        <?php
        if ($is_filter_active) {
            echo htmlspecialchars($interest) . " Courses";
        } else {
            echo "Discover Your Next Course";
        }
        ?>
    </h2>
    <div class="filter-buttons-wrapper">
        <button class="filter-btn" onclick="toggleDropdown()">Filter</button>
        <?php if ($is_filter_active): ?>
            <a href="?" class="filter-btn-clear">Clear Filter</a>
        <?php endif; ?>
    </div>
    <div class="filter-dropdown" id="filterDropdown" style="display: none;">
        <form method="GET" action="">
            <select name="interest" required>
                <option value="">Select Interest</option>
                <?php foreach ($interest_mapping as $key => $value): ?>
                    <option value="<?php echo htmlspecialchars($key); ?>" <?php if ($interest === $key) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($key); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Apply Filter</button>
        </form>
    </div>
</div>
<div class="courses-container">
    <?php
    if (!empty($no_courses_message)) {
        echo $no_courses_message;
    } elseif ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
        <div class="course-card">
            <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Course Image">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></p>
            <p><?php echo nl2br(htmlspecialchars($row['short_intro'])); ?></p>
            <a href="course_details.php?course_id=<?php echo htmlspecialchars($row['course_id']); ?>" class="enroll-btn">Explore Now</a>
        </div>
    <?php
        }
    }
    if ($conn) { $conn->close(); }
    ?>
</div>

<footer class="cw-footer">
    <svg class="cw-footer__logo" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M4 3h8a3 3 0 0 1 3 3v14a3 3 0 0 0-3-3H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm8 0h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-8a3 3 0 0 0-3 3V6a3 3 0 0 1 3-3ZM8 7h4v2H8V7Zm0 4h4v2H8v-2Z"/>
    </svg>

    <h2>Intelligent Course Recommendation System</h2>
    <p class="tagline">Your intelligent guide to learning.</p>

    <div class="cw-socials">
        <a href="https://github.com/your-repo" aria-label="GitHub">
        <svg viewBox="0 0 24 24"><path d="M12 .5a12 12 0 0 0-3.79 23.4c.6.11.82-.26.82-.58v-2.04c-3.34.73-4.04-1.6-4.04-1.6-.55-1.4-1.34-1.77-1.34-1.77-1.1-.75.08-.73.08-.73 1.22.09 1.86 1.25 1.86 1.25 1.08 1.84 2.83 1.31 3.52 1 .11-.78.42-1.31.76-1.61-2.66-.3-5.47-1.33-5.47-5.9 0-1.3.47-2.36 1.24-3.19-.12-.3-.54-1.52.12-3.16 0 0 1-.32 3.31 1.23A11.5 11.5 0 0 1 12 6.8a11.5 11.5 0 0 1 3.02.41c2.3-1.55 3.3-1.23 3.3-1.23.66 1.64.24 2.86.12 3.16.77.83 1.23 1.9 1.23 3.2 0 4.59-2.82 5.6-5.5 5.89.43.37.82 1.09.82 2.2v3.26c0 .32.21.7.82.58A12 12 0 0 0 12 .5Z"/></svg>
        </a>
        <a href="https://linkedin.com/in/your-profile" aria-label="LinkedIn">
        <svg viewBox="0 0 24 24"><path d="M4.98 3.5A2.5 2.5 0 1 1 5 8.5a2.5 2.5 0 0 1 0-5Zm.02 5.75H2V22h3V9.25Zm7.25 0H11V22h3v-6.5c0-1.72 2-1.86 2 0V22h3v-7.79c0-4.6-5.25-4.43-6.75-2.16v-2.8Z"/></svg>
        </a>
        <a href="https://twitter.com/your-handle" aria-label="Twitter">
        <svg viewBox="0 0 24 24"><path d="M23 2.94a9.6 9.6 0 0 1-2.83.78A4.93 4.93 0 0 0 22.39.37a9.8 9.8 0 0 1-3.13 1.2A4.9 4.9 0 0 0 16.2 0c-2.73 0-4.95 2.23-4.95 4.97 0 .39.04.77.12 1.13A13.94 13.94 0 0 1 1.64.88a4.97 4.97 0 0 0-.67 2.5 5 5 0 0 0 2.2 4.14 4.8 4.8 0 0 1-2.24-.62v.07c0 2.4 1.7 4.4 3.95 4.86-.41.11-.85.17-1.3.17-.32 0-.63-.03-.93-.09.64 2 2.5 3.46 4.7 3.5A9.86 9.86 0 0 1 0 19.54a13.88 13.88 0 0 0 7.55 2.22c9.06 0 14.01-7.55 14.01-14.09 0-.21 0-.42-.01-.63A10.07 10.07 0 0 0 23 2.94Z"/></svg>
        </a>
    </div>

    <small>© 2025 Intelligent Course Recommendation System. All rights reserved.</small>
    <small>Built by <a href="#">Nitesh - K Manoj - Mahalakshmi</a>.</small>
</footer>

</body>
</html>
