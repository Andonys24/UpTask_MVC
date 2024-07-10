<div class="contenedor restablecer">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca Tu nuevo Password</p>

        <form action="/restablcer" class="formulario" method="post">
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Tu Password">
            </div>

            <input type="submit" class="boton" value="Cambiar Password">
        </form>

        <div class="acciones">
            <a href="/crear">Aun no tienes una cuenta? obtener una</a>
            <a href="/olvide">Olvidaste tu password?</a>
        </div>
    </div> <!-- .contenedor-sm -->
</div>