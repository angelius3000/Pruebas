<?php

include("../../Connections/ConDB.php");
// Definir La table de la base de datos

$IDDeVendedor = $_POST['ID'];

$sql = "SELECT * FROM vendedores WHERE vendedores.VENDEDORESID = $IDDeVendedor";
$status = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
$row = mysqli_fetch_array($status);

$msg = array(
    'VENDEDORESID' => $row['VENDEDORESID'],
    'NombreVendedor' => $row['NombreVendedor'],
    'IncidenciasVendedor' => $row['IncidenciasVendedor']
);

// send data as json format
echo json_encode($msg);
