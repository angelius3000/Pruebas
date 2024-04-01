<?php
include("../../Connections/ConDB.php");
// include("../../includes/Funciones.php");

// if (!isset($_SESSION)) {
//     session_start();
// }

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;

$columns = array(
    // datatable column index  => database column name
    0 => 'REPARTOID',
    1 => 'STATUSID',
    2 => 'ApellidoPaterno',
    3 => 'NombreCliente',
    4 => 'FechaReparto',
    5 => 'HoraReparto',
    6 => 'Calle',
    7 => 'CP',
    8 => 'Receptor',
    9 => 'TelefonoDeReceptor',
    10 => 'TelefonoAlternativo',
    11 => 'NumeroFactura',
    12 => 'Comentarios',
    13 => ' '

);

// getting total number records without any search
$sql = "SELECT * FROM repartos
LEFT JOIN usuarios ON usuarios.USUARIOID = repartos.USUARIOID
LEFT JOIN clientes ON clientes.CLIENTEID = repartos.CLIENTEID
LEFT JOIN Status ON status.STATUSID = repartos.STATUSID ";
$query = mysqli_query($conn, $sql) or die("Usuario-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT * FROM repartos
LEFT JOIN usuarios ON usuarios.USUARIOID = repartos.USUARIOID
LEFT JOIN clientes ON clientes.CLIENTEID = repartos.CLIENTEID
LEFT JOIN Status ON status.STATUSID = repartos.STATUSID
WHERE 1=1 ";

if (!empty($requestData['search']['value'])) {

    $search_words = explode(' ', $requestData['search']['value']);
    $sql_words = array();
    foreach ($search_words as $word) {
        $sql_words[] = "(
            repartos.REPARTOID LIKE '%" . $word . "%' OR
            repartos.STATUSID LIKE '%" . $word . "%' OR
            usuarios.PrimerNombre LIKE '%" . $word . "%' OR
            usuarios.SegundoNombre LIKE '%" . $word . "%' OR
            usuarios.ApellidoPaterno LIKE '%" . $word . "%' OR
            usuarios.ApellidoMaterno LIKE '%" . $word . "%' OR
            clientes.NombreCliente LIKE '%" . $word . "%' OR
            repartos.FechaReparto LIKE '%" . $word . "%' OR
            repartos.HoraReparto LIKE '%" . $word . "%' OR
            repartos.Calle LIKE '%" . $word . "%' OR
            repartos.CP LIKE '%" . $word . "%' OR
            repartos.Receptor LIKE '%" . $word . "%' OR
            repartos.TelefonoDeReceptor LIKE '%" . $word . "%' OR
            repartos.TelefonoAlternativo LIKE '%" . $word . "%' OR
            repartos.NumeroDeFactura LIKE '%" . $word . "%' OR
            repartos.Comentarios LIKE '%" . $word . "%'
        )";
    }
    $sql .= " AND " . implode(' AND ', $sql_words);
}

$query = mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */


$query = mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();

while ($row = mysqli_fetch_array($query)) {  // preparing an array ... Preparando el Arraigo


    if ($row["STATUSID"] == 1) {
        $BadgeStatus = '<span class="badge badge-info">Registrado</span>';
    } else if ($row["STATUSID"] == 2) {
        $BadgeStatus = '<span class="badge badge-warning">En tránsito</span>';
    } else if ($row["STATUSID"] == 3) {
        $BadgeStatus = '<span class="badge badge-dark">Demorado</span>';
    } else if ($row["STATUSID"] == 4) {
        $BadgeStatus = '<span class="badge badge-secondary">Surtiendo</span>';
    } else if ($row["STATUSID"] == 5) {
        $BadgeStatus = '<span class="badge badge-success">Entregado</span>';
    } else if ($row["STATUSID"] == 6) {
        $BadgeStatus = '<span class="badge badge-danger">Cancelado</span>';
    }


    $nestedData = array();

    $nestedData[] = '<strong>' . $row["REPARTOID"] . '</strong>';
    $nestedData[] = $BadgeStatus;
    $nestedData[] = $row["PrimerNombre"] . ' ' . $row["SegundoNombre"] . ' ' . $row["ApellidoPaterno"] . ' ' . $row["ApellidoMaterno"];
    $nestedData[] = $row["NombreCliente"];
    $nestedData[] = $row["FechaReparto"];
    $nestedData[] = $row["HoraReparto"];
    $nestedData[] = $row["Calle"] . ' ' . $row["NumeroEXT"] . ' ' . $row["Colonia"];
    $nestedData[] = $row["CP"];
    $nestedData[] = $row["Receptor"];
    $nestedData[] = $row["TelefonoDeReceptor"];
    $nestedData[] = $row["TelefonoAlternativo"];
    $nestedData[] = $row["NumeroDeFactura"];
    $nestedData[] = $row["Comentarios"];
    $nestedData[] = '

    <button type="button" class="btn btn-sm btn-primary waves-effect width-md waves-light" data-bs-toggle="modal" data-bs-target="#ModalEditarUsuarios" onclick="TomarDatosParaModalUsuarios(' . $row["USUARIOID"] . ')"><i class="mdi mdi-pencil"></i>Editar</button>

    <button type="button" class="btn btn-sm btn-danger waves-effect width-md waves-light" data-bs-toggle="modal" data-bs-target="#ModalDeshabilitarUsuarios" onclick="TomarDatosParaModalUsuarios(' . $row["USUARIOID"] . ')"><i class="mdi mdi-pencil"></i>Deshabilitar</button>
    ';

    $data[] = $nestedData;
}


$json_data = array(
    "draw" => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
    "recordsTotal"    => intval($totalData),  // total number of records
    "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $data,   // total data array,
);

echo json_encode($json_data);  // send data as json format
