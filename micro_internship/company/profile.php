<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "company") {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$msg = "";

$res = mysqli_query($conn, "
    SELECT c.*, u.name, u.email
    FROM companies c
    JOIN users u ON c.user_id = u.user_id
    WHERE c.user_id = $user_id
");

if (!$res || mysqli_num_rows($res) == 0) {
    die("Company profile not found.");
}

$company = mysqli_fetch_assoc($res);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name = $_POST["company_name"];
    $industry = $_POST["industry"];
    $website = $_POST["website"];
    $description = $_POST["description"];

    $update = mysqli_query($conn, "
        UPDATE companies
        SET company_name='$company_name',
            industry='$industry',
            website='$website',
            description='$description'
        WHERE user_id=$user_id
    ");

    if (!$update) {
        die("Update Error: " . mysqli_error($conn));
    }

    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Company Profile</title>
<style>
body{margin:0;font-family:Arial;background:linear-gradient(135deg,#e0f2fe,#fff);color:#0f172a}
.navbar{background:linear-gradient(135deg,#0284c7,#38bdf8);color:white;padding:18px 40px;display:flex;justify-content:space-between;align-items:center}
.navbar a{color:white;text-decoration:none;margin-left:18px;font-weight:bold}
.container{width:90%;margin:30px auto}
.box{background:white;border:4px solid #38bdf8;border-radius:15px;padding:25px;margin-bottom:20px;box-shadow:0 12px 30px rgba(2,132,199,.18)}
h2{color:#0284c7}
.info{background:#e0f2fe;padding:12px;border-radius:8px;margin-bottom:12px}
label{font-weight:bold;color:#075985;display:block;margin-bottom:8px}
input,textarea{width:100%;padding:10px;margin-bottom:15px;border:1px solid #bae6fd;border-radius:6px;box-sizing:border-box}
textarea{height:110px}
button{background:#0284c7;color:white;padding:10px 15px;border:none;border-radius:6px;font-weight:bold;cursor:pointer}
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

    <div class="box">
        <h2><?php echo $company["company_name"]; ?></h2>
        <div class="info"><b>Email:</b> <?php echo $company["email"]; ?></div>
        <div class="info"><b>Industry:</b> <?php echo $company["industry"]; ?></div>
        <div class="info"><b>Website:</b> <?php echo $company["website"]; ?></div>
    </div>

    <div class="box">
        <h2>Edit Company Profile</h2>

        <form method="POST">
            <label>Company Name</label>
            <input type="text" name="company_name" value="<?php echo $company["company_name"]; ?>" required>

            <label>Industry</label>
            <input type="text" name="industry" value="<?php echo $company["industry"]; ?>">

            <label>Website</label>
            <input type="text" name="website" value="<?php echo $company["website"]; ?>">

            <label>Description</label>
            <textarea name="description"><?php echo $company["description"]; ?></textarea>

            <button type="submit">Update Profile</button>
        </form>
    </div>

</div>

</body>
</html>