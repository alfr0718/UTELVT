<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\User;
use yii\helpers\Html;


\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback');


$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

$publishedRes = Yii::$app->assetManager->publish('@vendor/hail812/yii2-adminlte3/src/web/js');
$this->registerJsFile($publishedRes[1] . '/control_sidebar.js', ['depends' => '\hail812\adminlte3\assets\AdminLteAsset']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<?php
$bodyClass = "sidebar-collapse layout-fixed layout-navbar-fixed sidebar-closed";
$sidebarClass = "main-sidebar sidebar-light-teal elevation-4";
$navbarClass = "main-header navbar navbar-expand navbar-white navbar-light";
$userData = NULL;
if (!Yii::$app->user->isGuest) {
    $cacheKey = 'user_' . Yii::$app->user->id;
    $userData = Yii::$app->cache->get($cacheKey);

    if ($userData === false) {
        // Los datos del usuario no están en caché, obtén los datos de la base de datos o de donde corresponda
        $userData = Yii::$app->user->identity;
        // Almacena los datos del usuario en la caché por un período de tiempo específico (por ejemplo, 3600 segundos o 1 hora)
        Yii::$app->cache->set($cacheKey, $userData, 3600);
    }

    if ($userData->tipo_usuario === User::TYPE_ADMIN || $userData->tipo_usuario === User::TYPE_GERENTE || $userData->tipo_usuario === User::TYPE_PERSONALB) {
        $bodyClass = "sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed dark-mode";
        $sidebarClass = "main-sidebar sidebar-dark-teal elevation-4";
        $navbarClass = "main-header navbar navbar-expand navbar-gray navbar-dark";
    }
}

?>

<body class="<?= $bodyClass ?>">
    <?php $this->beginBody() ?>

    <div class="wrapper">

        <?php if (!Yii::$app->user->isGuest) : ?>
            <?= $this->render('navbar', ['assetDir' => $assetDir, 'userData' => $userData, 'navbarClass' => $navbarClass]) ?>
            <?= $this->render('sidebar', ['assetDir' => $assetDir, 'userData' => $userData, 'sidebarClass' => $sidebarClass]) ?>
        <?php endif; ?>

        <!-- Content Wrapper. Contains page content -->
        <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir, 'userData' => $userData]) ?>
        <!-- /.content-wrapper -->



        <!-- Control Sidebar -->

        <?php if (!Yii::$app->user->isGuest) : ?>
            <?php if ($userData->tipo_usuario === User::TYPE_ADMIN) : ?>
                <?= $this->render('control-sidebar') ?>
            <?php endif; ?>
        <?php endif; ?>

        <!-- /.control-sidebar -->

    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>