<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Prestamo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="prestamo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $form->field($model, 'fecha_solicitud')->textInput() ?>

    <?= $form->field($model, 'field_choice')->dropDownList([
        'personaldata_Ci' => 'Persona Externa',
        'informacionpersonal_Ci' => 'Estudiante',
        'informacionpersonal_d_CI' => 'Personal Universitario',

    ], ['prompt' => 'Seleccione Tipo de Solicitante'])->label('Tipo de Solicitante'); ?>

    <div id="dynamic-input-container"></div> <!-- Container for dynamic input fields -->


    <?= $form->field($model, 'intervalo_solicitado')
        ->textInput(['type' => 'time', 'value' => '01:00:00']) ?>

    <?= $form->field($model, 'biblioteca_idbiblioteca')
        ->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
            ['prompt' => 'Seleccione Campus',]
        ) ?>

    <?= $form->field($model, 'tipoprestamo_id')
        ->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Tipoprestamo::find()->all(), 'id', 'nombre_tipo',),
        ['prompt' => 'Servicio Solicitado', 'id' => 'tipoprestamo-id']
        ) ?>


    <div class="dynamic-fields" id="libro-fields" style="display: none">
        <?= $form->field($model, 'libro_id')
            ->dropDownList(
                \yii\helpers\ArrayHelper::map(\app\models\Libro::find()->all(), 'id', function ($model) {
                    return $model->codigo_barras . ' - ' . $model->titulo;
                }),
                ['prompt' => 'Seleccione Libro']
            ) ?>
    </div>

    <div class="dynamic-fields" id="pc-fields" style="display: none">
        <?= $form->field($model, 'pc_idpc')
            ->dropDownList(
                \yii\helpers\ArrayHelper::map(\app\models\Pc::find()->all(), 'idpc', 'nombre'),
                ['prompt' => 'Seleccione Dispositivo']
            ) ?>
    </div>
    <?php // $form->field($model, 'pc_biblioteca_idbiblioteca')->textInput() 
    ?>

    <?php // $form->field($model, 'libro_biblioteca_idbiblioteca')->textInput() 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<<JS
$('#prestamo-field_choice').on('change', function() {
    var choice = $(this).val();
    var container = $('#dynamic-input-container');
    container.empty();

    if (choice === 'personaldata_Ci') {
        container.append('<input type="text" class="form-control" name="Prestamo[personaldata_Ci]" placeholder="Cédula de Persona Externa">');
    } else if (choice === 'informacionpersonal_Ci') {
        container.append('<input type="text" class="form-control" name="Prestamo[informacionpersonal_Ci]" placeholder="Cédula de Estudiante">');
    } else if (choice === 'informacionpersonal_d_CI') {
        container.append('<input type="text" class="form-control" name="Prestamo[informacionpersonal_d_CI]" placeholder="Cédula de Docente">');
    }
});

$('#tipoprestamo-id').on('change', function() {
    var selectedValue = $(this).val();

    if (selectedValue === 'LIB') { // Cambiar '2' por el valor correspondiente a la opción que muestra el campo libro
        $('#libro-fields').show();
        $('#pc-fields').hide();
    } else if (selectedValue === 'COMP') { // Cambiar '3' por el valor correspondiente a la opción que muestra el campo computadora
        $('#pc-fields').show();
        $('#libro-fields').hide();
    } else {
        $('#libro-fields').hide();
        $('#pc-fields').hide();
    }
});

JS;
$this->registerJs($script);
?>