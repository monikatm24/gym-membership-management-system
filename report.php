<?php
include("../includes/db.php");

/* FILTER */
$filter = $_GET['filter'] ?? 'today';

/* BASE SQL */
$sql = "
SELECT 
    m.id,
    m.name, 
    m.phone, 
    p.amount, 
    p.start_date, 
    p.end_date,

    /* ATTENDANCE COUNT */
    (
        SELECT COUNT(*) 
        FROM attendance a 
        WHERE a.member_id = m.id
    ) as attendance_count

FROM payments p
JOIN members m ON m.id = p.member_id
";

/* APPLY FILTER */
if ($filter == 'today') {

    $sql .= " WHERE DATE(p.start_date) = CURDATE() ";

}
elseif ($filter == 'week') {

    $sql .= " WHERE p.start_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ";

}
elseif ($filter == 'month') {

    $sql .= " WHERE MONTH(p.start_date) = MONTH(CURDATE())
              AND YEAR(p.start_date) = YEAR(CURDATE()) ";

}

$sql .= " ORDER BY p.id DESC";

$result = $conn->query($sql);

/* SUMMARY STATS */
$totalRevenue = 0;
$totalCount = 0;

if($result){
    $rows = [];
    while($r = $result->fetch_assoc()){
        $rows[] = $r;
        $totalRevenue += $r['amount'];
        $totalCount++;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7fb;
            font-family:Segoe UI;
        }

        .topbar{
            background:white;
            padding:15px;
            border-radius:12px;
            margin:20px 0;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
        }

        .box{
            background:white;
            padding:20px;
            border-radius:15px;
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
        }

        .stat-card{
            background:white;
            padding:15px;
            border-radius:12px;
            text-align:center;
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
        }

        .btn-filter{
            margin-right:5px;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- TOP -->
    <div class="topbar">
        <h4>📊 Reports Dashboard</h4>
        <a href="../dashboard.php" class="btn btn-dark btn-sm">🏠 Dashboard</a>
    
  <a href="export_excel.php"
class="btn btn-success">
📥 Print All Members
</a>
</div>

    <!-- FILTER BUTTONS -->
    <div class="mb-3">
        <a href="?filter=today" class="btn btn-primary btn-filter">Today</a>
        <a href="?filter=week" class="btn btn-warning btn-filter">Last 7 Days</a>
        <a href="?filter=month" class="btn btn-success btn-filter">This Month</a>
    </div>

    <!-- SUMMARY -->
    <div class="row g-3 mb-3">

        <div class="col-md-6">
            <div class="stat-card">
                <h4>₹<?= $totalRevenue ?></h4>
                <small>Total Revenue</small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="stat-card">
                <h4><?= $totalCount ?></h4>
                <small>Total Transactions</small>
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="box">

        <table class="table table-bordered table-hover">

            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Amount</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
                <th>Attendance</th>
            </tr>

            <?php if(!empty($rows)) { foreach($rows as $row) { ?>

            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td>₹<?= $row['amount'] ?></td>
                <td><?= $row['start_date'] ?></td>
                <td><?= $row['end_date'] ?></td>

                <td>
                    <?php if(strtotime($row['end_date']) >= time()) { ?>
                        <span class="badge bg-success">Active</span>
                    <?php } else { ?>
                        <span class="badge bg-danger">Expired</span>
                    <?php } ?>
                </td>

                <td><?= $row['attendance_count'] ?></td>
            </tr>

            <?php }} else { ?>
                <tr><td colspan="7">No records found</td></tr>
            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>