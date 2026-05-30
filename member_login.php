<?php

session_start();

$conn = new mysqli("localhost","root","","gym_db",3307);

$error="";

if(isset($_POST['login'])){

$phone=$_POST['phone'];
$password=$_POST['password'];

$user=$conn->query("
SELECT *
FROM members
WHERE phone='$phone'
AND password='$password'
");

if($user->num_rows>0){

$row=$user->fetch_assoc();

$_SESSION['member']=$row['id'];

header("Location: member_dashboard.php");

exit();

}
else{

$error="Invalid Phone or Password";

}

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Member Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{

background:linear-gradient(135deg,#1d2b64,#f8cdda);

height:100vh;

display:flex;

justify-content:center;

align-items:center;

font-family:Arial;

}

.login-box{

background:white;

padding:30px;

border-radius:15px;

width:360px;

box-shadow:0 10px 30px rgba(0,0,0,0.2);

}

.title{

text-align:center;

font-weight:bold;

margin-bottom:20px;

}

.form-control{

border-radius:10px;

}

.btn-login{

width:100%;

border-radius:10px;

background:#1d2b64;

color:white;

}

.btn-login:hover{

background:#111a3a;

color:white;

}

.signup{

text-align:center;

margin-top:15px;

}

</style>

</head>

<body>

<div class="login-box">

<h3 class="title">

👤 Member Login

</h3>

<?php if($error!=""){ ?>

<div class="alert alert-danger">

<?= $error ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<input
type="text"
name="phone"
class="form-control"
placeholder="Phone Number"
required>

</div>

<div class="mb-3">

<input
type="password"
name="password"
class="form-control"
placeholder="Password"
required>

</div>

<button
name="login"
class="btn btn-login">

Login

</button>

<div class="signup">

<a href="signup.php">

Create New Account

</a>

</div>

</form>

</div>

</body>

</html>