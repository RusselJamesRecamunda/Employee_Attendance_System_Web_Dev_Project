<?php
session_start();

if (isset($_SESSION['name'])) {
    try {
        // Establishing connection with the database
        include('connect.php');

        // Set the timezone to Manila time
        date_default_timezone_set('Asia/Manila');

        // Retrieve user_id from session
        $user_id = $_SESSION['name'];

        // Record logout information in log_report table
        $logout_date = date("Y-m-d");
        $logout_time = date("H:i:s");
        $status = "Logout";

        // Update log_report table with logout information
        $updateStmt = $conn->prepare("UPDATE log_report SET logout_date=?, logout_time=?, status=? WHERE user_id=? AND status='Login' ORDER BY log_id DESC LIMIT 1");
        $updateStmt->bind_param("sssi", $logout_date, $logout_time, $status, $user_id);
        $updateStmt->execute();

        // Destroy the session
        session_destroy();

        header('location: login.php');
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
} else {
    // If session is not set, redirect to login page
    header('location: login.php');
}
?>
