<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Prestamo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="prestamo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'fecha_solicitud')->textInput() ?>

    <?php $username = Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->username; ?>

    <?= $form->field($model, 'personaldata_Ci')->textInput(['maxlength' => true, 'value' => $username, 'readonly' => true]) ?>

    <?= $form->field($model, 'intervalo_solicitado')->textInput(['type' => 'time', 'value' => '01:00:00']) ?>

    <?php // $form->field($model, 'tipoprestamo_id')->dropDownList( \yii\helpers\ArrayHelper::map(\app\models\Tipoprestamo::find()->all(), 'id', 'nombre_tipo',),
   // ['prompt' => 'Seleccione servicio solicitado']) ?>

    <?= $form->field($model, 'tipoprestamo_id')->dropDownList(
    [   'COMP' => 'Computador',
        'LIB' => 'Libro',
        'ESP' => 'Espacio Físico',
    ],
    ['prompt' => 'Seleccione servicio solicitado', 'disabled' => true]) ?>

    <?= $form->field($model, 'biblioteca_idbiblioteca')->dropDownList( \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
    ['prompt' => 'Seleccione el campus',]) ?>


    <?= $form->field($model, 'pc_idpc')->textInput() ?>
    <?php // $form->field($model, 'pc_biblioteca_idbiblioteca')->textInput() ?>

    <?php // $form->field($model, 'libro_codigo_barras')->textInput(['id' => 'libro-codigo-barras']) ?>

    <?=  $form->field($model, 'libro_codigo_barras')->dropDownList(
    \yii\helpers\ArrayHelper::map(\app\models\Libro::find()->all(), 'codigo_barras', function ($model) {
        return $model->codigo_barras . ' - ' . $model->titulo;
    }),
    ['prompt' => 'Seleccione el libro']) ?>

    <?php // $form->field($model, 'libro_biblioteca_idbiblioteca')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
