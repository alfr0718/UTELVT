<?php

use app\models\Prestamo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\PrestamoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Préstamos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestamo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingresar Préstamo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fecha_solicitud',
            'intervalo_solicitado',
           //'tipoprestamo_id',
           [
            'attribute' => 'tipoprestamo_id', // Esto muestra el código del país
            'value' => function ($model) {
                return $model->tipoprestamo->nombre_tipo; // Accede al nombre del país relacionado
            },
        ],
            'pc_idpc',
            //'pc_biblioteca_idbiblioteca',
            'libro_codigo_barras',
           // 'biblioteca_idbiblioteca',
            [
                'attribute' => 'biblioteca_idbiblioteca', // Esto muestra el código del país
                'value' => function ($model) {
                    return $model->bibliotecaIdbiblioteca->Campus; // Accede al nombre del país relacionado
                },
            ],
            //'libro_biblioteca_idbiblioteca',
            'personaldata_Ci',
            
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Prestamo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca, 'personaldata_Ci' => $model->personaldata_Ci]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
