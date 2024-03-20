<!-- Navbar -->
<?php

use yii\helpers\Html;

$jsFilePath = '@web/js/logout-modal.js';
$this->registerJsFile($jsFilePath, ['depends' => [\yii\web\JqueryAsset::class]]);

?>

<nav class="<?= $navbarClass ?>">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= \yii\helpers\Url::home() ?>" class="nav-link"><i class="fas fa-home"></i>&nbsp;&nbsp; Inicio</a>
        </li>

        <li class="nav-item d-inline-block d-sm-none">
            <a href="<?= \yii\helpers\Url::home() ?>" class="nav-link"><i class="fas fa-home"></i></a>
        </li>


        <li class="nav-item dropdown d-none d-sm-inline-block">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"> <i class="fas fa-clock"></i>&nbsp;&nbsp; Horarios de Atención</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <li><a href="<?= \yii\helpers\Url::to(['/biblioteca/view?idbiblioteca=1']) ?>" class="dropdown-item">Esmeraldas</a></li>
                <li class="dropdown-divider"></li>
                <li><a href="<?= \yii\helpers\Url::to(['/biblioteca/view?idbiblioteca=3']) ?>" class="dropdown-item">Mutiles</a></li>
                <li class="dropdown-divider"></li>
                <li><a href="<?= \yii\helpers\Url::to(['/biblioteca/view?idbiblioteca=2']) ?>" class="dropdown-item">La Concordia</a></li>
            </ul>
        </li>


        <li class="nav-item dropdown d-inline-block d-sm-none">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"> <i class="fas fa-clock"></i></a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <li><a href="<?= \yii\helpers\Url::to(['/biblioteca/view?idbiblioteca=1']) ?>" class="dropdown-item">Esmeraldas</a></li>
                <li class="dropdown-divider"></li>
                <li><a href="<?= \yii\helpers\Url::to(['/biblioteca/view?idbiblioteca=3']) ?>" class="dropdown-item">Mutiles</a></li>
                <li class="dropdown-divider"></li>
                <li><a href="<?= \yii\helpers\Url::to(['/biblioteca/view?idbiblioteca=2']) ?>" class="dropdown-item">La Concordia</a></li>
            </ul>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Formulario para Búsqueda de Libro por Título -->

        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline" action="<?= \yii\helpers\Url::to(['libro/index']) ?>" method="get">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Buscar Libro por Título..." aria-label="Search" name="LibroSearch[titulo]">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>




        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= \yii\helpers\Url::to(['/site/about']) ?>" class="nav-link"><i class="far fa-question-circle"></i></a>
        </li>

        <li class="nav-item d-inline-block d-sm-none">
            <a href="<?= \yii\helpers\Url::to(['/site/about']) ?>" class="nav-link"><i class="far fa-question-circle"></i></a>
        </li>

        <li class="nav-item">
            <?= Html::a(
                '<i class="fas fa-sign-out-alt"></i>',
                'javascript:void(0)',
                [
                    'class' => 'nav-link',
                    'onclick' => 'showLogoutModal(); return false;'
                ]
            ) ?>



        </li>

        <!--<li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>-->


    </ul>
</nav>
<!-- /.navbar -->



<div class="modal fade" id="logout-modal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-teal">
                <h4 class="modal-title text-white"> Es una pena que tengas que partir...

                </h4>
            </div>
            <div class="modal-body text-center">
                ¿Estás seguro de que deseas cerrar la sesión?
                <!-- Y como le dije a mi ex. Te extrañaremos... -->
            </div>
            <div class="modal-footer justify-content-center">
                <?= Html::a(
                    'Cerrar Sesión &nbsp;&nbsp;<i class="fas fa-sign-out-alt"></i>',
                    '/site/logout', // JavaScript void(0) para evitar redireccionamiento
                    [
                        'class' => 'btn btn-primary', // CSS class para el estilo
                        'data-method' => 'post',
                    ]
                ) ?>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar &nbsp;&nbsp;<i class="fas fa-times"></i></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>