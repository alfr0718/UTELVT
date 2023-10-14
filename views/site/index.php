<?php

/** @var yii\web\View $this */
use app\models\PersonalData;
use app\models\Prestamo;
use app\models\User;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Biblioteca General';

$this->registerCss("

@import url('https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap');

.welcome-container {
    background-size: cover;
    background-position: center;
    animation: backgroundAnimation 60s infinite alternate;
    transition: background-image 2s ease-in-out; /* Agregamos una transición suave */
}

@keyframes backgroundAnimation {
    0% {
        background-image: url('/img/1.jpg');
    }
    25% {
        background-image: url('/img/2.jpeg');
    }
    50% {
        background-image: url('/img/3.jpeg');
    }
    75% {
        background-image: url('/img/4.jpeg');
    }
    100% {
        background-image: url('/img/1.jpeg');
    }
}

.site-index {
    text-align: center;
    padding: 30px 0;
    color: #FFF; /* Color del texto en blanco */
    font-family: 'Raleway', sans-serif;
    font-size: 1.2em;
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Sombreado del texto */
}


.site-index h1 {
    font-size: 3em;
    margin: 20px 0;
    transition: font-size 0.3s;
}

.site-index:hover h1 {
    font-size: 3.5em;
}

.site-index .lead {
    font-size: 1.2em;
    margin-bottom: 20px;
}

.site-index .btn-success,
.site-index .btn-primary {
    font-size: 1em;
    padding: 15px 20px;
    background-color: #5EB400;
    border: none;
    color: #FFF;
    transition: background-color 0.3s, transform 0.2s;
    margin: 10px;
}

.site-index .btn-success:hover,
.site-index .btn-primary:hover {
    background-color: #4E9A00;
    transform: scale(1.05);
}

.col-lg-4 {
    flex: 1;
    margin: 20px;
    padding: 20px;
    border-radius: 10px;
    background-color: #FFF;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.col-lg-4:hover {
    transform: scale(1.05);
}

.col-lg-4 p {
    font-size: 1em;
    margin-bottom: 10px;
}

.btn-outline-secondary {
    font-size: 1em;
    padding: 15px 20px;
    background-color: #FF6B00;
    color: #FFF;
    border: none;
}

.btn-outline-secondary:hover {
    background-color: #E95A00;
}
");

?>
    <div class="site-index welcome-container">

        <?php if (Yii::$app->user->isGuest): ?>
    
            <h1 class="display-4">¡Bienvenido!</h1>
    
        <?php else: ?>
        
        <?php $userData = Yii::$app->user->identity->personaldata; ?>
        
            <h1 class="display-4">¡Bienvenido, <?= $userData->Nombres ?>!</h1>
    
        <?php endif; ?>

        <p class="lead">"Te deseamos una experiencia enriquecedora y llena de inspiración."</p>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?php echo Html::button('Registra tu visita', [
                    'class' => 'btn btn-success',
                    'id' => 'open-modal-button',
                    'data-toggle' => 'modal',
                    'data-target' => '#prestamo-modal',
                    'data-remote' => Url::to(['/prestamo/prestarespacio']), // URL de la acción
                 ]);
            ?>
        
        <?php endif; ?>
   
    </div>

    <div class="body-content">

    <div class="row">
        <div class="col-12 col-lg-4">
            <h2>¡Bienvenido a Nuestra Biblioteca!</h2>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?php
                    //$ciParam = Yii::$app->user->isGuest ? null : Yii::$app->user->identity->personaldata->Ci;
                    $url = ['/personaldata/update', 'Ci' => $userData->Ci];
                    ?>
                    <p>¡Gracias por ser parte de nuestra comunidad! Actualiza tus datos ahora para brindarte una experiencia aún mejor. </p>
                    <p><a class="btn btn-outline-secondary float-right" href="<?= Yii::$app->urlManager->createUrl($url) ?>">Actualizar datos  &raquo;</a></p>
                <?php else: ?>
                    <p>¡Gracias por visitarnos! Para disfrutar de una experiencia aún mejor, te animamos a iniciar sesión.</p>
                    <p><a class="btn btn-outline-secondary float-right" href="<?= Yii::$app->urlManager->createUrl(['/site/login']) ?>">Iniciar sesión  &raquo;</a></p>
                <?php endif; ?>
            
        </div>
        <div class="col-12 col-lg-4">
            <h2>Catálogo de Libros</h2>

            <p>Explora nuestra amplia colección de libros. Sumérgete en el mundo de la literatura y descubre nuevas historias y conocimientos.</p>
            <?php  if (!Yii::$app->user->isGuest): ?>
                 <p><a class="btn btn-outline-secondary float-right" href="<?= Yii::$app->urlManager->createUrl(['/libro/index']) ?>">Ver libros disponibles &raquo;</a></p>
            <?php  else: ?>
                 <p><a class="btn btn-outline-secondary float-right" href="<?= Yii::$app->urlManager->createUrl(['/site/login']) ?>">Iniciar sesión  &raquo;</a></p>
            <?php  endif; ?>
        </div>
    
        <div class="col-12 col-lg-4">
            <h2>Solicitud de Préstamo</h2>

            <p>¿Necesitas un computador para tus tareas o proyectos? También ofrecemos la posibilidad de solicitar préstamo de computadoras.</p>

            <?php if (!Yii::$app->user->isGuest): ?>
            <p><a class="btn btn-outline-secondary float-right" href="<?= Yii::$app->urlManager->createUrl(['/pc/index']) ?>">Solicitar préstamo&raquo;</a></p>
            <?php else: ?>
                 <p><a class="btn btn-outline-secondary float-right" href="<?= Yii::$app->urlManager->createUrl(['/site/login']) ?>">Iniciar sesión  &raquo;</a></p>
            <?php  endif; ?>
        </div>

    </div>
</div>





<div class="modal fade" id="prestamo-modal" tabindex="-1" role="dialog" aria-labelledby="prestamo-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="prestamo-modal-label">Registro de Visita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenido del modal cargado a través de AJAX -->
                <div id="prestamo-modal-content"></div>
            </div>
        </div>
    </div>
</div>

<?php
// Registro de JS para manejar la apertura del modal
$this->registerJs('
    $("#open-modal-button").on("click", function () {
        $("#prestamo-modal-content").load($(this).data("remote"), function() {
            // Una vez que se carga el contenido en el modal, escuchamos el evento clic del botón "Enviar".
            $("#prestamo-modal-content #submit-button").on("click", function (e) {
                e.preventDefault(); // Prevenir el envío automático del formulario
                // Aquí puedes realizar validaciones del formulario si es necesario
                // Si las validaciones son exitosas, puedes enviar el formulario con AJAX

                $.ajax({
                    type: "POST",
                    url: "/prestamo/prestarespacio", // Reemplaza con la URL correcta
                    data: $("#prestamo-formulario").serialize(), // Reemplaza "tu-formulario" con el ID de tu formulario
                    success: function (data) {
                        // Manejar la respuesta si es necesario
                    }
                });
            });
        });
    });
');
?>
