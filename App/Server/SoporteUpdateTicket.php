<?php
require_once __DIR__ . "/../../Connections/ConDB.php";
require_once __DIR__ . "/../../includes/MandarEmail.php";
session_start();
header('Content-Type: application/json; charset=utf-8');
if (empty($_SESSION['USUARIOID'])) {
    echo json_encode(['success'=>false,'message'=>'No autenticado']);
    exit;
}
$ticketId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
action = $_POST['action'] ?? '';
$userId = (int)$_SESSION['USUARIOID'];
$rol = strtolower(trim($_SESSION['TipoDeUsuario'] ?? ''));

if ($ticketId <= 0 || $action === '') {
    echo json_encode(['success'=>false,'message'=>'Parámetros inválidos']);
    exit;
}

// load ticket
$stmt = mysqli_prepare($conn,'SELECT tecnico_id, estado FROM tickets WHERE id=?');
mysqli_stmt_bind_param($stmt,'i',$ticketId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt,$tecnicoId,$estado);
if (!mysqli_stmt_fetch($stmt)) {
    mysqli_stmt_close($stmt);
    echo json_encode(['success'=>false,'message'=>'Ticket no encontrado']);
    exit;
}
mysqli_stmt_close($stmt);

$canTech = in_array($rol,['tecnico','admin']);
$canAdmin = ($rol==='admin');

if ($action === 'assign_me') {
    if (!$canTech) {
        echo json_encode(['success'=>false,'message'=>'Solo técnicos pueden asignarse']);
        exit;
    }
    if ($tecnicoId && $tecnicoId !== $userId) {
        echo json_encode(['success'=>false,'message'=>'Ya está asignado']);
        exit;
    }
    $newEstado = $estado === 'Nuevo' ? 'Asignado' : $estado;
    $stmt = mysqli_prepare($conn,'UPDATE tickets SET tecnico_id=?, estado=? WHERE id=?');
    mysqli_stmt_bind_param($stmt,'isi',$userId,$newEstado,$ticketId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    // notify technician by email if address available
    $stmtu = mysqli_prepare($conn,'SELECT email FROM users WHERE id=?');
    mysqli_stmt_bind_param($stmtu,'i',$userId);
    mysqli_stmt_execute($stmtu);
    mysqli_stmt_bind_result($stmtu,$techEmail);
    mysqli_stmt_fetch($stmtu);
    mysqli_stmt_close($stmtu);
    if ($techEmail) {
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = getenv('SMTP_HOST');
            $mail->Port = getenv('SMTP_PORT');
            $mail->Username = getenv('SMTP_USER');
            $mail->Password = getenv('SMTP_PASS');
            $mail->setFrom(getenv('SMTP_FROM'));
            $mail->addAddress($techEmail);
            $mail->Subject = "Ticket asignado $ticketId";
            $mail->Body = "Se le ha asignado el ticket $ticketId";
            $mail->send();
        } catch (Exception $ex) {}
    }
    echo json_encode(['success'=>true]);
    exit;
}

if ($action === 'state') {
    $new = $_POST['value'] ?? '';
    // validate state
    $valid = ['Nuevo','Asignado','En proceso','En espera de usuario','En espera de tercero','Resuelto','Cerrado','Cancelado','Duplicado'];
    if (!in_array($new,$valid,true)) {
        echo json_encode(['success'=>false,'message'=>'Estado no válido']);
        exit;
    }
    if (!$canTech) {
        echo json_encode(['success'=>false,'message'=>'Sin permisos']);
        exit;
    }
    $stmt = mysqli_prepare($conn,'UPDATE tickets SET estado=? WHERE id=?');
    mysqli_stmt_bind_param($stmt,'si',$new,$ticketId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    // if state requires notifying requester
    if (in_array($new,['En espera de usuario','Resuelto','Cerrado'], true)) {
        $stmtu = mysqli_prepare($conn,'SELECT u.email FROM users u JOIN tickets t ON t.solicitante_id=u.id WHERE t.id=?');
        mysqli_stmt_bind_param($stmtu,'i',$ticketId);
        mysqli_stmt_execute($stmtu);
        mysqli_stmt_bind_result($stmtu,$emailDest);
        mysqli_stmt_fetch($stmtu);
        mysqli_stmt_close($stmtu);
        if ($emailDest) {
            try {
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->Host = getenv('SMTP_HOST');
                $mail->Port = getenv('SMTP_PORT');
                $mail->Username = getenv('SMTP_USER');
                $mail->Password = getenv('SMTP_PASS');
                $mail->setFrom(getenv('SMTP_FROM'));
                $mail->addAddress($emailDest);
                $mail->Subject = "Cambio de estado ticket $ticketId";
                $mail->Body = "El estado de su ticket $ticketId ha cambiado a $new.";
                $mail->send();
            } catch (Exception $ex) {}
        }
    }
    echo json_encode(['success'=>true]);
    exit;
}

if ($action === 'close') {
    if (!$canTech) {
        echo json_encode(['success'=>false,'message'=>'Sin permisos']);
        exit;
    }
    $closedAt = date('Y-m-d H:i:s');
    $stmt = mysqli_prepare($conn,'UPDATE tickets SET estado=?, closed_at=? WHERE id=?');
    $close = 'Cerrado';
    mysqli_stmt_bind_param($stmt,'ssi',$close,$closedAt,$ticketId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo json_encode(['success'=>true]);
    exit;
}

// other actions like priority override, assign to someone etc could be added

echo json_encode(['success'=>false,'message'=>'Acción no reconocida']);
