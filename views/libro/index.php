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

$this->title = 'Libros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libro-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p> 
        <?= Html::a('Agregar Libro', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'codigo_barras',
           // 'n_ejemplares',
            'titulo',
            'autor',
            'isbn',
            //'cute',
            //'editorial',
            'anio_publicacion',
            //'estado',
            'categoria_id',
            'asignatura_id',
            'pais_codigopais',
            //'biblioteca_idbiblioteca',
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
