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

    <?= $form->field($model, 'FechaNacimiento')->textInput() ?>

    <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Genero')->dropDownList([ 'M' => 'Masculino', 'F' => 'Femenino', ], ['prompt' => 'Seleccione su género']) ?>

    <?= $form->field($model, 'Institucion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Nivel')->dropDownList([ 'Bachiller' => 'Bachiller', 'Universidad' => 'Universidad', 'Posgrado'=> 'Posgrado', ], ['prompt' => 'Seleccione su Nivel Académico']) ?>

    <?= $form->field($model, 'Facultad')->dropDownList([
    'FACI' => 'Facultad de Ingenierías',
    'FACAE' => 'Facultad de Ciencias Sociales y de Servicios',
    'FACSOS' => 'Facultad de Ciencias Administrativas y Económicas',
    'FACAP' => 'Facultad de Ciencias Agropecuarias',
    'FACPED' => 'Facultad de la Pedagogía',
]) ?>


<?= $form->field($model, 'Ciclo')->dropDownList([
    '1' => '1',
    '2' => '2',
    '3' => '3',
    '4' => '4',
    '5' => '5',
    '6' => '6',
    '7' => '7',
    '8' => '8',
    '9' => '9',
    '10' => '10',
    '11' => '11',
    '12' => '12',
]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
