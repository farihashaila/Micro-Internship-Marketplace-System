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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $extra_days = $_POST["extra_days"];
    $feedback = mysqli_real_escape_string($conn, $_POST["feedback"]);

    $new_deadline = date("Y-m-d H:i:s", strtotime("+$extra_days days"));

    $res = mysqli_query($conn, "
        SELECT application_id 
        FROM submissions 
        WHERE submission_id=$sub_id
    ");

    if (!$res || mysqli_num_rows($res) == 0) {
        die("Submission not found.");
    }

    $data = mysqli_fetch_assoc($res);
    $app_id = $data["application_id"];

    mysqli_query($conn, "
        UPDATE submissions
        SET status='Revision Required',
            revision_deadline='$new_deadline',
            company_feedback='$feedback'
        WHERE submission_id=$sub_id
    ");

    mysqli_query($conn, "
        UPDATE applications
        SET deadline='$new_deadline'
        WHERE application_id=$app_id
    ");

    header("Location: submissions.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Revision Required</title>
<style>
body{margin:0;font-family:Arial;background:linear-gradient(135deg,#e0f2fe,#fff);color:#0f172a}
.navbar{background:linear-gradient(135deg,#0284c7,#38bdf8);color:white;padding:18px 40px;display:flex;justify-content:space-between;align-items:center}
.navbar a{color:white;text-decoration:none;margin-left:18px;font-weight:bold}
.container{width:90%;margin:35px auto}
.box{background:white;border:4px solid #38bdf8;border-radius:15px;padding:25px}
label{font-weight:bold;color:#075985;display:block;margin-bottom:8px}
input,textarea{width:100%;padding:12px;margin-bottom:15px;border:1px solid #bae6fd;border-radius:8px;box-sizing:border-box}
textarea{height:120px}
button{background:#0284c7;color:white;padding:12px 18px;border:none;border-radius:8px;font-weight:bold;cursor:pointer}
</style>
</head>
<body>

<div class="navbar">
    <h2>Company Panel</h2>
    <div>
        <a href="submissions.php">Submissions</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <div class="box">
        <h2>Request Revision</h2>

        <form method="POST">
            <label>Extra Days</label>
            <input type="number" name="extra_days" min="1" required>

            <label>Revision Feedback</label>
            <textarea name="feedback" required></textarea>

            <button type="submit">Send Revision Request</button>
        </form>
    </div>
</div>

</body>
</html>