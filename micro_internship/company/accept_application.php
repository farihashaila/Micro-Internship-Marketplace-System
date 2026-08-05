<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../config/db.php";

$app_id = $_GET["app_id"];

$appRes = mysqli_query($conn, "
    SELECT a.*, t.duration_days
    FROM applications a
    JOIN tasks t ON a.task_id = t.task_id
    WHERE a.application_id = $app_id
");

$app = mysqli_fetch_assoc($appRes);

$deadline = date("Y-m-d H:i:s", strtotime("+".$app["duration_days"]." days"));

mysqli_query($conn, "
    UPDATE applications
    SET status='Accepted',
        accepted_at=NOW(),
        deadline='$deadline'
    WHERE application_id=$app_id
");

header("Location: applications.php");
exit();
?>