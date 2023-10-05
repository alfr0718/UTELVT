<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Pc $model */

$this->title = $model->idpc;
$this->params['breadcrumbs'][] = ['label' => 'Pcs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idpc' => $model->idpc, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idpc' => $model->idpc, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], [
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
            'idpc',
            'estado',
            'biblioteca_idbiblioteca',
        ],
    ]) ?>

</div>
