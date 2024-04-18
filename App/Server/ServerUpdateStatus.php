<?php

include("../../Connections/ConDB.php");

// Get values from form

//STATUSIDEditar=6&REPARTOIDEditarStatus=2

$STATUSID = mysqli_real_escape_string($conn, $_POST['STATUSIDEditar']);
$REPARTOID = mysqli_real_escape_string($conn, $_POST['REPARTOIDEditarStatus']);

// Build the base query
$sql = "UPDATE repartos SET 
    STATUSID = '$STATUSID'
    WHERE REPARTOID = '$REPARTOID'";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}

$msg = array('REPARTOID' => $REPARTOID);

// send data as json format
echo json_encode($msg);
