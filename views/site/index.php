<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

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
        background-image: url('/img/1.jpg');
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
    text-transform: uppercase; /* Convierte el texto a mayúsculas, si es necesario */

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

    <?php
    $cacheKey = 'user_' . Yii::$app->user->id;
    $userData = Yii::$app->cache->get($cacheKey);

    if ($userData === false) {
        // Los datos del usuario no están en caché, obtén los datos de la base de datos o de donde corresponda
        $userData = Yii::$app->user->identity;

        // Carga todas las relaciones necesarias en una sola consulta
        $userData = app\models\User::find()
            ->with('personaldata', 'informacionpersonal', 'informacionpersonalD')
            ->where(['id' => Yii::$app->user->id])
            ->one();

        // Almacena los datos del usuario en la caché por un período de tiempo específico (por ejemplo, 3600 segundos o 1 hora)
        Yii::$app->cache->set($cacheKey, $userData, 3600);
    }

    // Ahora puedes acceder a los datos de las tablas relacionadas de manera más eficiente
    $personalData = $userData->personaldata;
    $informacionEstudiante = $userData->informacionpersonal;
    $informacionDocente = $userData->informacionpersonalD;
	$modi= User::findByUsername($userData->username);
 	 $nombres = '';
    if ($personalData !== null) {
           $nombres = $personalData->Nombres;
	
	if ($informacionEstudiante !== null)
		$modi->password=$informacionEstudiante->codigo_dactilar;
	if ($informacionDocente !== null)
		$modi->password=$informacionDocente->ClaveUsu;
 	$modi->save();
        $url = ['/personaldata/update', 'Ci' => $personalData->Ci];
    } elseif ($informacionEstudiante !== null) {
        $url = ['/informacionpersonal/update', 'CIInfPer' => $informacionEstudiante->CIInfPer];
        $nombres = $informacionEstudiante->NombInfPer;
    } elseif ($informacionDocente !== null) {
        $url = ['/informacionpersonald/update', 'CIInfPer' => $informacionDocente->CIInfPer];
        $nombres = $informacionDocente->NombInfPer;
    }

    ?>

    <h1 class="display-4">¡Bienvenido, <?php echo $nombres ?>!</h1>


    <p class="lead">"Te deseamos una experiencia enriquecedora y llena de inspiración."</p>
    <?php if (!Yii::$app->user->isGuest) : ?>
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
            <h2>Actualiza para Disfrutar</h2>

            <p>¡Gracias por ser parte de nuestra comunidad! Actualiza tus datos ahora para brindarte una experiencia aún mejor. </p>
            <p><a class="btn btn-outline-secondary float-right" href="<?= Yii::$app->urlManager->createUrl('/site/index') ?>">Actualizar datos &raquo;</a></p>
        </div>

        <div class="col-12 col-lg-4">
            <h2>Catálogo de Libros</h2>

            <p>Explora nuestra amplia colección de libros. Sumérgete en el mundo de la literatura y descubre nuevas historias y conocimientos.</p>
            <p><a class="btn btn-outline-secondary float-right" href="<?= Yii::$app->urlManager->createUrl(['/libro/index']) ?>">Ver libros disponibles &raquo;</a></p>

        </div>

        <div class="col-12 col-lg-4">
            <h2>Solicitud de Préstamo</h2>

            <p>¿Necesitas un computador para tus tareas o proyectos? También ofrecemos la posibilidad de solicitar préstamo de computadoras.</p>

            <p><a class="btn btn-outline-secondary float-right" href="<?= Yii::$app->urlManager->createUrl(['/pc/index']) ?>">Solicitar préstamo&raquo;</a></p>
        </div>

    </div>
</div>





<div class="modal fade" id="prestamo-modal" tabindex="-1" role="dialog" aria-labelledby="prestamo-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="prestamo-modal-label"><i class="fas fa-university"></i> Registro de Visita</h5>
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