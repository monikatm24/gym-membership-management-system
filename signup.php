<?php

include("../includes/db.php");

if(isset($_POST['signup'])){

$phone=$_POST['phone'];
$password=$_POST['password'];

$check=$conn->query("
SELECT *
FROM members
WHERE phone='$phone'
");

if($check->num_rows>0){

$conn->query("
UPDATE members
SET password='$password'
WHERE phone='$phone'
");

echo "<script>
alert('Account Created');
window.location='member_login.php';
</script>";

}
else{

echo "<script>
alert('Phone number not found. Contact Admin.');
</script>";

}

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Member Signup</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
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

.box{

background:white;

padding:30px;

width:360px;

border-radius:15px;

box-shadow:0 10px 30px rgba(0,0,0,0.2);

}

</style>

</head>

<body>

<div class="box">

<h3 class="text-center mb-4">

Create Account

</h3>

<form method="POST">

<input
name="phone"
class="form-control mb-3"
placeholder="Phone Number"
required>

<input
type="password"
name="password"
class="form-control mb-3"
placeholder="Password"
required>

<button
name="signup"
class="btn btn-primary w-100">

Signup

</button>

</form>

</div>

</body>

</html>