<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ejemplar $model */

$this->title = 'Create Ejemplar';
$this->params['breadcrumbs'][] = ['label' => 'Ejemplars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ejemplar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
