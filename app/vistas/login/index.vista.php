<main class="w-100">
    <div class="contenedor">
        <div class="login">
            <img src="<?php asset("images", "logo.png") ?>" alt="" srcset="">
            <form action="<?php echo url("/login/validar") ?>" method="POST" id="form-login">
                <input type="hidden" name="_token" value="<?php echo token() ?>">
                <div class="input-group">
                    <span>
                        <?php echo icon("mail-at-sign") ?>
                    </span>
                    <input type="email" name="email" placeholder="Correo electrónico" id="email" autocomplete="off">
                    <span class="icon-error">
                        <?php echo icon("information") ?>
                    </span>
                </div>
                <div class="input-group">
                    <span>
                        <?php echo icon("password") ?>
                    </span>
                    <input type="password" name="password" placeholder="Contraseña" id="contraseña">
                    <span class="icon-view">
                        <?php echo icon("view", "view") ?>
                        <?php echo icon("view-off", "view-off") ?>
                    </span>
                </div>
                <button>
                    <?php echo icon("login-02") ?>
                    Iniciar sesión
                </button>
            </form>
        </div>

        <div class="toast">
            <div class="toast-header">
                <strong class="mr-auto">Error</strong>
            </div>
            <div class="toast-body">
                Usuario o contraseña incorrectos
            </div>
            <button type="button" class="close-toast" data-dismiss="toast" aria-label="Close">
                <?php echo icon("cancel") ?>
            </button>
        </div>

    </div>
</main>