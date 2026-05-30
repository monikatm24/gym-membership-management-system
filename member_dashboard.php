<?php

session_start();

include("../includes/db.php");

if(!isset($_SESSION['member'])){

header("Location: member_login.php");
exit();

}

$id=$_SESSION['member'];

/* MEMBER DETAILS */

$member=$conn->query("
SELECT *
FROM members
WHERE id=$id
")->fetch_assoc();

/* PAYMENT */

$payment=$conn->query("
SELECT *
FROM payments
WHERE member_id=$id
ORDER BY id DESC
LIMIT 1
")->fetch_assoc();

/* ATTENDANCE COUNT */

$attendance = $conn->query("
SELECT COUNT(*) total
FROM attendance
WHERE member_id=$id
")->fetch_assoc()['total'];

?>

<!DOCTYPE html>

<html>

<head>

<title>Member Dashboard</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">
<style>
    body{
background:#eef3f9;
font-family:'Segoe UI',sans-serif;
padding:30px;
}

.header{
background:linear-gradient(135deg,#1d4ed8,#2563eb);
color:white;
padding:25px;
border-radius:18px;
margin-bottom:25px;
box-shadow:0 8px 20px rgba(0,0,0,0.1);
}

.card-box{

background:white;

border:none;

border-radius:20px;

padding:25px;

box-shadow:0 8px 25px rgba(0,0,0,0.08);

transition:.3s;

height:100%;

}

.card-box:hover{

transform:translateY(-6px);

box-shadow:0 15px 35px rgba(0,0,0,0.12);

}

.profile{

border-left:5px solid #7c3aed;

}

.membership{

border-left:5px solid #2563eb;

}

.attendance{

border-left:5px solid #22c55e;

}

.icon{

font-size:32px;

margin-bottom:10px;

}

.logout{

background:#ef4444;

border:none;

padding:10px 22px;

border-radius:10px;

color:white;

font-weight:600;

}

.logout:hover{

background:#dc2626;

}

.stat{

font-size:26px;

font-weight:700;

color:#2563eb;

}
</style>
</head>

<body style="background:#f5f7fb;">

<div class="container mt-4">



<div class="header">

<h2>
🏋 Welcome,
<?= $member['name'] ?>
</h2>

<p>
Manage your membership and attendance
</p>

</div>



<hr>

<div class="row g-4">

<div class="col-md-4">

<div class="card-box profile">

<div class="icon">👤</div>

<h4>Profile</h4>

<p>Name:
<?= $member['name'] ?></p>

<p>Phone:
<?= $member['phone'] ?></p>

<p>Occupation:
<?= $member['occupation'] ?></p>

</div>

</div>


<div class="col-md-4">

<div class="card-box membership">

<div class="icon">💳</div>

<h4>Membership</h4>

<p>Amount:
₹<?= $payment['amount'] ?></p>

<p>Valid Till:
<?= $payment['end_date'] ?></p>

</div>

</div>


<div class="col-md-4">

<div class="card-box attendance">

<div class="icon">📅</div>

<h4>Attendance</h4>

<div class="stat">

<?= $attendance ?>

</div>

<p>Total Visits</p>

</div>

</div>

</div>

<br>

<a href="member_logout.php" class="btn btn-danger">
Logout
</a>

</div>

</body>

</html>