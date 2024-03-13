function showPrestamoModal(id, url) {
    $.ajax({
        url: url, // Utiliza la URL pasada como parámetro
        type: 'GET',
        data: { id: id },
        success: function (response) {
            $('#prestamo-modal .modal-body').html(response); // Actualizar el contenido del modal con el resultado de la acción
            $('#prestamo-modal').modal('show'); // Mostrar el modal
        },
        error: function () {
            alert('Error al cargar la solicitud de préstamo.');
        }
    });
}

$(document).ready(function () {
    $('#equipoSubmit').click(function () {
        $('#equipoForm').submit(); // Envía el formulario cuando se hace clic en el botón fuera del formulario
    });
    $('#libroSubmit').click(function () {
        $('#libroForm').submit(); // Envía el formulario cuando se hace clic en el botón fuera del formulario
    });
});