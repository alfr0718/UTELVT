<?php

use app\models\Libro;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\LibroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Libros';
$this->params['breadcrumbs'][] = $this->title;

$jsFilePath = '@web/js/solicitar.js';
$this->registerJsFile($jsFilePath, ['depends' => [\yii\web\JqueryAsset::class]]);

?>
<div class="libro-index">

    <div class="card">
        <div class="card-header bg-teal">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body">


            <?php if (!Yii::$app->user->isGuest) : ?>

                <?php
                $userType = Yii::$app->user->identity->tipo_usuario;
                if ($userType === User::TYPE_ADMIN || $userType === User::TYPE_PERSONALB) : ?>

                    <div class="ml-auto mb-3">
                        <?= Html::a(
                            '<i class="fas fa-plus"></i> Agregar Libro ',
                            ['create'],
                            ['class' => 'btn btn-app bg-primary float-right']
                        ) ?>
                    </div>

                <?php endif; ?>
            <?php endif; ?>

            <?php Pjax::begin(); ?>

            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            <div class="table-responsive">

                <?php if (!Yii::$app->user->isGuest) : ?>
                    <?php if ($userType === User::TYPE_ADMIN || $userType === User::TYPE_PERSONALB) : ?>

                        <?= $this->render(
                            'indexOptions/userGrid',
                            ['dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'userType' => $userType]
                        ); ?>

                    <?php else : ?>
                        <?= $this->render(
                            'indexOptions/userGrid',
                            ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]
                        ); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <?php Pjax::end(); ?>
        </div>

    </div>
</div>

<div class="modal fade" id="libro-modal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-teal justify-content-center">
                <h4 class="modal-title">Solicitar Libro &nbsp;&nbsp;<i class="fas fa-book fa-lg"></i></h4>
            </div>
            <div class="modal-body">


            </div>
            <div class="modal-footer justify-content-center">
                <button id="libroSubmit" style="display: none;" type="button" class="btn btn-primary">Solicitar &nbsp;&nbsp;<i class="fas fa-check-circle"></i></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar &nbsp;&nbsp;<i class="fas fa-times"></i></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>