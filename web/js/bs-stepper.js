$(document).ready(function () {
    // Espera a que el DOM esté listo

    var stepperElement = $('.bs-stepper')[0]; // Selecciona el elemento del stepper

    var stepper = new Stepper(stepperElement, {
        linear: true, // Configura el stepper para navegación lineal
        animation: true // Habilita la animación para una transición suave entre pasos
    });

    // Vincula los eventos de clic a los botones de navegación
    $('.btn-next').click(function () {
        stepper.next(); // Avanza al siguiente paso
    });

    $('.btn-prev').click(function () {
        stepper.previous(); // Retrocede al paso anterior
    });
});
