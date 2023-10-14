<?php

use app\models\Biblioteca;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\BibliotecaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Lista de Bibliotecas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblioteca-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Agregar Biblioteca', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idbiblioteca',
            'Campus',
            'Apertura',
            'Cierre',
            'Email:email',
            //'Telefono',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Biblioteca $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idbiblioteca' => $model->idbiblioteca]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
