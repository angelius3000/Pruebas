<?php
// Export de conteos por periodo y agrupación a Excel (XML).
// Parámetros GET:
//   inicio: fecha inicial (YYYY-MM-DD)
//   fin: fecha final (YYYY-MM-DD)
//   grupo: "hora" o "dia" (default hora)

include("../../Connections/ConDB.php");

if (!$conn) {
    header('HTTP/1.1 500 Internal Server Error');
    echo 'No se pudo conectar a la base de datos.';
    exit;
}

$inicio = $_GET['inicio'] ?? '';
$fin = $_GET['fin'] ?? '';
$grupo = $_GET['grupo'] ?? 'hora';

$validGroups = ['hora', 'dia'];
if (!in_array($grupo, $validGroups, true)) {
    $grupo = 'hora';
}

// validar fechas
$fechaInicio = DateTime::createFromFormat('Y-m-d', $inicio);
$fechaFin = DateTime::createFromFormat('Y-m-d', $fin);

if (!$fechaInicio || !$fechaFin) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Fechas inválidas.';
    exit;
}

// normalizar orden
if ($fechaFin < $fechaInicio) {
    $tmp = $fechaInicio;
    $fechaInicio = $fechaFin;
    $fechaFin = $tmp;
}

$paramInicio = $fechaInicio->format('Y-m-d');
$paramFin = $fechaFin->format('Y-m-d');

if ($grupo === 'hora') {
    $sql = "SELECT Fecha, HoraInicio, SUM(Hombre) AS Hombre, SUM(Mujer) AS Mujer, SUM(Pareja) AS Pareja, "
         . "SUM(Familia) AS Familia, SUM(Cuadrilla) AS Cuadrilla "
         . "FROM conteo_visitantes WHERE Fecha BETWEEN ? AND ? "
         . "GROUP BY Fecha, HoraInicio ORDER BY Fecha, HoraInicio";
} else {
    $sql = "SELECT Fecha, SUM(Hombre) AS Hombre, SUM(Mujer) AS Mujer, SUM(Pareja) AS Pareja, "
         . "SUM(Familia) AS Familia, SUM(Cuadrilla) AS Cuadrilla "
         . "FROM conteo_visitantes WHERE Fecha BETWEEN ? AND ? "
         . "GROUP BY Fecha ORDER BY Fecha";
}

$stmt = @mysqli_prepare($conn, $sql);
$rows = [];
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'ss', $paramInicio, $paramFin);
    mysqli_stmt_execute($stmt);
    if ($grupo === 'hora') {
        mysqli_stmt_bind_result($stmt, $fecha, $hora, $hombre, $mujer, $pareja, $familia, $cuadrilla);
        while (mysqli_stmt_fetch($stmt)) {
            $rows[] = [
                'Fecha' => $fecha,
                'Hora' => $hora,
                'Hombre' => (int)$hombre,
                'Mujer' => (int)$mujer,
                'Pareja' => (int)$pareja,
                'Familia' => (int)$familia,
                'Cuadrilla' => (int)$cuadrilla,
            ];
        }
    } else {
        mysqli_stmt_bind_result($stmt, $fecha, $hombre, $mujer, $pareja, $familia, $cuadrilla);
        while (mysqli_stmt_fetch($stmt)) {
            $rows[] = [
                'Fecha' => $fecha,
                'Hora' => '',
                'Hombre' => (int)$hombre,
                'Mujer' => (int)$mujer,
                'Pareja' => (int)$pareja,
                'Familia' => (int)$familia,
                'Cuadrilla' => (int)$cuadrilla,
            ];
        }
    }
    mysqli_stmt_close($stmt);
}

$nombreArchivo = sprintf(
    'conteo_%s_%s_a_%s.xls',
    $grupo,
    str_replace('-', '', $paramInicio),
    str_replace('-', '', $paramFin)
);

// encabezados para descarga
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename=' . $nombreArchivo);

$escapeXml = static function (string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
};

// iniciar XML
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<?mso-application progid="Excel.Sheet"?>';
echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" ';
echo 'xmlns:o="urn:schemas-microsoft-com:office:office" ';
echo 'xmlns:x="urn:schemas-microsoft-com:office:excel" ';
echo 'xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">';
echo '<Worksheet ss:Name="Conteo">';
echo '<Table>';

// header row
echo '<Row>';
echo '<Cell><Data ss:Type="String">Fecha</Data></Cell>';
echo '<Cell><Data ss:Type="String">Hora</Data></Cell>';
echo '<Cell><Data ss:Type="String">Hombre</Data></Cell>';
echo '<Cell><Data ss:Type="String">Mujer</Data></Cell>';
echo '<Cell><Data ss:Type="String">Pareja</Data></Cell>';
echo '<Cell><Data ss:Type="String">Familia</Data></Cell>';
echo '<Cell><Data ss:Type="String">Cuadrilla</Data></Cell>';
echo '<Cell><Data ss:Type="String">Total</Data></Cell>';
echo '</Row>';

if (empty($rows)) {
    echo '<Row><Cell ss:MergeAcross="7"><Data ss:Type="String">No hay registros en el rango indicado.</Data></Cell></Row>';
} else {
    foreach ($rows as $fila) {
        $fechaFmt = '';
        if (!empty($fila['Fecha'])) {
            $d = strtotime($fila['Fecha']);
            if ($d !== false) {
                $fechaFmt = date('d/m/Y', $d);
            }
        }
        $horaFmt = '';
        if (!empty($fila['Hora'])) {
            $h = strtotime($fila['Hora']);
            if ($h !== false) {
                $horaFmt = date('H:i', $h);
            } else {
                $horaFmt = $fila['Hora'];
            }
        }
        $hombre = $fila['Hombre'];
        $mujer = $fila['Mujer'];
        $pareja = $fila['Pareja'];
        $familia = $fila['Familia'];
        $cuadrilla = $fila['Cuadrilla'];
        $total = $hombre + $mujer + $pareja + $familia + $cuadrilla;

        echo '<Row>';
        echo '<Cell><Data ss:Type="String">' . $escapeXml($fechaFmt) . '</Data></Cell>';
        echo '<Cell><Data ss:Type="String">' . $escapeXml($horaFmt) . '</Data></Cell>';
        echo '<Cell><Data ss:Type="Number">' . $hombre . '</Data></Cell>';
        echo '<Cell><Data ss:Type="Number">' . $mujer . '</Data></Cell>';
        echo '<Cell><Data ss:Type="Number">' . $pareja . '</Data></Cell>';
        echo '<Cell><Data ss:Type="Number">' . $familia . '</Data></Cell>';
        echo '<Cell><Data ss:Type="Number">' . $cuadrilla . '</Data></Cell>';
        echo '<Cell><Data ss:Type="Number">' . $total . '</Data></Cell>';
        echo '</Row>';
    }
}

echo '</Table>';
echo '</Worksheet>';
echo '</Workbook>';

exit;
