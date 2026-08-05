<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../config/db.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $res = mysqli_query($conn, "
        SELECT * FROM users 
        WHERE email='$email' AND password='$password'
    ");

    if (!$res) {
        die("SQL Error: " . mysqli_error($conn));
    }

    $user = mysqli_fetch_assoc($res);

    if ($user) {
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["name"] = $user["name"];

        if ($user["role"] == "student") {
            header("Location: ../student/dashboard.php");
            exit();
        } 
        elseif ($user["role"] == "company") {
            header("Location: ../company/dashboard.php");
            exit();
        } 
        elseif ($user["role"] == "admin") {
            header("Location: ../admin/dashboard.php");
            exit();
        }
    } else {
        $msg = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>
body {
    margin:0;
    font-family:Arial;
    background:linear-gradient(135deg,#e0f2fe,#ffffff);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box {
    background:white;
    padding:40px;
    border-radius:20px;
    width:360px;
    box-shadow:0 20px 50px rgba(2,132,199,.25);
    border:3px solid #38bdf8;
}

h2 {
    text-align:center;
    color:#0284c7;
}

label {
    font-weight:bold;
    color:#075985;
}

input {
    width:100%;
    padding:12px;
    margin:10px 0 18px;
    border:1px solid #bae6fd;
    border-radius:8px;
    box-sizing:border-box;
}

button {
    width:100%;
    background:#0284c7;
    color:white;
    padding:12px;
    border:none;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
}

button:hover {
    background:#0369a1;
}

.link {
    text-align:center;
    margin-top:15px;
}

.link a {
    color:#0284c7;
    font-weight:bold;
    text-decoration:none;
}

.alert {
    background:#fee2e2;
    color:#991b1b;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
}
</style>

</head>
<body>

<div class="box">

<h2>Login</h2>

<?php if($msg != "") { ?>
    <div class="alert"><?php echo $msg; ?></div>
<?php } ?>

<form method="POST">
    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
</form>

<div class="link">
    Don't have an account? <a href="register.php">Register</a>
</div>

</div>

</body>
</html>