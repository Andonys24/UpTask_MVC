<div class="contenedor crear">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form action="/crear" class="formulario" method="post">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="nombre" name="nombre" id="nombre" placeholder="Tu Nombre" value="<?php echo $usuario->nombre ?>">
            </div>
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Tu Email" value="<?php echo $usuario->email ?>">
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Tu Password">
            </div>
            <div class="campo">
                <label for="password2">Repetir Pasword</label>
                <input type="password" name="password2" id="password2" placeholder="Repite tu Password">
            </div>

            <input type="submit" class="boton" value="Crear Cuenta">
        </form>

        <div class="acciones">
            <a href="/">Ya tienes una cuenta? iniciar sesion</a>
            <a href="/olvide">Olvidaste tu password?</a>
        </div>
    </div> <!-- .contenedor-sm -->
</div>