<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Prestamo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="prestamo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha_solicitud')->textInput() ?>

    <?= $form->field($model, 'intervalo_solicitado')->textInput() ?>

    <?= $form->field($model, 'tipoprestamo_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biblioteca_idbiblioteca')->textInput() ?>

    <?= $form->field($model, 'pc_idpc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pc_biblioteca_idbiblioteca')->textInput() ?>

    <?= $form->field($model, 'libro_codigo_barras')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'libro_biblioteca_idbiblioteca')->textInput() ?>

    <?= $form->field($model, 'personaldata_Ci')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
