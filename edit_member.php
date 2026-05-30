<?php
include("../includes/db.php");

$id = $_GET['id'];

/* GET MEMBER */
$member = $conn->query("SELECT * FROM members WHERE id=$id")->fetch_assoc();

/* GET EQUIPMENT */
$equipment = $conn->query("SELECT * FROM equipment");

/* GET SELECTED EQUIPMENT */
$selected = [];
$res = $conn->query("SELECT equipment_id FROM member_equipment WHERE member_id=$id");

if($res){
    while($row = $res->fetch_assoc()){
        $selected[] = $row['equipment_id'];
    }
}

/* UPDATE MEMBER */
if(isset($_POST['update'])){

    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $occupation = $_POST['occupation'];

    $conn->query("
        UPDATE members SET
        name='$name',
        dob='$dob',
        address='$address',
        phone='$phone',
        gender='$gender',
        occupation='$occupation'
        WHERE id=$id
    ");

    /* RESET EQUIPMENT */
    $conn->query("DELETE FROM member_equipment WHERE member_id=$id");

    if(!empty($_POST['equipment'])){
        foreach($_POST['equipment'] as $eq_id){
            $conn->query("
                INSERT INTO member_equipment (member_id, equipment_id)
                VALUES ($id, $eq_id)
            ");
        }
    }

    echo "<script>alert('Member Updated'); window.location='view_members.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Member</title>

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

        .equip-card{
            cursor:pointer;
        }

        .equip-card input{
            display:none;
        }

        .card-box{
            background:white;
            border:2px solid #e5e7eb;
            padding:12px;
            border-radius:12px;
            text-align:center;
            transition:0.3s;
        }

        .equip-card input:checked + .card-box{
            background:#1d4ed8;
            color:white;
            border-color:#1d4ed8;
        }
    </style>
</head>

<body>

<div class="container">

<div class="box">

<h3>✏️ Edit Member</h3>

<form method="POST">

<input type="text" name="name" value="<?= $member['name'] ?>" class="form-control mb-2">
<input type="date" name="dob" value="<?= $member['dob'] ?>" class="form-control mb-2">
<input type="text" name="address" value="<?= $member['address'] ?>" class="form-control mb-2">
<input type="text" name="phone" value="<?= $member['phone'] ?>" class="form-control mb-2">

<select name="gender" class="form-control mb-2">
    <option <?= $member['gender']=="Male"?"selected":"" ?>>Male</option>
    <option <?= $member['gender']=="Female"?"selected":"" ?>>Female</option>
    <option <?= $member['gender']=="Other"?"selected":"" ?>>Other</option>
</select>

<input type="text" name="occupation" value="<?= $member['occupation'] ?>" class="form-control mb-2">

<hr>

<h5>🏋️ Update Equipment</h5>

<div class="row g-2">

<?php if($equipment){ while($e = $equipment->fetch_assoc()) { ?>

<div class="col-6 col-md-4">

<label class="equip-card">

<input type="checkbox" name="equipment[]" value="<?= $e['id'] ?>"
<?= in_array($e['id'],$selected) ? "checked" : "" ?>>

<div class="card-box">
    <?= $e['name'] ?>
</div>

</label>

</div>

<?php }} ?>

</div>

<br>

<button name="update" class="btn btn-success w-100">
Update Member
</button>

</form>

</div>

</div>

</body>
</html>