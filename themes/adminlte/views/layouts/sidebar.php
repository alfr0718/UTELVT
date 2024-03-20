<?php

use app\models\User;

$this->registerCssFile('@web/css/user-initial.css');

?>
<aside class="<?= $sidebarClass ?>">
    <!-- Brand Logo -->
    <a href="<?= \yii\helpers\Url::home() ?>" class="brand-link">
        <img src="<?= Yii::$app->urlManager->baseUrl ?>/img/ESCUDETO_UTE-LVT.png" alt="Universidad Luis Vargas Torres" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">UTELVT | Biblioteca</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!--img-circle elevation-2 Sidebar user panel (optional) -->
        <div class="user-panel  mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <?php if (!Yii::$app->user->isGuest) : ?>
                    <?php
                    $personalData = $userData->personaldata;
                    if ($personalData !== null) {
                        $nombre = $personalData->Nombres;
                        $apellido = $personalData->Apellidos;
                        $url = ['/personaldata/view', 'Ci' => $personalData->Ci];
                        $perfil = $personalData->Nombres;
                    }

                    // Acceder a datos de la tabla InformacionPersonal
                    $informacionEstudiante = $userData->informacionpersonal;
                    if ($informacionEstudiante !== null) {
                        $nombre = $informacionEstudiante->NombInfPer;
                        $apellido = $informacionEstudiante->ApellInfPer;
                        $perfil = $nombre . ' ' . $apellido;
                        $url = ['/informacionpersonal/view', 'CIInfPer' => $informacionEstudiante->CIInfPer];
                    }
                    // Acceder a datos de la tabla InformacionPersonalD
                    $informacionDocente = $userData->informacionpersonalD;
                    if ($informacionDocente !== null) {
                        $nombre = $informacionDocente->NombInfPer;
                        $apellido = $informacionDocente->ApellInfPer;
                        $perfil = $nombre . ' ' . $apellido;
                        $url = ['/informacionpersonald/view', 'CIInfPer' => $informacionDocente->CIInfPer];
                    }

                    $iniciales = substr($nombre, 0, 1) . substr($apellido, 0, 1);
                    echo '<div class="user-initials">' . $iniciales . '</div>';
                    ?>

                <?php else : ?>
                    <div class="user-initials">¿?</div>
                <?php endif; ?>
            </div>
            <div class="info">
                <?php if (!Yii::$app->user->isGuest) : ?>
                    <?= \yii\helpers\Html::a($perfil, $url) ?>
                <?php else : ?>
                    <a href="#">¿Cómo llegaste hasta aquí?</a>
                <?php endif; ?>
            </div>
        </div>

        <?php
        $commonMenuItems = [
            ['label' => 'Página Principal', 'icon' => 'fas fa-home', 'url' => ['/site/index']],
            ['label' => 'Libros', 'url' => ['/libro/index'], 'icon' => 'fas fa-book'],
            ['label' => 'Equipos', 'url' => ['/pc/index'], 'icon' => 'fas fa-desktop'],
        ];

        $adminMenuItems = [
            ['label' => 'Soporte Técnico', 'header' => true],
            ['label' => 'Usuarios', 'url' => ['/user/index'], 'icon' => 'fas fa-user'],
            ['label' => 'Restablecer Contraseña', 'url' => ['/user/reset-password'], 'icon' => 'fas fa-unlock-alt'],
            /*  [
                'label' => 'Registro de Personas',
                'icon' => 'fas fa-address-book',
                'items' => [
                    ['label' => 'Estudiantes', 'icon' => 'fas fa-user-graduate', 'url' => ['/informacionpersonal/index'],],
                    ['label' => 'Personal Universitario', 'icon' => 'far fa-user-tie', 'url' => ['/informacionpersonald/index'],],
                    ['label' => 'Personas Externas', 'icon' => 'far fa-id-card', 'url' => ['/personaldata/index'],],

                ]
            ], */
            [
                'label' => 'Roles y Permisos',
                'icon' => 'fas fa-users',
                'items' => [
                    ['label' => 'Rol', 'url' => ['/rbac/role'], 'target' => '_blank'],
                    ['label' => 'Asignación', 'url' => ['/rbac/assignment'], 'target' => '_blank'],
                    ['label' => 'Rutas', 'url' => ['/rbac/route'], 'target' => '_blank'],
                    ['label' => 'Permisos', 'url' => ['/rbac/permission'], 'target' => '_blank'],
                ]
            ],
            // Otros elementos específicos para administradores
        ];

        $personalMenuItems = [
            ['label' => 'Registro Bibliotecario', 'header' => true],
            ['label' => 'Solicitudes', 'url' => ['/prestamo/index'], 'icon' => 'fas fa-clipboard'],
            [
                'label' => 'Estadísticas',
                'icon' => 'fas fa-chart-area',
                'items' => [
                    ['label' => 'General', 'icon' => 'fas fa-chart-bar', 'url' => ['/estadistica/estadistica-general']],
                    ['label' => 'Estadística de Libros', 'icon' => 'fas fa-chart-pie', 'url' => ['/estadistica/index-libro']],
                ]
            ],
        ];

        $userType = $userData->tipo_usuario;
        // Selecciona el conjunto de menuItems según el tipo de usuario
        if ($userType === User::TYPE_PERSONALB || $userType === User::TYPE_GERENTE) {
            //personal
            $menuItems = array_merge($commonMenuItems, $personalMenuItems);
        } elseif ($userType === User::TYPE_ADMIN) {
            //adminitradores
            $menuItems = array_merge($commonMenuItems, $personalMenuItems, $adminMenuItems);
        } else {
            //usuarios comunes
            $menuItems = $commonMenuItems;
        }

        // Finalmente, pasa las variables definidas al widget de menú
        echo \hail812\adminlte\widgets\Menu::widget([
            'items' => $menuItems,
        ]);
        ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>