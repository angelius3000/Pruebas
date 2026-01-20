$(document).ready(function () {
    const tabla = $('#conteo-tabla');
    const botones = $('.conteo-accion');

    const actualizarFila = function (fila) {
        const selector = `tr[data-hora-inicio="${fila.hora_inicio}"]`;
        const filaElemento = tabla.find(selector);
        if (filaElemento.length === 0) {
            return;
        }

        filaElemento.find('[data-campo="hombre"]').text(fila.hombre);
        filaElemento.find('[data-campo="mujer"]').text(fila.mujer);
        filaElemento.find('[data-campo="pareja"]').text(fila.pareja);
        filaElemento.find('[data-campo="familia"]').text(fila.familia);
        filaElemento.find('[data-campo="cuadrilla"]').text(fila.cuadrilla);
        filaElemento.find('[data-campo="total"]').text(fila.total);
    };

    const cargarConteo = function () {
        $.getJSON('App/Server/ServerConteoObtener.php', function (respuesta) {
            if (!respuesta || !respuesta.success) {
                return;
            }

            if (Array.isArray(respuesta.data)) {
                respuesta.data.forEach(actualizarFila);
            }
        });
    };

    botones.on('click', function () {
        const boton = $(this);
        const tipo = boton.data('tipo');
        const delta = parseInt(boton.data('delta'), 10);

        botones.prop('disabled', true);

        $.ajax({
            url: 'App/Server/ServerConteoActualizar.php',
            method: 'POST',
            dataType: 'json',
            data: { tipo: tipo, delta: delta }
        })
            .done(function (respuesta) {
                if (respuesta && respuesta.success && respuesta.fila) {
                    actualizarFila(respuesta.fila);
                } else if (respuesta && respuesta.message) {
                    alert(respuesta.message);
                }
            })
            .fail(function (xhr) {
                const respuesta = xhr.responseJSON;
                if (respuesta && respuesta.message) {
                    alert(respuesta.message);
                }
            })
            .always(function () {
                botones.prop('disabled', false);
            });
    });

    cargarConteo();
});
