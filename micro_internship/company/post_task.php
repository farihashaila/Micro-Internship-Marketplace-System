<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../config/db.php";

$user_id = $_SESSION["user_id"] ?? 6;
$msg = "";

$companyResult = mysqli_query($conn, "SELECT company_id FROM companies WHERE user_id=$user_id");
$company = mysqli_fetch_assoc($companyResult);
$company_id = $company["company_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $duration_days = $_POST["duration_days"];

    $sql = "INSERT INTO tasks (company_id, title, description, duration_days, status)
            VALUES ($company_id, '$title', '$description', $duration_days, 'Open')";

    if (mysqli_query($conn, $sql)) {
        $msg = "Task posted successfully!";
    } else {
        $msg = "Task post failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Post Task</title>
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
</style>
</head>
<body>

<div class="navbar">
    <h2>Company Panel</h2>
    <div>
    <a href="dashboard.php">Dashboard</a>
    <a href="profile.php">Profile</a>
    <a href="post_task.php">Post Task</a>
    <a href="my_tasks.php">My Tasks</a>
    <a href="applications.php">Applications</a>
    <a href="submissions.php">Submissions</a>
    <a href="../auth/logout.php">Logout</a>
</div>
</div>

<div class="container">
    <div class="page-title">
        <h1>Post New Task</h1>
        <p>Create a new micro-internship opportunity for students.</p>
    </div>

    <?php if($msg != "") { ?>
        <div class="alert"><?php echo $msg; ?></div>
    <?php } ?>

    <div class="form-box">
        <form method="POST">
            <label>Task Title</label>
            <input type="text" name="title" required>

            <label>Description</label>
            <textarea name="description" required></textarea>

            <label>Duration Days</label>
            <input type="number" name="duration_days" required min="1">

            <button type="submit">Publish Task</button>
        </form>
    </div>
</div>

</body>
</html>
