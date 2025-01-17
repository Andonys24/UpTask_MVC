<div class="contenedor olvide">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu Acceso UpTask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <?php
        if (!isset($alertas['exito'])) {
        ?>
            <form action="/olvide" class="formulario" method="post">
                <div class="campo">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Tu Email">
                </div>

                <input type="submit" class="boton" value="Enviar Instrucciones">
            </form>
        <?php
        }
        ?>

        <div class="acciones">
            <a href="/">Ya tienes una cuenta? iniciar sesion</a>
            <a href="/crear">Aun no tienes una cuenta? obtener una</a>
        </div>
    </div> <!-- .contenedor-sm -->
</div>