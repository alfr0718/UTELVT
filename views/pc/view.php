<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Pc $model */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Pcs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-view">
    <div class="card">
        <div class="card-header bg-olive">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body">

            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-hover'], 
                'attributes' => [
                    //'idpc',
                    'nombre',
                    [
                        'attribute' => 'Status',
                        'value' => function ($model) {
                            $estados = $model->statusArray;
                            return isset($estados[$model->Status]) ? $estados[$model->Status] : $model->Status;
                        },
                    ],                  
                    [
                        'attribute' => 'biblioteca_idbiblioteca',
                        'value' => function ($model) {
                            return $model->bibliotecaIdbiblioteca->Campus;
                        },
                    ],
                ],
            ]) ?>

        </div>
        <div class="card-footer">
            <div class="group-form text-right">
                <?= Html::a('<i class="far fa-edit"></i> Actualizar', ['update', 'idpc' => $model->idpc, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], ['class' => 'btn btn-app btn-primary']) ?>
                <?= Html::a('<i class="fas fa-trash"></i> Eliminar', ['delete', 'idpc' => $model->idpc, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], [
                    'class' => 'btn btn-app btn-danger',
                    'data' => [
                        'confirm' => '¿Estás seguro de eliminar este elemento?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>

    </div>

</div>