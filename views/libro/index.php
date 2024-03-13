<?php

use app\models\Libro;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\LibroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Catálogo de Libros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libro-index">

    <?php Pjax::begin(); ?>
        <div class="card">
            <div class="card-header bg-teal">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-body">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>

    <?php if (!Yii::$app->user->isGuest) : ?>
        <?php $userType = Yii::$app->user->identity->tipo_usuario;
        if ($userType === User::TYPE_ADMIN || $userType === User::TYPE_PERSONALB) : ?>
            <?= $this->render(
                'indexOptions/bibliotecaGrid',
                ['dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'userType' => $userType]
            ); ?>

        <?php else : ?>
            <?= $this->render(
                'indexOptions/userGrid',
                ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]
            ); ?>
        <?php endif; ?>
    <?php endif; ?>


    <?php Pjax::end(); ?>
</div>