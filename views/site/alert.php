<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;

$this->title = '';
?>
<div class="site-alert">

    <h1><?= Html::encode($this->title) ?></h1>
    
<?php if (Yii::$app->session->hasFlash('sucess')): ?>
<?= \hail812\adminlte\widgets\Alert::widget([
    'type' => 'success',
    'title' => '¡Éxito!', 
    'body' => Yii::$app->session->getFlash('sucess'),
]) ?>
<?php endif; ?>
    
<?php if (Yii::$app->session->hasFlash('error')): ?>
<?= \hail812\adminlte\widgets\Alert::widget([
    'type' => 'danger',
    'title' => 'Error', 
    'body' => Yii::$app->session->getFlash('error'),
]) ?>
<?php endif; ?>

</div>
