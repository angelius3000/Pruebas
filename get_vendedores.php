<?php
require_once 'ConDB.php';

$sql = "SELECT NombreVendedor FROM vendedores";
$result = $conn->query($sql);

$vendedores = [];
while ($row = $result->fetch_assoc()) {
    $vendedores[] = ["value" => $row['NombreVendedor'], "text" => $row['NombreVendedor']];
}

echo json_encode($vendedores);
$conn->close();
?>
