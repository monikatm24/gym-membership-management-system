<?php
session_start();

$conn = new mysqli("localhost", "root", "", "gym_db", 3307);

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin 
            WHERE username='$username' 
            AND password='$password'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {

        $row = $result->fetch_assoc();

        // ✅ SESSION (IMPORTANT FOR YOUR PROJECT)
        $_SESSION['admin'] = $row['username'];

        // 👉 SIMPLE SAAS FIX (TEMP FOR YOUR PROJECT)
        $_SESSION['gym_id'] = 1;

        header("Location: dashboard.php");
        exit();

    } else {
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gym Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1d2b64, #f8cdda);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial;
        }

        .login-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 360px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-login {
            width: 100%;
            border-radius: 10px;
            background: #1d2b64;
            color: white;
        }

        .btn-login:hover {
            background: #111a3a;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h3 class="title">🏋️ Gym Admin Login</h3>

    <?php if($error != "") { ?>
        <div class="alert alert-danger text-center">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <form method="POST">

        <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <button class="btn btn-login">Login</button>
        <div class="text-center mt-3">

<a href="members/member_login.php"
class="btn btn-success w-100">

Member Login

</a>

</div>

    </form>

</div>

</body>
</html>