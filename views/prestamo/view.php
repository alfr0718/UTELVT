<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Prestamo $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Prestamos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="prestamo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca, 'personaldata_Ci' => $model->personaldata_Ci], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca, 'personaldata_Ci' => $model->personaldata_Ci], [
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
            'id',
            'fecha_solicitud',
            'intervalo_solicitado',
            //'tipoprestamo_id',
            [
                'attribute' => 'tipoprestamo_id', // Esto muestra el código del país
                'value' => function ($model) {
                    return $model->tipoprestamo->nombre_tipo; // Accede al nombre del país relacionado
                },
            ],
            //'biblioteca_idbiblioteca',
            [
                'attribute' => 'biblioteca_idbiblioteca', // Esto muestra el código del país
                'value' => function ($model) {
                    return $model->bibliotecaIdbiblioteca->Campus; // Accede al nombre del país relacionado
                },
            ],
            'pc_idpc',
            //'pc_biblioteca_idbiblioteca',
            //'libro_codigo_barras',
            //'libro_biblioteca_idbiblioteca',
            //MAS DATOS DEL LIBRO
            [
                'attribute' => 'libro_id', // Esto muestra el código
                'label' => 'Código de Barra del Libro',
                'value' => function ($model) {
                    return $model->libro ? $model->libro->codigo_barras : ''; // Accede al dato relacionado si no es nulo, de lo contrario, muestra Nada
                },
            ],
            
            [
                'attribute' => 'libro_id', // Esto muestra el código
                'label' => 'Titulo solicitado',
                'value' => function ($model) {
                    return $model->libro ? $model->libro->titulo : ''; // Accede al dato relacionado si no es nulo, de lo contrario, muestra Nada
                },
            ],
            [
                'attribute' => 'libro_id', // Esto muestra el código
                'label' => 'Asignatura',
                'value' => function ($model) {
                    return $model->libro ? $model->libro->asignatura->Nombre : ''; // Accede al dato relacionado si no es nulo, de lo contrario, muestra Nada
                },
            ],

            'personaldata_Ci',
            ///MAS DATOS PERSONALES
            [
                'attribute' => 'personaldata_Ci', // Esto muestra el código
                'label' => 'Nombres',
                'value' => function ($model) {
                    return $model->personaldataCi->Nombres; // Accede al dato relacionado
                },
            ],
            [
                'attribute' => 'personaldata_Ci', // Esto muestra el código
                'label' => 'Apellidos',
                'value' => function ($model) {
                    return $model->personaldataCi->Apellidos; // Accede al dato relacionado
                },
            ],
            [
                'attribute' => 'personaldata_Ci', // Esto muestra el código 
                'label' => 'Institución',
                'value' => function ($model) {
                    return $model->personaldataCi->Institucion; // Accede al nombre relacionado
                },
            ],
        ],
    ]) ?>

</div>
