<?php
include("../includes/db.php");

$filter = $_GET['filter'] ?? '';

$where = "";

if($filter == "paid"){
    $where = "WHERE p.end_date >= CURDATE()";
}
elseif($filter == "unpaid"){
    $where = "WHERE p.end_date IS NULL OR p.end_date < CURDATE()";
}

$result = $conn->query("
SELECT m.*, p.amount, p.start_date, p.end_date
FROM members m
LEFT JOIN payments p 
ON m.id = p.member_id
AND p.id = (
    SELECT MAX(id) FROM payments WHERE member_id = m.id
)
$where
ORDER BY m.id DESC
");
?>

<!-- HTML STARTS AFTER THIS -->
<!DOCTYPE html>
<html>
<head>
    <title>Members</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7fb;
            font-family:Segoe UI;
        }

        .topbar{
            background:white;
            padding:15px;
            border-radius:15px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin:20px 0;
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
        }

        .member-card{
            background:white;
            border-radius:18px;
            padding:18px;
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
            transition:0.3s;
            border-left:3px solid #2563eb;
            height:100%;
        }

        .member-card:hover{
             transform:translateY(-5px);
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
        }

        .profile{
            width:65px;
            height:65px;
            border-radius:50%;
            object-fit:cover;
            border:2px solid #1d4ed8;
        }

        .status-active{
            background:#22c55e;
            color:white;
            padding:3px 10px;
            border-radius:20px;
            font-size:12px;
        }

        .status-expired{
            background:#ef4444;
            color:white;
            padding:3px 10px;
            border-radius:20px;
            font-size:12px;
        }

      
            .badge-equipment{
    background:#eef2ff;
    color:#1d4ed8;
    border-radius:12px;
    padding:4px 8px;
    font-size:11px;
    margin:2px;
    font-size:11px;
    display:inline-block;
        }

        .actions a{
            margin:2px;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- TOP BAR -->
    <div class="topbar">
        <h4>👥 Gym Members</h4>
        <div class="mt-2">
    <button class="btn btn-outline-success btn-sm">Paid</button>
<button class="btn btn-outline-danger btn-sm">Unpaid</button>
<button class="btn btn-outline-dark btn-sm">All</button>
</div>

        <div>
            <a href="add_member.php" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Add Member
            </a>

            <a href="../dashboard.php" class="btn btn-dark btn-sm">
                🏠 Dashboard
            </a>
        </div>
    </div>

    <!-- GRID -->
    <div class="row g-3">

        <?php if($result){ while($row = $result->fetch_assoc()) { ?>

        <?php
            $mid = $row['id'];

            $eq = $conn->query("
                SELECT e.name 
                FROM equipment e
                JOIN member_equipment me ON e.id = me.equipment_id
                WHERE me.member_id = $mid
            ");
        ?>

        <div class="col-md-4">

            <div class="member-card">

                <!-- HEADER -->
                <div class="d-flex align-items-center gap-3">

                    <img src="../uploads/<?php echo $row['photo']; ?>" class="profile">

                    <div>
                        <h6 class="mb-0"><?php echo $row['name']; ?></h6>
                        <small class="text-muted"><?php echo $row['phone']; ?></small><br>

                        <?php if($row['status'] == 'active') { ?>
                            <span class="status-active">Active</span>
                        <?php } else { ?>
                            <span class="status-expired">Expired</span>
                        <?php } ?>
                    </div>

                </div>

                <hr>

                <!-- DETAILS -->
                <small>
                    <b>📍 Address:</b> <?php echo $row['address']; ?><br>
                    <b>💼 Occupation:</b> <?php echo $row['occupation']; ?>
                </small>

                <hr>

<small>
    <b>💰 Paid:</b> ₹<?= $row['amount'] ?? 0 ?><br>
    <b>📅 Valid Till:</b> <?= $row['end_date'] ?? 'Not Paid' ?><br>

    <?php if($row['end_date'] && strtotime($row['end_date']) >= time()) { ?>
        <span class="status-active">Paid</span>
    <?php } else { ?>
        <span class="status-expired">Not Paid</span>
    <?php } ?>
</small>

                <!-- EQUIPMENT -->
                <div>
                    <small><b>🏋️ Equipment:</b></small><br>

                    <?php if($eq){ while($e = $eq->fetch_assoc()) { ?>
                        <span class="badge-equipment">
                            <?= $e['name'] ?>
                        </span>
                    <?php }} ?>
                </div>

                <hr>

                <!-- ACTIONS -->
                <div class="actions d-flex flex-wrap">

    <a href="payment_history.php?id=<?= $row['id'] ?>" 
       class="btn btn-primary btn-sm">💳</a>

    <a href="edit_member.php?id=<?= $row['id'] ?>" 
       class="btn btn-success btn-sm">
       <i class="fa fa-pen"></i>
    </a>

    <a href="membership_card.php?id=<?= $row['id'] ?>" 
       class="btn btn-primary btn-sm">
       <i class="fa fa-id-card"></i>
    </a>

    <a href="../attendance/checkin.php?id=<?= $row['id'] ?>" 
       class="btn btn-outline-dark btn-sm">
       <i class="fa fa-check"></i>
    </a>

    <a href="delete_member.php?id=<?= $row['id'] ?>" 
       class="btn btn-danger btn-sm">
       <i class="fa fa-trash"></i>
    </a>

</div>

            </div>

        </div>

        <?php }} ?>

    </div>

</div>

</body>
</html>