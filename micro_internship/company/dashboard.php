<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../config/db.php";
include __DIR__ . "/../config/check_deadlines.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "company") {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$companyRes = mysqli_query($conn, "SELECT company_id, company_name FROM companies WHERE user_id=$user_id");
$company = mysqli_fetch_assoc($companyRes);
$company_id = $company["company_id"];

$total_tasks = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE company_id=$company_id"))["total"];
$open_tasks = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE company_id=$company_id AND status='Open'"))["total"];
$in_progress = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE company_id=$company_id AND status='In Progress'"))["total"];
$completed = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE company_id=$company_id AND status='Completed'"))["total"];
?>

<!DOCTYPE html>
<html>
<head>
<title>Company Dashboard</title>
<style>
body{
    margin:0;
    font-family:Arial;
    background:linear-gradient(135deg,#e0f2fe,#fff);
    color:#0f172a;
}

.navbar{
    background:linear-gradient(135deg,#0284c7,#38bdf8);
    color:white;
    padding:18px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.navbar a{
    color:white;
    text-decoration:none;
    margin-left:18px;
    font-weight:bold;
}

.container{
    width:92%;
    margin:35px auto;
}

.page-title{
    background:linear-gradient(135deg,#38bdf8,#e0f2fe);
    color:#075985;
    padding:28px;
    border-radius:16px;
    margin-bottom:25px;
    border:1px solid #bae6fd;
}

.grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:14px;
    margin-bottom:22px;
}

.card{
    background:white;
    border:3px solid #38bdf8;
    border-radius:14px;
    padding:15px 18px;
    box-shadow:0 8px 20px rgba(2,132,199,.12);
}

.card p{
    margin:0 0 12px 0;
    font-size:16px;
}

.card h2{
    color:#0284c7;
    margin:0;
    font-size:28px;
}

.card-link{
    text-decoration:none;
    color:inherit;
    display:block;
}

.card-link .card{
    height:120px;
}

.card-link:hover .card{
    transform:translateY(-5px);
    transition:0.3s;
    cursor:pointer;
    box-shadow:0 14px 30px rgba(2,132,199,.25);
}

.btn{
    background:#0284c7;
    color:white;
    padding:10px 14px;
    border-radius:8px;
    text-decoration:none;
    font-weight:bold;
    display:inline-block;
    margin-right:8px;
}

.btn-green{
    background:#0f766e;
}

@media(max-width:900px){
    .grid{
        grid-template-columns:1fr 1fr;
    }
}
</style>
</head>
<body>

<div class="navbar">
    <h2>Company Dashboard</h2>
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
        <h1>Welcome, <?php echo $company["company_name"]; ?></h1>
        <p>Post tasks, select applicants, review submissions, and give feedback.</p>
    </div>

    <div class="grid">
        <a href="my_tasks.php" class="card-link">
            <div class="card">
                <p>Total Tasks</p>
                <h2><?php echo $total_tasks; ?></h2>
            </div>
        </a>

        <a href="my_tasks.php" class="card-link">
            <div class="card">
                <p>Open Tasks</p>
                <h2><?php echo $open_tasks; ?></h2>
            </div>
        </a>

        <a href="my_tasks.php" class="card-link">
            <div class="card">
                <p>In Progress</p>
                <h2><?php echo $in_progress; ?></h2>
            </div>
        </a>

        <a href="my_tasks.php" class="card-link">
            <div class="card">
                <p>Completed</p>
                <h2><?php echo $completed; ?></h2>
            </div>
        </a>
    </div>

    <div class="card">
        <a class="btn btn-green" href="post_task.php">Post New Task</a>
        <a class="btn" href="my_tasks.php">View My Tasks</a>
        <a class="btn" href="applications.php">Review Applications</a>
    </div>
</div>

</body>
</html>