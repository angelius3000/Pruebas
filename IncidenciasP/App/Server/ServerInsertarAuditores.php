<?php

include("../../Connections/ConDB.php");

$AUDITORESID = mysqli_real_escape_string($conn, $_POST['AUDITORESID']);
$NombreAuditor = mysqli_real_escape_string($conn, $_POST['NombreAuditor']);

$sql = "INSERT INTO auditores (AUDITORESID, NombreAuditor) VALUES ('$AUDITORESID', '$NombreAuditor')";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}

$last_id = mysqli_insert_id($conn);

$msg = array('AUDITORESID' => $last_id);

// send data as json format
echo json_encode($msg);

mysqli_close($conn);
