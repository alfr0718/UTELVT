function showLogoutModal() {
    $.ajax({
        success: function (response) {
            $('#logout-modal').modal('show'); // Mostrar el modal
        },
        error: function () {
            alert('Error al cargar el cuadro de Cerrar Sesión.');
        }
    });
}