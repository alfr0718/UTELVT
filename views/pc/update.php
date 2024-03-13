<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pc $model */

$this->title = 'Actualizar Computador: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Pcs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idpc, 'url' => ['view', 'idpc' => $model->idpc, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pc-update">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-olive">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>

                <div class="card-body">

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>