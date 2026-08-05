<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../config/db.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $role = $_POST["role"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Incorrect Email format!";
    } else {

        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

        if (mysqli_num_rows($check) > 0) {
            $msg = "Email already exists!";
        } else {

            mysqli_query($conn, "
                INSERT INTO users (name,email,password,role)
                VALUES ('$name','$email','$password','$role')
            ");

            $user_id = mysqli_insert_id($conn);

            if ($role == "student") {
                mysqli_query($conn, "
                    INSERT INTO students (user_id,department,skills)
                    VALUES ($user_id,'','')
                ");
            } else {
                mysqli_query($conn, "
                    INSERT INTO companies (user_id,company_name)
                    VALUES ($user_id,'$name')
                ");
            }

            $msg = "Registration successful!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>

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
    width:350px;
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

input,select {
    width:100%;
    padding:12px;
    margin:10px 0 18px;
    border:1px solid #bae6fd;
    border-radius:8px;
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
    background:#dcfce7;
    color:#166534;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
}
</style>

</head>
<body>

<div class="box">

<h2>Register</h2>

<?php if($msg!=""){ ?>
<div class="alert"><?php echo $msg; ?></div>
<?php } ?>

<form method="POST">

<label>Name / Company</label>
<input type="text" name="name" required>

<label>Email</label>
<input type="email" name="email" required>

<label>Password</label>
<input type="password" name="password" required>

<label>Role</label>
<select name="role" required>
    <option value="">Select</option>
    <option value="student">Student</option>
    <option value="company">Company</option>
</select>

<button type="submit">Register</button>

</form>

<div class="link">
    Already have account? <a href="login.php">Login</a>
</div>

</div>

</body>
</html>