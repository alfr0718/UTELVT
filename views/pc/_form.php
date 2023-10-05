<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Pc $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idpc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biblioteca_idbiblioteca')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
