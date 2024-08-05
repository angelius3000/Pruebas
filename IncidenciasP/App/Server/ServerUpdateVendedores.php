<?php

include("../../Connections/ConDB.php");

$VENDEDORESIDEditar = mysqli_real_escape_string($conn, $_POST['VENDEDORESIDEditar']);
$NombreVendedorEditar = mysqli_real_escape_string($conn, $_POST['NombreVendedorEditar']);
$IncidenciasVendedorEditar = mysqli_real_escape_string($conn, $_POST['IncidenciasVendedorEditar']);

// Build the base query
$sql = "UPDATE vendedores SET
    NombreVendedor = '$NombreVendedorEditar'
    WHERE VENDEDORESID = '$VENDEDORESIDEditar'";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}

 $msg = array('VENDEDORESID' => "VENDEDORESIDEditar");

//send data as json format
echo json_encode($msg);
