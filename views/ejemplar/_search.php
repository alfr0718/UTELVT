<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\EjemplarSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ejemplar-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'codigo_barras') ?>

    <?= $form->field($model, 'ubicacion') ?>

    <?= $form->field($model, 'Status') ?>

    <?= $form->field($model, 'libro_id') ?>

    <?php // echo $form->field($model, 'biblioteca_idbiblioteca') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
