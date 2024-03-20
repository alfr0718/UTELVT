 <?php

    use yii\helpers\Html;

    $this->registerCssFile('@web/css/site-index.css', ['depends' => [yii\bootstrap4\BootstrapAsset::class]]);
    $this->title = 'Estadísticas de Libros';

    ?>
 <div class="estadistica-libro-index">
     <div class="row justify-content-center text-center">
         <div class="card card-success w-75">
             <div class="card-header">
                 <h1 class="sub-index"><?= Html::encode($this->title) ?></h1>
             </div>

             <div class="card-body">

                 <div class="row">
                     <div class="col-md-6">
                         <a class="card mb-2 card-effect" href="<?= Yii::$app->urlManager->createUrl(['/estadistica/asignatura-libro']) ?>">
                             <img class="card-img-top dark-img" src="<?= Yii::getAlias('@web') ?>/img/index/estadistic-index.jpg" alt="Libros">
                             <div class="card-img-overlay d-flex flex-column justify-content-center">
                                 <h5 class="card-title text-light"><b>Asignatura Mes-Año</b></h5>
                             </div>
                         </a>
                     </div>
                     <div class="col-md-6">
                         <a class="card mb-2 card-effect" href="<?= Yii::$app->urlManager->createUrl(['/estadistica/asignatura-libro-inicio-fin']) ?>">
                             <img class="card-img-top dark-img" src="<?= Yii::getAlias('@web') ?>/img/index/estadistic-index.jpg" alt="Dist Photo 3">
                             <div class="card-img-overlay d-flex flex-column justify-content-center">
                                 <h5 class="card-title text-light"><b>Asignatura por Fechas</b></h5>

                             </div>
                         </a>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-6">
                         <a class="card mb-2 card-effect" href="<?= Yii::$app->urlManager->createUrl(['/estadistica/seccion-libro']) ?>">
                             <img class="card-img-top dark-img" src="<?= Yii::getAlias('@web') ?>/img/index/estadistic-index.jpg" alt="Libros">
                             <div class="card-img-overlay d-flex flex-column justify-content-center">
                                 <h5 class="card-title text-light"><b>Seccion por Mes-Año</b></h5>
                             </div>
                         </a>
                     </div>
                     <div class="col-md-6">
                         <a class="card mb-2 card-effect" href="<?= Yii::$app->urlManager->createUrl(['/estadistica/seccion-libro-inicio-fin']) ?>">
                             <img class="card-img-top dark-img" src="<?= Yii::getAlias('@web') ?>/img/index/estadistic-index.jpg" alt="Dist Photo 3">
                             <div class="card-img-overlay d-flex flex-column justify-content-center">
                                 <h5 class="card-title text-light"><b>Seccion por Fechas</b></h5>
                             </div>
                         </a>
                     </div>
                 </div>
             </div>
         </div>

     </div>

 </div>