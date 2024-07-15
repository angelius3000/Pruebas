<?php

include("../../Connections/ConDB.php");

$FechaRepartoBorrar = mysqli_real_escape_string($conn, $_POST['FechaReparto']);
$HoraRepartoBorrar = mysqli_real_escape_string($conn, $_POST['HoraReparto']);

// Build the base query
$sql = "DELETE FROM repartos
    WHERE FechaReparto = '$FechaRepartoBorrar'";
    
$sql = "DELETE FROM repartos
    WHERE HoraReparto = '$HoraRepartoBorrar'";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}

$msg = array('REPARTOID' => $REPARTOID);

// send data as json format
echo json_encode($msg);
