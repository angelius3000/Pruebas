<?php

include("../../Connections/ConDB.php");
// Definir la tabla de la base de datos

$CLCSIANDeCliente = $_POST['CLCSIAN'];

if ($CLCSIANDeCliente === '' || $CLCSIANDeCliente === '0') {
    echo json_encode([]);
    exit;
}

$sql = "SELECT * FROM clientes WHERE clientes.CLCSIAN = '$CLCSIANDeCliente'";
$status = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
$row = mysqli_fetch_array($status);

$msg = array(
    'CLIENTEID' => $row['CLIENTEID'],
    'CLIENTESIAN' => $row['CLIENTESIAN'],
    'CLCSIAN' => $row['CLCSIAN'],
    'NombreCliente' => $row['NombreCliente'],
    'EmailCliente' => $row['EmailCliente'],
    'TelefonoCliente' => $row['TelefonoCliente'],
    'NombreContacto' => $row['NombreContacto'],
    'DireccionCliente' => $row['DireccionCliente'],
    'ColoniaCliente' => $row['ColoniaCliente'],
    'CiudadCliente' => $row['CiudadCliente'],
    'EstadoCliente' => $row['EstadoCliente']
);

// send data as json format
echo json_encode($msg);
