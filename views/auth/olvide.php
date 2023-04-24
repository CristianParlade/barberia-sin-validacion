<h1 class="nombre-pagina">Restablecer</h1>
<p class="descripcion-pagina">Dinos tu email para recuperar tu cuenta</p>

<?php include_once __DIR__ . '/../templates/alertas.php'?>

<form action="/olvide" class="formulario" method="POST">
    <div class="campo">
    <label for="email">Email</label>
    <input  type="email"
            id="email"
            name="email"
            placeholder="Tu email"
    >
    </div>
    <input type="submit" class="boton" value="Enviar">
</form>
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar Sesion </a>
    <a href="/crear">¿Aún no tiene una cuenta? Crear una</a>
</div>
