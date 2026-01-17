<div class="app-menu">
    <ul class="accordion-menu">
        <!--   <li class="sidebar-title">
            Apps
        </li> -->
        <?php
        $permisosSecciones = $_SESSION['PermisosSecciones'] ?? [];
        $seccionesVisibles = $_SESSION['SeccionesVisibles'] ?? [];
        $tipoUsuarioActual = isset($_SESSION['TipoDeUsuario']) ? strtolower(trim((string) $_SESSION['TipoDeUsuario'])) : '';
        $menuSecciones = [
            [
                'slug' => 'aplicaciones',
                'ruta' => 'main.php',
                'icono' => 'fas fa-th-large',
                'nombre' => 'Aplicaciones',
            ],
            [
                'slug' => 'charolas',
                'ruta' => 'charolas.php',
                'icono' => 'fas fa-layer-group',
                'nombre' => 'Charolas',
            ],
            [
                'slug' => 'reparto',
                'ruta' => 'Repartos.php',
                'icono' => 'fas fa-truck',
                'nombre' => 'Reparto',
            ],
            [
                'slug' => 'materialpendiente',
                'ruta' => 'MaterialPendiente.php',
                'icono' => 'fas fa-clipboard-list',
                'nombre' => 'Material Pendiente',
            ],
            [
                'slug' => 'clientes',
                'ruta' => 'Clientes.php',
                'icono' => 'fas fa-users',
                'nombre' => 'Clientes',
            ],
            [
                'slug' => 'usuarios',
                'ruta' => 'Usuarios.php',
                'icono' => 'fas fa-user-plus',
                'nombre' => 'Usuarios',
            ],
            [
                'slug' => 'administracion',
                'ruta' => 'Administracion.php',
                'icono' => 'fas fa-cogs',
                'nombre' => 'Administración',
                'soloAdministrador' => true,
            ],
        ];

        foreach ($menuSecciones as $seccionMenu) {
            $slug = $seccionMenu['slug'];
            $mostrar = !isset($permisosSecciones[$slug]) || (int)$permisosSecciones[$slug] === 1;

            if (isset($seccionesVisibles[$slug]) && (int)$seccionesVisibles[$slug] !== 1) {
                $mostrar = false;
            }

            if (!empty($seccionMenu['soloAdministrador']) && $tipoUsuarioActual !== 'administrador') {
                $mostrar = false;
            }

            if ($mostrar) {
                echo '<li>';
                echo '<a href="' . htmlspecialchars($seccionMenu['ruta'], ENT_QUOTES, 'UTF-8') . '"><i class="' . htmlspecialchars($seccionMenu['icono'], ENT_QUOTES, 'UTF-8') . '"></i><span class="menu-text">' . htmlspecialchars($seccionMenu['nombre'], ENT_QUOTES, 'UTF-8') . '</span></a>';
                echo '</li>';
            }
        }
        ?>

        <br>

        <li class="border-menu-top">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span class="menu-text">Cerrar Sesión</span></a>
        </li>

    </ul>
</div>
