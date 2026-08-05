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

$companyResult = mysqli_query($conn, "SELECT company_id FROM companies WHERE user_id=$user_id");

if (!$companyResult || mysqli_num_rows($companyResult) == 0) {
    die("Company profile not found. Please login using a company account.");
}

$company = mysqli_fetch_assoc($companyResult);
$company_id = $company["company_id"];

$tasks = mysqli_query($conn, "
    SELECT *
    FROM tasks
    WHERE company_id = $company_id
    ORDER BY task_id DESC
");

if (!$tasks) {
    die("SQL Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>My Tasks</title>
<style>
body{margin:0;font-family:Arial;background:linear-gradient(135deg,#e0f2fe,#fff);color:#0f172a}
.navbar{background:linear-gradient(135deg,#0284c7,#38bdf8);color:white;padding:18px 40px;display:flex;justify-content:space-between;align-items:center}
.navbar a{color:white;text-decoration:none;margin-left:18px;font-weight:bold}
.container{width:92%;margin:35px auto}
.page-title{background:linear-gradient(135deg,#38bdf8,#e0f2fe);color:#075985;padding:28px;border-radius:16px;margin-bottom:25px;border:1px solid #bae6fd}
.table-box{background:linear-gradient(135deg,#0284c7,#7dd3fc);padding:6px;border-radius:18px;overflow-x:auto}
table{width:100%;border-collapse:collapse;background:white;border-radius:14px;overflow:hidden}
th{background:linear-gradient(135deg,#075985,#0284c7);color:white;padding:16px;text-align:left}
td{padding:15px;border-bottom:1px solid #dbeafe}
tr:nth-child(even) td{background:#f0f9ff}
tr:nth-child(odd) td{background:white}
tr:hover td{background:#e0f2fe}
.btn{background:#0284c7;color:white;padding:9px 14px;border-radius:8px;text-decoration:none;font-weight:bold;display:inline-block}
.btn-green{background:#0f766e}
.status{padding:6px 12px;border-radius:20px;font-weight:bold;background:#e0f2fe;color:#075985;border:1px solid #7dd3fc}
.action{margin-bottom:18px}
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
        <h1>My Posted Tasks</h1>
        <p>View and manage all tasks posted by your company.</p>
    </div>

    <div class="action">
        <a class="btn btn-green" href="post_task.php">+ Post New Task</a>
    </div>

    <div class="table-box">
        <table>
            <tr>
                <th>ID</th>
                <th>Task Title</th>
                <th>Description</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Applications</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($tasks)) { ?>
            <tr>
                <td><?php echo $row["task_id"]; ?></td>
                <td><b><?php echo $row["title"]; ?></b></td>
                <td><?php echo $row["description"]; ?></td>
                <td><?php echo $row["duration_days"]; ?> days</td>
                <td><span class="status"><?php echo $row["status"]; ?></span></td>
                <td>
                    <a class="btn" href="applications.php?task_id=<?php echo $row["task_id"]; ?>">View</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

</div>

</body>
</html>