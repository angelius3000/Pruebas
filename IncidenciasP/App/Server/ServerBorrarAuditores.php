<?php

include("../../Connections/ConDB.php");

$AUDITORESID = mysqli_real_escape_string($conn, $_POST['AUDITORESID']);

// Build the base query
$sql = "DELETE FROM auditores
    WHERE AUDITORESID = '$AUDITORESID'";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}

$msg = array('AUDITORESID' => $AUDITORESID);

// send data as json format
echo json_encode($msg);
