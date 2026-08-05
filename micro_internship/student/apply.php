<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET["task_id"])) {
    die("Task ID missing.");
}

$user_id = $_SESSION["user_id"];
$task_id = $_GET["task_id"];

$studentRes = mysqli_query($conn, "SELECT student_id FROM students WHERE user_id=$user_id");
$student = mysqli_fetch_assoc($studentRes);
$student_id = $student["student_id"];

/* Only Open task can be applied */
$taskCheck = mysqli_query($conn, "
    SELECT * FROM tasks 
    WHERE task_id=$task_id 
    AND status='Open'
");

if (!$taskCheck || mysqli_num_rows($taskCheck) == 0) {
    die("This task is not open for application.");
}

/* Duplicate apply check */
$check = mysqli_query($conn, "
    SELECT * FROM applications 
    WHERE task_id=$task_id 
    AND student_id=$student_id
");

if (mysqli_num_rows($check) > 0) {
    header("Location: applications.php?msg=already");
    exit();
}

mysqli_query($conn, "
    INSERT INTO applications (task_id, student_id, status)
    VALUES ($task_id, $student_id, 'Pending')
");

header("Location: applications.php?msg=applied");
exit();
?>