$(document).ready(function () {

Swal.fire({
    icon: 'question',
    text: '¿Desde dónde estás conectado?',
    title: 'Un paso mas...',
    showCancelButton: false,
    confirmButtonText: 'Guardar',
    //cancelButtonText: 'Cancelar',
    input: 'select',
    inputOptions: {
        1: 'Esmeraldas',
        2: 'La Concordia',
        3: 'Mutiles'
    },
    inputPlaceholder: 'Selecciona una ubicación',
    inputValidator: (value) => {
        // Validar que se haya seleccionado una opción
        return new Promise((resolve) => {
            if (value !== '') {
                resolve();
            } else {
                resolve('Por favor, selecciona una opción antes de continuar.');
            }
        });
    },
}).then((result) => {
    if (result.isConfirmed) {
        var selectedOption = result.value; // Capturar la opción seleccionada
        // Enviar la opción seleccionada al servidor a través de una solicitud AJAX
        $.ajax({
            url: '/site/guardar-biblioteca-en-sesion', // Ajusta la URL según tu estructura de rutas
            type: 'POST',
            data: { option: selectedOption }, // Datos a enviar al servidor
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Genial',
                        text: '¡Comenzemos nuestro viaje!'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error al intentar guardar la opción. Por favor, inténtalo de nuevo.'
                    });

                }
            },
            error: function (xhr, status, error) {
                // Manejar errores si es necesario
            }
        });
    } else {
        // El usuario cerró el diálogo sin seleccionar una opción
        // Aquí puedes manejar este caso, por ejemplo, mostrar un mensaje de alerta
        Swal.fire({
            icon: 'warning',
            title: '¡Atención!',
            text: 'Esto puede afectar tu experiencia.'
        });
    }
});
});