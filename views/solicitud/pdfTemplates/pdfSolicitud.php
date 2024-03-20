<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Préstamo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
        }

        /* Agrega cualquier otro estilo necesario */
    </style>

    
</head>

<?php $this->registerCssFile('@web/css/print.css', ['depends' => [yii\bootstrap4\BootstrapAsset::class]]);
?>
<body>
    
    <div class="container">


        <!-- Encabezado -->
        <div id="encabezado-impresion">
            <div id="encabezado-izquierda">
                <img src="/img/escudo_ecuador.png" alt="Escudo Ecuador" class="imagen-encabezado">
            </div>
            <div>
                <p>UNIVERSIDAD TÉCNICA LUIS VARGAS TORRES</p>
                <p><?= $model->bibliotecaIdbiblioteca->Campus ?> - Ecuador</p>
            </div>
            <div id="encabezado-derecha">
                <img src="/img/escudo_utelvt.png" alt="Escudo UTELVT" class="imagen-encabezado">
            </div>
        </div>
        <div class="linea-separadora"></div>
        <!-- Final encabezado -->


        <!-- Agrega más contenido según sea necesario -->
    </div>
</body>

</html>