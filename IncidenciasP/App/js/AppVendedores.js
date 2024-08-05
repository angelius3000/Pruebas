$(document).ready
(function()
  {
    var dataTableVendedoresDT = $("#VendedoresDT").DataTable
    (
      {
        // Tabla General de Usuarios

        dom: "Bifrtip",
        buttons: ["excelHtml5", "pdfHtml5", "pageLength"],
        processing: true,
        serverSide: true,
        responsive: true,
        pageLength: 100,
        language:
        {
          search: "Búsqueda:",
          lengthMenu: "Mostrar _MENU_ filas",
          zeroRecords: "Sin información",
          info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
          paginate:
          {
            first: "Primera",
            last: "Última",
            next: "Siguiente",
            previous: "Anterior",
          },
          infoEmpty: "Sin vendedores registrados",
          infoFiltered: "(filtrado de _MAX_ registros)",
        },
        processing: "Procesando...",
        loadingRecords: "Cargando...",
        ajax:
        {
          url: "App/Datatables/Vendedores-grid-data.php", // json datasource
          type: "post",
        },
        lengthChange: true, // añade la lista desplegable
        order: [[0, "ASC"]],
      }
    );

    // Para agregar vendedor
    $("#ValidacionAgregarVendedor").on
    (
      "submit", function(e)
      {
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid())
        {
          //prevent Default functionality
          e.preventDefault();
          // data string
          var dataString = form.serialize();
          
          // ajax
          $.ajax
          (
            {
              //async: false,
              type: "POST",
              url: "App/Server/ServerInsertarVendedores.php",
              data: dataString,
              dataType: "json",
              success: function(response) 
              {
                console.log("Hola");
                // Reescribe la Datatable y le da refresh
                console.log(response.VENDEDORESID);
                dataTableVendedoresDT.columns.adjust().draw();
              }
            }
          )
          .done(function() {});

          $("#ModalAgregarVendedor").modal("toggle");
        }
      }
    );
    // Para editar vendedor
    $("#ValidacionEditarVendedor").on
    (
      "submit", function(e)
      {
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid())
        {
          //prevent Default functionality
          //e.preventDefault();

          // data string
          var dataString = form.serialize();

          console.log(dataString);

          // ajax
          $.ajax
          (
            {
              //async: false,
              type: "POST",
              url: "App/Server/ServerUpdateVendedores.php",
              data: dataString,
              dataType: "json",
              success: function(response) 
              {
                dataTableVendedoresDT.columns.adjust().draw();
              }
            }
          )
          .done(function() {});
          $("#ModalEditarVendedor").modal("toggle");
        }
      }
    );

    // Para Borrar Registro

    $("body").on
    (
      "click", "#BorrarVendedor", function()
      {
        var VENDEDORESID = $("input#VENDEDORESIDBorrar").val();

        var dataString = "VENDEDORESID=" + VENDEDORESID;

        console.log(dataString);

        // ajax
        $.ajax
        (
          {
            //async: false,
            type: "POST",
            url: "App/Server/ServerBorrarVendedores.php",
            data: dataString,
            dataType: "json",
            success: function(response) 
            {
              dataTableVendedoresDT.columns.adjust().draw();
            }
          }
        )
        .done(function() {});

        $("#ModalBorrarVendedor").modal("toggle");
      }
    );
  }
);

function TomarDatosParaModalVendedor(val)
{
  $.ajax
  (
    {
      type: "POST",
      url: "App/Server/ServerInfoVendedoresParaModal.php",
      dataType: "json",
      data: "ID=" + val,
      success: function(response) 
      {
        // Para el Modal de editar
        $("input#NombreVendedorEditar").val(response.NombreVendedor);
        $("input#VENDEDORESIDEditar").val(response.VENDEDORESID);

        //Para modal de Borrar
        $("#EliminarVendedor").text("Nombre:" + response.NombreVendedor);
        $("#DatosVendedoresParaBorrar").html(response.DatosParaBorrarVendedores);
        $("input#VENDEDORESIDBorrar").val(response.VENDEDORESID);
      },
    }
  );
}
