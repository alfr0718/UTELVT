<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PrestamoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="prestamo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fecha_solicitud') ?>

    <?= $form->field($model, 'intervalo_solicitado') ?>

    <?= $form->field($model, 'tipoprestamo_id') ?>

    <?= $form->field($model, 'biblioteca_idbiblioteca') ?>

    <?php // echo $form->field($model, 'pc_idpc') ?>

    <?php // echo $form->field($model, 'pc_biblioteca_idbiblioteca') ?>

    <?php // echo $form->field($model, 'libro_codigo_barras') ?>

    <?php // echo $form->field($model, 'libro_biblioteca_idbiblioteca') ?>

    <?php // echo $form->field($model, 'personaldata_Ci') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
