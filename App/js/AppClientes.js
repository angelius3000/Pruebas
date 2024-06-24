$(document).ready(function() {
  var dataTableClientesDT = $("#ClientesDT").DataTable({
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
      infoEmpty: "Sin rúbricas registradas",
      infoFiltered: "(filtrado de _MAX_ registros)",
    },
    processing: "Procesando...",
    loadingRecords: "Cargando...",
    ajax: {
      url: "App/Datatables/Clientes-grid-data.php", // json datasource
      type: "post",
    },
    lengthChange: true, // añade la lista desplegable
    order: [[1, "ASC"]],
  });

  // Para Agregar Usuarios
  $("#ValidacionAgregarClientes").on("submit", function(e) {
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
        url: "App/Server/ServerInsertarClientes.php",
        data: dataString,
        dataType: "json",
        success: function(response) {
          // Reescribe la Datatable y le da refresh

          console.log(response.CLIENTEID);

          dataTableClientesDT.columns.adjust().draw();
        },
      }).done(function() {});

      $("#ModalAgregarClientes").modal("toggle");
    }
  });

  $("#ValidacionEditarClientes").on("submit", function(e) {
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
        url: "App/Server/ServerUpdateClientes.php",
        data: dataString,
        dataType: "json",
        success: function(response) {
          // Reescribe la Datatable y le da refresh

          console.log(response.CLIENTEID);

          dataTableClientesDT.columns.adjust().draw();
        },
      }).done(function() {});

      $("#ModalEditarClientes").modal("toggle");
    }
  });

  // Deshabilitar Usuario

  $("body").on("click", "#DeshabilitarCliente", function() {
    var CLIENTEID = $("input#CLIENTEIDDeshabilitar").val();

    var dataString = "CLIENTEID=" + CLIENTEID;

    console.log(dataString);

    // ajax
    $.ajax({
      //async: false,
      type: "POST",
      url: "App/Server/ServerDeshabilitarClientes.php",
      data: dataString,
      dataType: "json",
      success: function(response) {
        dataTableClientesDT.columns.adjust().draw();
      },
    }).done(function() {});

    $("#ModalDeshabilitarClientes").modal("toggle");
  });

  $(document).on("change", "#TIPODEUSUARIOID", function() {
    var TipoDeUsuario = $(this).val();

    if (TipoDeUsuario == 4) {
      $("#ClientesEscondidos").show();

      // Ponerle el parametro "required al select de Clientes"
      $("select#CLIENTEID").attr("required", true);
    } else {
      $("#ClientesEscondidos").hide();
      $("select#CLIENTEID").attr("required", false);
    }
  });

  // Para que los clientes no se puedan clonar , mandamos el pedido para ver si existen

  $("#CLIENTESIAN, #CLIENTESIANEditar").on("keyup", function() {
    var ValorClienteSIAN = $(this).val();

    // ajax
    $.ajax({
      //async: false,
      type: "POST",
      url: "App/Server/ServerUpdateClientes.php",
      data: dataString,
      dataType: "json",
      success: function(response) {
        // Reescribe la Datatable y le da refresh

        console.log(response.CLIENTEID);

        dataTableClientesDT.columns.adjust().draw();
      },
    }).done(function() {});
  });

  $("#EmailCliente, #EmailClienteEditar").on("keyup", function() {
    var ValorEmail = $(this).val();

    // ajax
    $.ajax({
      //async: false,
      type: "POST",
      url: "App/Server/ServerInfoClientesChecarEmailSiExiste.php",
      data: "EmailCliente=" + ValorEmail,
      dataType: "json",
      success: function(response) {
        // Reescribe la Datatable y le da refresh

        if (response.NombreCliente != null) {
          // Mandar el modal de que ya existe el email

          $("#ModalEmailYaExiste").modal("show");

          // Quitamos el modal que genero el email

          $("#ModalAgregarClientes").modal("hide");

          // Mandamos la informacion al nuevo modal

          $("#NombreClienteYaExiste").text(response.NombreCliente);
          $("#EmailClienteYaExiste").text(response.EmailCliente);
          $("#TelefonoClienteYaExiste").text(response.TelefonoCliente);
          $("#NombreContactoYaExiste").text(response.NombreContacto);
          $("#DireccionClienteYaExiste").text(response.DireccionCliente);
          $("#ColoniaClienteYaExiste").text(response.ColoniaCliente);
          $("#CiudadClienteYaExiste").text(response.CiudadCliente);
          $("#EstadoClienteYaExiste").text(response.EstadoCliente);
        }
      },
    }).done(function() {});
  });
});

function TomarDatosParaModalClientes(val) {
  $.ajax({
    type: "POST",
    url: "App/Server/ServerInfoClientesParaModal.php",
    dataType: "json",
    data: "ID=" + val,
    success: function(response) {
      // Para el Modal de editar
      $("input#CLIENTESIANEditar").val(response.CLIENTESIAN);
      $("input#NombreClienteEditar").val(response.NombreCliente);
      $("input#EmailClienteEditar").val(response.EmailCliente);
      $("input#TelefonoClienteEditar").val(response.TelefonoCliente);
      $("input#NombreContactoEditar").val(response.NombreContacto);
      $("input#DireccionClienteEditar").val(response.DireccionCliente);
      $("input#ColoniaClienteEditar").val(response.ColoniaCliente);
      $("input#CiudadClienteEditar").val(response.CiudadCliente);
      $("input#EstadoClienteEditar").val(response.EstadoCliente);

      //Para modal de Borrar

      $("#NombreUsuarioDeshabilitar").text(
        response.CLIENTESIAN + " " + response.NombreCliente
      );

      $("input#CLIENTEIDDeshabilitar").val(response.CLIENTEID);
    },
  });
}
