<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Libro $model */

$this->title = $model->codigo_barras;
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="libro-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'codigo_barras' => $model->codigo_barras, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'codigo_barras' => $model->codigo_barras, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codigo_barras',
            'n_ejemplares',
            'titulo',
            'autor',
            'isbn',
            'cute',
            'editorial',
            'anio_publicacion',
            'estado',
            'categoria_id',
            'asignatura_id',
            'pais_codigopais',
            'biblioteca_idbiblioteca',
        ],
    ]) ?>

</div>
