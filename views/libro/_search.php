<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LibroSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="libro-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'codigo_barras') ?>

    <?php // $form->field($model, 'n_ejemplares') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'autor') ?>

    <?= $form->field($model, 'isbn') ?>

    <?php // echo $form->field($model, 'cute') ?>

    <?php // echo $form->field($model, 'editorial') ?>

    <?php  echo $form->field($model, 'anio_publicacion') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'categoria_id') ?>

    <?php  echo $form->field($model, 'asignatura_id') ?>

    <?php  echo $form->field($model, 'pais_codigopais') ?>

    <?php // echo $form->field($model, 'biblioteca_idbiblioteca') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
