
<?php
include("includes/db.php");
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}


/* ================= SAFE STATS ================= */

$totalMembers = 0;
$activeMembers = 0;
$expiredMembers = 0;
$todayCheckins = 0;
$expiring = 0;

/* EQUIPMENT STATUS */
$eq_working = $conn->query("SELECT COUNT(*) as c FROM equipment WHERE status='working'")->fetch_assoc()['c'] ?? 0;
$eq_repair = $conn->query("SELECT COUNT(*) as c FROM equipment WHERE status='repair'")->fetch_assoc()['c'] ?? 0;
$eq_broken = $conn->query("SELECT COUNT(*) as c FROM equipment WHERE status='broken'")->fetch_assoc()['c'] ?? 0;

/* EXPIRING MEMBERS LIST */
$expiring_list = $conn->query("
SELECT m.name, p.end_date 
FROM payments p
JOIN members m ON m.id = p.member_id
WHERE p.end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 5 DAY)
LIMIT 3
");

/* TOTAL MEMBERS */
$res = $conn->query("SELECT COUNT(*) as total FROM members");
if($res) $totalMembers = $res->fetch_assoc()['total'];

/* ACTIVE MEMBERS */
$res = $conn->query("
    SELECT COUNT(DISTINCT member_id) as total 
    FROM payments 
    WHERE CURDATE() BETWEEN start_date AND end_date
");
if($res) $activeMembers = $res->fetch_assoc()['total'];

/* EXPIRED MEMBERS */
$res = $conn->query("
    SELECT COUNT(DISTINCT member_id) as total 
    FROM payments 
    WHERE end_date < CURDATE()
");
if($res) $expiredMembers = $res->fetch_assoc()['total'];

/* TODAY CHECKINS */
$res = $conn->query("
    SELECT COUNT(*) as total 
    FROM attendance 
    WHERE DATE(check_in) = CURDATE()
");
if($res) $todayCheckins = $res->fetch_assoc()['total'];

/* EXPIRING MEMBERS */
$res = $conn->query("
    SELECT COUNT(*) as total 
    FROM payments 
    WHERE end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 5 DAY)
");
if($res) $expiring = $res->fetch_assoc()['total'];

/* RECENT MEMBERS */
$recent = $conn->query("
    SELECT * FROM members ORDER BY id DESC LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gym Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7fb;
            font-family:Segoe UI;
        }

        /* SIDEBAR */
        .sidebar{
             width:240px;
    height:100vh;
    background: linear-gradient(180deg,#0f172a,#020617);
    position:fixed;
    padding:20px;
    box-shadow:2px 0 12px rgba(0,0,0,0.05);
    color:white;
        }

   .sidebar h4{
    margin-bottom:25px;
    color:white;
    font-weight:600;
}

        .sidebar a{
    display:block;
    padding:12px;
    text-decoration:none;
    color:#cbd5f5;
    border-radius:10px;
    margin-bottom:5px;
    transition:0.3s;
}

   .sidebar a:hover{
    background:rgba(255,255,255,0.1);
    color:white;
    transform:translateX(5px);
}

        /* MAIN */
        .main{
            margin-left:240px;
            padding:20px;
        }

        /* TOPBAR */
        .topbar{
            background:white;
            padding:16px;
            border-radius:16px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
        }

        /* CARDS */
        .card-box{
            background:white;
            padding:20px;
            border-radius:16px;
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
            transition:0.3s;
        }

        .card-box:hover{
            transform:translateY(-5px);
        }

        .icon{
            font-size:22px;
            color:#3b82f6;
        }

        .value{
            font-size:28px;
            font-weight:bold;
        }

        .label{
            color:gray;
        }

        /* TABLE */
        .table-box{
            background:white;
            padding:20px;
            border-radius:16px;
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
        }

        .badge-active{
            background:#dcfce7;
            color:#16a34a;
            padding:5px 10px;
            border-radius:10px;
        }

        .badge-expired{
            background:#fee2e2;
            color:#dc2626;
            padding:5px 10px;
            border-radius:10px;
        }
        .notice-item{
    padding:8px 10px;
    border-radius:10px;
    margin-bottom:8px;
    background:#f9fafb;
}

.notice-danger{
    background:#fee2e2;
    color:#dc2626;
}

.notice-success{
    background:#dcfce7;
    color:#16a34a;
}

.eq-row{
    padding:6px 0;
    border-bottom:1px solid #eee;
}

    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>🏋️ FitZone Gym</h4>

    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="members/view_members.php">👥 Members</a>
    <a href="members/add_member.php">➕ Add Member</a>
    <a href="attendance/view_attendance.php">📋 Attendance</a>
    <a href="attendance/scan.php">📷 Scanner</a>
    <a href="members/renew_membership.php">🔄 Renew</a>
    <a href="equipment/equipment.php">🏋️ Equipment</a>
    <a href="reports/report.php">📊 Reports</a>
    <a href="logout.php" style="color:red;">🚪 Logout</a>
</div>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <h4>Dashboard Overview</h4>
        
    </div>

    <br>

    <!-- ALERT -->
    <?php if($expiring > 0) { ?>
        <div class="alert alert-warning">
            ⚠️ <?= $expiring ?> memberships expiring in 5 days
        </div>
    <?php } ?>

    <!-- CARDS -->
    <div class="row g-3">

        <div class="col-md-3">
            <div class="card-box text-center">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="value"><?= $totalMembers ?></div>
                <div class="label">Total Members</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box text-center">
                <div class="icon"><i class="fa fa-user-check"></i></div>
                <div class="value"><?= $activeMembers ?></div>
                <div class="label">Active Members</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box text-center">
                <div class="icon"><i class="fa fa-user-xmark"></i></div>
                <div class="value"><?= $expiredMembers ?></div>
                <div class="label">Expired Members</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box text-center">
                <div class="icon"><i class="fa fa-calendar-check"></i></div>
                <div class="value"><?= $todayCheckins ?></div>
                <div class="label">Today Check-ins</div>
            </div>
        </div>

    </div>

    <br>

    <!-- RECENT MEMBERS -->
     <div class="row mt-3">

    <div class="col-md-6">
    <div class="table-box">
        <h5>👥 Recent Members</h5>
        <hr>

        <table class="table">
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Status</th>
            </tr>

            <?php if($recent){ while($r = $recent->fetch_assoc()) { ?>
            <tr>
                <td><?= $r['name'] ?></td>
                <td><?= $r['phone'] ?></td>
                <td>
                    <?php if($r['status']=="active"){ ?>
                        <span class="badge-active">Active</span>
                    <?php } else { ?>
                        <span class="badge-expired">Expired</span>
                    <?php } ?>
                </td>
            </tr>
            <?php }} ?>

        </table>
    </div>
        </div> <!-- END LEFT SIDE -->

    <!-- RIGHT SIDE -->
    <div class="col-md-6">

        <div class="table-card mb-3">

            <h5>📢 Notice Board</h5>
            <hr>

            <?php if($expiring_list && $expiring_list->num_rows > 0){ ?>
                <?php while($e = $expiring_list->fetch_assoc()) { ?>
                    <div class="mb-2">
                        ⚠️ <?= $e['name'] ?> expires on <?= $e['end_date'] ?>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="notice-item notice-success">
    ✅ No urgent expiries
</div>
            <?php } ?>

            <hr>

            <?php if($eq_broken > 0){ ?>
                <div class="notice-item notice-danger">
                    ❌ <?= $eq_broken ?> equipment needs attention
                </div>
            <?php } else { ?>
                <div class="text-success">
                    ✅ All equipment working fine
                </div>
            <?php } ?>

        </div>

        <div class="table-card">

            <h5>🏋️ Equipment Status</h5>
            <hr>

            <div class="d-flex justify-content-between eq-row">
                <span>Working</span>
                <b class="text-success"><?= $eq_working ?></b>
            </div>

            <div class="d-flex justify-content-between eq-row">
                <span>Repair</span>
                <b class="text-warning"><?= $eq_repair ?></b>
            </div>

            <div class="d-flex justify-content-between">
                <span>Broken</span>
                <b class="text-danger"><?= $eq_broken ?></b>
            </div>

        </div>

    </div> <!-- END RIGHT SIDE -->

</div> <!-- END ROW -->

</div>

</body>
</html>