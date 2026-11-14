    // -------   Mail Send ajax

$(document).ready(function() {
    var form = $('#contactForm'); // ID correcto de tu formulario en Blade
    var submit = $('button[type="submit"]'); // Botón de envío
    var alert = $('.alert-msg');

    form.on('submit', function(e) {
        e.preventDefault(); // Evita la recarga tradicional

        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: form.attr('action'), // Toma automáticamente {{ route('sendEmail') }}
            type: 'POST',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function() {
                alert.fadeOut();
                submit.html('Sending....').prop('disabled', true);
            },
            success: function(data) {
                alert.html('¡Tu solicitud ha sido enviada con éxito!').fadeIn();
                form.trigger('reset'); // Limpia los campos
                submit.html('Send').prop('disabled', false);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert.html('Hubo un error al enviar el mensaje. Inténtalo de nuevo.').fadeIn();
                submit.html('Send').prop('disabled', false);
            }
        });
    });
});