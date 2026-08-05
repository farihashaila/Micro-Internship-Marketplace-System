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

$res = mysqli_query($conn, "SELECT student_id FROM students WHERE user_id=$user_id");
$student = mysqli_fetch_assoc($res);
$student_id = $student["student_id"];

$applications = mysqli_query($conn, "
    SELECT 
        a.*,
        t.title,
        c.company_name,
        sub.submission_id,
        sub.status AS submission_status,
        sub.revision_deadline,
        sub.company_feedback
    FROM applications a
    JOIN tasks t ON a.task_id = t.task_id
    JOIN companies c ON t.company_id = c.company_id
    LEFT JOIN submissions sub ON a.application_id = sub.application_id
    WHERE a.student_id = $student_id
    ORDER BY a.application_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Applications</title>
<style>
body{margin:0;font-family:Arial;background:linear-gradient(135deg,#e0f2fe,#fff);color:#0f172a}
.navbar{background:linear-gradient(135deg,#0284c7,#38bdf8);color:white;padding:18px 40px;display:flex;justify-content:space-between;align-items:center}
.navbar a{color:white;text-decoration:none;margin-left:18px;font-weight:bold}
.container{width:92%;margin:35px auto}
.page-title{background:linear-gradient(135deg,#38bdf8,#e0f2fe);color:#075985;padding:28px;border-radius:16px;margin-bottom:25px;border:1px solid #bae6fd}
.table-box{background:linear-gradient(135deg,#0284c7,#7dd3fc);padding:6px;border-radius:18px;overflow-x:auto}
table{width:100%;border-collapse:collapse;background:white;border-radius:14px;overflow:hidden}
th{background:linear-gradient(135deg,#075985,#0284c7);color:white;padding:16px;text-align:left}
td{padding:15px;border-bottom:1px solid #dbeafe;vertical-align:top}
tr:nth-child(even) td{background:#f0f9ff}
tr:nth-child(odd) td{background:white}
tr:hover td{background:#e0f2fe}
.btn{background:#0284c7;color:white;padding:9px 14px;border-radius:8px;text-decoration:none;font-weight:bold;display:inline-block}
.status{padding:6px 12px;border-radius:20px;font-weight:bold;background:#e0f2fe;color:#075985;border:1px solid #7dd3fc;display:inline-block}
.feedback{background:#fff7ed;color:#9a3412;border:1px solid #fdba74;padding:10px;border-radius:8px;margin-top:8px;font-size:14px}
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
        <h1>My Applications</h1>
        <p>Track your application, submission status, deadline, and revision feedback.</p>
    </div>

    <div class="table-box">
        <table>
            <tr>
                <th>Task</th>
                <th>Company</th>
                <th>Application Status</th>
                <th>Submission Status</th>
                <th>Deadline</th>
                <th>Feedback</th>
                <th>Action</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($applications)) { ?>
            <tr>
                <td><b><?php echo $row["title"]; ?></b></td>
                <td><?php echo $row["company_name"]; ?></td>

                <td>
                    <span class="status"><?php echo $row["status"]; ?></span>
                </td>

                <td>
                    <?php if($row["submission_status"]) { ?>
                        <span class="status"><?php echo $row["submission_status"]; ?></span>
                    <?php } else { ?>
                        -
                    <?php } ?>
                </td>

                <td>
                    <?php 
                    if($row["submission_status"] == "Revision Required" && $row["revision_deadline"]) {
                        echo $row["revision_deadline"];
                    } elseif($row["deadline"]) {
                        echo $row["deadline"];
                    } else {
                        echo "Not Assigned";
                    }
                    ?>
                </td>

                <td>
                    <?php if($row["submission_status"] == "Revision Required") { ?>
                        <div class="feedback">
                            <b>Revision Required:</b><br>
                            <?php echo $row["company_feedback"]; ?>
                        </div>
                    <?php } else { ?>
                        -
                    <?php } ?>
                </td>

                <td>
                    <?php if($row["status"] == "Accepted") { ?>
                        <a class="btn" href="submit_work.php?app_id=<?php echo $row["application_id"]; ?>">
                            <?php 
                            if($row["submission_status"] == "Revision Required") {
                                echo "Resubmit Work";
                            } else {
                                echo "Submit Work";
                            }
                            ?>
                        </a>
                    <?php } else { ?>
                        -
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>

        </table>
    </div>

</div>

</body>
</html>