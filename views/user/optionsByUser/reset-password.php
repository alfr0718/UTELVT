<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Restablecer Contraseña';
?>

<div class="user-reset-password">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-lightblue">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>

                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Restablecer Contraseña', ['class' => 'btn btn-primary float-right']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>