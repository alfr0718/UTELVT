<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Prestamo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="prestamo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha_solicitud')->textInput() 
    ?>

    <?= $form->field($model, 'personaldata_Ci')
        ->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'informacionpersonal_d_CIInfPer')
    ->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'informacionpersonal_CIInfPer')
    ->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intervalo_solicitado')
        ->textInput(['type' => 'time', 'value' => '01:00:00']) ?>

    <?= $form->field($model, 'tipoprestamo_id')
        ->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Tipoprestamo::find()->all(), 'id', 'nombre_tipo',),
            ['prompt' => 'Seleccione servicio solicitado']
        ) ?>


    <?= $form->field($model, 'biblioteca_idbiblioteca')
        ->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
            ['prompt' => 'Seleccione el campus',]
        ) ?>


    <?= $form->field($model, 'pc_idpc')
        ->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Pc::find()->all(), 'idpc', 'nombre'),
            ['prompt' => 'Seleccione el dispositivo']
        ) ?>

    <?php // $form->field($model, 'pc_biblioteca_idbiblioteca')->textInput() 
    ?>

    <?= $form->field($model, 'libro_id')
        ->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Libro::find()->all(), 'id', function ($model) {
                return $model->codigo_barras . ' - ' . $model->titulo;
            }),
            ['prompt' => 'Seleccione el libro']
        ) ?>

    <?php // $form->field($model, 'libro_biblioteca_idbiblioteca')->textInput() 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>