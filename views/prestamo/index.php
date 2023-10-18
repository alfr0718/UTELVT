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

$this->title = 'Préstamos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestamo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php
    $tipoUsuario = null; // Inicializamos la variable

    if (!Yii::$app->user->isGuest) {
        // El usuario ha iniciado sesión, podemos acceder a 'tipo_usuario'
        $tipoUsuario = Yii::$app->user->identity->tipo_usuario;

        if ($tipoUsuario === 8 || $tipoUsuario === 21 ) {
            echo Html::a('Ingresar Préstamo', ['create'], ['class' => 'btn btn-success']);
        }
    }
    ?>

    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fecha_solicitud',
            //'fechaentrega',
            //'tipoprestamo_id',
            [
                'label' => 'Intervalo (horas)',
                'value' => function ($model) {
                    $fechaSolicitud = new DateTime($model->fecha_solicitud);
                    $fechaEntrega = new DateTime($model->fechaentrega);
                    $interval = $fechaSolicitud->diff($fechaEntrega);

                    return $interval->format('%h horas');
                },
            ],
            [
                'attribute' => 'tipoprestamo_id', // Esto muestra el código del país
                'value' => function ($model) {
                    return $model->tipoprestamo->nombre_tipo; // Accede al nombre del país relacionado
                },
            ],
            'pc_idpc',
            //'pc_biblioteca_idbiblioteca',
            //'libro_id',
           // 'biblioteca_idbiblioteca',
           [
            'attribute' => 'libro_id', // Esto muestra el código
            'label' => 'Código de Barra del Libro',
            'value' => function ($model) {
                return $model->libro ? $model->libro->codigo_barras : ''; // Accede al dato relacionado si no es nulo, de lo contrario, muestra Nada
            },
        ],
            [
                'attribute' => 'biblioteca_idbiblioteca', // Esto muestra el código del país
                'value' => function ($model) {
                    return $model->bibliotecaIdbiblioteca->Campus; // Accede al nombre del país relacionado
                },
            ],
            //'libro_biblioteca_idbiblioteca',
            'personaldata_Ci',
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
