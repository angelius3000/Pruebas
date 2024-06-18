<?php

include("../../Connections/ConDB.php");

$CLIENTEIDDeshabilitar = mysqli_real_escape_string($conn, $_POST['CLIENTEID']);

// Build the base query
$sql = "UPDATE clientes SET 
    Deshabilitado = 1
    WHERE CLIENTEID = '$CLIENTEIDDeshabilitar'";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}

$msg = array('CLIENTEID' => $CLIENTEIDDeshabilitar);

// send data as json format
echo json_encode($msg);
