$(document).ready(function() {
  // como puedo disparar en la clase .select2 que comienze la busqueda de los clientes

  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  $("body").tooltip({ selector: '[data-toggle="tooltip"]' });

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
    columnDefs: [
      { orderable: false, targets: [1] },
      { className: "text-end NumerosSIAN", targets: [0] }, // Deshabilitar ordenar para la segunda columna (índice 1)
    ],

    ajax: {
      url: "App/Datatables/Repartos-grid-data.php", // json datasource
      type: "post",
    },
    lengthChange: true, // añade la lista desplegable
    order: [[0, "DESC"]],
  });

  var dataTableRepartosDTClientes = $("#RepartosCliente2DT").DataTable({
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

      // ajax
      $.ajax({
        //async: false,
        type: "POST",
        url: "App/Server/ServerInsertarRepartos.php",
        data: dataString,
        dataType: "json",
        success: function(response) {
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

      // ajax
      $.ajax({
        //async: false,
        type: "POST",
        url: "App/Server/ServerUpdateRepartos.php",
        data: dataString,
        dataType: "json",
        success: function(response) {
          // Reescribe la Datatable y le da refresh

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

      // ajax
      $.ajax({
        //async: false,
        type: "POST",
        url: "App/Server/ServerUpdateStatus.php",
        data: dataString,
        dataType: "json",
        success: function(response) {
          // Reescribe la Datatable y le da refresh

          dataTableRepartosDT.columns.adjust().draw();
        },
      }).done(function() {});

      $("#ModalCambioStatus").modal("toggle");
    }
  });

  // Toma el change de el editor de Repartos

  $(document).on("change", "#STATUSIDEditar", function() {
    var Status = $(this).val();
    var REPARTOID = $("input#REPARTOIDEditarStatus").val();

    TomarDatosParaModalEnEdicionDeStatus(REPARTOID);

    if (Status != 1) {
      $(".StatusEscondidos").show();
    } else {
      $(".StatusEscondidos").hide();
    }

    if (Status == 4) {
      $(".RepartosEscondidos").show();
      $("#Surtidores").prop("required", true);
      $("#USUARIOIDRepartidor").prop("required", true);
    } else {
      $(".RepartosEscondidos").hide();
      $("#Surtidores").prop("required", false);
      $("#USUARIOIDRepartidor").prop("required", false);
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
      $("input#EnlaceGoogleMapsEditar").val(response.EnlaceMapaGoogle);
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

      $("textarea#MotivoDelEstatus").val(response.MotivoDelEstatus);

      if (response.STATUSID != 1) {
        $(".StatusEscondidos").show();
      } else {
        $(".StatusEscondidos").hide();
      }

      if (response.STATUSID == 4) {
        $(".RepartosEscondidos").show();

        $("textarea#Surtidores").val(response.Surtidores);
        $("select#USUARIOIDRepartidor").val(response.USUARIOIDRepartidor);
      } else {
        $(".RepartosEscondidos").hide();
        $("textarea#Surtidores").val("");
        $("select#USUARIOIDRepartidor").val("");
      }
    },
  });
}

function TomarDatosParaModalEnEdicionDeStatus(val) {
  $.ajax({
    type: "POST",
    url: "App/Server/ServerInfoRepartosParaModal.php",
    dataType: "json",
    data: "ID=" + val,
    success: function(response) {
      // Para el Modal de editar
      $("textarea#Surtidores").val(response.Surtidores);
      $("select#USUARIOIDRepartidor").val(response.USUARIOIDRepartidor);
    },
  });
}
