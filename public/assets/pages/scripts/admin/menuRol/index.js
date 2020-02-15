$('.menu_rol').on('change', function () {
    var data = {
        Men_id: $(this).data('menuid'),
        Rol_codigo: $(this).val(),
        _token: $('input[name=_token]').val()
    };
    if ($(this).is(':checked')) {
        data.estado = 1
    } else {
        data.estado = 0
    }
    ajaxRequest('/admin/menu-rol', data);
});

function ajaxRequest (url, data) {
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function (respuesta) {
            Insuval.notificaciones(respuesta.respuesta, 'Insuval', 'success');
        }
    });
} 