<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Libro $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="libro-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'codigo_barras')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'n_ejemplares')->textInput() ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'autor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cute')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'editorial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anio_publicacion')->textInput() ?>

    <?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categoria_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'asignatura_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pais_codigopais')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biblioteca_idbiblioteca')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
