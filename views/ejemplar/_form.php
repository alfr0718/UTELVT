<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ejemplar $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ejemplar-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'codigo_barras')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ubicacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status', ['options' => ['class' => 'input-field']])
        ->dropDownList(
            $model->statusArray,
            ['prompt' => 'Seleccione Estado', 'class' => 'form-control']
        ) ?>




    <?= $form->field($model, 'libro_id')->hiddenInput() ?>

    <?= $form->field($model, 'biblioteca_idbiblioteca')->hiddenInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>