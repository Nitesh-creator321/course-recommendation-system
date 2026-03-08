<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized request.']);
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "course_recommender_db";

// Get data from the request
$user_id = $_SESSION['user_id'];
$course_id = $_POST['course_id'] ?? null;
$rating = $_POST['rating'] ?? null;

// Validate basic data requirements
if (!is_numeric($course_id) || !is_numeric($rating) || $rating < 1 || $rating > 5) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid rating data.']);
    exit;
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// 1. SECURITY CHECK: Verify user is enrolled AND course is 'completed'
// This matches your requirement that the rating only appears after 100% completion.
$stmt_check = $conn->prepare("SELECT enrollment_id FROM enrollments WHERE user_id = ? AND course_id = ? AND status = 'completed'");
$stmt_check->bind_param('ii', $user_id, $course_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows === 0) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'You must finish the course roadmap to 100% before rating.']);
    $stmt_check->close();
    $conn->close();
    exit;
}
$stmt_check->close();

// 2. UPDATE ACTION: Save the rating value to the enrollment record
$stmt_update = $conn->prepare("UPDATE enrollments SET rating = ? WHERE user_id = ? AND course_id = ?");
$stmt_update->bind_param('iii', $rating, $user_id, $course_id);

if ($stmt_update->execute()) {
    // Return success to the AJAX fetch call in profile.php
    echo "success"; 
} else {
    http_response_code(500);
    echo "Error updating database: " . $stmt_update->error;
}

$stmt_update->close();
$conn->close();
?>