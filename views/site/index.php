<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

$this->title = 'Biblioteca General';

//Js para registrar visita
$jsFilePath = '@web/js/solicitar.js';
$this->registerJsFile($jsFilePath, ['depends' => [\yii\web\JqueryAsset::class]]);

//Estilos
$this->registerCssFile('@web/css/site-index.css', ['depends' => [yii\bootstrap4\BootstrapAsset::class]]);

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
        $modi->password = $informacionEstudiante->ClaveUsu;
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

    <div class="row">

        <div class="card">

            <div id="carouselIndex" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselIndex" data-slide-to="0" class="active">&#8226;</li>
                    <li data-target="#carouselIndex" data-slide-to="1"></li>
                    <li data-target="#carouselIndex" data-slide-to="2"></li>
                    <li data-target="#carouselIndex" data-slide-to="3"></li>
                </ol>
                <div class="carousel-inner cropped-image">
                    <div class="carousel-item active">
                        <img class="d-block w-100 dark-img" src="<?= Yii::getAlias('@web') ?>/img/background/1.jpg" alt=" First slide">

                        <div class="card-img-overlay d-flex flex-column justify-content-center">

                            <div class="row justify-content-center">

                                <?php if (!Yii::$app->user->isGuest) : ?>
                                    <h1 class="display-4 text-center index-title"><b>¡Bienvenido, <?= $nombres ?>!</b></h1>
                                <?php endif; ?>
                            </div>

                            <div class="row justify-content-center align-items-center">

                                <p class="text-white text-center index-sub">
                                    Te deseamos una experiencia <br>
                                    enriquecedora y llena de inspiración.
                                </p>

                                <!-- <p class="text-white index-sub">
                                    Por favor, ayúdanos a mejorar <br>
                                    completando nuestra encuesta.
                                </p>

                                 <a class="btn btn-success" href="#">Empezar &raquo;</a> -->

                            </div>

                        </div>
                    </div>


                    <div class="carousel-item">
                        <img class="d-block w-100" src="<?= Yii::getAlias('@web') ?>/img/background/5.jpg" alt=" Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="<?= Yii::getAlias('@web') ?>/img/background/2.jpeg" alt=" Third slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="<?= Yii::getAlias('@web') ?>/img/background/4.jpeg" alt=" Fourth slide">
                    </div>

                </div>
                <a class="carousel-control-prev" href="#carouselIndex" role="button" data-slide="prev">
                    <span class="carousel-control-custom-icon" aria-hidden="true">
                        <i class="fas fa-angle-left fa-sm"></i> </span>
                </a>
                <a class="carousel-control-next" href="#carouselIndex" role="button" data-slide="next">
                    <span class="carousel-control-custom-icon" aria-hidden="true">
                        <i class="fas fa-angle-right fa-sm"></i> </span>
                </a>
            </div>

        </div>

    </div>



    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <a class="card mb-2 card-effect" onclick="showRegistroModal('<?php echo Url::to(['/solicitud/solicitar-espacio']); ?>')">
                        <img class="card-img-top dark-img" src="<?= Yii::getAlias('@web') ?>/img/index/visita-index.jpg" alt="Visita">
                        <div class="card-img-overlay d-flex flex-column justify-content-center">
                            <h5 class="card-title text-teal index-sub"><b>Registra tu Visita</b></h5>
                            <p class="card-text text-white pb-2 pt-1">
                                ¡Nos alegra que estés aquí! <br>
                                Anímate y firma nuestro libro de visitas.<br>
                            </p>
                            <!--    <?= Html::button('Registra tu Visita &raquo;', [
                                        'class' => 'btn btn-success float-right',
                                        'onclick' => 'showRegistroModal("' . Url::to(['/solicitud/solicitar-espacio']) . '")', // Llamar a la función JavaScript con el ID del modelo y la URL
                                    ]);
                                    ?> -->
                        </div>
                    </a>
                </div>
                <a class="col-md-12 col-lg-6 col-xl-4" href="<?= Yii::$app->urlManager->createUrl(['/libro/index']) ?>">
                    <div class="card mb-2 card-effect">
                        <img class="card-img-top dark-img" src="<?= Yii::getAlias('@web') ?>/img/index/book-index.jpg" alt="Libros">
                        <div class="card-img-overlay d-flex flex-column justify-content-center">
                            <h5 class="card-title text-teal index-sub"><b>Catálogo de Libros</b></h5>
                            <p class="card-text pb-1 pt-1 text-white">
                                Descubre un vasto universo de conocimientos.<br>
                                ¡Explora nuestra colección ahora!

                            </p>
                            <!-- <a class="btn btn-success float-right" href="<?= Yii::$app->urlManager->createUrl(['/libro/index']) ?>">Libros disponibles &raquo;</a> -->
                        </div>
                    </div>
                </a>
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <a class="card mb-2 card-effect" href="<?= Yii::$app->urlManager->createUrl(['/pc/index']) ?>">
                        <img class="card-img-top dark-img" src="<?= Yii::getAlias('@web') ?>/img/index/computer-index.jpg" alt="Dist Photo 3">
                        <div class="card-img-overlay d-flex flex-column justify-content-center">
                            <h5 class="card-title text-teal index-sub"><b>Préstamo de Equipos</b></h5>
                            <p class="card-text pb-1 pt-1 text-white">
                                ¿Necesitas un Computador para <br>
                                tus proyectos? ¡Solicita un equipo<br>
                                ahora!
                            </p>

                            <!-- <a class="btn btn-success float-right" href="<?= Yii::$app->urlManager->createUrl(['/pc/index']) ?>">Equipos disponibles &raquo;</a> -->

                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>



</div>


<div class="modal fade" id="registro-modal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-teal justify-content-center">
                <h4 class="modal-title">Registrar Visita &nbsp;&nbsp;<i class="fas fa-street-view fa-lg"></i></h4>
                <!--   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
            </div>
            <div class="modal-body">


            </div>
            <div class="modal-footer justify-content-center">
                <button id="registroSubmit" type="button" class="btn btn-primary">Registrar &nbsp;&nbsp;<i class="fas fa-check-circle"></i></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar &nbsp;&nbsp;<i class="fas fa-times"></i></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>