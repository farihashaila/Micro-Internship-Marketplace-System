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

/* check duplicate review */
$check = mysqli_query($conn, "SELECT * FROM reviews WHERE submission_id=$sub_id");
if ($check && mysqli_num_rows($check) > 0) {
    die("Review already given for this submission.");
}

/* submission info */
$res = mysqli_query($conn, "
    SELECT 
        sub.submission_id,
        a.student_id,
        t.title,
        t.company_id,
        u.name AS student_name
    FROM submissions sub
    JOIN applications a ON sub.application_id = a.application_id
    JOIN tasks t ON a.task_id = t.task_id
    JOIN students s ON a.student_id = s.student_id
    JOIN users u ON s.user_id = u.user_id
    WHERE sub.submission_id = $sub_id
");

if (!$res || mysqli_num_rows($res) == 0) {
    die("Invalid submission.");
}

$data = mysqli_fetch_assoc($res);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST["rating"];
    $comment = mysqli_real_escape_string($conn, $_POST["comment"]);

    $student_id = $data["student_id"];
    $company_id = $data["company_id"];

    mysqli_query($conn, "
        INSERT INTO reviews (submission_id, company_id, student_id, rating, comment)
        VALUES ($sub_id, $company_id, $student_id, $rating, '$comment')
    ");

    
    header("Location: submissions.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Give Review</title>
<style>
body{margin:0;font-family:Arial;background:linear-gradient(135deg,#e0f2fe,#fff);color:#0f172a}
.container{width:420px;margin:80px auto;background:white;padding:30px;border-radius:18px;border:3px solid #38bdf8;box-shadow:0 20px 50px rgba(2,132,199,.20)}
h2{color:#0284c7;text-align:center}
.info{background:#f0f9ff;border:1px solid #bae6fd;padding:14px;border-radius:10px;margin-bottom:20px}
label{font-weight:bold;color:#075985;display:block;margin-bottom:8px}
textarea{width:100%;height:110px;padding:12px;border:1px solid #bae6fd;border-radius:8px;box-sizing:border-box;margin-bottom:18px}
button{background:#0284c7;color:white;padding:12px;border:none;border-radius:8px;width:100%;font-weight:bold;cursor:pointer}
.stars{display:flex;flex-direction:row-reverse;justify-content:flex-end;margin-bottom:18px}
.stars input{display:none}
.stars label{font-size:34px;color:#cbd5e1;cursor:pointer;transition:.2s;margin-right:5px}
.stars input:checked ~ label,.stars label:hover,.stars label:hover ~ label{color:#facc15}
</style>
</head>

<body>

<div class="container">
    <h2>Give Review</h2>

    <div class="info">
        <p><b>Task:</b> <?php echo $data["title"]; ?></p>
        <p><b>Student:</b> <?php echo $data["student_name"]; ?></p>
    </div>

    <form method="POST">
        <label>Rating</label>

        <div class="stars">
            <input type="radio" name="rating" value="5" id="star5" required><label for="star5">★</label>
            <input type="radio" name="rating" value="4" id="star4"><label for="star4">★</label>
            <input type="radio" name="rating" value="3" id="star3"><label for="star3">★</label>
            <input type="radio" name="rating" value="2" id="star2"><label for="star2">★</label>
            <input type="radio" name="rating" value="1" id="star1"><label for="star1">★</label>
        </div>

        <label>Comment</label>
        <textarea name="comment" required></textarea>

        <button type="submit">Submit Review</button>
    </form>
</div>

</body>
</html>