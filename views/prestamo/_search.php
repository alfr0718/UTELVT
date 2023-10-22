<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PrestamoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="prestamo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>


    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'fecha_solicitud')->input('date') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'tipoprestamo_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(\app\models\Tipoprestamo::find()->all(), 'id', 'nombre_tipo'),
                ['prompt' => 'Seleccione un tipo de préstamo']
            ) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'biblioteca_idbiblioteca')->dropDownList(
                \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
                ['prompt' => 'Seleccione una biblioteca']
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'pc_idpc') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'cedula_solicitante')
                ->label('Cédula Solicitante') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'libro_id') ?>
        </div>
    </div>

    <?php // $form->field($model, 'fechaentrega') 
    ?>

    <?php // $form->field($model, 'intervalo_solicitado') 
    ?>
    <?php // echo $form->field($model, 'pc_biblioteca_idbiblioteca') 
    ?>
    <?php // echo $form->field($model, 'libro_biblioteca_idbiblioteca') 
    ?>


    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Restablecer', ['index', 'reset-button' => 1], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>