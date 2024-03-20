<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use hail812\adminlte3\assets\PluginAsset;


PluginAsset::register($this)->add('chart-js');

/* @var $this yii\web\View */
/* @var $mesSeleccionado string */
/* @var $anioSeleccionado string */
/* @var $books array */
/* @var $computadoras array */
/* @var $tiposPrestamo array */
/* @var $bibliotecas array */

$this->title = 'Estadísticas Generales';
$this->params['breadcrumbs'][] = $this->title;

$labelsLibros = [];
$dataLibros = [];

foreach ($books as $item) {
    $labelsLibros[] = $item['libro'];
    $dataLibros[] = $item['cantidad'];
}

$labelsComputadoras = [];
$dataComputadoras = [];

foreach ($computadoras as $item) {
    $labelsComputadoras[] = $item['computadora'];
    $dataComputadoras[] = $item['cantidad'];
}


$labelsPrestamos = [];
$dataPrestamos = [];

foreach ($tiposPrestamo as $item) {
    $labelsPrestamos[] = $item['nombre'];
    $dataPrestamos[] = $item['cantidad'];
}

?>


<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-body">
                <h5>Filtrar por Mes y Año:</h5>

                <?php $form = ActiveForm::begin(['method' => 'get']); ?>

                <div class="form-group">
                    <label for="mes">Mes:</label>
                    <select name="mes" class="form-control">
                        <?php
                        $meses = [
                            '01' => 'Enero',
                            '02' => 'Febrero',
                            '03' => 'Marzo',
                            '04' => 'Abril',
                            '05' => 'Mayo',
                            '06' => 'Junio',
                            '07' => 'Julio',
                            '08' => 'Agosto',
                            '09' => 'Septiembre',
                            '10' => 'Octubre',
                            '11' => 'Noviembre',
                            '12' => 'Diciembre',
                        ];
                        foreach ($meses as $mesNumero => $mesNombre) {
                            echo '<option value="' . $mesNumero . '"';
                            if ($mesNumero == $mesSeleccionado) {
                                echo ' selected';
                            }
                            echo '>' . $mesNombre . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="anio">Año:</label>
                    <?= Html::textInput('anio', $anioSeleccionado, ['class' => 'form-control', 'placeholder' => 'Ingrese el año']); ?>
                </div>

                <div class="form-group">
                    <label for="biblioteca_idbiblioteca">Biblioteca:</label>
                    <?= Html::dropDownList(
                        'biblioteca_idbiblioteca',
                        $bibliotecaSeleccionada,
                        \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
                        ['prompt' => 'Todos', 'class' => 'form-control']
                    ) ?>

                </div>
                <div class="form-group">
                    <?= Html::submitButton('<i class="fas fa-chart-bar"></i> Generar', ['class' => 'btn btn-primary']) ?>
                    <?= Html::button('<i class="fas fa-eraser"></i>', ['class' => 'btn btn-outline-secondary', 'onclick' => 'window.location.href = "' . Yii::$app->urlManager->createUrl(['estadistica/info']) . '"']) ?>

                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Solicitudes de Préstamos</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="table-responsive">
                            <?= GridView::widget([
                                'summary' => false,
                                'dataProvider' => new \yii\data\ArrayDataProvider([
                                    'allModels' => $tiposPrestamo,
                                ]),
                                'columns' => [
                                    ['attribute' => 'nombre', 'label' => 'Tipo'],
                                    ['attribute' => 'cantidad', 'label' => 'Cantidad'],
                                ],
                            ]); ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <canvas id="chartPrestamos" style="height: 250px;"></canvas>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Libros Más Solicitados</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="chartLibros" style="height: 250px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Equipos Más Solicitados</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <canvas id="chartComputadoras" style="height: 250px;"></canvas>
            </div>
        </div>
    </div>
</div>

<?php
// Código JavaScript para crear los gráficos con Chart.js
$this->registerJs("
    var ctxPrestamos = document.getElementById('chartPrestamos').getContext('2d');
    var colores = [
    'rgba(41, 128, 185, 0.5)',   // Azul
    'rgba(39, 174, 96, 0.5)',   // Verde
        'rgba(231, 76, 60, 0.5)'    // Granate
];
    var chartPrestamos = new Chart(ctxPrestamos, {
        type: 'doughnut',
        data: {
            labels: " . json_encode($labelsPrestamos) . ",
            datasets: [{
                label: 'Préstamos',
                data: " . json_encode($dataPrestamos) . ",
                backgroundColor: colores,
                borderColor: colores,
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                 position: 'bottom'
                }
            }
        }
    });
    
    
    var ctxLibros = document.getElementById('chartLibros').getContext('2d');
    var coloresCalidos = [
    'rgba(231, 76, 60, 0.5)',    // Granate
    'rgba(217, 30, 24, 0.5)',    // Rojo oscuro
    'rgba(192, 57, 43, 0.5)',    // Rojo intenso
    'rgba(231, 111, 81, 0.5)',   // Rojo salmón
    'rgba(203, 67, 53, 0.5)',    // Rojo pálido
    'rgba(242, 120, 75, 0.5)',   // Naranja intenso
    'rgba(245, 171, 53, 0.5)',   // Naranja vivo
    'rgba(211, 84, 0, 0.5)',     // Naranja oscuro
    'rgba(241, 196, 15, 0.5)',   // Amarillo oscuro
    'rgba(244, 208, 63, 0.5)'    // Amarillo intenso
    ];
    var chartLibros = new Chart(ctxLibros, {
        type: 'bar',
        data: {
            labels: " . json_encode($labelsLibros) . ",
            datasets: [{
                label: 'Libros Más Solicitados',
                data: " . json_encode($dataLibros) . ",
                backgroundColor: coloresCalidos,
                borderColor: coloresCalidos,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctxComputadoras = document.getElementById('chartComputadoras').getContext('2d');
    var coloresFrios = [
    'rgba(52, 152, 219, 0.5)',   // Azul claro
    'rgba(44, 130, 201, 0.5)',   // Azul medio
    'rgba(38, 97, 156, 0.5)',    // Azul oscuro
    'rgba(90, 200, 250, 0.5)',   // Azul agua
    'rgba(142, 196, 221, 0.5)',  // Azul pálido
    'rgba(115, 185, 190, 0.5)',  // Azul verdoso
    'rgba(79, 193, 233, 0.5)',   // Azul celeste
    'rgba(93, 173, 226, 0.5)',   // Azul pastel
    'rgba(72, 126, 176, 0.5)',   // Azul acero
    'rgba(68, 108, 179, 0.5)'    // Azul intenso
    ];
    var chartComputadoras = new Chart(ctxComputadoras, {
        type: 'bar',
        data: {
            labels: " . json_encode($labelsComputadoras) . ",
            datasets: [{
                label: 'Equipos Más Solicitados',
                data: " . json_encode($dataComputadoras) . ",
                backgroundColor: coloresFrios,
                borderColor: coloresFrios,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
");
?>