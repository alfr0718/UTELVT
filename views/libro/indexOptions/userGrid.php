<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<style>
    .card-hover:hover {
        /* Agrega una transición suave al efecto */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        /* Agrega una sombra más suave */
        background-color: #f8f9fa;
        /* Cambia el color de fondo a un tono más claro */
    }
</style>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'showHeader' => false,
    'tableOptions' => ['class' => 'table'],
    'pager' => [
        'options' => ['class' => 'pagination justify-content-center'],
        'maxButtonCount' => 5,
        'prevPageLabel' => 'Anterior',
        'nextPageLabel' => 'Siguiente',
        'prevPageCssClass' => 'page-item',
        'nextPageCssClass' => 'page-item',
        'linkOptions' => ['class' => 'page-link'],
        'activePageCssClass' => 'page-item active',
        'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
        // Personalizar el enlace de la primera página 'firstPageLabel' => 'Primera', 
        // Personalizar el enlace de la última página 'lastPageLabel' => 'Última', 
        'hideOnSinglePage' => true,
    ],
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'], //CONTADOR
        [
            'attribute' => 'TarjetaInformación',
            'format' => 'raw',
            'value' => function ($model) {

                $coverUrl = Yii::getAlias('@web');

                if (!isset($model->cover) || $model->cover == '') {
                    $coverUrl .= '/cover/default-cover.jpg';
                } else {
                    $coverPath = Yii::getAlias('@webroot') . '/cover/' . $model->cover;
                    if (file_exists($coverPath)) {
                        $coverUrl .= '/cover/' . $model->cover;
                    } else {
                        // Si la imagen no existe, utilizamos la imagen por defecto
                        $coverUrl .= '/cover/default-cover.jpg';
                    }
                }

                $buttonId = 'open-modal-button-' . $model->id;


                $cardContent = '<div class="card card-hover">'; // Inicia la tarjeta

                // Inicia el cuerpo de la tarjeta
                $cardContent .= '<div class="card-body">';

                // Columna para los detalles del libro
                $cardContent .= '<div class="row align-items-center">'; // Inicia una fila para las columnas
                // Columna para la categoría y la sección
                $cardContent .= '<div class="col-md-2 col-6 text-center">'; // Inicia la primer columna
                $cardContent .= '<img src="' . $coverUrl . '" class="img-fluid img-thumbnail mb-2" 
                style="max-width: 100%; max-height: 200px;" alt="Imagen del libro" 
                onclick="showLibroStep1Modal(' . $model->id . ', \'' . Url::to(['/solicitud/indice-ejemplares']) . '\')"
                >';
                
                $cardContent .= '<div>';
                $cardContent .= Html::button('<i class="fas fa-share"></i>', [
                    'title' => Yii::t('app', 'Solicitar Libro'),
                    'class' => 'btn bg-teal',
                    'id' => $buttonId,
                    'onclick' => 'showLibroStep1Modal(' . $model->id . ', "' . Url::to(['/solicitud/indice-ejemplares']) . '")',
                ]);
                $cardContent .= '</div>';

                $cardContent .= '</div>'; // Cierra la primer columna

                $cardContent .= '<div class="col-md-2 col-6">'; // Inicia la segunda columna
                $cardContent .= '<p><strong><h5 class="color-info">' . (isset($model->titulo) ? $model->titulo : 'N/A') . '</h5>'; // Título del libro
                $cardContent .= '(' . (isset($model->anio_publicacion) ? $model->anio_publicacion : 'N/A') . ')</p></strong>'; // Año de publicación
                $cardContent .= '<p><strong>Autor:</strong> ' . (isset($model->autor) ? $model->autor : 'N/A') . '</p>'; // Autor del libro
                $cardContent .= '<p><strong>Editorial:</strong> ' . (isset($model->editorial) ? $model->editorial : 'N/A') . '</p>'; // Editorial del libro
                $cardContent .= '<p><strong>ISBN:</strong> ' . (isset($model->isbn) ? $model->isbn : 'N/A') . '</p>'; // ISBN del libro
                $cardContent .= '<p><strong>Sección:</strong> ' . (isset($model->seccion) ? $model->seccion->NombreSeccion : 'N/A') . '</p>'; // Sección del libro
                $cardContent .= '</div>'; // Cierra la segunda columna

                $cardContent .= '<div class="col-md-2 col-6">'; // Inicia la segunda columna


                $cardContent .= '</div>'; // Cierra la segunda columna

                $cardContent .= '</div>'; // Cierra la fila

                $cardContent .= '</div>'; // Cierra el cuerpo de la tarjeta

                $cardContent .= '</div>'; // Cierra la tarjeta

                return $cardContent; // Retorna el contenido de la tarjeta
            },
        ],

    ],

]); ?>