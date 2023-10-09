<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Personaldata $model */

$this->title = $model->Nombres.' '.$model->Apellidos;
$this->params['breadcrumbs'][] = ['label' => 'Personaldatas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="personaldata-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'Ci' => $model->Ci], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'Ci' => $model->Ci], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Ci',
            'Apellidos',
            'Nombres',
            'FechaNacimiento',
            'Email:email',
            'Genero',
            'Institucion',
            'Nivel',
        ],
    ]) ?>

</div>
