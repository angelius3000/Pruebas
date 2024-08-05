<?php

include("../../Connections/ConDB.php");

$AUDITORESIDEditar = mysqli_real_escape_string($conn, $_POST['AUDITORESIDEditar']);
$NombreAuditorEditar = mysqli_real_escape_string($conn, $_POST['NombreAuditorEditar']);

// Build the base query
$sql = "UPDATE auditores SET
    NombreAuditor = '$NombreAuditorEditar'
    WHERE AUDITORESID = '$AUDITORESIDEditar'";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}

 $msg = array('AUDITORESID' => "AUDITORESIDEditar");

//send data as json format
echo json_encode($msg);
