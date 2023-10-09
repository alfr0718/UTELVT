<?php

use app\models\Libro;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\LibroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Listado de Libros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libro-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p> 
        <?= Html::a('Ingresar Libro', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'codigo_barras',
            'n_ejemplares',
            'titulo',
            'autor',
            'isbn',
            //'cute',
            //'editorial',
            'anio_publicacion',
            //'estado',
            //'categoria_id',
            [
                'attribute' => 'categoria_id',
                'value' => function ($model) {
                    return $model->categoria->Categoría;
                },
            ],
           // 'asignatura_id',
            [
                'attribute' => 'asignatura_id', // Esto muestra el código de la asignatura
                'value' => function ($model) {
                    return $model->asignatura->Nombre; // Accede al nombre de la asignatura relacionada
                },
            ],
           // 'pais_codigopais',
            [
                'attribute' => 'pais_codigopais', // Esto muestra el código del país
                'value' => function ($model) {
                    return $model->paisCodigopais->Nombrepais; // Accede al nombre del país relacionado
                },
            ],
           // 'biblioteca_idbiblioteca',
            [
                'attribute' => 'biblioteca_idbiblioteca', // Esto muestra el código de la biblioteca
                'value' => function ($model) {
                    return $model->bibliotecaIdbiblioteca->Campus; // Accede al nombre de la biblioteca
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'template' => '{customButton}', // Agrega el botón personalizado
                'buttons' => [
                    'customButton' => function ($url, $model, $key) {
                        return Html::a('Prestar', ['prestamo/prestarlibro', 'id' => $model->codigo_barras], [
                            'class' => 'btn btn-primary',
                            'data' => [
                                //'confirm' => '¿Estás seguro de que deseas prestar este libro?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
            
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Libro $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'codigo_barras' => $model->codigo_barras, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
