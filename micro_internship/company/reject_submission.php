<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "company") {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET["sub_id"])) {
    die("Submission ID missing.");
}

$sub_id = $_GET["sub_id"];

$res = mysqli_query($conn, "
    SELECT sub.application_id, a.task_id
    FROM submissions sub
    JOIN applications a ON sub.application_id = a.application_id
    WHERE sub.submission_id = $sub_id
");

if (!$res || mysqli_num_rows($res) == 0) {
    die("Submission not found.");
}

$data = mysqli_fetch_assoc($res);
$app_id = $data["application_id"];
$task_id = $data["task_id"];

mysqli_query($conn, "UPDATE submissions SET status='Rejected' WHERE submission_id=$sub_id");

mysqli_query($conn, "UPDATE applications SET status='Rejected' WHERE application_id=$app_id");

mysqli_query($conn, "UPDATE tasks SET status='Open' WHERE task_id=$task_id");

header("Location: submissions.php");
exit();
?>