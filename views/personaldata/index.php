<?php
use app\models\Personaldata;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Lista de Personas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personaldata-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $tipoUsuario = null; // Inicializamos la variable

    if (!Yii::$app->user->isGuest) {
        // El usuario ha iniciado sesión, podemos acceder a 'tipo_usuario'
        $tipoUsuario = Yii::$app->user->identity->tipo_usuario;

        if ($tipoUsuario === 8) {
            echo Html::a('Agregar Persona Natural', ['create'], ['class' => 'btn btn-success']);
        }
    }
    ?>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Ci',
            'Apellidos',
            'Nombres',
            'FechaNacimiento',
            'Genero',
            'Institucion',
            'Nivel',
            'Facultad',
            'Ciclo',

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Personaldata $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'Ci' => $model->Ci]);
                },
                'visible' => $tipoUsuario === 8, // Esto oculta la columna de acciones si el tipo de usuario es diferente de 8
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
