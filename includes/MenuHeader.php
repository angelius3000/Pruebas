<div class="app-header">
    <nav class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <button class="btn btn-link text-white sidebar-toggle mr-3" type="button">
                <i class="fas fa-bars"></i>
            </button>
            <div class="navbar-nav" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link hide-sidebar-toggle-button text-white" href="#"><i class="fas fa-chevron-left"></i></a>
                    </li>
                </ul>

            </div>
            <div class="d-flex">
                <ul class="navbar-nav align-items-center">

                    <li class="nav-item hidden-on-mobile">

                        <?php
                        $NombreUsuario = $_SESSION['NombreDelUsuario'];
                        $CaracterUsuario = $NombreUsuario[0]; ?>

                        <?php if ($_SESSION['TIPOUSUARIO'] == '4') { ?>


                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link" href="Repartos.php"><strong><?php echo $_SESSION['NombreCliente']; ?></strong></a>
                    </li>

                <?php } ?>
                <a class="nav-link nav-notifications-toggle text-white" id="notificationsDropDown" href="#" data-bs-toggle="dropdown"><?php echo $CaracterUsuario; ?></a>
                <div class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="notificationsDropDown">




                    <h6 class="dropdown-headerNombreUsuario"><?php echo $_SESSION['NombreDelUsuario']; ?></h6>
                    <span class="dropdown-headerEdison"><?php echo $_SESSION['Username']; ?></span>
                    <br>

                    <?php if ($_SESSION['TIPOUSUARIO'] == '4') {

                        $TituloDeUsuarioParaMenu = $_SESSION['NombreCliente'];
                    } else {
                        $TituloDeUsuarioParaMenu = $_SESSION['TipoDeUsuario'];
                    }

                    ?>

                    <span class="dropdown-headerTipoUsuario"><?php echo $TituloDeUsuarioParaMenu; ?></span>
                    <br>

                    <a href="#ModalCambiarContrasenas" data-bs-toggle="modal" data-bs-target="#ModalCambiarContrasena">Cambiar contraseña</a>

                    <div class="dropdown-divider"></div>

                    <a href="logout.php">Cerrar sesión</a>


                </div>
                </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<?php include("App/Modales/ModalesCambiarContrasena.php") ?>
