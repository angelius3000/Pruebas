<?php

include("../../Connections/ConDB.php");
// Definir La table de la base de datos

$IDDeIncidencias = $_POST['ID'];

$sql = "SELECT * FROM incidencias WHERE incidencias.INCIDENCIASID = $IDDeIncidencias";
$status = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
$row = mysqli_fetch_array($status);

$msg = array(
    'INCIDENCIASID' => $row['INCIDENCIASID'],
    'Fecha' => $row['Fecha'],
    'Creador' => $row['Creador'],
    'Folio' => $row['Folio'],
    'Cantidad' => $row['Cantidad'],
    'SKU' => $row['SKU'],
    //'Articulo' => $row['Articulo'],
    //'Marca' => $row['Marca'],
    //'Precio' => $row['Precio'],
    'Vendedor' => $row['Vendedor'],
    'Surtidor' => $row['Surtidor'],
    //'Total' => $row['Total'],
    'Comentarios' => $row['Comentarios']
);

// send data as json format
echo json_encode($msg);
