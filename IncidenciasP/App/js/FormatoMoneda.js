$(document).ready(function() {
    $('#IncidenciasDT').DataTable({
        "columnDefs": [{
            "render": function(data, type, row) {
                return '$' + parseFloat(data).toFixed(2); // Formatear Precio como moneda
            },
            "targets": 7 // Índice de la columna Precio en la tabla
        }, {
            "render": function(data, type, row) {
                return '$' + parseFloat(data).toFixed(2); // Formatear Total como moneda
            },
            "targets": 10 // Índice de la columna Total en la tabla
        }]
    });
});