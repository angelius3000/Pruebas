<?php

include("../../Connections/ConDB.php");

$INCIDENCIASIDEditar = mysqli_real_escape_string($conn, $_POST['INCIDENCIASIDEditar']);
$Fecha = mysqli_real_escape_string($conn, $_POST['FechaEditar']);
$Folio = mysqli_real_escape_string($conn, $_POST['FolioEditar']);
$Cantidad = mysqli_real_escape_string($conn, $_POST['CantidadEditar']);
$SKU = mysqli_real_escape_string($conn, $_POST['SKUEditar']);
$Articulo = mysqli_real_escape_string($conn, $_POST['ArticuloEditar']);
$Marca = mysqli_real_escape_string($conn, $_POST['MarcaEditar']);
$Precio = mysqli_real_escape_string($conn, $_POST['PrecioEditar']);
$Vendedor = mysqli_real_escape_string($conn, $_POST['VendedorEditar']);
$Surtidor = mysqli_real_escape_string($conn, $_POST['SurtidorEditar']);
$Total = mysqli_real_escape_string($conn, $_POST['TotalEditar']);
$Creador = mysqli_real_escape_string($conn, $_POST['CreadorEditar']);
$Comentarios = mysqli_real_escape_string($conn, $_POST['ComentariosEditar']);

// Build the base query
$sql = "UPDATE incidencias SET 
    INCIDENCIASID = '$INCIDENCIASIDEditar',
    Fecha = '$FechaEditar',
    Folio = '$FolioEditar'
    Cantidad = '$CantidadEditar'
    SKU = '$SKUEditar'
    Articulo = '$ArticuloEditar'
    Marca = '$MarcaEditar'
    Precio = '$PrecioEditar'
    Vendedor = '$VendedorEditar'
    Surtidor = '$SurtidorEditar'
    Total = '$TotalEditar'
    Creador = '$CreadorEditar'
    Comentarios = '$ComentariosEditar'
    WHERE INCIDENCIASID = '$INCIDENCIASIDEditar'";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}

$msg = array('INCIDENCIASID' => $INCIDENCIASIDEditar);

// send data as json format
echo json_encode($msg);
