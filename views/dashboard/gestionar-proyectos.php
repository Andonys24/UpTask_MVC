<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <div class="contenedor-nuevo-proyecto">
        <button type="button" class="agregar-proyecto" id="agregar-proyecto">&#43 Nuevo Proyecto</button>
    </div>
    
    <ul id="listado-proyectos" class="listado-proyectos-api"></ul>
</div>
<?php include_once __DIR__ . '/footer-dashboard.php'; ?>

<?php
$script .= '
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="build/js/proyectos.js"></script>
';
?>