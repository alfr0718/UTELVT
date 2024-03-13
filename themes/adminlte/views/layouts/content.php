<!-- Verificar si el usuario está autenticado -->
<?php

use yii\bootstrap5\Html;
use hail812\adminlte3\assets\PluginAsset;

PluginAsset::register($this)->add('sweetalert2');

?>
<?php
// Definir los tipos de flash y sus correspondientes títulos SweetAlert
$sweetAlertType = [
    'success' => 'Enhorabuena <i class="far fa-laugh-beam"></i>',
    'error' => 'Error <i class="far fa-sad-cry"></i>',
    'warning' => 'Cuidado <i class="fas fa-surprise"></i>',
    'info' => 'Detalles',
    'question' => 'Curioso',
];

// Iterar sobre los tipos de flash
foreach ($sweetAlertType as $flashType => $messageTitle) {
    // Mostrar el mensaje SweetAlert si existe
    if (Yii::$app->session->hasFlash($flashType)) {
        // Escapar el mensaje flash para evitar problemas de seguridad
        $message = addslashes(Yii::$app->session->getFlash($flashType));

        $this->registerJs("Swal.fire({
                                    icon: '$flashType',
                                    text: '$message',
                                    title: '$messageTitle'
                                    });
                                ");
    }
}
?>
<?php if (Yii::$app->user->isGuest) : ?>
    <!-- Si el usuario es un invitado (no ha iniciado sesión), muestra solo el contenido del login -->

    <div class="container-fluid">
        <!-- Espacio en blanco antes del login (puede ajustar el tamaño aquí) -->
        <?= $content ?>
    </div>


<?php else : ?>
    <div class="content-wrapper">

        <!-- Si el usuario está autenticado, muestra el menú y el contenido principal -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <!-- Botón de regresar -->

                    </div><!-- /.col -->

                    <div class="col-sm-6">


                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->



        <!-- Main content -->
        <div class="content">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-10 col-md-11 col-lg-11 col-xl-11">

                    <?= $content ?>
                </div>
            </div>
        </div>
        <!-- /.content -->



    </div>
<?php endif; ?>