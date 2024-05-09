$(document).ready(function() {
  // como puedo disparar en la clase .select2 que comienze la busqueda de los clientes

  $(".select2").select2();

  var dataTableRepartosDT = $("#Repartos2DT").DataTable({
    // Tabla General de Usuarios

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
      infoEmpty: "Sin repartos registradas",
      infoFiltered: "(filtrado de _MAX_ registros)",
    },
    processing: "Procesando...",
    loadingRecords: "Cargando...",
    ajax: {
      url: "App/Datatables/Repartos-grid-data.php", // json datasource
      type: "post",
    },
    lengthChange: true, // añade la lista desplegable
    order: [[0, "DESC"]],
  });

  var dataTableRepartosDT = $("#RepartosCliente2DT").DataTable({
    // Tabla General de Usuarios

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
      infoEmpty: "Sin repartos registradas",
      infoFiltered: "(filtrado de _MAX_ registros)",
    },
    processing: "Procesando...",
    loadingRecords: "Cargando...",
    ajax: {
      url: "App/Datatables/RepartosCliente-grid-data.php", // json datasource
      type: "post",
    },
    lengthChange: true, // añade la lista desplegable
    order: [[0, "DESC"]],
  });

  // Para Agregar Usuarios
  $("#ValidacionAgregarRepartos").on("submit", function(e) {
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
        url: "App/Server/ServerInsertarRepartos.php",
        data: dataString,
        dataType: "json",
        success: function(response) {
          //console.log(response.USUARIOID);

          dataTableRepartosDT.columns.adjust().draw();
        },
      }).done(function() {});

      $("#ModalAgregarReparto").modal("toggle");
    }
  });

  $("#ValidacionEditarRepartos").on("submit", function(e) {
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
        url: "App/Server/ServerUpdateRepartos.php",
        data: dataString,
        dataType: "json",
        success: function(response) {
          // Reescribe la Datatable y le da refresh

          console.log(response.USUARIOID);

          dataTableRepartosDT.columns.adjust().draw();
        },
      }).done(function() {});

      $("#ModalEditarReparto").modal("toggle");
    }
  });

  // Deshabilitar Usuario

  $("body").on("click", "#BorrarReparto", function() {
    var REPARTOID = $("input#REPARTOIDBorrar").val();

    var dataString = "REPARTOID=" + REPARTOID;

    console.log(dataString);

    // ajax
    $.ajax({
      //async: false,
      type: "POST",
      url: "App/Server/ServerBorrarRepartos.php",
      data: dataString,
      dataType: "json",
      success: function(response) {
        dataTableRepartosDT.columns.adjust().draw();
      },
    }).done(function() {});

    $("#ModalBorrarReparto").modal("toggle");
  });

  // Evento para editar Status de reparto

  $("#ValidacionEditarStatus").on("submit", function(e) {
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
        url: "App/Server/ServerUpdateStatus.php",
        data: dataString,
        dataType: "json",
        success: function(response) {
          // Reescribe la Datatable y le da refresh

          console.log(response.USUARIOID);

          dataTableRepartosDT.columns.adjust().draw();
        },
      }).done(function() {});

      $("#ModalCambioStatus").modal("toggle");
    }
  });
});
function TomarDatosParaModalRepartos(val) {
  $.ajax({
    type: "POST",
    url: "App/Server/ServerInfoRepartosParaModal.php",
    dataType: "json",
    data: "ID=" + val,
    success: function(response) {
      // Para el Modal de editar

      // Campos para el modal #ModalEditarReparto

      $("select#CLIENTEIDEditar").val(response.CLIENTEID);
      $("input#NumeroDeFacturaEditar").val(response.NumeroDeFactura);
      $("input#CalleEditar").val(response.Calle);
      $("input#ColoniaEditar").val(response.Colonia);
      $("input#NumeroEXTEditar").val(response.NumeroEXT);
      $("input#ColoniaEditar").val(response.Colonia);
      $("input#CPEditar").val(response.CP);
      $("input#CiudadEditar").val(response.Ciudad);
      $("input#EstadoEditar").val(response.Estado);
      $("input#ReceptorEditar").val(response.Receptor);
      $("input#TelefonoDeReceptorEditar").val(response.TelefonoDeReceptor);
      $("input#TelefonoAlternativoEditar").val(response.TelefonoAlternativo);
      $("textarea#ComentariosEditar").val(response.Comentarios);

      $("input#REPARTOIDEditar").val(response.REPARTOID);
      $("#DatosRepartoParaBorrar").html(response.DatosParaBorrarReparto);

      $("input#REPARTOIDBorrar").val(response.REPARTOID);

      // Para el editor de Status
      $("input#REPARTOIDEditarStatus").val(response.REPARTOID);
      $("select#STATUSIDEditar").val(response.STATUSID);
    },
  });
}
