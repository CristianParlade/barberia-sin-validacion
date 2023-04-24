<h1 class="nombre-pagina">Restabece tu password</h1>
<?php include __DIR__ .'/../templates/alertas.php'?>
<?php if($token === false){return;}?>
<?php if($exito === true){?>
<div class="acciones">
<a href="/">!Ya tienes tu password nuevo¡ Iniciar sesion</a>
</div>
<?php return;}?>
<form class="formulario" method="POST">
    <div class="campo">
    <label for="password">Nuevo Password</label>
    <input 
        type="password"
        id="password"
        name="password"
        placeholder="Nuevo password"
        >
    
    </div>
<input type="submit" class="boton" value="Restablacer password">
</form>
<div class="acciones">
<a href="/">¿Ya tienes una cuenta? Iniciar sesion</a>
<a href="/crear">¿Todavía no tienes una cuenta? Crear una</a>
</div>