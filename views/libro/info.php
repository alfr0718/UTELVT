<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Libros por Asignatura';
$this->params['breadcrumbs'][] = $this->title;
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="libro-info">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-3">
            <?php $form = ActiveForm::begin(); ?>

            <div class="form-group">
                <label for="mes">Mes</label>
                <select id="mes" name="mes" class="form-control">
                    <option value="" selected>Seleccione Mes</option>
                    <?php foreach ($meses as $value => $label) : ?>
                        <option value="<?= $value ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="anio">Año</label>
                <select id="anio" name="anio" class="form-control">
                    <option value="" selected>Seleccione Año</option>
                    <?php foreach ($anios as $anio) : ?>
                        <option value="<?= $anio ?>"><?= $anio ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="asignatura">Asignatura</label>
                <select id="asignatura" name="asignatura" class="form-control">
                    <option value="" selected>Seleccione Asignatura</option>
                    <?php foreach ($asignaturas as $value => $label) : ?>
                        <option value="<?= $value ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="biblioteca">Biblioteca</label>
                <select id="biblioteca" name="biblioteca" class="form-control">
                    <option value="" selected>Seleccione Biblioteca</option>
                    <?php foreach ($bibliotecas as $biblioteca) : ?>
                        <option value="<?= $biblioteca['idbiblioteca'] ?>"><?= $biblioteca['Campus'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group text-center">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-9">
            <?php if (!empty($topBooksByAsignatura)) : ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Libro</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($topBooksByAsignatura as $item) : ?>
                            <tr>
                                <td><?= $item['libro'] ?></td>
                                <td><?= $item['cantidad'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p class="text-center">No se encontraron resultados.</p>
            <?php endif; ?>
            <div class="chart-container" style="position: relative; height:400px; width:100%">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chartData = <?= json_encode($chartData) ?>;

    var myChart = new Chart(ctx, {
        type: 'bar', // Tipo de gráfica (puedes ajustarlo)
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Cantidad',
                data: chartData.data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
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
</script>