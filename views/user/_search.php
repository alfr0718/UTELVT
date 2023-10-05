<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'Auth_key') ?>

    <?= $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'tipo_usuario') ?>

    <?php // echo $form->field($model, 'Created_at') ?>

    <?php // echo $form->field($model, 'Updated_at') ?>

    <?php // echo $form->field($model, 'Temporalpassword') ?>

    <?php // echo $form->field($model, 'Tempralpasswordtime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
