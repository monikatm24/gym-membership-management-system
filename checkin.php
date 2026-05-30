<?php
include("../includes/db.php");

$id = $_GET['id'];

/* CHECK IF ALREADY CHECKED TODAY */
$check = $conn->query("
    SELECT * FROM attendance 
    WHERE member_id = $id 
    AND DATE(check_in) = CURDATE()
");

if($check->num_rows > 0){
    echo "<script>alert('Already checked in today'); window.location='../members/view_members.php';</script>";
    exit();
}

/* INSERT CHECK-IN */
$conn->query("
    INSERT INTO attendance (member_id, check_in)
    VALUES ($id, NOW())
");

echo "<script>alert('Check-in successful'); window.location='../members/view_members.php';</script>";
?>