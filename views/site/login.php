<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Iniciar Sesión | Biblioteca';
$this->registerCss("
body::before {
    content: '';
    background-color: rgba(0, 0, 0, 0.5);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
}

body {
    background-image: url('/img/5.jpg');
    background-size: cover;
    background-position: center;
    height: 100vh;
    margin: 0;
}

.container-bg {
    background-color: rgba(255, 255, 255, 0.6);
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    max-width: 80%;
    margin: 0 auto;
}
");

// Configure the breadcrumbs
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="background"></div>
<div class="container container-bg">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center">
                <h1 class="display-4 text-black">Iniciar Sesión</h1>
                <p class ="text-blue">Ingresa tus credenciales</p>
            </div>

            <div class="card">
                <div class="card-body">
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
                            'class' => 'btn btn-primary btn-block btn-lg',
                        ]) ?>
                    </div>

                    <div class="form-group text-center">
                        <?= Html::a('Registrarse', ['site/signup'], [
                            'class' => 'btn btn-success btn-block btn-lg',
                        ]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                    <?php if (Yii::$app->session->hasFlash('success')): ?>
<?= \hail812\adminlte\widgets\Alert::widget([
    'type' => 'success',
    'icon' => 'fas fa-check', // Cambia el icono a un ícono de check (opcional)
    'closeButton' => false, // Oculta el botón de cierre (opcional)
    'options' => [
        'class' => 'alert alert-success', // Agrega una clase CSS personalizada (opcional)
    ],
    'body' => Yii::$app->session->getFlash('success'), // Mostrar mensaje de éxito
]) ?>
<?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>
