<?php
require_once __DIR__ . "/../../Connections/ConDB.php";
session_start();
header('Content-Type: application/json; charset=utf-8');
if (empty($_SESSION['USUARIOID'])) {
    echo json_encode(['success'=>false,'message'=>'No autenticado']);
    exit;
}
$ticketId = isset($_POST['ticket_id']) ? (int)$_POST['ticket_id'] : 0;
$body = trim($_POST['body'] ?? '');
isInternal = isset($_POST['is_internal']) && $_POST['is_internal'] == 'on' ? 1 : 0;
$userId = (int)$_SESSION['USUARIOID'];

if ($ticketId <= 0 || $body === '') {
    echo json_encode(['success'=>false,'message'=>'Datos incompletos']);
    exit;
}

// verify ticket exists and permission
$stmt = mysqli_prepare($conn, 'SELECT solicitante_id, estado FROM tickets WHERE id=?');
mysqli_stmt_bind_param($stmt,'i',$ticketId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt,$solicitanteId,$estado);
if (!mysqli_stmt_fetch($stmt)) {
    mysqli_stmt_close($stmt);
    echo json_encode(['success'=>false,'message'=>'Ticket no encontrado']);
    exit;
}
mysqli_stmt_close($stmt);

$rol = strtolower(trim($_SESSION['TipoDeUsuario'] ?? ''));
if ($rol === 'solicitante' && $solicitanteId !== $userId) {
    echo json_encode(['success'=>false,'message'=>'No autorizado']);
    exit;
}

// insert message
$stmt = mysqli_prepare($conn, 'INSERT INTO ticket_messages (ticket_id, author_id, body, is_internal) VALUES (?,?,?,?)');
mysqli_stmt_bind_param($stmt,'iisi',$ticketId,$userId,$body,$isInternal);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// if status was "En espera de usuario" and message from solicitante, change to En proceso
if (!$isInternal && $rol === 'solicitante' && $estado === 'En espera de usuario') {
    $u = 'En proceso';
    $stmt = mysqli_prepare($conn, 'UPDATE tickets SET estado=? WHERE id=?');
    mysqli_stmt_bind_param($stmt,'si',$u,$ticketId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

echo json_encode(['success'=>true]);
