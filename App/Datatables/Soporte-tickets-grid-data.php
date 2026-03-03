<?php
include("../../Connections/ConDB.php");
session_start();
header('Content-Type: application/json; charset=utf-8');
if (empty($_SESSION['USUARIOID'])) {
    echo json_encode(['draw' => 0, 'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => []]);
    exit;
}

$rol = strtolower(trim($_SESSION['TipoDeUsuario'] ?? ''));
$usuarioId = (int)$_SESSION['USUARIOID'];

// read params
$draw = intval($_POST['draw'] ?? 0);
$start = intval($_POST['start'] ?? 0);
$length = intval($_POST['length'] ?? 10);
$orderCol = intval($_POST['order'][0]['column'] ?? 0);
$orderDir = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';

$columns = ['folio','asunto','estado','prioridad_calculada','solicitante_nombre','tecnico_nombre','created_at'];
$orderBy = $columns[$orderCol] ?? 'created_at';

$cond = [];
$params = [];

if (!empty($_POST['estado'])) {
    $cond[] = 't.estado = ?';
    $params[] = $_POST['estado'];
}
if (!empty($_POST['prioridad'])) {
    $cond[] = 'COALESCE(t.prioridad_override,t.prioridad_calculada) = ?';
    $params[] = $_POST['prioridad'];
}
if (!empty($_POST['texto'])) {
    $cond[] = '(t.folio LIKE CONCAT(?,"%") OR t.asunto LIKE CONCAT("%",?,"%") OR t.descripcion LIKE CONCAT("%",?,"%"))';
    $params[] = $_POST['texto'];
    $params[] = $_POST['texto'];
    $params[] = $_POST['texto'];
}

// role-based visibility
if ($rol === 'solicitante') {
    $cond[] = 't.solicitante_id = ?';
    $params[] = $usuarioId;
} elseif ($rol === 'tecnico') {
    // allow filter by buttons
    if (!empty($_POST['asignadosami'])) {
        $cond[] = 't.tecnico_id = ?';
        $params[] = $usuarioId;
    }
    if (!empty($_POST['sinasignar'])) {
        $cond[] = 't.tecnico_id IS NULL';
    }
}

$where = '';
if (!empty($cond)) $where = 'WHERE ' . implode(' AND ', $cond);

// count total
$totalQ = "SELECT COUNT(*) FROM tickets t $where";
$stmt = mysqli_prepare($conn, $totalQ);
if ($stmt && !empty($params)) {
    $types = str_repeat('s', count($params));
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $recordsFiltered);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
$recordsTotal = $recordsFiltered;

// fetch data
$dataQ = "SELECT t.id, t.folio, t.asunto, t.estado, COALESCE(t.prioridad_override,t.prioridad_calculada) as prioridad, 
    (SELECT nombre FROM users u WHERE u.id = t.solicitante_id) as solicitante_nombre,
    (SELECT nombre FROM users u WHERE u.id = t.tecnico_id) as tecnico_nombre,
    t.created_at
    FROM tickets t $where ORDER BY $orderBy $orderDir LIMIT ?, ?";
$stmt = mysqli_prepare($conn, $dataQ);
if ($stmt) {
    // bind params plus limit
    $bindParams = [];
    $types = '';
    if (!empty($params)) {
        $types .= str_repeat('s', count($params));
        $bindParams = $params;
    }
    $types .= 'ii';
    $bindParams[] = $start;
    $bindParams[] = $length;
    mysqli_stmt_bind_param($stmt, $types, ...$bindParams);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $rows = [];
    while ($r = mysqli_fetch_assoc($res)) {
        $rows[] = [$r['folio'],$r['asunto'],$r['estado'],$r['prioridad'],$r['solicitante_nombre'],$r['tecnico_nombre'],$r['created_at']];
    }
    mysqli_stmt_close($stmt);
}

echo json_encode([ 'draw'=>$draw, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=>$recordsFiltered, 'data'=>$rows ]);
