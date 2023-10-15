<?php
use yii2mod\admin\helper\LayoutHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Registro';
$this->registerCss("
@import url('https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap');

.welcome-container {
    background-size: cover;
    background-position: center;
    animation: backgroundAnimation 60s infinite alternate;
    transition: background-image 2s ease-in-out; /* Agregamos una transición suave */
}

@keyframes backgroundAnimation {
    0% {
        background-image: url('/img/1.jpg');
    }
    25% {
        background-image: url('/img/2.jpeg');
    }
    50% {
        background-image: url('/img/3.jpeg');
    }
    75% {
        background-image: url('/img/4.jpeg');
    }
    100% {
        background-image: url('/img/1.jpeg');
    }
}

.site-index {
    text-align: center;
    padding: 30px 0;
    color: #FFF; /* Color del texto en blanco */
    font-family: 'Raleway', sans-serif;
    font-size: 1.2em;
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Sombreado del texto */
}


.site-index h1 {
    font-size: 3em;
    margin: 20px 0;
    transition: font-size 0.3s;
}

.site-index:hover h1 {
    font-size: 3.5em;
}

.site-index .lead {
    font-size: 1.2em;
    margin-bottom: 20px;
}

.site-index .btn-success,
.site-index .btn-primary {
    font-size: 1em;
    padding: 15px 20px;
    background-color: #5EB400;
    border: none;
    color: #FFF;
    transition: background-color 0.3s, transform 0.2s;
    margin: 10px;
}

.site-index .btn-success:hover,
.site-index .btn-primary:hover {
    background-color: #4E9A00;
    transform: scale(1.05);
}

.col-lg-4 {
    flex: 1;
    margin: 20px;
    padding: 20px;
    border-radius: 10px;
    background-color: #FFF;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.col-lg-4:hover {
    transform: scale(1.05);
}

.col-lg-4 p {
    font-size: 1em;
    margin-bottom: 10px;
}

.btn-outline-secondary {
    font-size: 1em;
    padding: 15px 20px;
    background-color: #FF6B00;
    color: #FFF;
    border: none;
}

.btn-outline-secondary:hover {
    background-color: #E95A00;
}
}
");

?>
<style >
    /* Estilos para el título */
    h1 {
        text-align: center;
        color: #5EB400;
    }

    /* Estilos para los campos del formulario */
    .form-group {
        margin-bottom: 20px;
    }

    /* Estilos para el botón de enviar */
    .btn-primary {
        background-color: #5EB400;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($PersonalD, 'Ci', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true]) ?>
<?= $form->field($PersonalD, 'Apellidos', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true]) ?>
<?= $form->field($PersonalD, 'Nombres', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true]) ?>
<?= $form->field($PersonalD, 'FechaNacimiento', ['options' => ['class' => 'form-group']])->input('date') ?>
<?= $form->field($PersonalD, 'Email', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true]) ?>
<?= $form->field($PersonalD, 'Genero', ['options' => ['class' => 'form-group']])->dropDownList(['M' => 'Masculino', 'F' => 'Femenino'], ['prompt' => 'Seleccione su género']) ?>
<?= $form->field($PersonalD, 'Institucion', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true]) ?>
<?= $form->field($PersonalD, 'Nivel', ['options' => ['class' => 'form-group']])->dropDownList(['Bachiller' => 'Bachiller', 'Universidad' => 'Universidad', 'Posgrado' => 'Posgrado'], ['prompt' => 'Seleccione su Nivel Académico']) ?>

<div class="form-group">
    <?= Html::submitButton('Iniciar Registro', ['class' => 'btn btn-outline-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
