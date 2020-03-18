$(document).ready(function() {
    Alfredo.validacionGeneral('form-general');
    $('#Men_icono').on('input', function() {
        $('#mostrar-icono').removeClass().addClass($(this).val() + ' pt-2');
    });
});