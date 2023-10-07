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

    <?php // $form->field($model, 'intervalo_solicitado')->textInput() ?>

    <?= $form->field($model, 'tipoprestamo_id')->dropDownList( \yii\helpers\ArrayHelper::map(\app\models\Tipoprestamo::find()->all(), 'id', 'nombre_tipo'),
    ['prompt' => 'Seleccione su tipo de préstamo']) ?>

    <?= $form->field($model, 'biblioteca_idbiblioteca')->dropDownList( \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
    ['prompt' => 'Seleccione el campus']) ?>

    <?= $form->field($model, 'pc_idpc')->dropDownList( \yii\helpers\ArrayHelper::map(\app\models\Pc::find()->all(), 'idpc', 'idpc'),
    ['prompt' => 'Seleccione su computador']) ?>

    <?php // $form->field($model, 'pc_biblioteca_idbiblioteca')->textInput() ?>

    <?= $form->field($model, 'libro_codigo_barras')->dropDownList(
    \yii\helpers\ArrayHelper::map(\app\models\Libro::find()->all(), 'codigo_barras', function ($model) {
        return $model->codigo_barras . ' - ' . $model->titulo;
    }),
    ['prompt' => 'Seleccione su libro']
) ?>

    <?php // $form->field($model, 'libro_biblioteca_idbiblioteca')->textInput() ?>

    <?= $form->field($model, 'personaldata_Ci')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
