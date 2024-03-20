<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use hail812\adminlte3\assets\PluginAsset;


PluginAsset::register($this)->add('chart-js');
$this->title = 'Libros Más Solicitados: ' .($fechaInicio ? $fechaInicio: '').' / '.($fechaFin ? $fechaFin : '') ;
$this->params['breadcrumbs'][] = $this->title;

$asignaturasConLibros = \app\models\Asignatura::find()
    ->where(['IN', 'IdAsig', \app\models\Libro::find()->select('asignatura_IdAsig')->distinct()])
    ->orderBy(['NombAsig' => SORT_ASC])
    ->all();

?>

<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

<div class="libro">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Generador Estadístico por Fechas</h3>

                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['method' => 'get']); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= Html::input('date', 'fechaInicio', $fechaInicio, ['class' => 'form-control']); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= Html::input('date', 'fechaFin', $fechaFin, ['class' => 'form-control']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= Html::dropDownList(
                                    'bibliotecaId',
                                    $bibliotecaSeleccionada,
                                    \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
                                    ['prompt' => 'Todos', 'class' => 'form-control']
                                ) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <?= Html::dropDownList(
                                    'asignaturaId',
                                    $asignaturaSeleccionada,
                                    \yii\helpers\ArrayHelper::map(
                                        $asignaturasConLibros,
                                        'IdAsig',
                                        'NombAsig'
                                    ),
                                    ['prompt' => 'Todas', 'class' => 'form-control']
                                ) ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('<i class="fas fa-chart-pie"></i> Generar', ['class' => 'btn btn-primary']) ?>
                        <?= Html::button('<i class="fas fa-eraser"></i>', ['class' => 'btn btn-outline-secondary', 'onclick' => 'window.location.href = "' . Yii::$app->urlManager->createUrl(['estadistica/asignatura-libro-inicio-fin']) . '"']) ?>

                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class=col-md-6>
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Informe de Solicitudes de Libros</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Título del Libro</th>
                                <th>Total de Solicitudes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($librosMasSolicitados as $libro) : ?>
                                <tr>
                                    <td><?= $libro['titulo'] ?></td>
                                    <td><?= $libro['total'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Top 10 Libros Más Solicitados</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="graficaLibrosMasSolicitados" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>


</div>

<?php
$this->registerJs("
    var ctx = document.getElementById('graficaLibrosMasSolicitados').getContext('2d');
    var colores = [
    'rgba(255, 99, 132, 0.5)',   // Rojo
    'rgba(54, 162, 235, 0.5)',   // Azul
    'rgba(255, 206, 86, 0.5)',   // Amarillo
    'rgba(75, 192, 192, 0.5)',   // Verde agua
    'rgba(153, 102, 255, 0.5)',  // Púrpura
    'rgba(255, 159, 64, 0.5)',   // Naranja
    'rgba(231, 76, 60, 0.5)',    // Granate
    'rgba(46, 204, 113, 0.5)',   // Verde esmeralda
    'rgba(52, 152, 219, 0.5)',   // Azul claro
    'rgba(241, 196, 15, 0.5)'    // Amarillo oscuro
    ];
    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: " . json_encode($chartData['labels']) . ",
            datasets: [{
                label: 'Libros más solicitados',
                data: " . json_encode($chartData['data']) . ",
                backgroundColor: colores, // Asignar los colores al conjunto de datos
                borderColor: colores,
                borderWidth: 1
            }]
        },
    });
");
?>