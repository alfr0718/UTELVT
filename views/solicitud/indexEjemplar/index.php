<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<h6><b>1. Seleccione una Copia:</b></h6>

<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-hover',
        ],
        'summary' => false,
        'rowOptions' => ['class' => 'text-nowrap'],
        'columns' => [
            'id',
            'codigo_barras',
            'ubicacion',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{PrestarLibro}',
                'contentOptions' => ['style' => 'text-align:center; vertical-align: middle;'],
                'buttons' => [
                    'PrestarLibro' => function ($url, $model, $key) {
                        $icon = ($model->Status == 1) ? '<i class="far fa-check-circle"></i>' : (($model->Status == 2) ? '<i class="fas fa-clock"></i>' : '<i class="fas fa-exclamation"></i>');

                        $buttonClass = ($model->Status == 1) ? 'bg-teal' : (($model->Status == 2) ? 'btn-outline-warning' : 'btn-outline-danger');

                        $disabled = ($model->Status == 1) ? false : true;
                        $buttonId = 'open-modal-button-' . $model->id; // Id único para el botón
                        return Html::button($icon, [
                            'title' => Yii::t('app', 'Solicitar'),
                            'class' => 'btn ' . $buttonClass,
                            'id' => $buttonId, // Id único para cada botón
                            'disabled' => $disabled, // Deshabilitar el botón si el modelo está en estado diferente de 1
                            'onclick' => 'showLibroStep2Modal(' . $model->id . ', "' . Url::to(['/solicitud/solicitar-libro']) . '")', // Llamar a la función JavaScript con el ID del modelo y la URL
                        ]);
                    },
                ],

            ],

        ],

    ]); ?>
</div>