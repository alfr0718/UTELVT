<?php
use yii2mod\admin\helper\LayoutHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Registro';

$this->registerCss("
@import url('https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap');

body {
    background-image: url('/img/3.jpeg'); /* Reemplaza con la ruta real de tu imagen de fondo */
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
}
.registro-form {
    max-width: 90vw;
    margin: 0 auto;
    padding: 20px;
    background-color: #f8f8ff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.registro-form label {
    font-weight: 700;
}

.registro-form .form-group {
    margin-bottom: 20px;
}

.registro-form .btn-primary {
    background-color: #5EB400;
    color: #FFF;
    padding: 15px 20px;
    border: none;
}

.registro-form .btn-primary:hover {
    background-color: #4E9A00;
}

/* Estilo adicional para el título */
.registro-title {
    font-size: 2em;
    margin: 20px 0;
    color: #191970; /* Color del texto para el título */
    font-family: 'Raleway', sans-serif;
    font-size: 2em;
    font-weight: 700;
    letter-spacing: 2px; /* Ajusta el espaciado entre letras */
    text-transform: uppercase; /* Convierte el texto a mayúsculas, si es necesario */

}
");

?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
<?= \hail812\adminlte\widgets\Alert::widget([
    'type' => 'danger',
    'body' => Yii::$app->session->getFlash('error'),
]) ?>
<?php endif; ?>

<div class="registro-form">
    <h1 class="registro-title"><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= $form->field($PersonalD, 'Ci')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($PersonalD, 'Apellidos')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($PersonalD, 'Nombres')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($PersonalD, 'FechaNacimiento')->input('date') ?>
    </div>

    <div class="form-group">
        <?= $form->field($PersonalD, 'Email')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($PersonalD, 'Genero')->dropDownList(['M' => 'Masculino', 'F' => 'Femenino'], ['prompt' => 'Seleccione su género']) ?>
    </div>

    <div class="form-group">
        <?= $form->field($PersonalD, 'Institucion')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($PersonalD, 'Nivel')->dropDownList(['Bachiller' => 'Bachiller', 'Universidad' => 'Universidad', 'Posgrado' => 'Posgrado'], ['prompt' => 'Seleccione su Nivel Académico']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Iniciar Registro', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
