<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Prestamo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="prestamo-form">

    <?php $form = ActiveForm::begin([
        'id' => 'registroForm', // Asignando el ID al formulario
    ]); ?>


    <!-- 
   <?= $form->field($model, 'fecha_solicitud')->textInput() ?>


    <?= $form->field($model, 'informacionpersonal_d_CIInfPer')
        ->textInput(['maxlength' => true, 'readonly' => true]) ?>
    <?= $form->field($model, 'informacionpersonal_CIInfPer')
        ->textInput(['maxlength' => true, 'readonly' => true]) ?>
    <?= $form->field($model, 'personaldata_Ci')
        ->textInput(['maxlength' => true, 'readonly' => true]) ?> -->
        

    <?= $form->field($model, 'cedula_solicitante')
        ->textInput(['maxlength' => true, 'readonly' => $isEnabled]) ?>

    <?= $form->field($model, 'intervalo_solicitado')
        ->label('Horas de Estudio')
        ->textInput(['type' => 'time', 'value' => '01:00:00', 'max' => '08:00:00']) ?>

    <?= $form->field($model, 'tipoprestamo_id')
        ->label('¿Qué buscas?')
        ->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Tipoprestamo::find()->all(), 'id', 'nombre_tipo',),
            ['prompt' => 'Seleccione servicio solicitado', 'disabled' => true]
        ) ?>

    <?= $form->field($model, 'biblioteca_idbiblioteca')
        ->label('Nuestro Espacio')
        ->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
            ['prompt' => 'Seleccione el campus']
        ) ?>

    <!-- <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success']) ?>
    </div> -->

    <?php ActiveForm::end(); ?>

</div>