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
    2 => 'USUARIOID',
    3 => 'CLIENTEID',
    4 => 'Fecha',
    5 => 'Calle',
    6 => 'CP',
    7 => 'Receptor',
    8 => 'TelefonoDeReceptor',
    9 => 'TelefonoAlternativo',
    10 => 'NumeroFactura',
    11 => 'Comentarios'


);

// Esta es la nueva version


// getting total number records without any search
$sql = "SELECT * FROM Repartos
LEFT JOIN Usuarios ON Usuarios.USUARIOID = Repartos.USUARIOID
LEFT JOIN Clientes ON Clientes.CLIENTEID = Repartos.CLIENTEID
LEFT JOIN Status ON Status.STATUSID = Repartos.STATUSID ";
$query = mysqli_query($conn, $sql) or die("Usuario-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT * FROM Repartos
LEFT JOIN Usuarios ON Usuarios.USUARIOID = Repartos.USUARIOID
LEFT JOIN Clientes ON Clientes.CLIENTEID = Repartos.CLIENTEID
LEFT JOIN Status ON Status.STATUSID = Repartos.STATUSID
WHERE 1=1 ";

if (!empty($requestData['search']['value'])) {

    $search_words = explode(' ', $requestData['search']['value']);
    $sql_words = array();
    foreach ($search_words as $word) {
        $sql_words[] = "(
            Usuarios.PrimerNombre LIKE '%" . $word . "%' OR
            Usuarios.SegundoNombre LIKE '%" . $word . "%' OR
            Usuarios.ApellidoPaterno LIKE '%" . $word . "%' OR
            Usuarios.ApellidoMaterno LIKE '%" . $word . "%' OR
            Clientes.NombreCliente LIKE '%" . $word . "%' OR
            Repartos.REPARTOID LIKE '%" . $word . "%' OR
            Repartos.Fecha LIKE '%" . $word . "%' OR
            Repartos.Calle LIKE '%" . $word . "%' OR
            Repartos.CP LIKE '%" . $word . "%' OR
            Repartos.Receptor LIKE '%" . $word . "%' OR
            Repartos.TelefonoDeReceptor LIKE '%" . $word . "%' OR
            Repartos.TelefonoAlternativo LIKE '%" . $word . "%' OR
            Repartos.NumeroDeFactura LIKE '%" . $word . "%' OR
            Repartos.Comentarios LIKE '%" . $word . "%' OR
            Usuarios.email LIKE '%" . $word . "%'
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
    $nestedData[] = $row["Fecha"];
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
    "data"            => $data
);

echo json_encode($json_data);  // send data as json format
