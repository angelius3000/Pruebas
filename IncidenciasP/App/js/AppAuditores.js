$(document).ready(function() {
  var dataTableAuditoresDT = $("#AuditoresDT").DataTable({
      // Configuración de la tabla
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
          infoEmpty: "Sin vendedores registrados",
          infoFiltered: "(filtrado de _MAX_ registros)",
      },
      processing: "Procesando...",
      loadingRecords: "Cargando...",
      ajax: {
          url: "App/Datatables/Auditores-grid-data.php", // json datasource
          type: "post",
      },
      lengthChange: true, // añade la lista desplegable
      order: [[0, "ASC"]],
  });

  // Para agregar vendedor
  $("#ValidacionAgregarAuditores").on("submit", function(e) {
      e.preventDefault(); // Previene el comportamiento predeterminado
      var form = $(this);
      form.parsley().validate();
      if (form.parsley().isValid()) {
          // Data string
          var dataString = form.serialize();
          // Ajax
          $.ajax({
              type: "POST",
              url: "App/Server/ServerInsertarAuditores.php",
              data: dataString,
              dataType: "json",
              success: function(response) {
                  console.log("Hola");
                  console.log(response.AUDITORESID);
                  // Reescribe la Datatable y le da refresh
                  dataTableAuditoresDT.ajax.reload(null, false);
              }
          });
          $("#ModalAgregarAuditores").modal("toggle");
      }
  });

  // Para editar Auditores
  $("#ValidacionEditarAuditores").on("submit", function(e) {
      e.preventDefault(); // Previene el comportamiento predeterminado
      var form = $(this);
      form.parsley().validate();
      if (form.parsley().isValid()) {
          // Data string
          var dataString = form.serialize();
          console.log(dataString);
          // Ajax
          $.ajax({
              type: "POST",
              url: "App/Server/ServerUpdateAuditores.php",
              data: dataString,
              dataType: "json",
              success: function(response) {
                  dataTableAuditoresDT.ajax.reload(null, false);
              }
          });
          $("#ModalEditarAuditores").modal("toggle");
      }
  });

  // Para borrar registro
  $("body").on("click", "#BorrarAuditores", function() {
      var AUDITORESID = $("input#AUDITORESIDBorrar").val();
      var dataString = "AUDITORESID=" + AUDITORESID;
      console.log(dataString);
      // Ajax
      $.ajax({
          type: "POST",
          url: "App/Server/ServerBorrarAuditores.php",
          data: dataString,
          dataType: "json",
          success: function(response) {
              dataTableAuditoresDT.ajax.reload(null, false);
          }
      });
      $("#ModalBorrarAuditores").modal("toggle");
  });
});

function TomarDatosParaModalAuditores(val) {
  $.ajax({
      type: "POST",
      url: "App/Server/ServerInfoAuditoresParaModal.php",
      dataType: "json",
      data: "ID=" + val,
      success: function(response) {
          // Para el Modal de editar
          $("input#NombreAuditoresEditar").val(response.NombreAuditor);
          $("input#AUDITORESIDEditar").val(response.AUDITORESID);
          // Para modal de borrar
          $("#EliminarAuditores").text("Nombre:" + " " + response.NombreAuditor);
          $("#DatosAuditoresParaBorrar").html(response.DatosParaBorrarAuditores);
          $("input#AUDITORESIDBorrar").val(response.AUDITORESID);
      },
  });
}
