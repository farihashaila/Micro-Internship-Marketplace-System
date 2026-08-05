<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include "../config/db.php";
include __DIR__ . "/../config/check_deadlines.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$studentRes = mysqli_query($conn, "SELECT student_id FROM students WHERE user_id=$user_id");
$student = mysqli_fetch_assoc($studentRes);
$student_id = $student["student_id"];

$search = "";

if (isset($_GET["search"])) {
    $search = mysqli_real_escape_string($conn, $_GET["search"]);

    $tasks = mysqli_query($conn, "
        SELECT t.*, c.company_name
        FROM tasks t
        JOIN companies c ON t.company_id = c.company_id
        WHERE t.status = 'Open'
        AND t.title LIKE '%$search%'
        AND t.task_id NOT IN (
            SELECT task_id
            FROM applications
            WHERE student_id = $student_id
        )
        ORDER BY t.task_id DESC
    ");
} else {
    $tasks = mysqli_query($conn, "
        SELECT t.*, c.company_name
        FROM tasks t
        JOIN companies c ON t.company_id = c.company_id
        WHERE t.status = 'Open'
        AND t.task_id NOT IN (
            SELECT task_id
            FROM applications
            WHERE student_id = $student_id
        )
        ORDER BY t.task_id DESC
    ");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Available Tasks</title>

<style>
body{margin:0;font-family:Arial;background:linear-gradient(135deg,#e0f2fe,#fff);color:#0f172a}
.navbar{background:linear-gradient(135deg,#0284c7,#38bdf8);color:white;padding:18px 40px;display:flex;justify-content:space-between;align-items:center}
.navbar a{color:white;text-decoration:none;margin-left:18px;font-weight:bold}
.container{width:92%;margin:35px auto}
.page-title{background:linear-gradient(135deg,#38bdf8,#e0f2fe);color:#075985;padding:28px;border-radius:16px;margin-bottom:25px;border:1px solid #bae6fd}
.search-box{background:white;border:3px solid #38bdf8;border-radius:14px;padding:18px;margin-bottom:20px}
.search-box input{width:75%;padding:12px;border:1px solid #bae6fd;border-radius:8px}
.search-box button{background:#0284c7;color:white;padding:12px 18px;border:none;border-radius:8px;font-weight:bold;cursor:pointer}
.table-box{background:linear-gradient(135deg,#0284c7,#7dd3fc);padding:6px;border-radius:18px;overflow-x:auto}
table{width:100%;border-collapse:collapse;background:white;border-radius:14px;overflow:hidden}
th{background:linear-gradient(135deg,#075985,#0284c7);color:white;padding:16px;text-align:left}
td{padding:15px;border-bottom:1px solid #dbeafe}
tr:nth-child(even) td{background:#f0f9ff}
tr:nth-child(odd) td{background:white}
tr:hover td{background:#e0f2fe}
.btn{background:#0284c7;color:white;padding:9px 14px;border-radius:8px;text-decoration:none;font-weight:bold;display:inline-block}
.status{padding:6px 12px;border-radius:20px;font-weight:bold;background:#e0f2fe;color:#075985;border:1px solid #7dd3fc}
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
        <h1>Available Open Tasks</h1>
        <p>Only open tasks that you have not applied to are shown here.</p>
    </div>

    <div class="search-box">
        <form method="GET">
            <input type="text" name="search" placeholder="Search task title..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="table-box">
        <table>
            <tr>
                <th>Task Title</th>
                <th>Company</th>
                <th>Description</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php if (mysqli_num_rows($tasks) > 0) { ?>
                <?php while($row = mysqli_fetch_assoc($tasks)) { ?>
                <tr>
                    <td><b><?php echo $row["title"]; ?></b></td>
                    <td><?php echo $row["company_name"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $row["duration_days"]; ?> days</td>
                    <td><span class="status"><?php echo $row["status"]; ?></span></td>
                    <td>
                        <a class="btn" href="apply.php?task_id=<?php echo $row["task_id"]; ?>">Apply</a>
                    </td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6">No open tasks available.</td>
                </tr>
            <?php } ?>

        </table>
    </div>

</div>

</body>
</html>