<h1 class="nombre-pagina">Crear nueva cita</h1>
<p class="descripcion-pagina">Elige tus servicios yo coloca tus datos</p>
<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1" >Servicios</button>
        <button type="button" data-paso="2" >Datos de citas</button>
        <button type="button" data-paso="3" >resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elije los servicios</p>
        <div class="listado-servicios" id="servicios"></div>
    </div>
    
    <div id="paso-2" class="seccion">
        <h2>tus datos y citas</h2>
        <p class="text-center">Escribe tu info</p>
        <div class="listado-servicios" id="servicios"></div>
        <form class="formulario">
            <div class="campo">
                <label for="nombre">NOMBRE</label>
                <input type="text"
                        id="nombre"
                        placeholder="Tu nombre"
                        value="<?php echo $nombre ?>"
                        disabled>
            </div>
            <div class="campo">
                <label for="fecha">FECHA</label>
                <input type="date"
                        id="fecha">
            </div>
            <div class="campo">
                <label for="hora">HORA</label>
                <input type="time"
                        id="hora">
            </div>
        </form>
    </div>
    <div id="paso-3" class="seccion">
        <h2>resumen</h2>
        <p class="text-center">Verrifica que tdo este correcto</p>
        <div class="listado-servicios" id="servicios"></div>
    </div>

</div>
<div class="paginacion">
    <button id="anterior" class="boton">&laquo; Anterior </button>
    <button id="siguiente" class="boton">Siguiente &raquo; </button>
</div>

<?php 
$script = "<script src='build/js/app.js'></script>";
?>
