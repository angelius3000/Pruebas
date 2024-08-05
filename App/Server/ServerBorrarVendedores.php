<?php

include("../../Connections/ConDB.php");

$VENDEDORESID = mysqli_real_escape_string($conn, $_POST['VENDEDORESID']);

// Build the base query
$sql = "DELETE FROM vendedores
    WHERE VENDEDORESID = '$VENDEDORESID'";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}

$msg = array('VENDEDORESID' => $VENDEDORESID);

// send data as json format
echo json_encode($msg);
