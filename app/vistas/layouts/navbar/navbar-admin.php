<?php $usuario = obtenerSession("usuario") ?>
<header>
    <nav class="navbar">
        <ul>
            <li class="active">
                <a href="#">
                    <span>
                        <?php echo icon("home") ?>
                    </span>
                    <p>Inicio</p>
                </a>
            </li>
            <li>
                <a href="#">
                    <span>
                        <?php echo icon("computer") ?>
                    </span>
                    <p>Equipos</p>
                </a>
            </li>
            <li>
                <a href="#">
                    <span>
                        <?php echo icon("movements") ?>
                    </span>
                    <p>Movimientos</p>
                </a>
            </li>
            <li>
                <a href="#">
                    <span>
                        <?php echo icon("loading") ?>
                    </span>
                    <p>Pendientes</p>
                </a>
            </li>
            <li class="logout">
                <a href="#">
                    <span>
                        <?php echo icon("logout") ?>
                    </span>
                    <p>Cerrar sesión</p>
                </a>
            </li>
        </ul>
        <button class="button-close">
            <?php echo icon("cancel") ?>
        </button>
    </nav>
    <div id="overlay"></div>
</header>
<main class="main-<?php echo $usuario->rol ?>">
    <div class="top-bar">
        <button class="button-hamburger">
            <?php echo icon("menu") ?>
        </button>
        <div class="search">
            <input type="text" placeholder="Buscar...">
            <button>
                <?php echo icon("search-square") ?>
            </button>
        </div>
        <div class="configuration">
            <div class="user">
                <img src="<?php asset("images", "favicon.png") ?>" alt="Imagen de perfil del usuario">
                <span>Willian</span>
            </div>
            <div class="notification">
                <button class="button-alert">
                    <?php echo icon("notification") ?>
                    <span>1</span>
                </button>
                <div class="alerts">
                    <h4>Alertas</h4>
                    <div class="item-alert">
                        <span>Mayo 05, 2024</span>
                        <p title="Ultimos equipos ingresados correctamente">Ultimos equipos ingresados correctamente</p>
                    </div>
                    <div class="item-alert">
                        <span>Mayo 05, 2024</span>
                        <p title="Equipos revisados">Equipos revisados</p>
                    </div>
                </div>
            </div>
            <a href="#">
                <?php echo icon("settings") ?>
            </a>
        </div>
    </div>