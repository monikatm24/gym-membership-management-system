<?php

include("../includes/db.php");

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=All_Gym_Members_Report.xls");

echo "Name\tPhone\tAmount\tMembership Valid Till\tStatus\tAttendance\n";

$result = $conn->query("

SELECT
m.name,
m.phone,
IFNULL(p.amount,0) amount,
IFNULL(p.end_date,'Not Paid') end_date,
m.status,

(
SELECT COUNT(*)
FROM attendance a
WHERE a.member_id=m.id
) attendance

FROM members m

LEFT JOIN payments p
ON p.id=
(
SELECT MAX(id)
FROM payments
WHERE member_id=m.id
)

ORDER BY m.name ASC

");

while($row=$result->fetch_assoc()){

echo
$row['name']."\t".
$row['phone']."\t".
$row['amount']."\t".
$row['end_date']."\t".
$row['status']."\t".
$row['attendance']."\n";

}

?>