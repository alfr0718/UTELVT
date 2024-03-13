<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?php if (!Yii::$app->user->isGuest) : ?>
            <?php $userType = Yii::$app->user->identity->tipo_usuario;
            if ($userType === User::TYPE_ADMIN) : ?>
    <div class="btn-toolbar">
        <div class="btn-group mr-2" role="group" aria-label="First group">

            <?= Html::a(
                    '<i class="fas fa-user-plus"></i> Agregar Usuario ',
                    ['create'],
                    ['class' => 'btn btn-app bg-success']
                ) ?>
        </div>
        <div class="btn-group ml-auto">
            <?= Html::a(
                    '<i class="fas fa-user-graduate"></i> Ver Estudiantes ',
                    ['informacionpersonal/index'],
                    ['class' => 'btn btn-app bg-primary']
                ) ?>
            <?= Html::a(
                    '<i class="fas fa-user-tie"></i> Ver Personal Universitario',
                    ['informacionpersonald/index'],
                    ['class' => 'btn btn-app bg-teal']
                ) ?>
            <?= Html::a(
                    '<i class="fas fa-id-card"></i> Ver Externos',
                    ['personaldata/index'],
                    ['class' => 'btn btn-app bg-pink']
                ) ?>
        </div>
    </div>
<?php endif; ?>

<?php endif; ?>
</p>


<?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); 
?>

<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            [
                'attribute' => 'Status',
                'value' => function ($model) {
                    if (($model->Status == 1)) {
                        return 'Activo';
                    } elseif (($model->Status == 0)) {
                        return 'Inactivo';
                    } else {
                        return 'N/A'; // Puedes definir un valor por defecto si ninguna condición se cumple.
                    }
                },
                'filter' => Html::activeDropDownList($searchModel, 'Status', [
                    '1' => 'Activo',
                    '0' => 'Inactivo',
                ], ['class' => 'form-control', 'prompt' => 'Todos']),
            ],
            //'tipo_usuario',
            [
                'attribute' => 'tipo_usuario',
                'value' => function ($model) {
                    $tipo = $model->typeUsuarioArray;
                    return isset($tipo[$model->tipo_usuario]) ? $tipo[$model->tipo_usuario] : $model->tipo_usuario;
                },
                'filter' => Html::activeDropDownList($searchModel, 'tipo_usuario', $searchModel->typeUsuarioArray, ['class' => 'form-control', 'prompt' => 'Todos']),
            ],
            [
                'attribute' => 'Created_at',
                'value' => 'Created_at', // Mostrar el valor de Created_at
                'filter' => Html::input('date', 'UserSearch[Created_at]', isset($searchModel->Created_at) ? $searchModel->Created_at : '', ['class' => 'form-control']),
            ],

            [
                'attribute' => 'Updated_at',
                'value' => 'Updated_at', // Mostrar el valor de Updated_at
                'filter' => Html::input('date', 'UserSearch[Updated_at]', isset($searchModel->Updated_at) ? $searchModel->Updated_at : '', ['class' => 'form-control']),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                'visible' => $userType === User::TYPE_ADMIN,
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-edit"></i>', $url, [
                            'title' => Yii::t('app', 'Actualizar'),
                            'class' => 'btn btn-primary', // Clase CSS para el botón de actualización
                            'data-pjax' => '0',

                        ]);
                    },
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'Ver'),
                            'class' => 'btn btn-info', // Clase CSS para el botón de vista
                            'data-pjax' => '0',

                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-trash"></i>', $url, [
                            'title' => Yii::t('app', 'Eliminar'),
                            'class' => 'btn bg-danger', // Clase CSS para el botón de eliminación
                            'data' => [
                                'confirm' => Yii::t('app', '¿Estás seguro de que quieres eliminar este elemento?'),
                                'method' => 'post',
                            ],
                        ]);
                    },


                ],
            ],
        ],
    ]); ?>


    <?php Pjax::end(); ?>

</div>

</div>