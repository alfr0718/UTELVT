<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Libro $model */

$this->title = 'Ingresar Libro';
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libro-create">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header bg-olive">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>

                <div class="card-body">

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>