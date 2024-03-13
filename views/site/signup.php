<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use hail812\adminlte3\assets\PluginAsset;

$this->title = 'Registro';

PluginAsset::register($this)->add('bs-stepper');
$this->registerJsFile('@web/js/bs-stepper.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$this->registerCssFile('@web/css/registro.css', ['depends' => [yii\bootstrap4\BootstrapAsset::class]]);

?>

<div class="site-signup">

    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                    <h1 class="registro-title"><?= Html::encode($this->title) ?></h1>

                    <div class="bs-stepper">
                        <div class="bs-stepper-header">
                            <!-- your steps here -->
                            <div class="step" data-target="#personal-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="personal-part" id="personal-part-trigger">
                                    <span class="bs-stepper-circle">1</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#information-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                    <span class="bs-stepper-circle">2</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#academic-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="academic-part" id="academic-part-trigger">
                                    <span class="bs-stepper-circle">3</span>
                                </button>
                            </div>
                        </div>

                        <?php $form = ActiveForm::begin([]); ?>

                        <div class="bs-stepper-content">
                            <!-- your steps content here -->
                            <div id="personal-part" class="content" role="tabpanel" aria-labelledby="personal-part-trigger">

                                <?= $form->field($model, 'Ci')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'Genero')->dropDownList(['M' => 'Masculino', 'F' => 'Femenino'], ['prompt' => 'Seleccione su género']) ?>
                                <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>

                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-primary btn-next">Siguiente</button>
                                </div>

                            </div>
                            <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">

                                <?= $form->field($model, 'Apellidos')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'Nombres')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'FechaNacimiento')->input('date') ?>

                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-primary btn-prev">Anterior</button>
                                    <button type="button" class="btn btn-primary btn-next">Siguiente</button>
                                </div>

                            </div>
                            <div id="academic-part" class="content" role="tabpanel" aria-labelledby="academic-part-trigger">

                                <?= $form->field($model, 'Institucion')->textInput(['maxlength' => true, 'placeholder' => 'Institución Académica, Organización...']) ?>

                                <?= $form->field($model, 'Nivel')->dropDownList($model->niveles, ['prompt' => 'Seleccione su Nivel Académico']) ?>

                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-primary btn-prev">Anterior</button>
                                    <?= Html::submitButton('<b>Crear Cuenta</b>', ['class' => 'btn btn-success btn-lg', 'name' => 'save-button']) ?>
                                </div>

                            </div>

                        </div>
                        <?php ActiveForm::end(); ?>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>