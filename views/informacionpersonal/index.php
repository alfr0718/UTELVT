<?php

use app\models\Informacionpersonal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\InformacionpersonalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Registro de Estudiantes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informacionpersonal-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingresar Estudiante', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'CIInfPer',
            'ApellInfPer',
            'ApellMatInfPer',
            'NombInfPer',
            //'codigo_dactilar',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Informacionpersonal $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'CIInfPer' => $model->CIInfPer]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
