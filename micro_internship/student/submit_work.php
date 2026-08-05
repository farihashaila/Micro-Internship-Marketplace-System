<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../config/db.php";

$app_id = $_GET["app_id"];
$msg = "";

$appRes = mysqli_query($conn, "
    SELECT a.*, t.title, c.company_name
    FROM applications a
    JOIN tasks t ON a.task_id = t.task_id
    JOIN companies c ON t.company_id = c.company_id
    WHERE a.application_id = $app_id
");
$app = mysqli_fetch_assoc($appRes);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submission_link = $_POST["submission_link"];
    $notes = $_POST["notes"];

    $check = mysqli_query($conn, "SELECT * FROM submissions WHERE application_id=$app_id");

    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "
            UPDATE submissions
            SET submission_link='$submission_link',
                notes='$notes',
                status='Submitted',
                submitted_at=NOW()
            WHERE application_id=$app_id
        ");
    } else {
        mysqli_query($conn, "
            INSERT INTO submissions (application_id, submission_link, notes, status)
            VALUES ($app_id, '$submission_link', '$notes', 'Submitted')
        ");
    }

    $msg = "Work submitted successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Submit Work</title>
<style>
body{margin:0;font-family:Arial;background:linear-gradient(135deg,#e0f2fe,#fff);color:#0f172a}
.navbar{background:linear-gradient(135deg,#0284c7,#38bdf8);color:white;padding:18px 40px;display:flex;justify-content:space-between;align-items:center}
.navbar a{color:white;text-decoration:none;margin-left:18px;font-weight:bold}
.container{width:92%;margin:35px auto}
.page-title{background:linear-gradient(135deg,#38bdf8,#e0f2fe);color:#075985;padding:28px;border-radius:16px;margin-bottom:25px;border:1px solid #bae6fd}
.form-box{background:white;border:4px solid #38bdf8;border-radius:18px;padding:28px;box-shadow:0 12px 30px rgba(2,132,199,.18)}
label{font-weight:bold;color:#075985;display:block;margin-bottom:8px}
input,textarea{width:100%;padding:13px;border:1px solid #bae6fd;border-radius:8px;margin-bottom:18px;font-size:15px}
textarea{height:120px}
button{background:#0284c7;color:white;padding:12px 18px;border:none;border-radius:8px;font-weight:bold;cursor:pointer}
.alert{background:#e0f2fe;color:#075985;padding:14px;border-radius:10px;margin-bottom:18px;font-weight:bold}
.info{background:#f0f9ff;border:1px solid #bae6fd;padding:15px;border-radius:10px;margin-bottom:20px}
</style>
</head>
<body>

<div class="navbar">
    <h2>Student Panel</h2>
   <div>
    <a href="dashboard.php">Dashboard</a>
    <a href="tasks.php">Tasks</a>
    <a href="applications.php">Applications</a>
    <a href="profile.php">Profile</a>
    <a href="../auth/logout.php">Logout</a>
</div>
</div>

<div class="container">
    <div class="page-title">
        <h1>Submit Completed Work</h1>
        <p>Submit your work link before the deadline.</p>
    </div>

    <?php if($msg != "") { ?>
        <div class="alert"><?php echo $msg; ?></div>
    <?php } ?>

    <div class="info">
        <b>Task:</b> <?php echo $app["title"]; ?><br>
        <b>Company:</b> <?php echo $app["company_name"]; ?><br>
        <b>Deadline:</b> <?php echo $app["deadline"]; ?>
    </div>

    <div class="form-box">
        <form method="POST">
            <label>Submission Link</label>
            <input type="text" name="submission_link" placeholder="Google Drive / GitHub / Website link" required>

            <label>Notes</label>
            <textarea name="notes" placeholder="Write a short note about your work"></textarea>

            <button type="submit">Submit Work</button>
        </form>
    </div>
</div>

</body>
</html>