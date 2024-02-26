<?php
include("../../Connections/Con.php");
// include("../../includes/Funciones.php");

// if (!isset($_SESSION)) {
//     session_start();
// }

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;

$columns = array(
    // datatable column index  => database column name
    0 => 'ApellidoPaterno',
    1 => 'email',
    2 => 'TIPODEUSUARIOID',
    3 => ' '
);

// getting total number records without any search
$sql = "SELECT * FROM Usuarios";
$query = mysqli_query($conn, $sql) or die("Usuario-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT * FROM Usuarios
WHERE 1=1 ";

if (!empty($requestData['search']['value'])) {
    $search_words = explode(' ', $requestData['search']['value']);
    $sql_words = array();
    foreach ($search_words as $word) {
        $sql_words[] = "(
            Usuarios.Nombre LIKE '%" . $word . "%' OR
            Usuarios.SegundoNombre LIKE '%" . $word . "%' OR
            Usuarios.ApellidoPaterno LIKE '%" . $word . "%' OR
            Usuarios.ApellidoMaterno LIKE '%" . $word . "%' OR
            Usuarios.SituacionUsuario LIKE '%" . $word . "%' OR
            Usuarios.Email LIKE '%" . $word . "%'
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

    $nestedData = array();

    $nestedData[] = $row["ApellidoPaterno"] . ' ' . $row["ApellidoMaterno"] . ' ' . $row["PrimerNombre"] . ' ' . $row["SegundoNombre"];
    $nestedData[] = $row["email"];
    $nestedData[] = $row["TIPODEUSUARIOID"];
    $nestedData[] = '

    <button type="button" class="btn btn-sm btn-primary waves-effect width-md waves-light" data-toggle="modal" data-target="#EditarUsuarios" onclick="TomarDatosParaModalUsuarios(' . $row["USUARIOID"] . ', ' . $Congreso . ')"><i class="mdi mdi-pencil"></i>Editar</button>

    
    <button type="button" class="btn btn-sm btn-danger waves-effect width-md waves-light" data-toggle="modal" data-target="#BorrarUsuarios" onclick="TomarDatosParaModalUsuarios(' . $row["USUARIOID"] . ', ' . $Congreso . ')"><i class="mdi mdi-close"></i>Borrar</button>';

    $data[] = $nestedData;
}


$json_data = array(
    "draw" => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
    "recordsTotal"    => intval($totalData),  // total number of records
    "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $data,   // total data array,
    'NombreCongreso' => $rowCongreso["Congreso"]
);

echo json_encode($json_data);  // send data as json format
