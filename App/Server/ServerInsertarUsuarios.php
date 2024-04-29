<?php

include("../../Connections/ConDB.php");

// TIPODEUSUARIOID=1&CLIENTEID=&PrimerNombre=987&SegundoNombre=987&ApellidoPaterno=987&ApellidoMaterno=987&email=987&Telefono=987

$TIPODEUSUARIOID = mysqli_real_escape_string($conn, $_POST['TIPODEUSUARIOID']);
$PrimerNombre = mysqli_real_escape_string($conn, $_POST['PrimerNombre']);
$SegundoNombre = mysqli_real_escape_string($conn, $_POST['SegundoNombre']);
$ApellidoPaterno = mysqli_real_escape_string($conn, $_POST['ApellidoPaterno']);
$ApellidoMaterno = mysqli_real_escape_string($conn, $_POST['ApellidoMaterno']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$Telefono = mysqli_real_escape_string($conn, $_POST['Telefono']);

$CLIENTEID = isset($_POST['CLIENTEID']) ? mysqli_real_escape_string($conn, $_POST['CLIENTEID']) : 0;


$sql = "INSERT INTO Usuarios (PrimerNombre, SegundoNombre, ApellidoPaterno, ApellidoMaterno, email, Telefono, TIPODEUSUARIOID, CLIENTEID) VALUES ('$PrimerNombre', '$SegundoNombre', '$ApellidoPaterno', '$ApellidoMaterno', '$email', '$Telefono', '$TIPODEUSUARIOID', '$CLIENTEID')";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}

$last_id = mysqli_insert_id($conn);

$msg = array('USUARIOID' => $last_id);

// send data as json format
echo json_encode($msg);

mysqli_close($conn);
