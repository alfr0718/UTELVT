<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Iniciar Sesión | Biblioteca';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center">
                <h1 class="display-4">Iniciar Sesión</h1>
                <p>Ingresa tus credenciales</p>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
            ]); ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
                'placeholder' => 'Usuario',
            ])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Contraseña',
            ])->label(false) ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ])->label('Recuérdame') ?>

            <div class="form-group text-center">
                <?= Html::submitButton('Acceder', [
                    'class' => 'btn btn-primary btn-block btn-lg', // Estilo de botón primario y grande
                ]) ?>
            </div>

            <div class="form-group text-center">
                <?= Html::a('Registrarse', ['site/signup'], [
                    'class' => 'btn btn-success btn-block btn-lg', // Estilo de botón de registro
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
