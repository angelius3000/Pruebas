<?php
require_once 'ConDB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $folio = $_POST['folio'];
    $sku = $_POST['sku'];
    $cantidad = $_POST['cantidad'];
    $vendedor = $_POST['vendedor'];
    $surtidor = $_POST['surtidor'];
    $auditor = $_POST['auditor'];
    $comentarios = $_POST['comentarios'];

    // Obtener información adicional del producto
    $stmt = $conn->prepare("SELECT Descripcion, MarcaProductos, PrecioConIVA FROM productos WHERE Sku = ?");
    $stmt->bind_param("s", $sku);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    $articulo = $producto['Descripcion'];
    $marca = $producto['MarcaProductos'];
    $precio = $producto['PrecioConIVA'];
    $total = $cantidad * $precio;

    // Insertar la incidencia en la base de datos
    $sql = "INSERT INTO incidencias (Fecha, Folio, Cantidad, SKU, Articulo, Marca, Precio, Vendedor, Surtidor, Total, Auditor, Comentarios) 
            VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssssssss", $folio, $cantidad, $sku, $articulo, $marca, $precio, $vendedor, $surtidor, $total, $auditor, $comentarios);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Incidencia registrada exitosamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al registrar la incidencia: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
}
?>
