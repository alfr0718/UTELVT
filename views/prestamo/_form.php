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

    <?php //$form->field($model, 'fecha_solicitud')->textInput() ?>

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


<?= $form->field($model, 'intervalo_solicitado')
->textInput(['type' => 'time', 'value' =>'01:00:00'])?>
    <?= $form->field($model, 'biblioteca_idbiblioteca')
        ->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
            ['prompt' => 'Seleccione Campus']
        ) ?>

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
    } else if (choice === 'informacionpersonal_CIInfPer') {
        container.append('<input type="text" class="form-control" name="Prestamo[informacionpersonal_CIInfPer]" placeholder="Cédula de Estudiante">');
    } else if (choice === 'informacionpersonal_d_CIInfPer') {
        container.append('<input type="text" class="form-control" name="Prestamo[informacionpersonal_d_CIInfPer]" placeholder="Cédula de Docente">');
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
