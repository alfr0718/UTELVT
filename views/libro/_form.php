<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Libro $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="libro-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'codigo_barras')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'n_ejemplares')->input('number', ['max' => 100, 'step' => 1, 'placeholder' => 'Ingrese la cantidad de ejemplares', 'min' => 0])?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'autor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cute')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'editorial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anio_publicacion')->input('number', ['max' => date('Y'), 'step' => 1, 'placeholder' => 'Ingrese el año'])?>

    <?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categoria_id')->dropDownList( \yii\helpers\ArrayHelper::map(\app\models\Categoria::find()->all(), 'id', 'Categoría'),
    ['prompt' => 'Ingrese la categoría']) ?>

    <?= $form->field($model, 'asignatura_id')->dropDownList( \yii\helpers\ArrayHelper::map(\app\models\Asignatura::find()->all(), 'id', 'Nombre'),
    ['prompt' => 'Ingrese la asignatura']) ?>

    <?= $form->field($model, 'pais_codigopais')->dropDownList( \yii\helpers\ArrayHelper::map(\app\models\Pais::find()->all(), 'codigopais', 'Nombrepais'),
    ['prompt' => 'Ingrese el país']) ?>

    <?= $form->field($model, 'biblioteca_idbiblioteca')->dropDownList( \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
    ['prompt' => 'Ingrese el campus']) ?>

    <div class="form-group">
        <?= Html::submitButton('Ingresar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
