<?php

use app\models\Pc;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\PcSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Computadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingresar PC', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idpc',
            'estado',
          //  'biblioteca_idbiblioteca',
            [
                'attribute' => 'biblioteca_idbiblioteca', // Esto muestra el código del país
                'value' => function ($model) {
                    return $model->bibliotecaIdbiblioteca->Campus; // Accede al nombre del país relacionado
                },
            ],
            //boton de Prestar
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'template' => '{customButton}', // Agrega el botón personalizado
                'buttons' => [
                    'customButton' => function ($url, $model, $key) {
                        return Html::a('Prestar', ['prestamo/prestarpc', 'id' => $model->idpc], [
                            'class' => 'btn btn-primary',
                            'data' => [
                                'confirm' => '¿Estás seguro de que deseas prestar este computador?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Pc $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idpc' => $model->idpc, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
