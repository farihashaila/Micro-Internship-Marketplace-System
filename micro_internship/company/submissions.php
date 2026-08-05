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

$submissions = mysqli_query($conn, "
    SELECT sub.*, a.application_id, t.title, u.name AS student_name
    FROM submissions sub
    JOIN applications a ON sub.application_id = a.application_id
    JOIN tasks t ON a.task_id = t.task_id
    JOIN students s ON a.student_id = s.student_id
    JOIN users u ON s.user_id = u.user_id
    WHERE t.company_id = $company_id
    ORDER BY sub.submission_id DESC
");

if (!$submissions) {
    die("SQL Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Submissions</title>

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
.btn{color:white;padding:9px 14px;border-radius:8px;text-decoration:none;font-weight:bold;display:inline-block;margin:3px}
.btn-green{background:#16a34a}
.btn-red{background:#dc2626}
.btn-yellow{background:#d97706}
.btn-blue{background:#0284c7}
.status{padding:6px 12px;border-radius:20px;font-weight:bold;background:#e0f2fe;color:#075985;border:1px solid #7dd3fc}
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
        <h1>Student Submissions</h1>
        <p>Review submitted work and decide approval, rejection, revision, or give review.</p>
    </div>

    <div class="table-box">
        <table>
            <tr>
                <th>Submission ID</th>
                <th>Task</th>
                <th>Student</th>
                <th>Submission Link</th>
                <th>Notes</th>
                <th>Status</th>
                <th>Revision Deadline</th>
                <th>Action</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($submissions)) { ?>
            <tr>
                <td><?php echo $row["submission_id"]; ?></td>
                <td><b><?php echo $row["title"]; ?></b></td>
                <td><?php echo $row["student_name"]; ?></td>

                <td>
                    <a href="<?php echo $row["submission_link"]; ?>" target="_blank">
                        Open Link
                    </a>
                </td>

                <td><?php echo $row["notes"]; ?></td>

                <td>
                    <span class="status"><?php echo $row["status"]; ?></span>
                </td>

                <td>
                    <?php echo $row["revision_deadline"] ? $row["revision_deadline"] : "-"; ?>
                </td>

                <td>
                    <?php if($row["status"] == "Submitted" || $row["status"] == "Revision Required") { ?>

                        <a class="btn btn-green" href="approve_submission.php?sub_id=<?php echo $row["submission_id"]; ?>">
                            Approve
                        </a>

                        <a class="btn btn-red" href="reject_submission.php?sub_id=<?php echo $row["submission_id"]; ?>">
                            Reject
                        </a>

                        <a class="btn btn-yellow" href="revision_submission.php?sub_id=<?php echo $row["submission_id"]; ?>">
                            Revision
                        </a>

                    <?php } elseif($row["status"] == "Approved") { ?>

                        <a class="btn btn-blue" href="give_review.php?sub_id=<?php echo $row["submission_id"]; ?>">
                            Give Review
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