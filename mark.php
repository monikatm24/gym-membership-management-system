
<?php
include("../includes/db.php");
$conn = new mysqli("localhost", "root", "", "gym_db", 3307);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id == 0){
    die("Invalid QR");
}

$today = date('Y-m-d');

/* CHECK TODAY ATTENDANCE */
$check = $conn->query("
    SELECT * FROM attendance 
    WHERE member_id=$id 
    AND DATE(check_in)=CURDATE()
    AND check_out IS NULL
");

/* IF NOT CHECKED IN → CHECK IN */
if($check->num_rows == 0){

    $conn->query("
        INSERT INTO attendance(member_id, check_in)
        VALUES($id, NOW())
    ");

    echo "✅ Check-in Successful";

}else{

    /* CHECK OUT */
    $conn->query("
        UPDATE attendance 
        SET check_out = NOW()
        WHERE member_id=$id 
        AND DATE(check_in)=CURDATE()
        AND check_out IS NULL
    ");

    echo "🚪 Check-out Successful";
}
?>