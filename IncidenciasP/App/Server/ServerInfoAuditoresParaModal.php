<?php

include("../../Connections/ConDB.php");
// Definir La table de la base de datos

$IDDeAuditor = $_POST['ID'];

$sql = "SELECT * FROM auditores WHERE auditores.AUDITORESID = $IDDeAuditor";
$status = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
$row = mysqli_fetch_array($status);

$msg = array(
    'AUDITORESID' => $row['AUDITORESID'],
    'NombreAuditor' => $row['NombreAuditor']
);

// send data as json format
echo json_encode($msg);
