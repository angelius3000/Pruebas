<?php
require_once 'ConDB.php';

$sql = "SELECT Sku, Descripcion FROM productos";
$result = $conn->query($sql);

$skus = [];
while ($row = $result->fetch_assoc()) {
    $skus[] = ["value" => $row['Sku'], "text" => $row['Sku'] . ' - ' . $row['Descripcion']];
}

echo json_encode($skus);
$conn->close();
?>
