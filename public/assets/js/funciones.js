var Alfredo = function() {
    return {
        validacionGeneral: function(id, reglas, mensajes) {
            const formulario = $('#' + id);
            formulario.validate({
                rules: reglas,
                messages: mensajes,
                errorElement: 'div', //default input error message container
                errorClass: 'invalid-feedback', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: ":hidden, [contenteditable='true']:not([name])", // validate all fields including form hidden input
                highlight: function(element, errorClass, validClass) { // hightlight error inputs
                    $(element).closest('.form-control').addClass('is-invalid'); // set error class to the control control
                },
                unhighlight: function(element) { // revert the change done by hightlight
                    $(element).closest('.form-control').removeClass('is-invalid'); // set error class to the control control
                },
                success: function(label) {
                    label.closest('.form-control').removeClass('is-invalid'); // set success class to the control control
                },
                errorPlacement: function(error, element) {
                    if ($(element).is('select') && element.hasClass('bs-select')) { //PARA LOS SELECT BOOSTRAP
                        error.insertAfter(element); //element.next().after(error);
                    } else if ($(element).is('select') && element.hasClass('select2-hidden-accessible')) {
                        element.next().after(error);
                    } else if (element.attr("data-error-container")) {
                        error.appendTo(element.attr("data-error-container"));
                    } else {
                        error.insertAfter(element); // default placement for everything else
                    }
                },
                invalidHandler: function(event, validator) { //display error alert on form submit

                },
                submitHandler: function(form) {
                    return true;
                }
            });
        },
        notificaciones: function(mensaje, titulo, tipo) {
            toastr.options = {
                closeButton: true,
                newestOnTop: true,
                positionClass: 'toast-top-right',
                preventDuplicates: true,
                timeOut: '5000'
            };
            if (tipo == 'error') {
                toastr.error(mensaje, titulo);
            } else if (tipo == 'success') {
                toastr.success(mensaje, titulo);
            } else if (tipo == 'info') {
                toastr.info(mensaje, titulo);
            } else if (tipo == 'warning') {
                toastr.warning(mensaje, titulo);
            }
        },
    }
}();