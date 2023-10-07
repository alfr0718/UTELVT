<?php

use app\models\Personaldata;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\PersonaldataSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Datos Personales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personaldata-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingresar Persona Natural', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Ci',
            'Apellidos',
            'Nombres',
            'FechaNacimiento',
            'Email:email',
            'Genero',
            'Institucion',
            'Nivel',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Personaldata $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'Ci' => $model->Ci]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
