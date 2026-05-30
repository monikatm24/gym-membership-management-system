<?php
include("../includes/db.php");

/* GET MEMBERS */
$members = $conn->query("SELECT * FROM members");
/* GET PLANS */
$plans = $conn->query("SELECT * FROM membership_types");

/* SAVE */
if(isset($_POST['renew'])){

    $member_id = $_POST['member_id'];
    $plan_id = $_POST['plan_id'];

    /* GET PLAN DETAILS */
    $plan = $conn->query("SELECT * FROM membership_types WHERE id=$plan_id")->fetch_assoc();

$amount = $plan['amount'];
$duration = $plan['duration']; // assuming you have duration column
$start = date('Y-m-d');

$startDate = new DateTime();
$startDate->modify('+30 days');

$end = $startDate->format('Y-m-d');

    /* INSERT PAYMENT */
    $conn->query("
        INSERT INTO payments (member_id, amount, start_date, end_date)
        VALUES ($member_id, $amount, '$start', '$end')
    ");

    /* UPDATE MEMBER STATUS */
    $conn->query("
        UPDATE members SET status='active' WHERE id=$member_id
    ");

    echo "<script>alert('Membership Renewed'); window.location='../dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Renew Membership</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
              background:#f6f8fc;
            font-family:Segoe UI;
        }

        .box{
            background:white;
            padding:25px;
            border-radius:15px;
            margin-top:40px;
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
        }
    </style>
</head>

<body>

<div class="container">

<div class="box">

<div class="d-flex justify-content-between align-items-center mb-3">

    <h4>🔄 Renew Membership</h4>

    <a href="../dashboard.php" class="btn btn-dark btn-sm">
        🏠 Dashboard
    </a>

</div>

<form method="POST">

<label>Select Member</label>
<select name="member_id" class="form-control mb-3" required>
    <option value="">Choose Member</option>
    <?php while($m = $members->fetch_assoc()) { ?>
        <option value="<?= $m['id'] ?>">
            <?= $m['name'] ?>
        </option>
    <?php } ?>
</select>

<label>Select Plan</label>
<select name="plan_id" class="form-control mb-3" required>
    <option value="">Choose Plan</option>
    <?php while($p = $plans->fetch_assoc()) { ?>
        <option value="<?= $p['id'] ?>">
            <?= $p['type_name'] ?> - ₹<?= $p['amount'] ?>
        </option>
    <?php } ?>
</select>

<button name="renew" class="btn btn-success w-100">
    Renew Membership
</button>

</form>

</div>

</div>

</body>
</html>






















































































































































































































































