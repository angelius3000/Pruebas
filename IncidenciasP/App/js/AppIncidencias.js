$(document).ready(function() {

  // como puedo disparar en la clase .select2 que comienze la busqueda de los clientes
  $(".select2").select2();
  
  var dataTableIncidenciasDT = $("#IncidenciasDT").DataTable({
    // Tabla General de Registros

    dom: "Bifrtip",
    buttons: ["excelHtml5", "pdfHtml5", "pageLength"],
    processing: true,
    serverSide: true,
    responsive: true,
    pageLength: 100,
    language: {
      search: "Búsqueda:",
      lengthMenu: "Mostrar _MENU_ filas",
      zeroRecords: "Sin información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      paginate: {
        first: "Primera",
        last: "Última",
        next: "Siguiente",
        previous: "Anterior",
      },
      infoEmpty: "Sin rúbricas registradas",
      infoFiltered: "(filtrado de _MAX_ registros)",
    },
    processing: "Procesando...",
    loadingRecords: "Cargando...",
    ajax: {
      url: "App/Datatables/Incidencias-grid-data.php", // json datasource
      type: "post",
    },
    lengthChange: true, // añade la lista desplegable
    order: [[0, "DESC"]],
    "columnDefs": [{
      "targets": 7, // Índice de la columna Precio en la tabla
      "render": function(data, type, row) {
          return '$' + Number(data).toFixed(2); // Formatear Precio como moneda
      }
  }, {
      "targets": 10, // Índice de la columna Total en la tabla
      "render": function(data, type, row) {
          return '$' + Number(data).toFixed(2); // Formatear Total como moneda
      }
  }]
  });

  // Para Agregar Registro
  $("#ValidacionAgregarIncidencias").on("submit", function(e) {
    var form = $(this);

    form.parsley().validate();

    if (form.parsley().isValid()) {
      //prevent Default functionality
      //e.preventDefault();

      // data string
      var dataString = form.serialize();

      console.log(dataString);

      // ajax
      $.ajax({
        //async: false,
        type: "POST",
        url: "App/Server/ServerInsertarIncidencias.php",
        data: dataString,
        dataType: "json",
        success: function(response) {
          // Reescribe la Datatable y le da refresh

         // console.log(response.INCIDENCIASID);

          dataTableIncidenciasDT.columns.adjust().draw();
        },
      }).done(function() {});

      $("#ModalAgregarIncidencias").modal("toggle");
    }
  });

  // Para Editar Registro
  $("#ValidacionEditarIncidencias").on("submit", function(e) {
    var form = $(this);

    form.parsley().validate();

    if (form.parsley().isValid()) {
      //prevent Default functionality
      e.preventDefault();

      // data string
      var dataString = form.serialize();

      console.log(dataString);

      // ajax
      $.ajax({
        //async: false,
        type: "POST",
        url: "App/Server/ServerUpdateIncidencias.php",
        data: dataString,
        dataType: "json",
        success: function(response) {
          // Reescribe la Datatable y le da refresh

         console.log(response.INCIDENCIASID);

          dataTableIncidenciasDT.columns.adjust().draw();
        },
      }).done(function() {});

      $("#ModalEditarIncidencias").modal("toggle");
    }
  });

  // Para Borrar Registro

  $("body").on("click", "#BorrarIncidencias", function() {
    var INCIDENCIASID = $("input#INCIDENCIASIDBorrar").val();

    var dataString = "INCIDENCIASID=" + INCIDENCIASID;

    console.log(dataString);

    // ajax
    $.ajax({
      //async: false,
      type: "POST",
      url: "App/Server/ServerBorrarIncidencias.php",
      data: dataString,
      dataType: "json",
      success: function(response) {
        dataTableIncidenciasDT.columns.adjust().draw();
      },
    }).done(function() {});

    $("#ModalBorrarIncidencias").modal("toggle");
  });
});

function TomarDatosParaModalIncidencias(val) {
  $.ajax({
    type: "POST",
    url: "App/Server/ServerInfoIncidenciasParaModal.php",
    dataType: "json",
    data: "ID=" + val,
    success: function(response) {
      // Para el Modal de editar
      $("input#FechaEditar").val(response.Fecha);
      $("input#AuditorEditar").val(response.Auditor);
      $("input#FolioEditar").val(response.Folio);
      $("input#CantidadEditar").val(response.Cantidad);
      $("input#SKUEditar").val(response.SKU);
      $("input#VendedorEditar").val(response.Vendedor);
      $("input#SurtidorEditar").val(response.Surtidor);
      $("input#ComentariosEditar").val(response.Comentarios);

      //Para modal de Borrar
      $("#EliminarIncidencias").text("Incidencia:" + response.INCIDENCIASID + " " + "Folio:" + " " + response.Folio);
      $("#DatosIncidenciasParaBorrar").html(response.DatosParaBorrarIncidencias);
      $("input#INCIDENCIASIDBorrar").val(response.INCIDENCIASID);
    },
  });
}
