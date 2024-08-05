<?php
require_once 'ConDB.php';

if (isset($_GET['sku'])) {
    $sku = $_GET['sku'];
    
    $stmt = $conn->prepare("SELECT Descripcion, MarcaProductos, PrecioConIVA FROM productos WHERE Sku = ?");
    $stmt->bind_param("s", $sku);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
    
    echo json_encode($producto);
    
    $stmt->close();
} else {
    echo json_encode(["error" => "SKU no proporcionado"]);
}

$conn->close();
?>
