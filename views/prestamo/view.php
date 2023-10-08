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
        <?= Html::a('Update', ['update', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca, 'personaldata_Ci' => $model->personaldata_Ci], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca, 'personaldata_Ci' => $model->personaldata_Ci], [
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
            'id',
            'fecha_solicitud',
            'intervalo_solicitado',
            'tipoprestamo_id',
            'biblioteca_idbiblioteca',
            'pc_idpc',
            'pc_biblioteca_idbiblioteca',
            'libro_codigo_barras',
            'libro_biblioteca_idbiblioteca',
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
