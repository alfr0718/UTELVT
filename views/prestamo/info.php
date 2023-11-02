<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $mesSeleccionado string */
/* @var $anioSeleccionado string */
/* @var $books array */
/* @var $computadoras array */
/* @var $tiposPrestamo array */
/* @var $bibliotecas array */

$this->title = 'Estadísticas';
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

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Filtrar por Mes y Año</h3>
            </div>
            <div class="card-body">
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
                        ['prompt' => 'Seleccione el Campus', 'class' => 'form-control']
                    ) ?>

                </div>
                <div class="form-group">
                    <?= Html::submitButton('<i class="fas fa-chart-bar"></i> Generar', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tipos de Préstamo</h3>
            </div>
            <div class="card-body">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $tiposPrestamo,
                    ]),
                    'columns' => [
                        ['attribute' => 'nombre', 'label' => 'Tipo de Préstamo'],
                        ['attribute' => 'cantidad', 'label' => 'Cantidad'],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Libros Más Solicitados</h3>
            </div>
            <div class="card-body">
                <canvas id="chartLibros" style="height: 250px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Computadoras Más Solicitadas</h3>
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
        type: 'line',
        data: {
            labels: " . json_encode($labelsComputadoras) . ",
            datasets: [{
                label: 'Computadoras Más Solicitadas',
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