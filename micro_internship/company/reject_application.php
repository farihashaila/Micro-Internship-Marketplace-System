<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "company") {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET["app_id"])) {
    die("Application ID missing.");
}

$app_id = intval($_GET["app_id"]);

mysqli_query($conn, "
    UPDATE applications
    SET status='Rejected'
    WHERE application_id=$app_id
    AND status='Pending'
");

header("Location: applications.php");
exit();
?>