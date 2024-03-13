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

$this->title = 'Lista de Estudiantes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informacionpersonal-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?php //     <?= Html::a('Agregar Estudiante <i class="fas fa-user-plus"></i>', ['create'], ['class' => 'btn btn-success my-3']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <div class='table-responsive'>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'pager' => [
                'options' => ['class' => 'pagination justify-content-center'], 
                'maxButtonCount' => 5,
                'prevPageLabel' => 'Anterior',
                'nextPageLabel' => 'Siguiente',
                'prevPageCssClass' => 'page-item',
                'nextPageCssClass' => 'page-item',
                'linkOptions' => ['class' => 'page-link'], 
                'activePageCssClass' => 'page-item active',
                'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
            ],
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'CIInfPer',
                'ApellInfPer',
                'ApellMatInfPer',
                'NombInfPer',
                //'codigo_dactilar',
             //   [
               //     'class' => ActionColumn::className(),
                //    'urlCreator' => function ($action, Informacionpersonal $model, $key, $index, $column) {
                //        return Url::toRoute([$action, 'CIInfPer' => $model->CIInfPer]);
               //     }
               // ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>

    </div>
</div>