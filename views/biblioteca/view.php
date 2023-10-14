<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Biblioteca $model */

$this->title = $model->Campus;
$this->params['breadcrumbs'][] = ['label' => 'Bibliotecas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="biblioteca-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'idbiblioteca' => $model->idbiblioteca], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'idbiblioteca' => $model->idbiblioteca], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estas seguro de eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idbiblioteca',
            'Campus',
            'Apertura',
            'Cierre',
            'Email:email',
            'Telefono',
        ],
    ]) ?>

</div>
