<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../auth/login.php");
    exit();
}

$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))["total"];
$total_students = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM students"))["total"];
$total_companies = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM companies"))["total"];
$total_tasks = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks"))["total"];

$users = mysqli_query($conn, "SELECT user_id, name, email, role, created_at FROM users ORDER BY user_id DESC");
$tasks = mysqli_query($conn, "
    SELECT t.task_id, t.title, t.status, t.duration_days, c.company_name
    FROM tasks t
    JOIN companies c ON t.company_id = c.company_id
    ORDER BY t.task_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
body{margin:0;font-family:Arial;background:linear-gradient(135deg,#e0f2fe,#fff);color:#0f172a}
.navbar{background:linear-gradient(135deg,#0284c7,#38bdf8);color:white;padding:18px 40px;display:flex;justify-content:space-between;align-items:center}
.navbar a{color:white;text-decoration:none;margin-left:18px;font-weight:bold}
.container{width:92%;margin:35px auto}
.page-title{background:linear-gradient(135deg,#38bdf8,#e0f2fe);color:#075985;padding:28px;border-radius:16px;margin-bottom:25px;border:1px solid #bae6fd}
.grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:25px}
.card{background:white;border:3px solid #38bdf8;border-radius:16px;padding:22px;box-shadow:0 10px 25px rgba(2,132,199,.15)}
.card h2{color:#0284c7;margin:0}
.table-box{background:linear-gradient(135deg,#0284c7,#7dd3fc);padding:6px;border-radius:18px;margin-bottom:30px;overflow-x:auto}
table{width:100%;border-collapse:collapse;background:white;border-radius:14px;overflow:hidden}
th{background:linear-gradient(135deg,#075985,#0284c7);color:white;padding:16px;text-align:left}
td{padding:14px;border-bottom:1px solid #dbeafe}
tr:nth-child(even) td{background:#f0f9ff}
tr:nth-child(odd) td{background:white}
.status{padding:6px 12px;border-radius:20px;font-weight:bold;background:#e0f2fe;color:#075985;border:1px solid #7dd3fc}
@media(max-width:900px){.grid{grid-template-columns:1fr 1fr}}
</style>
</head>

<body>

<div class="navbar">
    <h2>Admin Panel</h2>
    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <div class="page-title">
        <h1>System Overview</h1>
        <p>Monitor users, companies, students, and task activity.</p>
    </div>

    <div class="grid">
        <div class="card">
            <p>Total Users</p>
            <h2><?php echo $total_users; ?></h2>
        </div>

        <div class="card">
            <p>Students</p>
            <h2><?php echo $total_students; ?></h2>
        </div>

        <div class="card">
            <p>Companies</p>
            <h2><?php echo $total_companies; ?></h2>
        </div>

        <div class="card">
            <p>Tasks</p>
            <h2><?php echo $total_tasks; ?></h2>
        </div>
    </div>

    <h2>All Users</h2>
    <div class="table-box">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($users)) { ?>
            <tr>
                <td><?php echo $row["user_id"]; ?></td>
                <td><b><?php echo $row["name"]; ?></b></td>
                <td><?php echo $row["email"]; ?></td>
                <td><span class="status"><?php echo $row["role"]; ?></span></td>
                <td><?php echo $row["created_at"]; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <h2>All Tasks</h2>
    <div class="table-box">
        <table>
            <tr>
                <th>ID</th>
                <th>Task</th>
                <th>Company</th>
                <th>Duration</th>
                <th>Status</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($tasks)) { ?>
            <tr>
                <td><?php echo $row["task_id"]; ?></td>
                <td><b><?php echo $row["title"]; ?></b></td>
                <td><?php echo $row["company_name"]; ?></td>
                <td><?php echo $row["duration_days"]; ?> days</td>
                <td><span class="status"><?php echo $row["status"]; ?></span></td>
            </tr>
            <?php } ?>
        </table>
    </div>

</div>

</body>
</html>