<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\InformacionpersonalD $model */

$this->title = /*$model->CIInfPer*/  $model->ApellInfPer . ' ' .  $model->NombInfPer;
$this->params['breadcrumbs'][] = ['label' => 'Informacionpersonal Ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="informacionpersonal-d-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'CIInfPer' => $model->CIInfPer], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'CIInfPer' => $model->CIInfPer], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estas seguro de eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'CIInfPer',
            'ApellInfPer',
            'ApellMatInfPer',
            'NombInfPer',
        ],
    ]) ?>

</div>
