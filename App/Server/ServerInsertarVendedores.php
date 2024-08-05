<?php

include("../../Connections/ConDB.php");

$VENDEDORESID = mysqli_real_escape_string($conn, $_POST['VENDEDORESID']);
$NombreVendedor = mysqli_real_escape_string($conn, $_POST['NombreVendedor']);
$IncidenciasVendedor = mysqli_real_escape_string($conn, $_POST['IncidenciasVendedor']);

$sql = "INSERT INTO vendedores (VENDEDORESID, NombreVendedor, IncidenciasVendedor) VALUES ('$VENDEDORESID', '$NombreVendedor', '$IncidenciasVendedor')";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}

$last_id = mysqli_insert_id($conn);

$msg = array('VENDEDORESID' => $last_id);

// send data as json format
echo json_encode($msg);

mysqli_close($conn);
