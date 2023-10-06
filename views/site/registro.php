<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\PersonalDs\User as User;
use app\PersonalDs\Personaldata as PersonalD;

$this->title = 'Registro';
?>

<h1><?= Html::encode($this->title) ?></h1>


<div class="registro-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($PersonalD, 'Ci')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'Apellidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'Nombres')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'FechaNacimiento')->textInput() ?>

    <?= $form->field($PersonalD, 'Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'Genero')->dropDownList([ 'M' => 'Male', 'F' => 'Female', ], ['prompt' => 'Seleccione su género']) ?>

    <?= $form->field($PersonalD, 'Institucion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'Nivel')->dropDownList([ 'Bachiller','Universidad', 'Posgrado' ], ['prompt' => 'Seleccione su nivel de educación']) ?>

    <div class="form-group">
        <?= Html::submitButton('Iniciar Registro', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

</div>