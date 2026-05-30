<?php
include("../includes/db.php");

$id = $_GET['id'];

/* MEMBER INFO */
$member = $conn->query("SELECT * FROM members WHERE id=$id")->fetch_assoc();

/* PAYMENT HISTORY */
$payments = $conn->query("
    SELECT * FROM payments 
    WHERE member_id = $id 
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7fb;
            font-family:Segoe UI;
        }

        .box{
            background:white;
            padding:20px;
            border-radius:15px;
            margin-top:20px;
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
        }
    </style>
</head>

<body>

<div class="container">

<div class="box">

<h4>💳 Payment History - <?= $member['name'] ?></h4>

<a href="view_members.php" class="btn btn-dark btn-sm mb-3">⬅ Back</a>

<table class="table table-bordered">

<tr>
    <th>Amount</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Status</th>
</tr>

<?php if($payments){ while($p = $payments->fetch_assoc()) { ?>

<tr>
    <td>₹<?= $p['amount'] ?></td>
    <td><?= $p['start_date'] ?></td>
    <td><?= $p['end_date'] ?></td>

    <td>
        <?php if(strtotime($p['end_date']) >= time()) { ?>
            <span class="badge bg-success">Active</span>
        <?php } else { ?>
            <span class="badge bg-danger">Expired</span>
        <?php } ?>
    </td>
</tr>

<?php }} ?>

</table>

</div>

</div>

</body>
</html>