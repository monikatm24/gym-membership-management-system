
<?php
include("../includes/db.php");
$month = $_GET['month'] ?? date('m');


/* TODAY PRESENT COUNT */
$todayCount = 0;

$res = $conn->query("
    SELECT COUNT(*) as total 
    FROM attendance 
    WHERE DATE(check_in) = CURDATE()
");

if($res){
    $todayCount = $res->fetch_assoc()['total'];
}

$result = $conn->query("
SELECT a.*, m.name 
FROM attendance a
JOIN members m ON m.id = a.member_id
WHERE MONTH(a.check_in) = $month
ORDER BY a.check_in DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI';
        }

        .header {
            background: white;
            padding: 15px;
            border-radius: 12px;
            margin: 20px 0;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .title {
            font-size: 22px;
            font-weight: 700;
            color: #1d2b64;
        }

        .card-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }

        table th {
            background: #1d2b64;
            color: white;
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-between align-items-center mb-3">

    <h4>🏋️ Gym System</h4>

    <a href="../dashboard.php" class="btn btn-outline-primary btn-sm">
        🏠 Home
    </a>

</div>
    <a href="../dashboard.php" class="btn btn-dark btn-sm mb-3">
    ⬅ Back to Dashboard
</a>

<div class="container">

    <div class="header">
        <div class="title">📋 Attendance Records</div>
        
    </div>
<div class="mt-2">
    <span class="badge bg-success">
        Present Today: <?= $todayCount ?>
    </span>
</div>
    <div class="card-box">
        <form method="GET" class="mb-3">

    <select name="month" class="form-control w-25 d-inline">

        <option value="01">Jan</option>
        <option value="02">Feb</option>
        <option value="03">Mar</option>
        <option value="04">Apr</option>
        <option value="05">May</option>
        <option value="06">Jun</option>
        <option value="07">Jul</option>
        <option value="08">Aug</option>
        <option value="09">Sep</option>
        <option value="10">Oct</option>
        <option value="11">Nov</option>
        <option value="12">Dec</option>

    </select>

    <button class="btn btn-primary btn-sm">Filter</button>

</form>

        <table class="table table-bordered table-hover">

            <tr>
    <th>Member</th>
    <th>Date</th>
    <th>Time</th>
    <th>Status</th>
</tr>

            <?php while($row = $result->fetch_assoc()) { ?>

<tr>
    <td><?= $row['name'] ?></td>

    <td><?= date('d M Y', strtotime($row['check_in'])) ?></td>

    <td><?= date('h:i A', strtotime($row['check_in'])) ?></td>

    <td>
        <?php
        if (!empty($row['check_in'])) {
            echo '<span class="badge bg-success">Present</span>';
        } else {
            echo '<span class="badge bg-danger">Absent</span>';
        }
        ?>
    </td>
</tr>

<?php } ?>

        </table>

    </div>

</div>

</body>
</html>