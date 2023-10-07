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

    <?= $form->field($model, 'estado')->dropDownList([
    'Reparación' => 'Reparación',
    'Activa' => 'Activa',
    'Apagada' => 'Apagada',], ['prompt' => 'Seleccione el estado']) ?>

    <?= $form->field($model, 'biblioteca_idbiblioteca')->dropDownList( \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
    ['prompt' => 'Seleccione el campus']) ?>

    <div class="form-group">
        <?= Html::submitButton('Ingresar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
