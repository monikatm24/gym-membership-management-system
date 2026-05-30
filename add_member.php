<?php
include("../includes/db.php");

/* FETCH EQUIPMENT */
$equipment = $conn->query("SELECT * FROM equipment");

/* SAVE MEMBER */
if (isset($_POST['save'])) {

    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $occupation = $_POST['occupation'];

    /* VALIDATION */
    if ($occupation == "") {
        die("Occupation is required");
    }

    if ($_FILES['photo']['name'] == "") {
        die("Photo required");
    }

    $photo = time() . "_" . $_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "../uploads/".$photo);

    /* INSERT MEMBER */
    $insert = $conn->query("
        INSERT INTO members 
        (name,dob,address,phone,gender,occupation,photo,status)
        VALUES 
        ('$name','$dob','$address','$phone','$gender','$occupation','$photo','expired')
    ");

    if(!$insert){
        die("Error: " . $conn->error);
    }

    $member_id = $conn->insert_id;

    /* SAVE EQUIPMENT */
    if (!empty($_POST['equipment'])) {
        foreach ($_POST['equipment'] as $eq_id) {

            $conn->query("
                INSERT INTO member_equipment (member_id, equipment_id)
                VALUES ($member_id, $eq_id)
            ");
        }
    }

    echo "<script>alert('Member Added Successfully'); window.location='view_members.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Member</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7fb;
            font-family:Segoe UI;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:15px;
            box-shadow:0 6px 18px rgba(0,0,0,0.08);
        }

        .equip-box{
            background:#f9fafb;
            padding:10px;
            border-radius:10px;
        }
    </style>
</head>

<body>

<div class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>➕ Add Member</h4>
    <a href="../dashboard.php" class="btn btn-dark btn-sm">🏠 Dashboard</a>
</div>

<div class="card">

<form method="POST" enctype="multipart/form-data">

<div class="row">

<div class="col-md-6 mb-2">
<input type="text" name="name" class="form-control" placeholder="Name" required>
</div>

<div class="col-md-6 mb-2">
<input type="date" name="dob" class="form-control" required>
</div>

<div class="col-md-6 mb-2">
<input type="text" name="phone" class="form-control" placeholder="Phone" required>
</div>

<div class="col-md-6 mb-2">
<input type="text" name="occupation" class="form-control" placeholder="Occupation" required>
</div>

<div class="col-md-6 mb-2">
<select name="gender" class="form-control">
<option>Male</option>
<option>Female</option>
<option>Other</option>
</select>
</div>

<div class="col-md-6 mb-2">
<input type="file" name="photo" class="form-control" required>
</div>

<div class="col-md-12 mb-2">
<input type="text" name="address" class="form-control" placeholder="Address" required>
</div>

</div>

<hr>

<h5>🏋️ Select Equipment</h5>

<div class="equip-box">
<?php if($equipment){ while($e = $equipment->fetch_assoc()) { ?>
<label class="me-3">
<input type="checkbox" name="equipment[]" value="<?= $e['id'] ?>">
<?= $e['name'] ?>
</label>
<?php }} ?>
</div>

<br>

<button name="save" class="btn btn-primary w-100">Save Member</button>

</form>

</div>

</div>

</body>
</html>