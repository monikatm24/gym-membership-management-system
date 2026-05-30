<?php
$conn = new mysqli("localhost","root","","gym_db");

/* TOTAL MEMBERS */
$total = $conn->query("SELECT COUNT(*) as c FROM members")
->fetch_assoc()['c'];

/* ACTIVE MEMBERS = have valid membership (based on latest payment end_date) */
$active = $conn->query("
    SELECT COUNT(DISTINCT m.id) as c
    FROM members m
    JOIN payments p ON m.id = p.member_id
    WHERE p.end_date >= CURDATE()
")->fetch_assoc()['c'];

/* EXPIRED MEMBERS */
$expired = $conn->query("
    SELECT COUNT(*) as c FROM members m
    WHERE m.id NOT IN (
        SELECT member_id FROM payments WHERE end_date >= CURDATE()
    )
")->fetch_assoc()['c'];

/* REVENUE */
$revenue = $conn->query("SELECT SUM(amount) as s FROM payments")
->fetch_assoc()['s'];

echo json_encode([
    "total"=>$total,
    "active"=>$active,
    "expired"=>$expired,
    "revenue"=>$revenue ?: 0
]);
?>