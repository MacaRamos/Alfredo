$(document).ready(function() {
    $("#tabla-data").on('submit', '.form-eliminar', function() {
        event.preventDefault();
        const form = $(this);
        swal({
            title: '¿Está seguro que desea eliminar el registro ?',
            text: "Esta acción no se puede deshacer!",
            icon: 'warning',
            buttons: {
                cancel: "Cancelar",
                confirm: "Aceptar"
            },
            dangerMode: true,
        }).then((value) => {
            if (value) {
                ajaxRequest(form);
            }
        });
    });

    function ajaxRequest(form) {
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(respuesta) {
                console.log(respuesta.mensaje);
                if (respuesta.tipo == "success") {
                    form.parents('tr').remove();
                    Alfredo.notificaciones(respuesta.mensaje, '', respuesta.tipo);
                } else {
                    Alfredo.notificaciones(respuesta.mensaje, '', respuesta.tipo);
                }

            },
            error: function() {}
        });
    }
});