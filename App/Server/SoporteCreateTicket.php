<?php
// Server endpoint for creating a new soporte ticket (via AJAX or form POST)
// Expects POST: asunto, descripcion, categoria, impacto, urgencia, asset_id (optional)
// Files in $_FILES['adjuntos'] (multiple allowed)

require_once __DIR__ . "/../../Connections/ConDB.php";
session_start();
header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['USUARIOID'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'No autenticado']);
    exit;
}

$usuarioId = (int) $_SESSION['USUARIOID'];

$asunto = trim($_POST['asunto'] ?? '');
descripcion = trim($_POST['descripcion'] ?? '');
categoria = (int) ($_POST['categoria'] ?? 0);
$impacto = $_POST['impacto'] ?? '';
$urgencia = $_POST['urgencia'] ?? '';
$assetId = isset($_POST['asset_id']) && $_POST['asset_id'] !== '' ? (int)$_POST['asset_id'] : null;

$errors = [];
if ($asunto === '') $errors[] = 'Asunto obligatorio';
if ($descripcion === '') $errors[] = 'Descripción obligatoria';
if ($categoria <= 0) $errors[] = 'Categoría obligatoria';
if (!in_array($impacto, ['Bajo','Medio','Alto'], true)) $errors[] = 'Impacto inválido';
if (!in_array($urgencia, ['Baja','Media','Alta'], true)) $errors[] = 'Urgencia inválida';

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

function calcularPrioridad($impacto, $urgencia) {
    if ($impacto === 'Alto' && $urgencia === 'Alta') return 'P1';
    if (($impacto === 'Alto' && $urgencia === 'Media') || ($impacto === 'Medio' && $urgencia === 'Alta')) return 'P2';
    if (($impacto === 'Medio' && $urgencia === 'Media') || ($impacto === 'Alto' && $urgencia === 'Baja')) return 'P3';
    return 'P4';
}

$prioridad = calcularPrioridad($impacto, $urgencia);

// transaction to generate folio and insert ticket
mysqli_begin_transaction($conn);
try {
    $year = date('Y');
    $folio = '';
    $stmt = mysqli_prepare($conn, 'SELECT counter FROM ticket_folio_counter WHERE year = ? FOR UPDATE');
    mysqli_stmt_bind_param($stmt, 'i', $year);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $counter);
    if (mysqli_stmt_fetch($stmt)) {
        $counter++;
        mysqli_stmt_close($stmt);
        $stmt2 = mysqli_prepare($conn, 'UPDATE ticket_folio_counter SET counter = ? WHERE year = ?');
        mysqli_stmt_bind_param($stmt2, 'ii', $counter, $year);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
    } else {
        mysqli_stmt_close($stmt);
        $counter = 1;
        $stmt2 = mysqli_prepare($conn, 'INSERT INTO ticket_folio_counter (year,counter) VALUES (?,?)');
        mysqli_stmt_bind_param($stmt2, 'ii', $year, $counter);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
    }
    $folio = sprintf('IT-%s-%06d', $year, $counter);

    $insert = mysqli_prepare($conn, 'INSERT INTO tickets (folio, asunto, descripcion, categoria_id, asset_id, impacto, urgencia, prioridad_calculada, solicitante_id) VALUES (?,?,?,?,?,?,?,?,?)');
    mysqli_stmt_bind_param($insert, 'sssssssss', $folio, $asunto, $descripcion, $categoria, $assetId, $impacto, $urgencia, $prioridad, $usuarioId);
    mysqli_stmt_execute($insert);
    $ticketId = mysqli_insert_id($conn);
    mysqli_stmt_close($insert);

    // insert initial message (public)
    if ($ticketId) {
        $msg = mysqli_prepare($conn, 'INSERT INTO ticket_messages (ticket_id, author_id, body, is_internal) VALUES (?,?,?,0)');
        mysqli_stmt_bind_param($msg, 'iis', $ticketId, $usuarioId, $descripcion);
        mysqli_stmt_execute($msg);
        mysqli_stmt_close($msg);
    }

    // audit log
    $log = mysqli_prepare($conn, 'INSERT INTO audit_log (entity, entity_id, action, user_id, before_json, after_json) VALUES (?,?,?,?,?,?)');
    $after = json_encode(['folio' => $folio, 'asunto' => $asunto]);
    $entity = 'ticket';
    $no = '';
    mysqli_stmt_bind_param($log, 'sissss', $entity, $ticketId, $action='created', $usuarioId, $no, $after);
    mysqli_stmt_execute($log);
    mysqli_stmt_close($log);

    mysqli_commit($conn);
} catch (Exception $e) {
    mysqli_rollback($conn);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al guardar ticket']);
    exit;
}

require_once __DIR__ . '/../../includes/MandarEmail.php';

function enviarNotificacion($destino, $asuntoCorreo, $cuerpo) {
    try {
        // reuse MandarEmail.php's PHPMailer configuration
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = getenv('SMTP_HOST');
        $mail->Port = getenv('SMTP_PORT');
        $mail->Username = getenv('SMTP_USER');
        $mail->Password = getenv('SMTP_PASS');
        $mail->setFrom(getenv('SMTP_FROM'));
        $mail->addAddress($destino);
        $mail->Subject = $asuntoCorreo;
        $mail->Body = $cuerpo;
        $mail->send();
        // log to database
        $stmt = mysqli_prepare($GLOBALS['conn'], 'INSERT INTO audit_log (entity,entity_id,action, user_id, before_json, after_json) VALUES (?,?,?,?,?,?)');
        $action = 'email_sent';
        $ent = 'ticket';
        $after = json_encode(['to'=>$destino,'subject'=>$asuntoCorreo]);
        mysqli_stmt_bind_param($stmt,'sissss',$ent,$ticketId,$action,$usuarioId,$no='',$after);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } catch (Exception $ex) {
        // ignore
    }
}

// notify requester
$resq = mysqli_prepare($conn,'SELECT email FROM users WHERE id=?');
mysqli_stmt_bind_param($resq,'i',$usuarioId);
mysqli_stmt_execute($resq);
mysqli_stmt_bind_result($resq,$soloEmail);
mysqli_stmt_fetch($resq);
mysqli_stmt_close($resq);
if ($soloEmail) {
    enviarNotificacion($soloEmail, "Ticket creado $folio", "Su ticket ha sido creado con folio $folio.");
}

echo json_encode(['success' => true, 'ticket_id' => $ticketId, 'folio' => $folio]);
