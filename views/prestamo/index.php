<?php

use app\models\Prestamo;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\PrestamoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Registros de Préstamo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestamo-index">

    <?php $tipoUsuario = null; // Inicializamos la variable
    if (!Yii::$app->user->isGuest) : ?>
        <?php $tipoUsuario = Yii::$app->user->identity->tipo_usuario;
        if ($tipoUsuario === User::TYPE_ADMIN || $tipoUsuario === User::TYPE_PERSONALB) : ?>

            <!--   <?= Html::a(
                        'Nuevo Préstamo <i class="fas fa-plus-circle"></i>',
                        ['create'],
                        ['class' => 'btn btn-success my-3']
                    ); ?> -->

        <?php endif; ?>
    <?php endif; ?>



    <div class="card">
        <div class="card-header bg-teal">
            <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body">

            <?php Pjax::begin(); ?>


            <?php echo $this->render('_search', ['model' => $searchModel]); ?>

            <div class="table-responsive">


                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-hover'],
                    'rowOptions' => ['class' => 'text-nowrap'],
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
                    ],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'contentOptions' => ['style' => 'vertical-align: middle;'],

                        ],

                        [
                            'attribute' => 'id',
                            'contentOptions' => ['style' => 'vertical-align: middle;'],
                        ],
                        [
                            'attribute' => 'fecha_solicitud',
                            'contentOptions' => ['style' => 'vertical-align: middle;'],

                        ],
                        [
                            'header' => 'Tiempo Solicitado',
                            'headerOptions' => ['style' => 'color: #0d75fd;'],
                            'value' => function ($model) {
                                $fechaSolicitud = new DateTime($model->fecha_solicitud);
                                $fechaEntrega = new DateTime($model->fechaentrega);
                                $interval = $fechaSolicitud->diff($fechaEntrega);

                                return $interval->format('%h h %i m');
                            },
                            'contentOptions' => ['style' => 'vertical-align: middle;'],

                        ],
                        [
                            'attribute' => 'tipoprestamo_id',
                            'value' => function ($model) {
                                return $model->tipoprestamo->nombre_tipo;
                            },
                            'contentOptions' => ['style' => 'vertical-align: middle;'],
                        ],
                        [
                            'header' => 'Equipo Solicitado',
                            'headerOptions' => ['style' => 'color: #0d75fd;'],
                            'attribute' => 'object_id', // Esto muestra el código
                            'value' => function ($model) {
                                if ($model->tipoprestamo_id == 'COMP') {
                                    return $model->pcIdpc ? $model->pcIdpc->nombre : $model->object_id; // Accede al dato relacionado si no es nulo, de lo contrario, muestra Nada
                                } else {
                                    return '';
                                }
                            },
                            'contentOptions' => ['style' => 'vertical-align: middle;'],

                        ],
                        [
                            'header' => 'Libro Solicitado',
                            'headerOptions' => ['style' => 'color: #0d75fd;'],
                            'attribute' => 'object_id', // Esto muestra el código
                            'value' => function ($model) {
                                if ($model->tipoprestamo_id == 'LIB') {
                                    return $model->ejemplar ? $model->ejemplar->codigo_barras. ' - ' . ($model->ejemplar->libro ? $model->ejemplar->libro->titulo : $model->ejemplar->libro_id) : $model->object_id; // Accede al dato relacionado si no es nulo, de lo contrario, muestra Nada
                                } else {
                                    return '';
                                }
                            },
                            'contentOptions' => ['style' => 'vertical-align: middle;'],

                        ],
                        [
                            'attribute' => 'Cédula Solicitante',
                            'headerOptions' => ['style' => 'color: #0d75fd;'],
                            'value' => function ($model) {
                                return $model->personaldata_Ci
                                    ?? $model->informacionpersonal_CIInfPer
                                    ?? $model->informacionpersonal_d_CIInfPer;
                            },
                            'contentOptions' => ['style' => 'vertical-align: middle;'],

                        ],
                        [
                            'attribute' => 'Tipo de Solicitante',
                            'headerOptions' => ['style' => 'color: #0d75fd;'],
                            'value' => function ($model) {
                                if (!empty($model->informacionpersonal_d_CIInfPer)) {
                                    return 'Personal Universitario';
                                } elseif (!empty($model->personaldata_Ci)) {
                                    return 'Externo';
                                } elseif (!empty($model->informacionpersonal_CIInfPer)) {
                                    return 'Estudiante';
                                } else {
                                    return 'N/A'; // Puedes definir un valor por defecto si ninguna condición se cumple.
                                }
                            },
                            'contentOptions' => ['style' => 'vertical-align: middle;'],

                        ],
                        [
                            'attribute' => 'biblioteca_idbiblioteca', // Esto muestra el código del país
                            'value' => function ($model) {
                                return $model->bibliotecaIdbiblioteca->Campus; // Accede al nombre del país relacionado
                            },
                            'contentOptions' => ['style' => 'vertical-align: middle;'],

                        ],
                        [
                            'class' => ActionColumn::className(),
                            'template' => '{view} {delete}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('<i class="far fa-eye"></i>', $url, [
                                        'title' => Yii::t('yii', 'Ver'),
                                        'class' => 'btn btn-info', // Estilo del botón de edición
                                        'data-pjax' => '0',
                                    ]);
                                },
                                'update' => function ($url, $model, $key) {
                                    return Html::a('<i class="far fa-edit"></i>', $url, [
                                        'title' => Yii::t('yii', 'Actualizar'),
                                        'class' => 'btn btn-primary', // Estilo del botón de edición
                                        'data-pjax' => '0',
                                    ]);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<i class="far fa-trash-alt"></i>', $url, [
                                        'title' => Yii::t('yii', 'Eliminar'),
                                        'class' => 'btn btn-danger', // Estilo del botón de eliminación
                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'data-method' => 'post',
                                        'data-pjax' => '0',
                                    ]);
                                },
                            ],
                            'visible' => $tipoUsuario === User::TYPE_ADMIN || $tipoUsuario === User::TYPE_PERSONALB,
                            'contentOptions' => ['style' => 'text-align:center; vertical-align: middle;'],

                        ],

                    ],
                ]); ?>

            </div>

            <?php Pjax::end(); ?>

        </div>
    </div>
</div>