<div class="app-header">
    <nav class="navbar navbar-light navbar-expand-lg">
        <div class="container-fluid">
            <div class="navbar-nav" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                    </li>
                    <!-- <li class="nav-item dropdown hidden-on-mobile">
                        <a class="nav-link dropdown-toggle" href="#" id="addDropdownLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons">add</i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="addDropdownLink">
                            <li><a class="dropdown-item" href="#">New Workspace</a></li>
                            <li><a class="dropdown-item" href="#">New Board</a></li>
                            <li><a class="dropdown-item" href="#">Create Project</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown hidden-on-mobile">
                        <a class="nav-link dropdown-toggle" href="#" id="exploreDropdownLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons-outlined">explore</i>
                        </a>
                        <ul class="dropdown-menu dropdown-lg large-items-menu" aria-labelledby="exploreDropdownLink">
                            <li>
                                <h6 class="dropdown-header">Repositories</h6>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <h5 class="dropdown-item-title">
                                        Neptune iOS
                                        <span class="badge badge-warning">1.0.2</span>
                                        <span class="hidden-helper-text">switch<i class="material-icons">keyboard_arrow_right</i></span>
                                    </h5>
                                    <span class="dropdown-item-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <h5 class="dropdown-item-title">
                                        Neptune Android
                                        <span class="badge badge-info">dev</span>
                                        <span class="hidden-helper-text">switch<i class="material-icons">keyboard_arrow_right</i></span>
                                    </h5>
                                    <span class="dropdown-item-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                </a>
                            </li>
                            <li class="dropdown-btn-item d-grid">
                                <button class="btn btn-primary">Create new repository</button>
                            </li>
                        </ul>
                    </li> -->
                </ul>

            </div>
            <div class="d-flex">
                <ul class="navbar-nav">

                    <li class="nav-item hidden-on-mobile">

                        <?php
                        $NombreUsuario = $_SESSION['NombreDelUsuario'];
                        $CaracterUsuario = $NombreUsuario[0]; ?>

                        <a class="nav-link nav-notifications-toggle" id="notificationsDropDown" href="#" data-bs-toggle="dropdown"><?php echo $CaracterUsuario; ?></a>
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
                            <div class="dropdown-divider"></div>

                            <a href="logout.php">Log out</a>


                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>