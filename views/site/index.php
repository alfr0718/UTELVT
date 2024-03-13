<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

$this->title = 'Biblioteca General';
$jsFilePath = '@web/js/registrar.js';
$this->registerJsFile($jsFilePath, ['depends' => [\yii\web\JqueryAsset::class]]);

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
$modi = User::findByUsername($userData->username);
$nombres = '';
if ($personalData !== null) {
    $nombres = $personalData->Nombres;

    if ($informacionEstudiante !== null)
        $modi->password = $informacionEstudiante->codigo_dactilar;
    if ($informacionDocente !== null)
        $modi->password = $informacionDocente->ClaveUsu;
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


<div class="site-index">

    <h1 class="display-4">¡Bienvenido, <?php echo $nombres ?>!</h1>


    <p class="lead">"Te deseamos una experiencia enriquecedora y llena de inspiración."</p>
    <?php if (!Yii::$app->user->isGuest) : ?>
        <?php echo Html::button('Registra tu visita', [
            'class' => 'btn btn-success',
            'onclick' => 'showRegistroModal("' . Url::to(['/solicitud/solicitar-espacio']) . '")', // Llamar a la función JavaScript con el ID del modelo y la URL
        ]);
        ?>
    <?php endif; ?>


    <div class="row">
        <div class="card">
            <div class="card-header">
                <h2>Actualiza para Disfrutar</h2>
            </div>
            <div class="card-body">
                <p>¡Gracias por ser parte de nuestra comunidad! Actualiza tus datos ahora para brindarte una experiencia aún mejor. </p>
            </div>
            <div class="card-footer">
                <p><a class="btn btn-outline-secondary float-right" href="<?= Yii::$app->urlManager->createUrl('/site/index') ?>">Actualizar datos &raquo;</a></p>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <h2>Catálogo de Libros</h2>
            </div>
            <div class="card-body">
                <p>Explora nuestra amplia colección de libros. Sumérgete en el mundo de la literatura y descubre nuevas historias y conocimientos.</p>
            </div>
            <div class="card-footer">
                <p><a class="btn btn-outline-secondary float-right" href="<?= Yii::$app->urlManager->createUrl(['/libro/index']) ?>">Ver libros disponibles &raquo;</a></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Solicitud de Préstamo</h2>
            </div>
            <div class="card-body">
                <p>¿Necesitas un computador para tus tareas o proyectos? También ofrecemos la posibilidad de solicitar préstamo de computadoras.</p>
            </div>
            <div class="card-footer">
                <p><a class="btn btn-outline-secondary float-right" href="<?= Yii::$app->urlManager->createUrl(['/pc/index']) ?>">Solicitar préstamo&raquo;</a></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registro-modal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-teal">
                <h4 class="modal-title">Registrar Visita <i class="fas fa-user-check"></i></h4>
                <!--   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
            </div>
            <div class="modal-body">


            </div>
            <div class="modal-footer justify-content-center">
                <button id="registroSubmit" type="button" class="btn btn-primary">Registrar <i class="fas fa-check-circle"></i></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fas fa-ban"></i></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>