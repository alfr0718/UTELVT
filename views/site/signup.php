<?php
use yii2mod\admin\helper\LayoutHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Registro';
?>


<?php if (Yii::$app->session->hasFlash('success')): ?>
    
<?= \hail812\adminlte\widgets\Alert::widget([
    'type' => 'success',
    'body' => Yii::$app->session->getFlash('success'), // Mostrar mensaje de éxito
]) ?>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <?= \hail812\adminlte\widgets\Alert::widget([
    'type' => 'danger',
    'body' => Yii::$app->session->getFlash('error'), // Mostrar mensaje de error
]) ?>
<?php endif; ?>


<h1><?= Html::encode($this->title) ?></h1>



<div class="registro-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($PersonalD, 'Ci')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'Apellidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'Nombres')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'FechaNacimiento')->input('date') ?>

    <?= $form->field($PersonalD, 'Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'Genero')->dropDownList([ 'M' => 'Masculino', 'F' => 'Femenino', ], ['prompt' => 'Seleccione su género']) ?>

    <?= $form->field($PersonalD, 'Institucion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($PersonalD, 'Nivel')->dropDownList([ 'Bachiller' => 'Bachiller', 'Universidad' => 'Universidad', 'Posgrado'=> 'Posgrado', ], ['prompt' => 'Seleccione su Nivel Académico']) ?>

    <div class="form-group">
        <?= Html::submitButton('Iniciar Registro', ['class' => 'btn btn-primary']) ?>
    </div>

    
    <?php ActiveForm::end(); ?>
</div>

