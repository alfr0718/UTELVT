<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Libro $model */

$this->title = $model->codigo_barras. ' - ' . $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="libro-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar Datos', ['update', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], [
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
            //'id',
            'codigo_barras',
            'titulo',
            'autor',
            'isbn',
            'cute',
            'editorial',
            'anio_publicacion',
            'estado',
            'n_ejemplares',
            //'categoria_id',
            //'asignatura_id',
            //'pais_codigopais',
            //'biblioteca_idbiblioteca',
            //'categoria_id',
            [
                'attribute' => 'categoria_id',
                'value' => function ($model) {
                    return $model->categoria->Categoría;
                },
            ],
            [
                'attribute' => 'asignatura_id',
                'value' => function ($model) {
                    return $model->asignatura->Nombre;
                },
            ],
            [
                'attribute' => 'pais_codigopais', // Esto muestra el código del país
                'value' => function ($model) {
                    return $model->paisCodigopais->Nombrepais; // Accede al nombre del país relacionado
                },
            ],
            [
                'attribute' => 'biblioteca_idbiblioteca', // Esto muestra el código del país
                'value' => function ($model) {
                    return $model->bibliotecaIdbiblioteca->Campus; // Accede al nombre del país relacionado
                },
            ],
            'link',
        ],
    ]) ?>

</div>
