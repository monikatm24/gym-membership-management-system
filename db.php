<?php
$conn = new mysqli(
    "your_host_name",
    "your_DB_USERNAME",
    "your_DB_PASSWORD",
    "your_DB_NAME"
);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>