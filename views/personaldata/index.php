<?php

use app\models\Personaldata;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Lista de Personas Externas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personaldata-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        $userType = null;

        if (!Yii::$app->user->isGuest) {
            // El usuario ha iniciado sesión, podemos acceder a 'tipo_usuario'
            $userType = Yii::$app->user->identity->tipo_usuario;

            if ($userType === User::TYPE_ADMIN) {
                echo Html::a('Agregar Persona Externa <i class="fas fa-user-plus"></i>', ['create'], ['class' => 'btn btn-success my-3']);
            }
        }
        ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>


    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
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
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'Ci',
                'Apellidos',
                'Nombres',
                'FechaNacimiento',
                //'Genero',
                'Institucion',
                'Nivel',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}', // Incluye los botones predeterminados además del nuevo botón
                    'visible' => $userType === User::TYPE_ADMIN,
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('<i class="fas fa-edit"></i>', $url, [
                                'title' => Yii::t('app', 'Actualizar'),
                                'class' => 'btn btn-info btn-sm', // Clase CSS para el botón de actualización
                            ]);
                        },
                        'view' => function ($url, $model, $key) {
                            return Html::a('<i class="fas fa-eye"></i>', $url, [
                                'title' => Yii::t('app', 'Ver'),
                                'class' => 'btn btn-primary btn-sm', // Clase CSS para el botón de vista
                            ]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('<i class="fas fa-trash"></i>', $url, [
                                'title' => Yii::t('app', 'Eliminar'),
                                'class' => 'btn bg-danger btn-sm', // Clase CSS para el botón de eliminación
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