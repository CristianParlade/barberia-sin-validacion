<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina"> Iniciar session</p>

<?php include __DIR__. '/../templates/alertas.php'?>

<form class="formulario" method="POST" action="/">
     <div class="campo">   
        <label for="email">Email</label>
        <input  type="email"
                id="email"
                placeholder="Escribe tu e-mail" 
                name="email">
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input  type="password"
                id="password"
                name="password"
                placeholder="Escribe tu contraseña">
    </div>
    <input type="submit" class="boton" value="Iniciar sesion">
</form>
<div class="acciones">
    <a href="/crear">¿Aún no tiene una cuenta? Crear</a>
    <a href="/olvide">¿Hás olvidado tu contraseña? restablecer</a>
</div>