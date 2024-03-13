<?php

use app\models\Pc;
use app\models\Biblioteca;
use app\models\Prestamo;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\PcSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Equipos';
$this->params['breadcrumbs'][] = $this->title;

$jsFilePath = '@web/js/solicitar.js';
$this->registerJsFile($jsFilePath, ['depends' => [\yii\web\JqueryAsset::class]]);

?>
<div class="pc-index">

    <?php Pjax::begin(); ?>
    <div class="card">
        <div class="card-header bg-teal">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body table-responsive">


            <?php if (!Yii::$app->user->isGuest) : ?>
                <?php $userType = Yii::$app->user->identity->tipo_usuario;
                if ($userType === User::TYPE_ADMIN || $userType === User::TYPE_PERSONALB) : ?>
                    <div class="ml-auto mb-3">
                        <?= Html::a(
                            '<i class="fas fa-plus"></i> Agregar Equipo ',
                            ['create'],
                            ['class' => 'btn btn-app bg-primary float-right']
                        ) ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'filterPosition' => 'header',
                'tableOptions' => ['class' => 'table table-hover'],
                'rowOptions' => ['class' => 'text-nowrap'],
                //'summary' => 'Mostrando <b>{begin} - {end}</b> de <b>{totalCount}</b> equipos.',
                //'summaryOptions' => ['class' => 'text-left text-gray'],
                'pager' => [
                    'options' => ['class' => 'pagination justify-content-center'],
                    'maxButtonCount' => 5,
                    'prevPageLabel' => 'Anterior',
                    'nextPageLabel' => 'Siguiente',
                    'prevPageCssClass' => 'page-item',
                    'nextPageCssClass' => 'page-item',
                    'linkOptions' => ['class' => 'page-link'],
                    'activePageCssClass' => 'page-item active',
                    'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
                    'hideOnSinglePage' => true,
                ],

                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn', //contador
                        'contentOptions' => ['style' => 'vertical-align: middle;'],
                        'visible' => $userType === User::TYPE_ADMIN
                            || $userType === User::TYPE_PERSONALB,
                    ],
                    //'idpc',
                    // 'nombre',
                    [
                        'attribute' => 'nombre',
                        'value' => function ($model) {
                            return $model->nombre;
                        },
                        'contentOptions' => ['style' => 'vertical-align: middle;'],

                    ],
                    [
                        'attribute' => 'type',
                        'visible' => $userType === User::TYPE_ADMIN
                            || $userType === User::TYPE_PERSONALB,
                        'value' => function ($model) {
                            $tipo = $model->typeArray;
                            return isset($tipo[$model->type]) ? $tipo[$model->type] : $model->type;
                        },
                        'filter' => Html::activeDropDownList(
                            $searchModel,
                            'type',
                            $searchModel->typeArray,
                            ['class' => 'form-control', 'prompt' => 'Todos']
                        ),
                        'contentOptions' => ['style' => 'vertical-align: middle;'],

                    ],
                    [
                        'attribute' => 'Status',
                        'visible' => $userType === User::TYPE_ADMIN
                            || $userType === User::TYPE_PERSONALB,
                        'value' => function ($model) {
                            $estados = $model->statusArray;
                            return isset($estados[$model->Status]) ? $estados[$model->Status] : $model->Status;
                        },
                        'filter' => Html::activeDropDownList(
                            $searchModel,
                            'Status',
                            $searchModel->statusArray,
                            ['class' => 'form-control', 'prompt' => 'Todos']
                        ),
                        'contentOptions' => ['style' => 'vertical-align: middle;'],

                    ],

                    [
                        'attribute' => 'biblioteca_idbiblioteca',
                        'value' => function ($model) {
                            return $model->bibliotecaIdbiblioteca->Campus; // Accede al nombre de la biblioteca
                        },
                        'filter' => Html::activeDropDownList(
                            $searchModel,
                            'biblioteca_idbiblioteca',
                            \yii\helpers\ArrayHelper::map(Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
                            ['class' => 'form-control', 'prompt' => 'Todos']
                        ),
                        'contentOptions' => ['style' => 'vertical-align: middle;'],

                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{PrestarEquipo}',
                        'contentOptions' => ['style' => 'text-align:center; vertical-align: middle;'],
                        'buttons' => [
                            'PrestarEquipo' => function ($url, $model, $key) {
                                $icon = ($model->Status == 1) ? '<i class="far fa-check-circle"></i>' : (($model->Status == 0) ? '<i class="fas fa-clock"></i>' : '<i class="fas fa-exclamation"></i>');

                                $buttonClass = ($model->Status == 1) ? 'bg-teal' : (($model->Status == 0) ? 'btn-outline-warning' : 'btn-outline-danger');

                                $disabled = ($model->Status == 1) ? false : true;
                                $buttonId = 'open-modal-button-' . $model->idpc; // Id único para el botón
                                return Html::button($icon, [
                                    'title' => Yii::t('app', 'Solicitar'),
                                    'class' => 'btn ' . $buttonClass,
                                    'id' => $buttonId, // Id único para cada botón
                                    'disabled' => $disabled, // Deshabilitar el botón si el modelo está en estado diferente de 1
                                    'onclick' => 'showPrestamoModal(' . $model->idpc . ', "' . Url::to(['/solicitud/solicitar-equipo']) . '")', // Llamar a la función JavaScript con el ID del modelo y la URL
                                ]);
                            },
                        ],

                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'contentOptions' => ['style' => 'text-align:center; vertical-align: middle;'],
                        'visible' => $userType === User::TYPE_ADMIN,
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('<i class="fas fa-edit"></i>', $url, [
                                    'title' => Yii::t('app', 'Actualizar'),
                                    'class' => 'btn btn-primary', // Clase CSS para el botón de actualización
                                    'data-pjax' => '0',

                                ]);
                            },
                            'view' => function ($url, $model, $key) {
                                return Html::a('<i class="fas fa-eye"></i>', $url, [
                                    'title' => Yii::t('app', 'Ver'),
                                    'class' => 'btn btn-info', // Clase CSS para el botón de vista
                                    'data-pjax' => '0',

                                ]);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<i class="fas fa-trash"></i>', $url, [
                                    'title' => Yii::t('app', 'Eliminar'),
                                    'class' => 'btn btn-danger', // Clase CSS para el botón de eliminación
                                    'data' => [
                                        'confirm' => Yii::t('app', '¿Estás seguro de que quieres eliminar este elemento?'),
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                    ],

                ],
            ]); ?>
        </div>
    </div>


    <div class="modal fade" id="prestamo-modal">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header bg-teal">
                    <h4 class="modal-title">Solicitar Equipo <i class="fas fa-laptop"></i></h4>
                    <!--   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                </div>
                <div class="modal-body">


                </div>
                <div class="modal-footer justify-content-center">
                    <button id="equipoSubmit" type="button" class="btn btn-primary">Solicitar <i class="fas fa-check-circle"></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fas fa-ban"></i></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <?php Pjax::end(); ?>
</div>