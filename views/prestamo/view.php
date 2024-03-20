<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Prestamo $model */

$this->title = $model->id . $model->tipoprestamo_id . $model->biblioteca_idbiblioteca;
$this->params['breadcrumbs'][] = ['label' => 'Prestamos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>

<div class="prestamo-view">

    <div class="card">
        <div class="card-header bg-olive">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body">

            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-hover'], // Agrega clases CSS a la tabla
                'attributes' => [
                    'id',
                    'fecha_solicitud',
                    'fechaentrega',
                    [
                        'label' => 'Tiempo Solicitado',
                        'value' => function ($model) {
                            $fechaSolicitud = new DateTime($model->fecha_solicitud);
                            $fechaEntrega = new DateTime($model->fechaentrega);
                            $interval = $fechaSolicitud->diff($fechaEntrega);

                            return $interval->format('%h h %i m');
                        },
                    ],
                    [
                        'attribute' => 'tipoprestamo_id',
                        'value' => function ($model) {
                            return $model->tipoprestamo->nombre_tipo;
                        },
                    ],
                    [
                        'attribute' => 'biblioteca_idbiblioteca', 
                        'value' => function ($model) {
                            return $model->bibliotecaIdbiblioteca->Campus; 
                        },
                    ],
                    [
                        'label' => $model->tipoprestamo_id === 'COMP' ? 'Equipo Solicitado' : ($model->tipoprestamo_id === 'LIB' ? 'Libro Solicitado' : ''),
                        'attribute' => 'object_id', // Esto muestra el código
                        'value' => function ($model) {
                            if ($model->tipoprestamo_id == 'COMP') {
                                return $model->object_id ? $model->pcIdpc->nombre : ''; // Accede al dato relacionado si no es nulo, de lo contrario, muestra Nada
                            } elseif ($model->tipoprestamo_id == 'LIB') {
                                return $model->object_id ? $model->ejemplar->codigo_barras.' - '. $model->ejemplar->libro->titulo: ''; // Accede al dato relacionado si no es nulo, de lo contrario, muestra Nada
                            } else {
                                return '';
                            }
                        },
                        'contentOptions' => ['style' => 'vertical-align: middle;'],
                        'visible' => !empty($model->object_id),
                    ],
                    //ESTUDIANTE
                    [
                        'attribute' => 'informacionpersonal_CIInfPer',
                        'visible' => !empty($model->informacionpersonal_CIInfPer),
                    ],
                    [
                        'attribute' => 'informacionpersonal_CIInfPer',
                        'label' => 'Apellidos',
                        'visible' => !empty($model->informacionpersonal_CIInfPer),
                        'value' => function ($model) {
                            if ($model->informacionpersonalCIInfPer !== null) {
                                return $model->informacionpersonalCIInfPer->ApellInfPer . ' ' . $model->informacionpersonalCIInfPer->ApellMatInfPer;
                            } else {
                                return 'No disponible'; // O cualquier otro mensaje adecuado
                            }
                        },
                    ],
                    [
                        'attribute' => 'informacionpersonal_CIInfPer',
                        'label' => 'Nombres',
                        'visible' => !empty($model->informacionpersonal_CIInfPer),
                        'value' => function ($model) {
                            if ($model->informacionpersonalCIInfPer !== null) {
                                return $model->informacionpersonalCIInfPer->NombInfPer;
                            } else {
                                return 'No disponible'; // O cualquier otro mensaje adecuado
                            }
                        },
                    ],
                    //PERSONAL UNIVERSITARIO
                    [
                        'attribute' => 'informacionpersonal_d_CIInfPer',
                        'visible' => !empty($model->informacionpersonal_d_CIInfPer),
                    ],
                    [
                        'attribute' => 'informacionpersonal_d_CIInfPer',
                        'label' => 'Apellidos',
                        'visible' => !empty($model->informacionpersonal_d_CIInfPer),
                        'value' => function ($model) {
                            if ($model->informacionpersonalDCIInfPer !== null) {
                                return $model->informacionpersonalDCIInfPer->ApellInfPer . ' ' . $model->informacionpersonalDCIInfPer->ApellMatInfPer;
                            } else {
                                return 'No disponible'; // O cualquier otro mensaje adecuado
                            }
                        },
                    ],
                    [
                        'attribute' => 'informacionpersonal_d_CIInfPer',
                        'label' => 'Nombres',
                        'visible' => !empty($model->informacionpersonal_d_CIInfPer),
                        'value' => function ($model) {
                            if ($model->informacionpersonalDCIInfPer !== null) {
                                return $model->informacionpersonalDCIInfPer->NombInfPer;
                            } else {
                                return 'No disponible'; // O cualquier otro mensaje adecuado
                            }
                        },
                    ],

                    //SOLICITANTE EXTERNO
                    [
                        'attribute' => 'personaldata_Ci',
                        'visible' => !empty($model->personaldata_Ci),
                    ],
                    [
                        'attribute' => 'personaldata_Ci',
                        'label' => 'Nombres',
                        'visible' => !empty($model->personaldata_Ci),
                        'value' => function ($model) {
                            return $model->personaldataCi->Nombres;
                        },
                    ],
                    [
                        'attribute' => 'personaldata_Ci',
                        'label' => 'Apellidos',
                        'visible' => !empty($model->personaldata_Ci),
                        'value' => function ($model) {
                            return $model->personaldataCi->Apellidos;
                        },
                    ],
                    [
                        'attribute' => 'personaldata_Ci',
                        'label' => 'Institución',
                        'visible' => !empty($model->personaldata_Ci),
                        'value' => function ($model) {
                            return $model->personaldataCi->Institucion;
                        },
                    ],
                    [
                        'attribute' => 'personaldata_Ci',
                        'label' => 'Email',
                        'visible' => !empty($model->personaldata_Ci),
                        'value' => function ($model) {
                            return $model->personaldataCi->Email;
                        },
                    ],
                ],
            ]) ?>
        </div>

        <div class="card-footer">
            <div class="form-group text-right botones-impresion">
                <?php $tipoUsuario = Yii::$app->user->identity->tipo_usuario;
                if ($tipoUsuario === User::TYPE_ADMIN || $tipoUsuario === User::TYPE_PERSONALB) : ?>
                    <?= Html::a('<i class="far fa-edit"></i> Actualizar', ['update', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca],
                     ['class' => 'btn btn-app btn-primary']) ?>
                    <?= Html::a('<i class="fas fa-trash"></i> Eliminar', ['delete', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], [
                        'class' => 'btn btn-app btn-danger',
                        'data' => [
                            'confirm' => '¿Estás seguro de eliminar este elemento?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif; ?>

                <?= Html::a('<i class="fas fa-print"></i> PDF', ['generate-pdf', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], [
                    'class' => 'btn btn-app btn-success',
                ]) ?>

            </div>
        </div>

    </div>

</div>