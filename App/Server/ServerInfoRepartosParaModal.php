<?php

include("../../Connections/ConDB.php");
// Definir La table de la base de datos

$IDDeReparto = $_POST['ID'];

$sql = "SELECT * FROM repartos WHERE repartos.REPARTOID = '$IDDeReparto'";
$status = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
$row = mysqli_fetch_array($status);

$msg = array(
    'REPARTOID' => $row['REPARTOID'],
    'USUARIOID' => $row['USUARIOID'],
    'CLIENTEID' => $row['CLIENTEID'],
    'NumeroDeFactura' => $row['NumeroDeFactura'],
    'FechaReparto' => $row['FechaReparto'],
    'HoraReparto' => $row['HoraReparto'],
    'FechaDeRegistro' => $row['FechaDeRegistro'],
    'Calle' => $row['Calle'],
    'NumeroEXT' => $row['NumeroEXT'],
    'Colonia' => $row['Colonia'],
    'CP' => $row['CP'],
    'Ciudad' => $row['Ciudad'],
    'Estado' => $row['Estado'],
    'Receptor' => $row['Receptor'],
    'TelefonoDeReceptor' => $row['TelefonoDeReceptor'],
    'TelefonoAlternativo' => $row['TelefonoAlternativo'],
    'Comentarios' => $row['Comentarios'],
    'STATUSID' => $row['STATUSID']

);

// send data as json format
echo json_encode($msg);
