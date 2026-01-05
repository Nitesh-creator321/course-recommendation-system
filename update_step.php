<?php
session_start();
if (!isset($_SESSION['user_id'])) { exit; }
$conn = new mysqli("localhost", "root", "", "course_recommender_db");
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = intval($_POST['course_id']);
    $step_number = intval($_POST['step_number']);

    // 1. Enrollment Check
    $enroll_check = $conn->prepare("SELECT enrollment_id FROM enrollments WHERE user_id = ? AND course_id = ?");
    $enroll_check->bind_param("ii", $user_id, $course_id);
    $enroll_check->execute();
    if ($enroll_check->get_result()->num_rows == 0) { die("Not enrolled."); }

    // 2. Insert into user progress table (individual tracking)
    $stmt = $conn->prepare("INSERT IGNORE INTO user_roadmap_progress (user_id, course_id, step_number) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $user_id, $course_id, $step_number);
    
    if ($stmt->execute()) {
        // 3. Check for 100% completion to update enrollment status
        $total_q = $conn->prepare("SELECT COUNT(*) as t FROM roadmaps WHERE course_id = ?");
        $total_q->bind_param("i", $course_id);
        $total_q->execute();
        $total = $total_q->get_result()->fetch_assoc()['t'];

        $done_q = $conn->prepare("SELECT COUNT(*) as d FROM user_roadmap_progress WHERE user_id = ? AND course_id = ?");
        $done_q->bind_param("ii", $user_id, $course_id);
        $done_q->execute();
        $done = $done_q->get_result()->fetch_assoc()['d'];

        if ($done >= $total) {
            $upd = $conn->prepare("UPDATE enrollments SET status = 'completed' WHERE user_id = ? AND course_id = ?");
            $upd->bind_param("ii", $user_id, $course_id);
            $upd->execute();
        }

        // Redirect with hash for scrolling
        header("Location: roadmap.php?course_id=$course_id#step-$step_number");
        exit;
    }
}
$conn->close();
?>