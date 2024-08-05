<?php
include("../../Connections/ConDB.php");
//include("../../includes/Funciones.php");

// if (!isset($_SESSION)) {
//     session_start();
// }

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;

$columns = array(
    // datatable column index  => database column name
    0 => 'INCIDENCIASID',
    1 => 'Fecha',
    2 => 'Folio',
    3 => 'Cantidad',
    4 => 'SKU',
    5 => 'Articulo',
    6 => 'Marca',
    7 => 'Precio',
    8 => 'Vendedor',
    9 => 'Surtidor',
    10 => 'Total',
    11 => 'Auditor',
    12 => 'Comentarios',
    13 => ''
);

// getting total number records without any search
$sql = "SELECT * FROM incidencias
        LEFT JOIN productos ON incidencias.SKU = productos.Sku
        LEFT JOIN vendedores ON incidencias.Vendedor = vendedores.NombreVendedor
        LEFT JOIN auditores ON incidencias.Auditor = auditores.NombreAuditor";
$query = mysqli_query($conn, $sql) or die("Incidencias-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT * FROM incidencias 
        LEFT JOIN productos ON incidencias.SKU = productos.Sku
        LEFT JOIN vendedores ON incidencias.Vendedor = vendedores.NombreVendedor
        LEFT JOIN auditores ON incidencias.Auditor = auditores.NombreAuditor
WHERE 1=1 ";

if (!empty($requestData['search']['value'])) {
    $search_words = explode(' ', $requestData['search']['value']);
    $sql_words = array();
    foreach ($search_words as $word) {
        $sql_words[] = "(
            incidencias.INCIDENCIASID LIKE '%" . $word . "%' OR
            incidencias.Fecha LIKE '%" . $word . "%' OR
            incidencias.Folio LIKE '%" . $word . "%' OR
            incidencias.Cantidad LIKE '%" . $word . "%' OR
            productos.Sku LIKE '%" . $word . "%' OR
            productos.Descripcion LIKE '%" . $word . "%' OR
            productos.MarcaProductos LIKE '%" . $word . "%' OR
            productos.PrecioProductos LIKE '%" . $word . "%' OR
            incidencias.Vendedor LIKE '%" . $word . "%' OR
            incidencias.Surtidor LIKE '%" . $word . "%' OR
            incidencias.Total LIKE '%" . $word . "%' OR
            incidencias.Auditor LIKE '%" . $word . "%' OR
            incidencias.Comentarios LIKE '%" . $word . "%'
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

    $nestedData[] = $row["INCIDENCIASID"];
    $nestedData[] = $row["Fecha"];
    $nestedData[] = $row["Folio"];
    $nestedData[] = $row["Cantidad"];
    $nestedData[] = $row["SKU"];
    $nestedData[] = htmlspecialchars($row["Articulo"]);
    $nestedData[] = $row["Marca"];
    $nestedData[] = $row["Precio"];
    $nestedData[] = $row["NombreVendedor"];
    $nestedData[] = $row["Surtidor"];
    $nestedData[] = $row["Total"];
    $nestedData[] = $row["Auditor"];
    $nestedData[] = $row["Comentarios"];
    $nestedData[] = '

    <button type="button" class="btn btn-sm btn-primary waves-effect width-md waves-light" data-bs-toggle="modal" data-bs-target="#ModalEditarIncidencias" onclick="TomarDatosParaModalIncidencias(' . $row["INCIDENCIASID"] . ')"><i class="mdi mdi-pencil"></i>Editar</button>

    <button type="button" class="btn btn-sm btn-danger waves-effect width-md waves-light" data-bs-toggle="modal" data-bs-target="#ModalBorrarIncidencias" onclick="TomarDatosParaModalIncidencias(' . $row["INCIDENCIASID"] . ')"><i class="mdi mdi-pencil"></i>Eliminar</button>
    ';

    $data[] = $nestedData;
}


$json_data = array(
    "draw" => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
    "recordsTotal"    => intval($totalData),  // total number of records
    "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
