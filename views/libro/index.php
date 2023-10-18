<?php

use app\models\Libro;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\LibroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Listado de Libros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libro-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $tipoUsuario = null; // Inicializamos la variable

    if (!Yii::$app->user->isGuest) {
        // El usuario ha iniciado sesión, podemos acceder a 'tipo_usuario'
        $tipoUsuario = Yii::$app->user->identity->tipo_usuario;

        if ($tipoUsuario === 8 || $tipoUsuario === 21) {
            echo Html::a('Ingresar Libro', ['create'], ['class' => 'btn btn-success my-3']); // Agregar la clase my-2 para espacio vertical
        }
    }
    ?>

    <?php $isDesktop = Yii::$app->request->userAgent && strpos(Yii::$app->request->userAgent, 'Mobile') === false; ?>

    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'codigo_barras',
            'titulo',
            'autor',
            [
                'attribute' => 'isbn',
                'visible' => $isDesktop,
            ],
            //'cute',
            //'editorial',
            //'anio_publicacion',
            //'estado',
            //'n_ejemplares',
            //'link',
            //'categoria_id',
            //'asignatura_id',
            //'pais_codigopais',
            //'biblioteca_idbiblioteca',
            [
                'attribute' => 'categoria_id',
                'visible' => $isDesktop,
                'value' => function ($model) {
                    return $model->categoria->Categoría;
                },

            ],
            [
                'attribute' => 'asignatura_id', // Esto muestra el código de la asignatura
                'visible' => $isDesktop,
                'value' => function ($model) {
                    return $model->asignatura->Nombre; // Accede al nombre de la asignatura relacionada
                },

            ],
            [
                'attribute' => 'pais_codigopais', // Esto muestra el código del país
                'visible' => $isDesktop,
                'value' => function ($model) {
                    return $model->paisCodigopais->Nombrepais; // Accede al nombre del país relacionado
                },

            ],
            [
                'attribute' => 'biblioteca_idbiblioteca', // Esto muestra el código de la biblioteca
                'value' => function ($model) {
                    return $model->bibliotecaIdbiblioteca->Campus; // Accede al nombre de la biblioteca
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{prestar} {otra-accion}', // Agrega otros botones personalizados si es necesario
                'buttons' => [
                    'prestar' => function ($url, $model, $key) {
                        $buttonId = 'open-modal-button-' . $model->id; // Id único para el botón
                        return Html::button('<i class="fas fa-plus"></i>', [
                            'class' => 'btn btn-success',
                            'id' => $buttonId, // Id único para cada botón
                            'data-toggle' => 'modal',
                            'data-target' => '#prestamo-modal',
                            'data-remote' => Url::to(['/prestamo/prestarlibro', 'id' => $model->id]), // URL de la acción
                        ]);
                    },
                ],
            ],

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Libro $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]);
                },
                'visible' => $tipoUsuario === 8 || $tipoUsuario === 21,
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>


<div class="modal fade" id="prestamo-modal" tabindex="-1" role="dialog" aria-labelledby="prestamo-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="prestamo-modal-label">Préstamo de Libro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenido del modal cargado a través de AJAX -->
                <div id="prestamo-modal-content"></div>
            </div>
        </div>
    </div>
</div>

<?php
// Registro de JS para manejar la apertura del modal
$this->registerJs('
    $("button[id^=open-modal-button]").on("click", function () {
        $("#prestamo-modal-content").load($(this).data("remote"), function() {
            // Una vez que se carga el contenido en el modal, escuchamos el evento clic del botón "Enviar".
            $("#prestamo-modal-content #submit-button").on("click", function (e) {
                e.preventDefault(); // Prevenir el envío automático del formulario
                // Aquí puedes realizar validaciones del formulario si es necesario
                // Si las validaciones son exitosas, puedes enviar el formulario con AJAX

                $.ajax({
                    type: "POST",
                    url: "/prestamo/prestarlibro", // Reemplaza con la URL correcta
                    data: $("#prestamo-formulario").serialize(), // Reemplaza "tu-formulario" con el ID de tu formulario
                    success: function (data) {
                        // Manejar la respuesta si es necesario
                    }
                });
            });
        });
    });
');
?>