<div class="contenedor login">
    <h1 class="uptask">UpTask</h1>
    <p class="tagline">Crea y Administra tus Proyectos</p>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesion</p>

        <form action="/" class="formulario" method="post">
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Tu Email">
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Tu Password">
            </div>

            <input type="submit" class="boton" value="Iniciar Sesion">
        </form>

        <div class="acciones">
            <a href="/crear">Aun no tienes una cuenta? obtener una</a>
            <a href="/olvide">Olvidaste tu password?</a>
        </div>
    </div> <!-- .contenedor-sm -->
</div>