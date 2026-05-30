<?php
$conn = new mysqli("localhost", "root", "", "gym_db", 3307);

$id = $_GET['id'];
$member = $conn->query("SELECT * FROM members WHERE id=$id")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Member QR Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f6f9;
            font-family:Segoe UI;
        }

        .box{
            max-width:400px;
            margin:60px auto;
            background:white;
            padding:20px;
            border-radius:15px;
            text-align:center;
            box-shadow:0 6px 18px rgba(0,0,0,0.1);
        }

        img{
            margin-top:15px;
        }
    </style>
</head>

<body>

<div class="box">

    <h4>🏋️ <?php echo $member['name']; ?></h4>

    <!-- QR CODE -->
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo $member['id']; ?>">

    <p class="mt-3">Scan for Attendance</p>

</div>

</body>
</html>