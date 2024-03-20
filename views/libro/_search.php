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

    <div class="row align-items-center justify-content-center">
        <div class="col-md-3">
            <?= $form->field($model, 'titulo')->textInput(['style' => 'width: 100%;', 'placeholder' => 'Nombre del Libro'])->label(false) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'autor')->textInput(['style' => 'width: 100%;', 'placeholder' => 'Autor de la Publicación'])->label(false) ?>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-search"></i>', ['class' => 'btn bg-teal']) ?>
                <?= Html::button('<i class="fas fa-backspace"></i>', ['class' => 'btn btn-outline-secondary', 'onclick' => 'window.location.href = "' . Yii::$app->urlManager->createUrl(['libro/index']) . '"']) ?>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Filtros</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <?= $form->field($model, 'isbn')->textInput(['style' => 'width: 100%;', 'placeholder' => 'ISBN de la Publicación'])->label('ISBN') ?>

                    <?= $form->field($model, 'anio_publicacion')
                        ->textInput(['style' => 'width: 100%;', 'placeholder' => 'Año de Publicación', 'type' => 'number', 'min' => 1900, 'max' => date('Y')])
                        ->label('Año de Publicación') ?>

                    <?= $form->field($model, 'categoria_id')
                        ->dropDownList(
                            \yii\helpers\ArrayHelper::map(
                                \app\models\Categoria::find()->orderBy(['NombreCateg' => SORT_ASC])->all(),
                                'id',
                                'NombreCateg'
                            ),
                            ['prompt' => 'Todos', 'style' => 'width: 100%;']
                        )->label('Categoría') ?>
                    <?= $form->field($model, 'seccion_id')
                        ->dropDownList(
                            \yii\helpers\ArrayHelper::map(
                                \app\models\Seccion::find()->orderBy(['NombreSeccion' => SORT_ASC])->all(),
                                'id',
                                'NombreSeccion'
                            ),
                            ['prompt' => 'Todos', 'style' => 'width: 100%;']
                        )->label('Sección') ?>


                    <?php $paisesConLibros = \app\models\Pais::find()
                        ->where(['IN', 'cod_pais', \app\models\Libro::find()->select('pais_cod_pais')->distinct()])
                        ->orderBy(['nomb_pais' => SORT_ASC])
                        ->all();
                    ?>

                    <?= $form->field($model, 'pais_cod_pais')
                        ->dropDownList(
                            \yii\helpers\ArrayHelper::map($paisesConLibros, 'cod_pais', 'nomb_pais'),
                            ['prompt' => 'Todos', 'style' => 'width: 100%;']
                        )
                        ->label('País de Publicación') ?>


                    <?php $asignaturasConLibros = \app\models\Asignatura::find()
                        ->where(['IN', 'IdAsig', \app\models\Libro::find()->select('asignatura_IdAsig')->distinct()])
                        ->orderBy(['NombAsig' => SORT_ASC])
                        ->all();
                    ?>
                    <?= $form->field($model, 'asignatura_IdAsig')
                        ->dropDownList(
                            \yii\helpers\ArrayHelper::map(
                                $asignaturasConLibros,
                                'IdAsig',
                                'NombAsig'
                            ),
                            ['prompt' => 'Todos', 'style' => 'width: 100%;']
                        )->label('Asignatura') ?>



                    <?= $form->field($model, 'biblioteca_idbiblioteca')
                        ->label('Biblioteca')
                        ->dropDownList(
                            \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
                            [
                                'prompt' => 'Todos',
                            ]
                        ) ?>


                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>