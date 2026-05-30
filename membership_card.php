<?php
include("../includes/db.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

/* GET MEMBER + PAYMENT */
$member = $conn->query("
    SELECT m.*, p.start_date, p.end_date, p.amount
    FROM members m
    LEFT JOIN payments p ON m.id = p.member_id
    WHERE m.id = $id
    ORDER BY p.id DESC
    LIMIT 1
")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Membership Card</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f4f6f9;
    font-family: 'Segoe UI';
}

.card-box {
    width: 380px;
    margin: 50px auto;
    background: linear-gradient(135deg,#1d2b64,#4f6ef7);
    color: white;
    padding: 25px;
    border-radius: 20px;
    text-align: center;
}

.profile {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid white;
}

.info {
    text-align: left;
    margin-top: 15px;
    background: rgba(255,255,255,0.1);
    padding: 12px;
    border-radius: 10px;
}

.active{background:#22c55e;padding:3px 8px;border-radius:10px;}
.expired{background:#ef4444;padding:3px 8px;border-radius:10px;}
</style>
</head>

<body>

<?php if($member){ ?>

<div class="card-box">

<h5>🏋️ GYM CARD</h5>

<img src="../uploads/<?= $member['photo'] ?>" class="profile">

<h4><?= $member['name'] ?></h4>

<div class="info">

<p>📞 <?= $member['phone'] ?></p>

<p>💼 <?= $member['occupation'] ?></p>

<p>
Status:
<?php if($member['status']=="active"){ ?>
<span class="active">ACTIVE</span>
<?php } else { ?>
<span class="expired">EXPIRED</span>
<?php } ?>
</p>

<p>💰 ₹<?= $member['amount'] ?? 0 ?></p>
<p>📅 Start: <?= $member['start_date'] ?? '-' ?></p>
<p>⏳ Expiry: <?= $member['end_date'] ?? '-' ?></p>

</div>

<br>

<img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=<?= $member['id'] ?>">

<br><br>

<button onclick="window.print()" class="btn btn-light w-100">🖨 Print</button>

</div>

<?php } else { ?>

<div class="alert alert-danger text-center mt-5">
Member not found
</div>

<?php } ?>

</body>
</html>