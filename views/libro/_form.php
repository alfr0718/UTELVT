<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Categoria;
use app\models\Asignatura;
use app\models\Pais;
use app\models\Biblioteca;
use app\models\Seccion;

/** @var yii\web\View $this */
/** @var app\models\Libro $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="libro-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'custom-form']]); ?>

    <div class="row">
        <div class="col-md-3">
            <img id="previewImage" class="img-thumbnail img-fluid" src="#" alt="Vista previa de la imagen" style="display: none;">
        </div>
        <div class="col-md-4">
            <div class="form-group">

                <?= $form->field($model, 'cubiertaLibro')->fileInput(['class' => 'form-control', 'id' => 'inputImage'])->label('Portada') ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'titulo')
                    ->label('Título')
                    ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Título de la Publicación']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'autor')
                    ->label('Autor')
                    ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Autor de la Publicación']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'isbn')
                    ->label('ISBN')
                    ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'ISBN']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'cute')
                    ->label('CUTE')
                    ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'CUTE']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'editorial')
                    ->label('Editorial')
                    ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Editorial']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?= $form->field($model, 'anio_publicacion')
                    ->label('Año de Publicación')
                    ->input('number', ['max' => date('Y'), 'step' => 1, 'class' => 'form-control', 'placeholder' => 'Año de Publicación']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'categoria_id')
                    ->label('Categoría')
                    ->dropDownList(ArrayHelper::map(Categoria::find()->all(), 'id', 'NombreCateg'), ['prompt' => 'Seleccione Categoría', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'asignatura_IdAsig')
                    ->label('Asignatura')
                    ->dropDownList(ArrayHelper::map(Asignatura::find()->all(), 'IdAsig', 'NombAsig'), ['prompt' => 'Seleccione Asignatura', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'pais_cod_pais')
                    ->label('País')
                    ->dropDownList(ArrayHelper::map(Pais::find()->orderBy(['nomb_pais' => SORT_ASC])->all(), 'cod_pais', 'nomb_pais'), ['prompt' => 'Seleccione País', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'seccion_id')
                    ->label('Seccion')
                    ->dropDownList(ArrayHelper::map(Seccion::find()->orderBy(['NombreSeccion' => SORT_ASC])->all(), 'id', 'NombreSeccion'), ['prompt' => 'Seleccione Sección', 'class' => 'form-control']) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Ingresar', ['class' => 'btn btn-success btn-lg float-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var inputImage = document.getElementById('inputImage');
        var previewImage = document.getElementById('previewImage');

        // Función para cargar la imagen existente del modelo
        function loadExistingImage() {
            // Verificar si el modelo tiene una imagen de portada
            if ("<?= $model->cover ?>" != "") {
                // Construir la URL de la imagen existente

                var existingImageUrl = "<?= Yii::getAlias('@web') ?>" + "<?= '/cover/' . $model->cover ?>";
                // Mostrar la imagen existente en la vista previa
                previewImage.src = existingImageUrl;
                previewImage.style.display = 'block'; // Mostrar la imagen
            }

        }

        // Llamar a la función para cargar la imagen existente al cargar la página
        loadExistingImage();

        // Manejar el evento de cambio del campo de entrada de archivos
        inputImage.addEventListener('change', function(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function() {
                // Mostrar la imagen seleccionada en la vista previa
                previewImage.src = reader.result;
                previewImage.style.display = 'block'; // Mostrar la imagen
            }

            reader.readAsDataURL(input.files[0]);
        });
    });
</script>