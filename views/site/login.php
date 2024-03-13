<?php

use hail812\adminlte3\assets\PluginAsset;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

\hail812\adminlte3\assets\AdminLteAsset::register($this);

$this->title = 'Iniciar Sesión | Biblioteca';

PluginAsset::register($this)->add('icheck-bootstrap');

$this->registerCssFile('@web/css/login.css', ['depends' => [yii\bootstrap4\BootstrapAsset::class]]);

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-4 col-lg-5 col-sm-3">

            <div class="card">

                <div class="login-logo">
                    <a href="https://www.utelvt.edu.ec/site/">
                        <img src="<?= Yii::$app->urlManager->baseUrl ?>/img/utlvt-header.png" alt="UTLVT HEADER" class="img-fluid">
                    </a>
                </div>
            </div>



            <div class="card">

                <div class="card-body">


                    <p class="text-center registro-title">Biblioteca</p>

                    <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>
                    <div class="login-card-body">

                        <?= $form->field($model, 'username', [
                            'options' => ['class' => 'form-group has-feedback'],
                            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text rounded-right"><span class="fas fa-user"></span></div></div>',
                            'template' => '{beginWrapper}{input}{error}{endWrapper}',
                            'wrapperOptions' => ['class' => 'input-group mb-3']
                        ])
                            ->label(false)
                            ->textInput(['placeholder' => $model->getAttributeLabel('username'), 'class' => 'form-control']) ?>

                        <?= $form->field($model, 'password', [
                            'options' => ['class' => 'form-group has-feedback'],
                            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text rounded-right"><span class="fas fa-key"></span></div></div>',
                            'template' => '{beginWrapper}{input}{error}{endWrapper}',
                            'wrapperOptions' => ['class' => 'input-group mb-3']
                        ])
                            ->label(false)
                            ->passwordInput(['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('password')]) ?>

                        <div class="row">
                            <div class="col-4">
                                <?= $form->field($model, 'rememberMe')->checkbox([
                                    'template' => '<div class="icheck-primary">{input}{label}</div>',
                                    'labelOptions' => [
                                        'class' => ''
                                    ],
                                    'uncheck' => null
                                ]) ?>
                            </div>

                        </div>

                        <?= Html::submitButton('<b>Iniciar Sesión</b>', ['class' => 'btn btn-primary btn-block']) ?>

                    </div>



                    <p class="text-center">
                        <a href="<?= Url::to(['site/signup']) ?>">¿Aún no formas parte de esta comunidad? ¡Únete!</a>
                    </p>

                    <?php ActiveForm::end(); ?>

                </div>

                <!-- /.login-card-body -->
            </div>
        </div>
    </div>
</div>
</div>