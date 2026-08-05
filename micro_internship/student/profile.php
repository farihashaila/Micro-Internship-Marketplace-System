<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

/* student info */
$res = mysqli_query($conn, "
SELECT u.name, u.email, s.*
FROM users u
JOIN students s ON u.user_id = s.user_id
WHERE u.user_id = $user_id
");

if (!$res || mysqli_num_rows($res) == 0) {
    die("Student profile not found");
}

$student = mysqli_fetch_assoc($res);

/* update profile */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $department = mysqli_real_escape_string($conn, $_POST["department"]);
    $skills = mysqli_real_escape_string($conn, $_POST["skills"]);
    $bio = mysqli_real_escape_string($conn, $_POST["bio"]);
    $portfolio = mysqli_real_escape_string($conn, $_POST["portfolio_url"]);

    mysqli_query($conn, "
    UPDATE students
    SET department='$department',
        skills='$skills',
        bio='$bio',
        portfolio_url='$portfolio'
    WHERE user_id=$user_id
    ");

    header("Location: profile.php");
    exit();
}

/* reviews */
$reviews = mysqli_query($conn, "
    SELECT r.rating, r.comment, u.name AS company_name
    FROM reviews r
    JOIN companies c ON r.company_id = c.company_id
    JOIN users u ON c.user_id = u.user_id
    WHERE r.student_id = ".$student["student_id"]."
    ORDER BY r.review_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Profile</title>

<style>
body{margin:0;font-family:Arial;background:linear-gradient(135deg,#e0f2fe,#fff)}
.navbar{background:linear-gradient(135deg,#0284c7,#38bdf8);color:white;padding:18px 40px;display:flex;justify-content:space-between}
.navbar a{color:white;text-decoration:none;margin-left:15px;font-weight:bold}
.container{width:90%;margin:30px auto}

.box{background:white;border:4px solid #38bdf8;border-radius:15px;padding:25px;margin-bottom:20px}

h2{color:#0284c7}

input,textarea{
width:100%;
padding:10px;
margin-bottom:15px;
border:1px solid #bae6fd;
border-radius:6px;
}

textarea{height:110px}

button{
background:#0284c7;
color:white;
padding:10px;
border:none;
border-radius:6px;
cursor:pointer;
}

.stat{
background:#e0f2fe;
padding:10px;
margin-bottom:10px;
border-radius:8px;
}

.table-box{
background:linear-gradient(135deg,#0284c7,#7dd3fc);
padding:6px;
border-radius:18px;
overflow-x:auto;
margin-top:20px;
}

table{
width:100%;
border-collapse:collapse;
background:white;
border-radius:14px;
overflow:hidden;
}

th{
background:linear-gradient(135deg,#075985,#0284c7);
color:white;
padding:14px;
}

td{
padding:12px;
border-bottom:1px solid #dbeafe;
}

tr:nth-child(even) td{background:#f0f9ff}
tr:nth-child(odd) td{background:white}
</style>

</head>

<body>

<div class="navbar">
    <div>Student Panel</div>
    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="tasks.php">Tasks</a>
        <a href="applications.php">Applications</a>
        <a href="profile.php">Profile</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

<div class="container">

<!-- PROFILE -->
<div class="box">
    <h2><?php echo $student["name"]; ?></h2>
    <p>Email: <?php echo $student["email"]; ?></p>

    <div class="stat">
        Rating: <?php echo round($student["average_rating"],2); ?> / 5
    </div>

    <div class="stat">
        Total Reviews: <?php echo $student["total_reviews"]; ?>
    </div>
</div>

<!-- EDIT -->
<div class="box">
    <h2>Edit Profile</h2>

    <form method="POST">

        <label>Department</label>
        <input type="text" name="department" value="<?php echo htmlspecialchars($student["department"] ?? ""); ?>">

        <label>Skills</label>
        <textarea name="skills"><?php echo htmlspecialchars($student["skills"] ?? ""); ?></textarea>

        <label>Bio</label>
        <textarea name="bio"><?php echo htmlspecialchars($student["bio"] ?? ""); ?></textarea>

        <label>Portfolio URL</label>
        <input type="text" name="portfolio_url" value="<?php echo htmlspecialchars($student["portfolio_url"] ?? ""); ?>">

        <button type="submit">Update</button>

    </form>
</div>

<!-- REVIEWS -->
<div class="box">
    <h2>My Reviews</h2>

    <?php if(mysqli_num_rows($reviews) > 0) { ?>

        <div class="table-box">
            <table>
                <tr>
                    <th>Company</th>
                    <th>Rating</th>
                    <th>Comment</th>
                </tr>

                <?php while($row = mysqli_fetch_assoc($reviews)) { ?>
                <tr>
                    <td><?php echo $row["company_name"]; ?></td>

                    <td>
                        <?php
                        for($i=1; $i<=5; $i++){
                            echo ($i <= $row["rating"]) ? "⭐" : "☆";
                        }
                        ?>
                    </td>

                    <td><?php echo $row["comment"]; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>

    <?php } else { ?>
        <p>No reviews yet.</p>
    <?php } ?>

</div>

</div>

</body>
</html>