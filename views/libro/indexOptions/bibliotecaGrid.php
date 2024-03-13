<?php

use app\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="card">
    <div class="card-body table-responsive">

        <div class="ml-auto mb-3">
            <?= Html::a(
                '<i class="fas fa-plus"></i> Agregar Libro ',
                ['create'],
                ['class' => 'btn btn-app bg-primary float-right']
            ) ?>
        </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table table-hover',
            ],
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
                'hideOnSinglePage' => true,
            ],
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                    'visible' => $userType === User::TYPE_ADMIN
                        || $userType === User::TYPE_PERSONALB,
                ],

                //'id',
                [
                    'attribute' => 'titulo',
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                ],
                [
                    'attribute' => 'autor',
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                ],
                [
                    'attribute' => 'isbn',
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                ],
               /* [
                    'attribute' => 'editorial',
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                ],*/
                [
                    'attribute' => 'anio_publicacion',
                    'contentOptions' => ['style' => 'text-align:center; vertical-align: middle;'],
                ],
                [
                    'attribute' => 'seccion_id',
                    'value' => function ($model) {
                        return isset($model->seccion) ? $model->seccion->CodeSeccion : 'N/A';
                    },
                    'contentOptions' => ['style' => 'vertical-align: middle;'],

                ],
                [
                    'attribute' => 'categoria_id',
                    'value' => function ($model) {
                        return isset($model->categoria) ? $model->categoria->NombreCateg : 'N/A';
                    },
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                ],
                
                [
                    'attribute' => 'pais_cod_pais', // Esto muestra el código del país
                    'value' => function ($model) {
                        return isset($model->pais_cod_pais) ? $model->pais_cod_pais : 'N/A'; // Accede al nombre del país relacionado
                    },
                    'contentOptions' => ['style' => 'vertical-align: middle;'],

                ],
                [
                    'attribute' => 'biblioteca_idbiblioteca', // Esto muestra el código del país
                    'value' => function ($model) {
                        return isset($model->bibliotecaIdbiblioteca) ? $model->bibliotecaIdbiblioteca->Campus : 'N/A'; // Accede al nombre del país relacionado
                    },
                    'contentOptions' => ['style' => 'vertical-align: middle;'],

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