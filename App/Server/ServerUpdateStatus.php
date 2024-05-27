<?php

include("../../Connections/ConDB.php");

// Get values from form

$STATUSID = mysqli_real_escape_string($conn, $_POST['STATUSIDEditar']);
$REPARTOID = mysqli_real_escape_string($conn, $_POST['REPARTOIDEditarStatus']);
$Surtidores = mysqli_real_escape_string($conn, $_POST['Surtidores']);
$Repartidor = mysqli_real_escape_string($conn, $_POST['USUARIOIDRepartidor']);


// Build the base query
$sql = "UPDATE repartos SET 
    STATUSID = '$STATUSID'";

if (!empty($Repartidor)) {
    $sql .= ", USUARIOIDRepartidor = '$Repartidor'";
}

if (!empty($Surtidores)) {
    $sql .= ", Surtidores = '$Surtidores'";
}

$sql .= " WHERE REPARTOID = '$REPARTOID'";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}

$msg = array('REPARTOID' => $REPARTOID);

// send data as json format
echo json_encode($msg);
