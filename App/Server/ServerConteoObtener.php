<?php
require_once __DIR__ . '/../../Connections/ConDB.php';

header('Content-Type: application/json; charset=utf-8');

if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'No se pudo conectar a la base de datos.']);
    exit;
}

$fecha = date('Y-m-d');

$intervalos = [];
for ($hora = 8; $hora < 19; $hora++) {
    $inicio = sprintf('%02d:00:00', $hora);
    $fin = sprintf('%02d:00:00', $hora + 1);
    $intervalos[] = [$inicio, $fin];
}

$insertStmt = @mysqli_prepare(
    $conn,
    'INSERT INTO conteo_visitantes (Fecha, HoraInicio, HoraFin) VALUES (?, ?, ?) '
        . 'ON DUPLICATE KEY UPDATE HoraFin = VALUES(HoraFin)'
);

if ($insertStmt) {
    foreach ($intervalos as $intervalo) {
        [$inicio, $fin] = $intervalo;
        mysqli_stmt_bind_param($insertStmt, 'sss', $fecha, $inicio, $fin);
        mysqli_stmt_execute($insertStmt);
    }
    mysqli_stmt_close($insertStmt);
}

$stmt = @mysqli_prepare(
    $conn,
    'SELECT HoraInicio, Hombre, Mujer, Pareja, Familia, Cuadrilla '
        . 'FROM conteo_visitantes WHERE Fecha = ? ORDER BY HoraInicio'
);

$data = [];
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $fecha);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $horaInicio, $hombre, $mujer, $pareja, $familia, $cuadrilla);

    while (mysqli_stmt_fetch($stmt)) {
        $total = (int)$hombre + (int)$mujer + (int)$pareja + (int)$familia + (int)$cuadrilla;
        $data[] = [
            'hora_inicio' => date('H:i', strtotime($horaInicio)),
            'hombre' => (int)$hombre,
            'mujer' => (int)$mujer,
            'pareja' => (int)$pareja,
            'familia' => (int)$familia,
            'cuadrilla' => (int)$cuadrilla,
            'total' => $total,
        ];
    }

    mysqli_stmt_close($stmt);
}

echo json_encode(['success' => true, 'fecha' => $fecha, 'data' => $data]);
