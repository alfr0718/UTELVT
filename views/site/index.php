<?php

/** @var yii\web\View $this */
use app\models\PersonalData;
use app\models\User;


$this->title = 'Biblioteca General - UTELVT';
?>
    <div class="site-index">

        <?php if (Yii::$app->user->isGuest): ?>
    
            <h1 class="display-4">¡Bienvenido!</h1>
    
        <?php else: ?>
        
        <?php $userData = Yii::$app->user->identity->personaldata->Nombres; ?>
        
            <h1 class="display-4">¡Bienvenido, <?= $userData ?>!</h1>
    
        <?php endif; ?>

        <p class="lead">"Te deseamos una experiencia enriquecedora y llena de inspiración."</p>
        <?php if (!Yii::$app->user->isGuest): ?>
        <p><a class="btn btn-lg btn-success" href="<?= Yii::$app->urlManager->createUrl(['/prestamo/prestarespacio']) ?>">Registra tu visita</a></p>
        <?php endif; ?>
   
    </div>

    <div class="body-content">

    <div class="row">
        <div class="col-lg-4">
            <h2>¡Bienvenido a Nuestra Biblioteca Digital!</h2>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?php
                    $ciParam = Yii::$app->user->isGuest ? null : Yii::$app->user->identity->personaldata->Ci;
                    $url = ['/personaldata/update', 'Ci' => $ciParam];
                    ?>
                    <p>¡Gracias por ser parte de nuestra comunidad! Actualiza tus datos ahora para brindarte una experiencia aún mejor. </p>
                    <p><a class="btn btn-outline-secondary" href="<?= Yii::$app->urlManager->createUrl(['/personaldata/update']) ?>">Actualizar datos  &raquo;</a></p>
                <?php else: ?>
                    <p>¡Gracias por visitarnos! Para disfrutar de una experiencia aún mejor, te animamos a iniciar sesión.</p>
                    <p><a class="btn btn-outline-secondary" href="<?= Yii::$app->urlManager->createUrl(['/site/login']) ?>">Iniciar sesión  &raquo;</a></p>
                <?php endif; ?>
            
        </div>
        <div class="col-lg-4 mb-3">
            <h2>Catálogo de Libros</h2>

            <p>Explora nuestra amplia colección de libros. Sumérgete en el mundo de la literatura y descubre nuevas historias y conocimientos.</p>
            <?php // if (!Yii::$app->user->isGuest): ?>
                 <p><a class="btn btn-outline-secondary" href="<?= Yii::$app->urlManager->createUrl(['/libro/index']) ?>">Ver libros disponibles &raquo;</a></p>
            <?php // else: ?>
                <!-- <p><a class="btn btn-outline-secondary" href="<?= Yii::$app->urlManager->createUrl(['/site/login']) ?>">Iniciar sesión  &raquo;</a></p>-->
            <?php // endif; ?>
        </div>
    
        <div class="col-lg-4 mb-3">
            <h2>Solicitud de Préstamo</h2>

            <p>¿Necesitas un computador para tus tareas o proyectos? También ofrecemos la posibilidad de solicitar préstamo de computadoras.</p>

            <?php // if (!Yii::$app->user->isGuest): ?>
            <p><a class="btn btn-outline-secondary" href="<?= Yii::$app->urlManager->createUrl(['/pc/index']) ?>">Solicitar préstamo&raquo;</a></p>
            <?php // else: ?>
                <!-- <p><a class="btn btn-outline-secondary" href="<?= Yii::$app->urlManager->createUrl(['/site/login']) ?>">Iniciar sesión  &raquo;</a></p>-->
            <?php // endif; ?>
        </div>

    </div>
</div>

