<div class="contenedor-error">
    <img src="<?php echo asset("images", "logo.png") ?>" alt="">
    <div class="error" data-text="404">
        404
    </div>
    <div class="mensaje">
        <h2>¡Ups! Página no encontrada</h2>
        <p>Lo sentimos, pero la página que buscas no existe.</p>
    </div>
    <a href="<?php echo url("/dashboard") ?>">
        <?php echo icon("square-arrow-left") ?>
        Volver al Dashboard
    </a>
</div>