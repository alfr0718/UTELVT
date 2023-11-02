<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Prestamo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<style>
    .custom-form {
        background-color: #f7f7f7;
        padding: 20px;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
    }

    .form-title {
        font-size: 24px;
        margin-bottom: 20px;
    }
</style>

<div class="prestamo-form custom-form">
    <h1 class="form-title">Detalles de Solicitud</h1>

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'field_choice')->dropDownList([
                'personaldata_Ci' => 'Solicitante Externo',
                'informacionpersonal_CIInfPer' => 'Estudiante de la Institución',
                'informacionpersonal_d_CIInfPer' => 'Personal Universitario',
            ], ['prompt' => 'Seleccione Tipo de Solicitante'])->label('Tipo de Solicitante'); ?>

            <div id="dynamic-input-container"></div> <!-- Container for dynamic input fields -->

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

        </div>
        <div class="col-md-6">

            <?php // echo $form->field($model, 'fecha_solicitud')->textInput()
            ?>
            <?= $form->field($model, 'intervalo_solicitado')
                ->textInput(['type' => 'time', 'value' => '01:00:00']) ?>
            <?= $form->field($model, 'biblioteca_idbiblioteca')
                ->dropDownList(
                    \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
                    ['prompt' => 'Seleccione Campus']
                ) ?>

        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success btn-lg btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<<JS
// Función para mostrar los campos dinámicos basados en los valores del modelo
function showDynamicFields() {
    // Obtener los valores de los campos desde el modelo
    var personaldata_Ci = "{$model->personaldata_Ci}";
    var informacionpersonal_CIInfPer = "{$model->informacionpersonal_CIInfPer}";
    var informacionpersonal_d_CIInfPer = "{$model->informacionpersonal_d_CIInfPer}";

    // Verificar qué campo tiene un valor y mostrar el campo correspondiente
    if (personaldata_Ci !== '') {
        $('#dynamic-input-container').html('<input type="text" class="form-control" name="Prestamo[personaldata_Ci]" placeholder="Cédula de Persona Externa" value="' + personaldata_Ci + '">');
    } else if (informacionpersonal_CIInfPer !== '') {
        $('#dynamic-input-container').html('<input type="text" class="form-control" name="Prestamo[informacionpersonal_CIInfPer]" placeholder="Cédula de Estudiante" value="' + informacionpersonal_CIInfPer + '">');
    } else if (informacionpersonal_d_CIInfPer !== '') {
        $('#dynamic-input-container').html('<input type="text" class="form-control" name="Prestamo[informacionpersonal_d_CIInfPer]" placeholder="Cédula de Personal Universitario" value="' + informacionpersonal_d_CIInfPer + '">');
    }
}

// Verificar si estás en modo de actualización
var isNewRecord = "{$model->isNewRecord}";

// Mostrar los campos dinámicos solo en modo de actualización
if (!isNewRecord) {
    showDynamicFields();

    var selectedTipoprestamo = $('#tipoprestamo-id').val();
    if (selectedTipoprestamo === 'LIB') {
        $('#libro-fields').show();
    } else if (selectedTipoprestamo === 'COMP') {
        $('#pc-fields').show();
    }
}

if(isNewRecord){
    $('#prestamo-field_choice').on('change', function() {
    var choice = $(this).val();
    var container = $('#dynamic-input-container');
    container.empty();

    if (choice === 'personaldata_Ci') {
        container.append('<input type="text" class="form-control" name="Prestamo[personaldata_Ci]" placeholder="Cédula de Persona Externa">');
    } else if (choice === 'informacionpersonal_CIInfPer') {
        container.append('<input type="text" class="form-control" name="Prestamo[informacionpersonal_CIInfPer]" placeholder="Cédula de Estudiante">');
    } else if (choice === 'informacionpersonal_d_CIInfPer') {
        container.append('<input type="text" class="form-control" name="Prestamo[informacionpersonal_d_CIInfPer]" placeholder="Cédula de Personal Universitario">');
    }
});
}


// Evento al cambiar la opción de 'tipoprestamo_id'
$('#tipoprestamo-id').on('change', function() {
    var selectedValue = $(this).val();

    if (selectedValue === 'LIB') {
        $('#libro-fields').show();
        $('#pc-fields').hide();
    } else if (selectedValue === 'COMP') {
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