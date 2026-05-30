
<?php
include("../includes/db.php");


/* ADD EQUIPMENT */
if (isset($_POST['add'])) {

    $name = $_POST['name'];
    $qty = $_POST['qty'];
    $status = $_POST['status'];

    $conn->query("
        INSERT INTO equipment (name, quantity, status)
        VALUES ('$name', '$qty', '$status')
    ");

    header("Location: equipment.php");
    exit();
}

/* DELETE EQUIPMENT */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM equipment WHERE id=$id");
    header("Location: equipment.php");
    exit();
}

/* STATS */
$total = $conn->query("SELECT COUNT(*) as c FROM equipment")->fetch_assoc()['c'] ?? 0;
$working = $conn->query("SELECT COUNT(*) as c FROM equipment WHERE status='working'")->fetch_assoc()['c'] ?? 0;
$repair = $conn->query("SELECT COUNT(*) as c FROM equipment WHERE status='repair'")->fetch_assoc()['c'] ?? 0;
$broken = $conn->query("SELECT COUNT(*) as c FROM equipment WHERE status='broken'")->fetch_assoc()['c'] ?? 0;

$list = $conn->query("SELECT * FROM equipment ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Equipment Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f7fb;
            font-family:Segoe UI;
        }

        .topbar{
            background:white;
            padding:16px;
            border-radius:16px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin:20px 0;
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
        }

        .stat-card{
            background:white;
            padding:18px;
            border-radius:16px;
            text-align:center;
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
            transition:0.3s;
        }

        .stat-card:hover{
            transform:translateY(-4px);
        }

        .form-card{
            background:white;
            padding:22px;
            border-radius:16px;
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
        }

        .form-control{
            border-radius:12px;
            border:1px solid #e5e7eb;
        }

        .form-control:focus{
            border-color:#3b82f6;
            box-shadow:none;
        }

        .btn-modern{
            background:#3b82f6;
            color:white;
            border-radius:12px;
            border:none;
            transition:0.3s;
        }

        .btn-modern:hover{
            background:#2563eb;
            transform:scale(1.03);
        }

        .eq-card{
            background:white;
            border-radius:16px;
            padding:18px;
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
            border-left:4px solid #3b82f6;
            transition:0.3s;
        }

        .eq-card:hover{
            transform:translateY(-5px);
        }

        .badge-working{
            background:#dcfce7;
            color:#16a34a;
            padding:5px 10px;
            border-radius:12px;
        }

        .badge-repair{
            background:#fef3c7;
            color:#d97706;
            padding:5px 10px;
            border-radius:12px;
        }

        .badge-broken{
            background:#fee2e2;
            color:#dc2626;
            padding:5px 10px;
            border-radius:12px;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- TOP BAR -->
    <div class="topbar">
        <h4>🏋️ Equipment Dashboard</h4>
        <a href="../dashboard.php" class="btn btn-dark btn-sm">🏠 Dashboard</a>
    </div>

    <!-- STATS -->
    <div class="row g-3 mb-3">

        <div class="col-md-3">
            <div class="stat-card">
                <h3><?= $total ?></h3>
                <small>Total Equipment</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <h3><?= $working ?></h3>
                <small>Working</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <h3><?= $repair ?></h3>
                <small>Repair</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <h3><?= $broken ?></h3>
                <small>Broken</small>
            </div>
        </div>

    </div>

    <!-- ADD EQUIPMENT -->
    <div class="form-card">

        <h5>➕ Add Equipment</h5>

        <form method="POST" class="row g-3">

            <!-- FIXED DROPDOWN ONLY (NO BUGS) -->
            <div class="col-md-6">
                <label class="form-label">Equipment</label>
                <select name="name" class="form-control" required>
                    <option value="">Select Equipment</option>
                    <option>Treadmill</option>
                    <option>Dumbbells</option>
                    <option>Cycle</option>
                    <option>Bench Press</option>
                    <option>Leg Press Machine</option>
                    <option>Cable Crossover</option>
                    <option>Lat Pulldown</option>
                    <option>Row Machine</option>
                    <option>Smith Machine</option>
                    <option>Shoulder Press Machine</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="qty" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="working">Working</option>
                    <option value="repair">Repair</option>
                    <option value="broken">Broken</option>
                </select>
            </div>

            <div class="col-md-12">
                <button name="add" class="btn btn-modern w-100">➕ Add Equipment</button>
            </div>

        </form>

    </div>

    <br>

    <!-- LIST -->
    <div class="row">

        <?php while($row = $list->fetch_assoc()) { ?>

        <div class="col-md-4 mb-3">

            <div class="eq-card">

                <h5><?= $row['name'] ?></h5>
                <small>Qty: <?= $row['quantity'] ?></small>

                <br><br>

                <?php if($row['status']=="working") { ?>
                    <span class="badge-working">Working</span>
                <?php } elseif($row['status']=="repair") { ?>
                    <span class="badge-repair">Repair</span>
                <?php } else { ?>
                    <span class="badge-broken">Broken</span>
                <?php } ?>

                <br><br>

                <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm w-100">
                    Delete
                </a>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

</body>
</html>