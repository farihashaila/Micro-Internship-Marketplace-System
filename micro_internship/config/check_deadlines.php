<?php
include "db.php";

$now = date("Y-m-d H:i:s");

$expired = mysqli_query($conn, "
    SELECT a.application_id, a.task_id
    FROM applications a
    LEFT JOIN submissions s ON a.application_id = s.application_id
    WHERE a.status = 'Accepted'
    AND a.deadline < '$now'
    AND s.submission_id IS NULL
");

while ($row = mysqli_fetch_assoc($expired)) {
    $app_id = $row["application_id"];
    $task_id = $row["task_id"];

    mysqli_query($conn, "
        UPDATE applications 
        SET status='Rejected'
        WHERE application_id=$app_id
    ");

    mysqli_query($conn, "
        UPDATE tasks 
        SET status='Open'
        WHERE task_id=$task_id
    ");
}
?>