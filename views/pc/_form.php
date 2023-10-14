<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Pc;
use app\models\Biblioteca;

/** @var yii\web\View $this */
/** @var Pc $model */
/** @var ActiveForm $form */
?>

<div class="pc-form custom-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?= $form->field($model, 'idpc', ['options' => ['class' => 'input-field']])
                    ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'ID PC']) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'estado', ['options' => ['class' => 'input-field']])
                    ->dropDownList([
                        'D' => 'Disponible',
                        'ND' => 'No Disponible',
                        'F' => 'Fuera de servicio',
                        'EM' => 'En Mantenimiento',
                        'R' => 'Retirada',
                    ], ['prompt' => 'Seleccione el estado', 'class' => 'form-control']) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'biblioteca_idbiblioteca', ['options' => ['class' => 'input-field']])
                    ->dropDownList(
                        \yii\helpers\ArrayHelper::map(Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
                        ['prompt' => 'Seleccione el campus', 'class' => 'form-control']
                    ) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Ingresar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
    .custom-form {
        background-color: #f7f7f7;
        padding: 20px;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
    }

    .input-field {
        margin-bottom: 15px;
    }
</style>
