<?php

include("../../Connections/ConDB.php");

$INCIDENCIASID = mysqli_real_escape_string($conn, $_POST['INCIDENCIASID']);
$Folio = mysqli_real_escape_string($conn, $_POST['Folio']);
$Cantidad = mysqli_real_escape_string($conn, $_POST['Cantidad']);
$SKU = mysqli_real_escape_string($conn, $_POST['SKU']);

$Articulo = "SELECT productos.Descripcion FROM productos WHERE productos.Sku = '$SKU'";
$status = mysqli_query($conn, $Articulo) or die("database error:" . mysqli_error($conn));
$Articulo = mysqli_fetch_array($status);
$Articulo = $Articulo['Descripcion'];

$Marca = "SELECT productos.MarcaProductos FROM productos WHERE productos.Sku = '$SKU'";
$status = mysqli_query($conn, $Marca) or die("database error:" . mysqli_error($conn));
$Marca = mysqli_fetch_array($status);
$Marca = $Marca['MarcaProductos'];

$Precio = "SELECT productos.PrecioConIVA FROM productos WHERE productos.Sku = '$SKU'";
$status = mysqli_query($conn, $Precio) or die("database error:" . mysqli_error($conn));
$Precio = mysqli_fetch_array($status);
$Precio = $Precio['PrecioConIVA'];

$Vendedor = mysqli_real_escape_string($conn, $_POST['Vendedor']);
$Surtidor = mysqli_real_escape_string($conn, $_POST['Surtidor']);
$Total = $Cantidad * $Precio;
$Auditor = mysqli_real_escape_string($conn, $_POST['Auditor']);
$Comentarios = mysqli_real_escape_string($conn, $_POST['Comentarios']);





$sql = "INSERT INTO incidencias (Folio, Cantidad, SKU, Articulo, Marca, Precio, Vendedor, Surtidor, Total, Auditor, Comentarios)
            VALUES ('$Folio', '$Cantidad', '$SKU', '$Articulo', '$Marca', '$Precio', '$Vendedor', '$Surtidor', '$Total', '$Auditor', '$Comentarios')";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}

$last_id = mysqli_insert_id($conn);

$msg = array('INCIDENCIASID' => $last_id);

// send data as json format
echo json_encode($msg);

mysqli_close($conn);
