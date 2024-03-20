<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PrestamoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="prestamo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>


    <?php // echo $form->field($model, 'id')->textInput(['style' => 'width: 100%;', 'placeholder' => 'N° Inicial del Formulario'])->label('Código de Préstamo') 
    ?>
    <div class="row">
        <div class="col md-6">
            <?= $form->field($model, 'cedula_solicitante')->textInput(['style' => 'width: 100%;', 'placeholder' => 'Ingrese N° de Cédula'])->label('Cédula Solicitante') ?>



            <?= $form->field($model, 'fecha_solicitud')->input('date') ?>


            <?= $form->field($model, 'biblioteca_idbiblioteca')->dropDownList(
                \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
                ['prompt' => 'Todos']
            ) ?>

            <div class="form-group float-right">
                <?= Html::submitButton(
                    '<i class="fas fa-search"></i> Buscar',
                    ['class' => 'btn btn-primary']
                ) ?>

                <?= Html::resetButton('Restablecer', [
                    'class' => 'btn btn-outline-secondary',
                    'onclick' => 'window.location.href = "' . Yii::$app->urlManager->createUrl(["prestamo/index"]) . '";'
                ]) ?>
            </div>

        </div>
        <div class="col md-6">

            <?= $form->field($model, 'tipoprestamo_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(\app\models\Tipoprestamo::find()->all(), 'id', 'nombre_tipo'),
                ['prompt' => 'Todos']
            ) ?>

            <div class="card">
                <div class="card-body">
                    <?= $form->field($model, 'codigo_barras')->textInput(['style' => 'width: 100%;', 'placeholder' => 'Código de Barras'])->label('Libro Solicitado') ?>

                    <?= $form->field($model, 'nombre_pc')->textInput(['style' => 'width: 100%;', 'placeholder' => 'Nombre del Equipo'])->label('Equipo Solicitado') ?>
                </div>
            </div>

        </div>
    </div>


    <?php // $form->field($model, 'fechaentrega') 
    ?>

    <?php // echo $form->field($model, 'pc_biblioteca_idbiblioteca')  
    ?>
    <?php // echo $form->field($model, 'libro_biblioteca_idbiblioteca')  
    ?>

    <?php ActiveForm::end(); ?>

</div>