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

        <p><a class="btn btn-lg btn-success" href="<?= Yii::$app->urlManager->createUrl(['/prestamo/registro']) ?>">Registra tu visita</a></p>
    </div>

    <div class="body-content">
    <div class="row">
        <div class="col-lg-4">
            <h2>¡Bienvenido a Nuestra Biblioteca Digital!</h2>

            <p>¡Tu información es valiosa para nosotros! Si ha pasado un tiempo desde que actualizaste tus datos, te animamos a hacerlo ahora. Esto nos ayudará a brindarte una experiencia aún mejor. ¡Gracias por ser parte de nuestra comunidad!</p>

            <p><a class="btn btn-outline-secondary" href="<?= Yii::$app->urlManager->createUrl(['/personaldata/update']) ?>">Actualiza tus datos  &raquo;</a></p>
        </div>
        <div class="col-lg-4 mb-3">
            <h2>Catálogo de Libros</h2>

            <p>Explora nuestra amplia colección de libros. Sumérgete en el mundo de la literatura y descubre nuevas historias y conocimientos.</p>

           <p><a class="btn btn-outline-secondary" href="<?= Yii::$app->urlManager->createUrl(['/libro/index']) ?>">Ver libros disponibles &raquo;</a></p>
        </div>
        <div class="col-lg-4 mb-3">
            <h2>Solicitud de Préstamo</h2>

            <p>¿Necesitas libros para tus tareas o proyectos? También ofrecemos la posibilidad de solicitar préstamo de computadoras.</p>

        <p><a class="btn btn-outline-secondary" href="<?= Yii::$app->urlManager->createUrl(['/prestamo/create']) ?>">Solicitar préstamo&raquo;</a></p>
        </div>

    </div>
</div>

