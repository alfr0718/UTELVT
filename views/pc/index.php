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

$this->title = 'Pcs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Pc', ['create'], ['class' => 'btn btn-success']) ?>
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
            'biblioteca_idbiblioteca',
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
