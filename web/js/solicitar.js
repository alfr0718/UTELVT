function showRegistroModal(url) {
    $.ajax({
        url: url, // Utiliza la URL pasada como parámetro
        type: 'GET',
        success: function (response) {
            $('#registro-modal .modal-body').html(response); // Actualizar el contenido del modal con el resultado de la acción
            $('#registro-modal').modal('show'); // Mostrar el modal
        },
        error: function () {
            alert('Error al cargar la solicitud de registro.');
        }
    });
}

function showEquipoModal(id, url) {
    $.ajax({
        url: url, // Utiliza la URL pasada como parámetro
        type: 'GET',
        data: { id: id },
        success: function (response) {
            $('#equipo-modal .modal-body').html(response); // Actualizar el contenido del modal con el resultado de la acción
            $('#equipo-modal').modal('show'); // Mostrar el modal
        },
        error: function () {
            alert('Error al cargar la solicitud de préstamo.');
        }
    });
}

function showLibroStep1Modal(id, url) {
    $.ajax({
        url: url, // Utiliza la URL pasada como parámetro
        type: 'GET',
        data: { id: id },
        success: function (response) {
            $('#libro-modal .modal-body').html(response); // Actualizar el contenido del modal con el resultado de la acción
            $('#libro-modal').modal('show'); // Mostrar el modal
        },
        error: function () {
            alert('Error al cargar la solicitud de préstamo.');
        }
    });
}

function showLibroStep2Modal(id, url) {
    $.ajax({
        url: url, // Utiliza la URL pasada como parámetro
        type: 'GET',
        data: { id: id },
        success: function (response) {
            $('#libroSubmit').show(); // Mostrar el botón
            $('#libro-modal .modal-body').html(response); // Actualizar el contenido del modal con el resultado de la acción
            $('#libro-modal').modal('show'); // Mostrar el modal Paso2

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
    $('#registroSubmit').click(function () {
        $('#registroForm').submit(); // Envía el formulario cuando se hace clic en el botón fuera del formulario
    });
});