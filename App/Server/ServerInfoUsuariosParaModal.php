<?php

include("../../Connections/ConDB.php");
// Definir La table de la base de datos

$IDDeUsuario = $_POST['ID'];

$sql = "SELECT * FROM Usuarios WHERE Usuarios.USUARIOID = $IDDeUsuario";
$status = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
$row = mysqli_fetch_array($status);

$msg = array(
    'USUARIOID' => $row['USUARIOID'],
    'PrimerNombre' => $row['PrimerNombre'],
    'SegundoNombre' => $row['SegundoNombre'],
    'ApellidoPaterno' => $row['ApellidoPaterno'],
    'ApellidoMaterno' => $row['ApellidoMaterno'],
    'Email' => $row['email'],
    'Telefono' => $row['Telefono'],
    'TIPODEUSUARIOID' => $row['TIPODEUSUARIOID']
);

// send data as json format
echo json_encode($msg);
