<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Libro $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="libro-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'codigo_barras')->textInput(['maxlength' => true]) ?>

    <div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'n_ejemplares')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'autor')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'cute')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'editorial')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'anio_publicacion')->input('number', ['max' => date('Y'), 'step' => 1, 'placeholder' => 'Ingrese el año']) ?>
        <?= $form->field($model, 'estado')->dropDownList([
        'B' => 'Bueno',
        'R' => 'Regular',
        'M' => 'Malo'],
         ['prompt' => 'Seleccione el estado']) ?>
        <?= $form->field($model, 'categoria_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Categoria::find()->all(), 'id', 'Categoría'), ['prompt' => 'Ingrese la categoría']) ?>
        <?= $form->field($model, 'asignatura_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Asignatura::find()->all(), 'id', 'Nombre'), ['prompt' => 'Ingrese la asignatura', 'options' => ['' => ['disabled' => true]]]) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'pais_codigopais')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Pais::find()->orderBy(['Nombrepais' => SORT_ASC])->all(), 'codigopais', 'Nombrepais'), ['prompt' => 'Ingrese el país', 'options' => ['' => ['disabled' => true]]]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'biblioteca_idbiblioteca')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'), ['prompt' => 'Ingrese el campus']) ?>
    </div>
</div>


    <div class="form-group">
        <?= Html::submitButton('Ingresar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
