<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Libro $model */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="libro-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar Datos', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'codigo_barras',
            'titulo',
            'autor',
            'isbn',
            'cute',
            'editorial',
            'anio_publicacion',
            //'estado',
            //'n_ejemplares',
            //'categoria_id',
            //'asignatura_id',
            //'pais_codigopais',
            //'biblioteca_idbiblioteca',
            //'categoria_id',
            [
                'attribute' => 'categoria_id',
                'value' => function ($model) {
                    return $model->categoria->NombreCateg;
                },
            ],
            [
                'attribute' => 'asignatura_IdAsig',
                'value' => function ($model) {
                    return $model->asignatura->NombAsig;
                },
            ],
            [
                'attribute' => 'pais_cod_pais', // Esto muestra el código del país
                'value' => function ($model) {
                    return $model->paisCodigopais->nomb_pais; // Accede al nombre del país relacionado
                },
            ],
            [
                'attribute' => 'seccion_id',
                'value' => function ($model) {
                    return $model->seccion->NombreSeccion; 
                },
            ],
        ],
    ]) ?>

</div>
