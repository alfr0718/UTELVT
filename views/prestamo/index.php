<?php

use app\models\Prestamo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\PrestamoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Registros de Préstamo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestamo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?php
        $tipoUsuario = null; // Inicializamos la variable

        if (!Yii::$app->user->isGuest) {
            // El usuario ha iniciado sesión, podemos acceder a 'tipo_usuario'
            $tipoUsuario = Yii::$app->user->identity->tipo_usuario;

            if ($tipoUsuario === 8 || $tipoUsuario === 21) {
                echo Html::a('Nuevo Préstamo <i class="fas fa-plus-circle"></i>', ['create'], ['class' => 'btn btn-success my-3']);
            }
        }
        ?>
    </p>


    <?php Pjax::begin(); ?>


    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="table-responsive">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pager' => [
                'options' => ['class' => 'pagination justify-content-center'], // Agrega una clase CSS personalizada al contenedor de paginación
                'maxButtonCount' => 5, // Controla el número de botones de página que se muestran
                'prevPageLabel' => 'Anterior',
                'nextPageLabel' => 'Siguiente',
                'prevPageCssClass' => 'page-item', // Clase CSS para el botón "Anterior"
                'nextPageCssClass' => 'page-item', // Clase CSS para el botón "Siguiente"
                'linkOptions' => ['class' => 'page-link'], // Agrega una clase CSS personalizada a los enlaces de página
                'activePageCssClass' => 'page-item active', // Clase CSS para la página activa
                'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'], // Estilo de los botones deshabilitados

            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'fecha_solicitud',
                //'fechaentrega',
                //'tipoprestamo_id',
                [
                    'header' => 'Tiempo Solicitado',
                    'headerOptions' => ['style' => 'color: #0d75fd;'],
                    'value' => function ($model) {
                        $fechaSolicitud = new DateTime($model->fecha_solicitud);
                        $fechaEntrega = new DateTime($model->fechaentrega);
                        $interval = $fechaSolicitud->diff($fechaEntrega);

                        return $interval->format('%h h %i m');
                    },
                ],
                [
                    'attribute' => 'tipoprestamo_id', // Esto muestra el código del país
                    'value' => function ($model) {
                        return $model->tipoprestamo->nombre_tipo; // Accede al nombre del país relacionado
                    },
                ],
                [
                    'attribute' => 'pc_idpc', // Esto muestra el código
                    'value' => function ($model) {
                        return $model->pc_idpc ? $model->pcIdpc->nombre : ''; // Accede al dato relacionado si no es nulo, de lo contrario, muestra Nada
                    },
                ],
                [
                    'attribute' => 'libro_id', // Esto muestra el código
                    'value' => function ($model) {
                        return $model->libro ? $model->libro->codigo_barras : ''; // Accede al dato relacionado si no es nulo, de lo contrario, muestra Nada
                    },
                ],
                [
                    'attribute' => 'Cédula Solicitante',
                    'headerOptions' => ['style' => 'color: #0d75fd;'],
                    'value' => function ($model) {
                        return $model->personaldata_Ci
                            ?? $model->informacionpersonal_CIInfPer
                            ?? $model->informacionpersonal_d_CIInfPer;
                    },
                ],
                [
                    'attribute' => 'Tipo de Solicitante',
                    'headerOptions' => ['style' => 'color: #0d75fd;'],
                    'value' => function ($model) {
                        if (!empty($model->informacionpersonal_d_CIInfPer)) {
                            return 'Personal Universitario';
                        } elseif (!empty($model->personaldata_Ci)) {
                            return 'Externo';
                        } elseif (!empty($model->informacionpersonal_CIInfPer)) {
                            return 'Estudiante';
                        } else {
                            return 'N/A'; // Puedes definir un valor por defecto si ninguna condición se cumple.
                        }
                    },
                ],
                [
                    'attribute' => 'biblioteca_idbiblioteca', // Esto muestra el código del país
                    'value' => function ($model) {
                        return $model->bibliotecaIdbiblioteca->Campus; // Accede al nombre del país relacionado
                    },
                ],
                //'libro_biblioteca_idbiblioteca',

                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Prestamo $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca, 'personaldata_Ci' => $model->personaldata_Ci]);
                    },
                    'visible' => $tipoUsuario === 8 || $tipoUsuario === 21,
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>