<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;


$this->title = 'SignUp';
?>

<h1><?= Html::encode($this->title) ?></h1>


<div class="registro-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($PersonalD, 'Ci')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'Apellidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'Nombres')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'FechaNacimiento')->widget(DatePicker::classname(), [
    'language' => 'es',
    'dateFormat' => 'yyyy-MM-dd',
    'clientOptions' => [
        'changeYear' => true,
        'changeMonth' => true,
    ],
    'options' => [
        'class' => 'form-control',
        'value' => '2000-01-01', // Aquí inicializamos la fecha en el año 2000
    ],]) ?>

    <?= $form->field($PersonalD, 'Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'Genero')->dropDownList([ 'M' => 'Male', 'F' => 'Female', ], ['prompt' => 'Seleccione su género']) ?>

    <?= $form->field($PersonalD, 'Institucion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'Nivel')->dropDownList([ 'Bachiller' => 'Bachiller', 'Universidad' => 'Universidad', 'Posgrado'=> 'Posgrado', ], ['prompt' => 'Seleccione su Nivel Académico']) ?>

    <div class="form-group">
        <?= Html::submitButton('Iniciar Registro', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>