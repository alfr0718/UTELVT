<?php

use app\models\EjemplarSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Libro $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$coverUrl = Yii::getAlias('@web');

if (!isset($model->cover) || $model->cover == '') {
    $coverUrl .= '/cover/default-cover.jpg';
} else {
    $coverPath = Yii::getAlias('@webroot') . '/cover/' . $model->cover;
    if (file_exists($coverPath)) {
        $coverUrl .= '/cover/' . $model->cover;
    } else {
        // Si la imagen no existe, utilizamos la imagen por defecto
        $coverUrl .= '/cover/default-cover.jpg';
    }

}

?>
<div class="libro-view">
    <div class="card">
        <div class="card-header bg-olive">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-4 col-6 text-center">
                    <img src="<?= $coverUrl ?>" class="img-fluid img-thumbnail mb-3" style="max-width: 100%; max-height: 300px;" alt="Imagen del libro">

                    <div class="group-form mb-3">
                        <?= Html::a('<i class="fas fa-plus"></i> Nuevo Ejemplar', ['ejemplar/agregar-ejemplar', 'libro_id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], ['class' => 'btn btn-app btn-success']) ?>
                        <?= Html::a('<i class="far fa-edit"></i> Actualizar Libro', ['update', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], ['class' => 'btn btn-app btn-primary']) ?>
                        <?= Html::a('<i class="fas fa-trash"></i> Eliminar Libro', ['delete', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], [
                            'class' => 'btn btn-app btn-danger',
                            'data' => [
                                'confirm' => '¿Estás seguro de eliminar este libro?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                    <?php if ($model->ejemplars) :

                        $searchModel = new EjemplarSearch();
                        $searchModel->libro_id = $model->id;
                        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                    ?>
                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                //'filterModel' => $searchModel,
                                'tableOptions' => [
                                    'class' => 'table table-hover',
                                ],
                                'rowOptions' => ['class' => 'text-nowrap'],
                                'columns' => [
                                    'id',
                                    'codigo_barras',
                                    'ubicacion',
                                    'Status',
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{view} {update}',
                                        'contentOptions' => ['style' => 'text-align:center; vertical-align: middle;'],
                                        'buttons' => [
                                            'update' => function ($url, $model, $key) {
                                                return Html::a('<i class="fas fa-edit"></i>', $url, [
                                                    'title' => Yii::t('app', 'Actualizar Ejemplar'),
                                                    'class' => 'btn btn-primary', // Clase CSS para el botón de actualización
                                                    'data-pjax' => '0',

                                                ]);
                                            },
                                            'view' => function ($url, $model, $key) {
                                                return Html::a('<i class="fas fa-eye"></i>', $url, [
                                                    'title' => Yii::t('app', 'Ver Ejemplar'),
                                                    'class' => 'btn btn-info', // Clase CSS para el botón de vista
                                                    'data-pjax' => '0',

                                                ]);
                                            },
                                            'delete' => function ($url, $model, $key) {
                                                return Html::a('<i class="fas fa-trash"></i>', $url, [
                                                    'title' => Yii::t('app', 'Eliminar Ejemplar'),
                                                    'class' => 'btn btn-danger', // Clase CSS para el botón de eliminación
                                                    'data' => [
                                                        'confirm' => Yii::t('app', '¿Estás seguro de eliminar este ejemplar?'),
                                                        'method' => 'post',
                                                    ],
                                                ]);
                                            },
                                        ],
                                    ],
                                ],

                            ]); ?>
                        </div>
                    <?php endif; ?>

                </div>
                <div class="col-md-6 col-6">
                    <div class="table-responsive">

                        <?= DetailView::widget([
                            'model' => $model,
                            'options' => ['class' => 'table table-hover'],
                            'attributes' => [
                                'id',
                                'titulo',
                                'autor',
                                'isbn',
                                'cute',
                                'editorial',
                                'anio_publicacion',
                                //'categoria_id',
                                //'asignatura_id',
                                //'pais_codigopais',
                                //'biblioteca_idbiblioteca',
                                //'categoria_id',
                                [
                                    'attribute' => 'categoria_id',
                                    'value' => function ($model) {
                                        return $model->categoria->NombreCateg;
                                    },
                                ],
                                [
                                    'attribute' => 'asignatura_IdAsig',
                                    'value' => function ($model) {
                                        return $model->asignatura->NombAsig;
                                    },
                                ],
                                [
                                    'attribute' => 'pais_cod_pais',
                                    'value' => function ($model) {
                                        return $model->paisCodigopais->nomb_pais;
                                    },
                                ],
                                [
                                    'attribute' => 'seccion_id',
                                    'value' => function ($model) {
                                        return $model->seccion->NombreSeccion;
                                    },
                                ],
                                [
                                    'attribute' => 'biblioteca_idbiblioteca',
                                    'value' => function ($model) {
                                        return $model->bibliotecaIdbiblioteca->Campus;
                                    },
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>