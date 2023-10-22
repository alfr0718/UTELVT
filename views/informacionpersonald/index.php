<?php

use app\models\InformacionpersonalD;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\InformacionpersonaldSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Registro de Docentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informacionpersonal-d-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingresar Docente', ['create'], ['class' => 'btn btn-success']) ?>
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
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, InformacionpersonalD $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'CIInfPer' => $model->CIInfPer]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
