<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use app\models\Pc;
use app\models\Biblioteca;

/** @var yii\web\View $this */
/** @var Pc $model */
/** @var ActiveForm $form */
?>

<div class="pc-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="form-group">

                <?= $form->field($model, 'nombre', ['options' => ['class' => 'input-field']])
                    ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Nombre de dispositivo']) ?>
            </div>
            <div class="form-group">

                <?= $form->field($model, 'type', ['options' => ['class' => 'input-field']])
                    ->dropDownList(
                        $model->typeArray,
                        ['prompt' => 'Seleccione Tipo', 'class' => 'form-control']
                    ) ?>

            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group">

                <?= $form->field($model, 'Status', ['options' => ['class' => 'input-field']])
                    ->dropDownList(
                        $model->statusArray,
                        ['prompt' => 'Seleccione Estado', 'class' => 'form-control']
                    ) ?>
            </div>

            <div class="form-group">

                <?= $form->field($model, 'biblioteca_idbiblioteca', ['options' => ['class' => 'input-field']])
                    ->dropDownList(
                        \yii\helpers\ArrayHelper::map(Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
                        ['prompt' => 'Seleccione Campus', 'class' => 'form-control']
                    ) ?>
            </div>

        </div>
        <div class="form-group">
            <?= Html::submitButton('Ingresar', ['class' => 'btn bg-gradient-lightblue']) ?>
        </div>
    </div>




    <?php ActiveForm::end(); ?>

</div>