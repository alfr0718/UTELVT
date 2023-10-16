
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/site/index" class="brand-link">
        <img src="<?= Yii::$app->urlManager->baseUrl ?>/img/ESCUDETO_UTE-LVT.png" alt="Universidad Luis Vargas Torres" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">UTELVT | Biblioteca</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!--img-circle elevation-2 Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php if (!Yii::$app->user->isGuest) : ?>
                    <?php
                        $user = Yii::$app->user->identity;
                        $nombre = $user->personaldata->Nombres;
                        $apellido = $user->personaldata->Apellidos;
                        $iniciales = substr($nombre, 0, 1) . substr($apellido, 0, 1);
                        echo '<div class="user-initials">' . $iniciales . '</div>';
                    ?>
                    <?php else : ?>
                    <div class="user-initials">¿?</div>
                    <?php endif; ?>
          </div>
            <div class="info">
                <?php if (!Yii::$app->user->isGuest) : ?>
                    <?= \yii\helpers\Html::a(Yii::$app->user->identity->personaldata->Nombres, // Nombre del usuario actual
                ['/personaldata/view', 'Ci' => Yii::$app->user->identity->personaldata->Ci]) ?>
                 <?php else : ?>
                    <a href="#">¿Qué estas haciendo aquí?</a> <!-- O el texto que desees para usuarios no autenticados -->
                <?php endif; ?>
    </div>
</div>

<?php
    $commonMenuItems = [
        ['label' => 'Página Principal', 'icon' => 'fas fa-home', 'url' => ['/site/index']],
        ];

    $adminMenuItems = [
        ['label' => 'ADMIN', 'header' => true],
        ['label' => 'Usuarios', 'url' => ['/user/index'], 'icon' => 'fas fa-user'],
        ['label' => 'Personas Naturales', 'url' => ['/personaldata/index'], 'icon' => 'fas fa-address-card'],
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
        ['label' => 'Personal', 'header' => true],
        ['label' => 'Libros', 'url' => ['/libro/index'], 'icon' => 'fas fa-book'],
        ['label' => 'PC', 'url' => ['/pc/index'], 'icon' => 'fas fa-desktop'],
        ['label' => 'Préstamos', 'url' => ['/prestamo/index'], 'icon' => 'fas fa-clipboard'],
        // Otros elementos específicos para personal
    ];
    
    $userType = $user->tipo_usuario;
    // Selecciona el conjunto de menuItems según el tipo de usuario
    if ($userType === 21 || $userType === 7 ) {
        //personal
        $menuItems = array_merge($commonMenuItems, $personalMenuItems);
    } elseif ($userType === 8) {
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