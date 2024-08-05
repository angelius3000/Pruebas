<?php

include("../../Connections/ConDB.php");

$INCIDENCIASID = mysqli_real_escape_string($conn, $_POST['INCIDENCIASID']);

// Build the base query
$sql = "DELETE FROM incidencias
    WHERE INCIDENCIASID = '$INCIDENCIASID'";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}

$msg = array('INCIDENCIASID' => $INCIDENCIASID);

// send data as json format
echo json_encode($msg);
