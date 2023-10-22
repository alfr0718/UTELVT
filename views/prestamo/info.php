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

                    <!-- <input type="text" name="anio" id="anio" value="<?php // = $anioSeleccionado ?>"> -->
                </div>

                <div class="form-group">
                    <label for="biblioteca">Biblioteca:</label>
                    <select id="biblioteca_idbiblioteca" name="biblioteca_idbiblioteca" class="form-control">
                        <option value="" selected>Seleccione Biblioteca</option>
                        <?php foreach ($bibliotecas as $biblioteca) : ?>
                            <option value="<?= $biblioteca->idbiblioteca ?>"><?= $biblioteca->Campus ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <button type="submit" class="btn btn-primary">Filtrar</button>
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
    var chartLibros = new Chart(ctxLibros, {
        type: 'bar',
        data: {
            labels: " . json_encode($labelsLibros) . ",
            datasets: [{
                label: 'Libros Más Solicitados',
                data: " . json_encode($dataLibros) . ",
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
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
    var chartComputadoras = new Chart(ctxComputadoras, {
        type: 'line',
        data: {
            labels: " . json_encode($labelsComputadoras) . ",
            datasets: [{
                label: 'Computadoras Más Solicitadas',
                data: " . json_encode($dataComputadoras) . ",
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
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