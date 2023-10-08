<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Personaldata $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="personaldata-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Ci')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Apellidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Nombres')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FechaNacimiento')->input('date') ?>

    <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Genero')->dropDownList([ 'M' => 'Male', 'F' => 'Female', ], ['prompt' => 'Seleccione su Género']) ?>

    <?= $form->field($model, 'Institucion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Nivel')->dropDownList([ 'Bachiller' => 'Bachiller', 'Universidad' => 'Universidad', 'Posgrado'=> 'Posgrado', ], ['prompt' => 'Seleccione su Nivel Académico']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
