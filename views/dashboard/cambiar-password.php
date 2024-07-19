<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/perfil" class="enlace">Volver a Perfil</a>

    <form action="/cambiar-password" method="post" class="formulario">
        <div class="campo">
            <label for="password_actual">Password Actual: </label>
            <input type="password" name="password_actual" placeholder="Tu Password Actual">
        </div>
        <div class="campo">
            <label for="password_nuevo">Password Nuevo: </label>
            <input type="password" name="password_nuevo" placeholder="Tu nuevo Password">
        </div>
        <div class="campo">
            <label for="password2">Confirmar: </label>
            <input type="password" name="password2" placeholder="Confirmar nuevo Password">
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>