<?php
require_once __DIR__ . '/../../Connections/ConDB.php';

header('Content-Type: application/json; charset=utf-8');

if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'No se pudo conectar a la base de datos.']);
    exit;
}

$tipo = isset($_POST['tipo']) ? strtolower(trim((string)$_POST['tipo'])) : '';
$delta = isset($_POST['delta']) ? (int)$_POST['delta'] : 0;

$permitidos = [
    'hombre' => 'Hombre',
    'mujer' => 'Mujer',
    'pareja' => 'Pareja',
    'familia' => 'Familia',
    'cuadrilla' => 'Cuadrilla',
];

if (!isset($permitidos[$tipo]) || !in_array($delta, [1, -1], true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Datos inválidos para actualizar el conteo.']);
    exit;
}

$horaActual = (int)date('G');
if ($horaActual < 8 || $horaActual >= 19) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'El conteo solo está disponible entre las 8:00 y 19:00.']);
    exit;
}

$fecha = date('Y-m-d');
$horaInicio = sprintf('%02d:00:00', $horaActual);
$horaFin = sprintf('%02d:00:00', $horaActual + 1);

$insertStmt = @mysqli_prepare(
    $conn,
    'INSERT INTO conteo_visitantes (Fecha, HoraInicio, HoraFin) VALUES (?, ?, ?) '
        . 'ON DUPLICATE KEY UPDATE HoraFin = VALUES(HoraFin)'
);

if ($insertStmt) {
    mysqli_stmt_bind_param($insertStmt, 'sss', $fecha, $horaInicio, $horaFin);
    mysqli_stmt_execute($insertStmt);
    mysqli_stmt_close($insertStmt);
}

$columna = $permitidos[$tipo];
$updateSql = "UPDATE conteo_visitantes SET $columna = GREATEST($columna + ?, 0) WHERE Fecha = ? AND HoraInicio = ?";
$updateStmt = @mysqli_prepare($conn, $updateSql);

if (!$updateStmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'No se pudo actualizar el conteo.']);
    exit;
}

mysqli_stmt_bind_param($updateStmt, 'iss', $delta, $fecha, $horaInicio);
mysqli_stmt_execute($updateStmt);
mysqli_stmt_close($updateStmt);

$selectStmt = @mysqli_prepare(
    $conn,
    'SELECT HoraInicio, Hombre, Mujer, Pareja, Familia, Cuadrilla '
        . 'FROM conteo_visitantes WHERE Fecha = ? AND HoraInicio = ? LIMIT 1'
);

if ($selectStmt) {
    mysqli_stmt_bind_param($selectStmt, 'ss', $fecha, $horaInicio);
    mysqli_stmt_execute($selectStmt);
    mysqli_stmt_bind_result($selectStmt, $horaSeleccionada, $hombre, $mujer, $pareja, $familia, $cuadrilla);

    if (mysqli_stmt_fetch($selectStmt)) {
        $total = (int)$hombre + (int)$mujer + (int)$pareja + (int)$familia + (int)$cuadrilla;
        echo json_encode([
            'success' => true,
            'fila' => [
                'hora_inicio' => date('H:i', strtotime($horaSeleccionada)),
                'hombre' => (int)$hombre,
                'mujer' => (int)$mujer,
                'pareja' => (int)$pareja,
                'familia' => (int)$familia,
                'cuadrilla' => (int)$cuadrilla,
                'total' => $total,
            ],
        ]);
        mysqli_stmt_close($selectStmt);
        exit;
    }

    mysqli_stmt_close($selectStmt);
}

http_response_code(500);
echo json_encode(['success' => false, 'message' => 'No se pudo obtener el conteo actualizado.']);
