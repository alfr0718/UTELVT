<?php
/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Acerca de Nosotros';
$this->params['breadcrumbs'][] = $this->title;

// Estilos CSS personalizados
$this->registerCss("
.site-about {
    padding: 30px 0;
    color: #333;
    transition: background-color 0.3s;
}

.site-about:hover {
    background-color: #FAFAFA;
}

.site-about h1 {
    font-size: 2.5em;
    margin: 20px 0;
}

.site-about p {
    font-size: 1.2em;
    margin-bottom: 20px;
}

.site-about .btn-success,
.site-about .btn-primary {
    font-size: 1.2em;
    padding: 15px 20px;
    background-color: #5EB400;
    border: none;
    color: #FFF;
    transition: background-color 0.3s, transform 0.2s;
    margin: 10px;
}

.site-about .btn-success:hover,
.site-about .btn-primary:hover {
    background-color: #4E9A00;
    transform: scale(1.05);
}

.container {
    max-width: 960px;
    margin: 0 auto;
}

.section {
    background-color: #FFF;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s, box-shadow 0.2s; /* Agregado efecto de transformación y sombra al pasar el mouse */
}

.section:hover {
    transform: scale(1.05); /* Efecto de sobresaltado al pasar el mouse */
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2); /* Aumentar la sombra al pasar el mouse */
}

.section h2 {
    font-size: 2em;
    margin-bottom: 15px;
    color: #333;
}

");

?>

<div class="site-about container">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="section">
        <h2>El esfuerzo del estudiantado de Tecnologías de la Información</h2>
        <p>
            El sistema que estás utilizando es el resultado del arduo esfuerzo del estudiantado de Tecnologías de la Información. Nuestro objetivo es proporcionar una solución eficiente y de alta calidad para tus necesidades. Si tienes alguna pregunta o sugerencia, no dudes en contactarnos.
        </p>
    </div>
</div>
