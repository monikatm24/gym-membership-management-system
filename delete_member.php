<?php
include("../includes/db.php");
$conn = new mysqli("localhost", "root", "", "gym_db", 3307);

$id = $_GET['id'];

$conn->query("DELETE FROM members WHERE id=$id");

header("Location: view_members.php");
?>