<?php
include("../../Connections/ConDB.php");
include("../../includes/Funciones.php");

if (!isset($_SESSION)) {
    session_start();
}

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;

$columns = array(
    // datatable column index  => database column name
    0 => 'REPARTOID',
    1 => 'STATUSID',
    2 => 'Surtidores',
    3 => 'USUARIOIDRepartidor',
    4 => 'USUARIOID',
    5 => 'CLIENTEID',
    6 => 'Fecha',
    7 => 'Calle',
    8 => 'CP',
    9 => 'Receptor',
    10 => 'TelefonoDeReceptor',
    11 => 'TelefonoAlternativo',
    12 => 'NumeroFactura',
    13 => 'Comentarios',
    14 => ''


);

// getting total number records without any search
$sql = "SELECT 
US.USUARIOID AS USUARIOID_US, 
US.PrimerNombre AS PrimerNombre_US, 
US.SegundoNombre AS SegundoNombre_US, 
US.ApellidoPaterno AS ApellidoPaterno_US, 
US.ApellidoMaterno AS ApellidoMaterno_US, 
US.email AS email_US, 
US.Telefono AS Telefono_US, 
US.TIPODEUSUARIOID AS TIPODEUSUARIOID_US, 
US.Deshabilitado AS Deshabilitado_US, 
US.Password AS Password_US, 
US.CLIENTEID AS CLIENTEID_US, 
US.HASH AS HASH_US,
REP.USUARIOID AS USUARIOID_REP, 
REP.PrimerNombre AS PrimerNombre_REP, 
REP.SegundoNombre AS SegundoNombre_REP, 
REP.ApellidoPaterno AS ApellidoPaterno_REP, 
REP.ApellidoMaterno AS ApellidoMaterno_REP, 
REP.email AS email_REP, 
REP.Telefono AS Telefono_REP, 
REP.TIPODEUSUARIOID AS TIPODEUSUARIOID_REP, 
REP.Deshabilitado AS Deshabilitado_REP, 
REP.Password AS Password_REP, 
REP.CLIENTEID AS CLIENTEID_REP, 
REP.HASH AS HASH_REP,
repartos.*, 
clientes.*, 
status.*
FROM 
repartos
LEFT JOIN 
usuarios US ON US.USUARIOID = repartos.USUARIOID
LEFT JOIN 
usuarios REP ON REP.USUARIOID = repartos.USUARIOIDRepartidor
LEFT JOIN 
clientes ON clientes.CLIENTEID = repartos.CLIENTEID
LEFT JOIN 
status ON status.STATUSID = repartos.STATUSID; ";
$query = mysqli_query($conn, $sql) or die("Usuario-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT 
US.USUARIOID AS USUARIOID_US, 
US.PrimerNombre AS PrimerNombre_US, 
US.SegundoNombre AS SegundoNombre_US, 
US.ApellidoPaterno AS ApellidoPaterno_US, 
US.ApellidoMaterno AS ApellidoMaterno_US, 
US.email AS email_US, 
US.Telefono AS Telefono_US, 
US.TIPODEUSUARIOID AS TIPODEUSUARIOID_US, 
US.Deshabilitado AS Deshabilitado_US, 
US.Password AS Password_US, 
US.CLIENTEID AS CLIENTEID_US, 
US.HASH AS HASH_US,
REP.USUARIOID AS USUARIOID_REP, 
REP.PrimerNombre AS PrimerNombre_REP, 
REP.SegundoNombre AS SegundoNombre_REP, 
REP.ApellidoPaterno AS ApellidoPaterno_REP, 
REP.ApellidoMaterno AS ApellidoMaterno_REP, 
REP.email AS email_REP, 
REP.Telefono AS Telefono_REP, 
REP.TIPODEUSUARIOID AS TIPODEUSUARIOID_REP, 
REP.Deshabilitado AS Deshabilitado_REP, 
REP.Password AS Password_REP, 
REP.CLIENTEID AS CLIENTEID_REP, 
REP.HASH AS HASH_REP,
repartos.*, 
clientes.*, 
status.*
FROM 
repartos
LEFT JOIN 
usuarios US ON US.USUARIOID = repartos.USUARIOID
LEFT JOIN 
usuarios REP ON REP.USUARIOID = repartos.USUARIOIDRepartidor
LEFT JOIN 
clientes ON clientes.CLIENTEID = repartos.CLIENTEID
LEFT JOIN 
status ON status.STATUSID = repartos.STATUSID
WHERE 1=1 ";

if (!empty($requestData['search']['value'])) {

    $search_words = explode(' ', $requestData['search']['value']);
    $sql_words = array();
    foreach ($search_words as $word) {
        $sql_words[] = "(
            US.PrimerNombre LIKE '%" . $word . "%' OR
            US.SegundoNombre LIKE '%" . $word . "%' OR
            US.ApellidoPaterno LIKE '%" . $word . "%' OR
            US.ApellidoMaterno LIKE '%" . $word . "%' OR
            REP.PrimerNombre LIKE '%" . $word . "%' OR
            REP.SegundoNombre LIKE '%" . $word . "%' OR
            REP.ApellidoPaterno LIKE '%" . $word . "%' OR
            REP.ApellidoMaterno LIKE '%" . $word . "%' OR
            clientes.NombreCliente LIKE '%" . $word . "%' OR
            repartos.REPARTOID LIKE '%" . $word . "%' OR
            repartos.Surtidores LIKE '%" . $word . "%' OR
            repartos.FechaReparto LIKE '%" . $word . "%' OR
            repartos.Calle LIKE '%" . $word . "%' OR
            repartos.CP LIKE '%" . $word . "%' OR
            repartos.Receptor LIKE '%" . $word . "%' OR
            repartos.TelefonoDeReceptor LIKE '%" . $word . "%' OR
            repartos.TelefonoAlternativo LIKE '%" . $word . "%' OR
            repartos.NumeroDeFactura LIKE '%" . $word . "%' OR
            repartos.Comentarios LIKE '%" . $word . "%' OR
            US.email LIKE '%" . $word . "%'
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

    if ($_SESSION['TIPOUSUARIO'] == '1') {
        $MandarModal = 'data-bs-toggle="modal" data-bs-target="#ModalCambioStatus" onclick="TomarDatosParaModalRepartos(' . $row["REPARTOID"] . ')"';
    } else {
        $MandarModal = '';
    }

    if ($row["STATUSID"] == 1) {
        $BadgeStatus = '<span class="badge badge-info" ' . $MandarModal . '>Registrado</span>';
    } else if ($row["STATUSID"] == 2) {
        $BadgeStatus = '<span class="badge badge-warning"  ' . $MandarModal . '>En tránsito</span>';
    } else if ($row["STATUSID"] == 3) {
        $BadgeStatus = '<span class="badge badge-dark"  ' . $MandarModal . '>Demorado</span>';
    } else if ($row["STATUSID"] == 4) {
        $BadgeStatus = '<span class="badge badge-secondary"  ' . $MandarModal . '>Surtiendo</span>';
    } else if ($row["STATUSID"] == 5) {
        $BadgeStatus = '<span class="badge badge-success" ' . $MandarModal . '>Entregado</span>';
    } else if ($row["STATUSID"] == 6) {
        $BadgeStatus = '<span class="badge badge-danger"  ' . $MandarModal . '>Cancelado</span>';
    }

    if ($row['USUARIOID_US'] == $_SESSION['USUARIOID'] || $_SESSION['TIPOUSUARIO'] == '1') {

        $BotonEditar = ' <button type="button" class="btn btn-sm btn-primary waves-effect width-md waves-light" data-bs-toggle="modal" data-bs-target="#ModalEditarReparto" onclick="TomarDatosParaModalRepartos(' . $row["REPARTOID"] . ')"><i class="mdi mdi-pencil"></i>Editar</button>';
    } else {
        $BotonEditar = '';
    }


    if (($row['USUARIOID_US'] == $_SESSION['USUARIOID']) && ($row['STATUSID'] == '1') || $_SESSION['TIPOUSUARIO'] == '1') {

        $BotonBorrar = '<button type="button" class="btn btn-sm btn-danger waves-effect width-md waves-light" data-bs-toggle="modal" data-bs-target="#ModalBorrarReparto" onclick="TomarDatosParaModalRepartos(' . $row["REPARTOID"] . ')"><i class="mdi mdi-pencil"></i>Borrar</button>';
    } else {
        $BotonBorrar = '';
    }

    $nestedData = array();

    $nestedData[] = '<strong>' . $row["REPARTOID"] . '</strong>';
    $nestedData[] = $BadgeStatus;

    $nestedData[] = $row["Surtidores"];

    $nestedData[] = $row["PrimerNombre_REP"] . ' ' . $row["SegundoNombre_REP"] . ' ' . $row["ApellidoPaterno_REP"] . ' ' . $row["ApellidoMaterno_REP"];

    $nestedData[] = $row["PrimerNombre_US"] . ' ' . $row["SegundoNombre_US"] . ' ' . $row["ApellidoPaterno_US"] . ' ' . $row["ApellidoMaterno_US"];

    $nestedData[] = $row["NombreCliente"];
    $nestedData[] =  SoloFecha($row["FechaDeRegistro"]);
    $nestedData[] = $row["Calle"] . ' ' . $row["NumeroEXT"] . ' ' . $row["Colonia"];
    $nestedData[] = $row["CP"];
    $nestedData[] = $row["Receptor"];
    $nestedData[] = $row["TelefonoDeReceptor"];
    $nestedData[] = $row["TelefonoAlternativo"];
    $nestedData[] = $row["NumeroDeFactura"];
    $nestedData[] = $row["Comentarios"];
    $nestedData[] = $BotonEditar . $BotonBorrar;

    $data[] = $nestedData;
}




$json_data = array(
    "draw" => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
    "recordsTotal"    => intval($totalData),  // total number of records
    "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $data,   // total data array,
);

echo json_encode($json_data);  // send data as json format
