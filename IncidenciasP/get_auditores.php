<?php
require_once 'ConDB.php';

$sql = "SELECT NombreAuditor FROM auditores";
$result = $conn->query($sql);

$auditores = [];
while ($row = $result->fetch_assoc()) {
    $auditores[] = ["value" => $row['NombreAuditor'], "text" => $row['NombreAuditor']];
}

echo json_encode($auditores);
$conn->close();
?>
