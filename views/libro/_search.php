<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LibroSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="libro-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php // $form->field($model, 'codigo_barras') ?>

    <?php // $form->field($model, 'n_ejemplares') ?>
    
    <?php // $form->field($model, 'isbn') ?>
    
    <?php // $form->field($model, 'titulo') ?>

    <?php // $form->field($model, 'autor') ?>

    <?php // echo $form->field($model, 'cute') ?>

    <?php // echo $form->field($model, 'editorial') ?>

    <?php // echo $form->field($model, 'anio_publicacion') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'categoria_id') ?>

    <?php //echo $form->field($model, 'asignatura_id')->dropDownList( \yii\helpers\ArrayHelper::map(\app\models\Asignatura::find()->all(), 'id', 'Nombre'),
    //['prompt' => 'Ingrese la asignatura']) ?>
    

    <?php // echo $form->field($model, 'pais_codigopais')->dropDownList( \yii\helpers\ArrayHelper::map(\app\models\Pais::find()->all(), 'codigopais', 'Nombrepais'),
    //['prompt' => 'Ingrese el país']) ?>

    <?php // echo $form->field($model, 'biblioteca_idbiblioteca') ?>


    <div class="container">
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'titulo')->textInput(['style' => 'width: 100%;'])->label('Título') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'autor')->textInput(['style' => 'width: 100%;'])->label('Autor') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'categoria_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(
                    \app\models\Categoria::find()->orderBy(['Categoría' => SORT_ASC])->all(),
                    'id',
                    'Categoría'
                ),
                ['prompt' => 'Seleccionar Categoría', 'style' => 'width: 100%;']
            )->label('Categoría') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'asignatura_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(
                    \app\models\Asignatura::find()->orderBy(['Nombre' => SORT_ASC])->all(),
                    'id',
                    'Nombre'
                ),
                ['prompt' => 'Seleccionar Asignatura', 'style' => 'width: 100%;']
            )->label('Asignatura') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'pais_codigopais')->dropDownList(
                \yii\helpers\ArrayHelper::map(
                    \app\models\Pais::find()->orderBy(['Nombrepais' => SORT_ASC])->all(),
                    'codigopais',
                    'Nombrepais'
                ),
                ['prompt' => 'Seleccionar País', 'style' => 'width: 100%;']
            )->label('País de Publicación') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'anio_publicacion')->textInput(['style' => 'width: 100%;', 'type' => 'number', 'min' => 1900, 'max' => date('Y')])->label('Año de Publicación') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'n_ejemplares')->textInput(['style' => 'width: 100%;'])->label('Número de Ejemplares') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'isbn')->textInput(['style' => 'width: 100%;'])->label('ISBN') ?>
        </div>
    </div>
</div>




    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
