<?php
//Inicio la sesion 
session_start();

include('../conexion.php');

$cadena='<div class="c100 card">
            <h2>Nuevo usuario</h2>
            <form name="fadusuario" id="fadusuario">
                <label class="l_form">Nombre:</label>
                <input type="text" name="nombre" id="nombre">
                <label class="l_form">Nombre de usuario:</label>
                <input type="text" name="nusuario" id="nusuario">
                <label class="l_form">Contraseña:</label>
                <input type="text" name="contrasena" id="contrasena">
                <label class="l_form">Perfil:</label>
                <select name="perfil" id="perfil">
                    <option value="">Selecciona</option>
                    <option value="admin">Administrador</option>
                    <option value="usuar">Usuario</option>
                </select>
                <label class="l_form">Color:</label>
                <input type="color" id="favcolor" name="favcolor" value="#ffffff">
                <label class="l_form">Agregar a agenda:</label>
                <ul class="tg-list">
                    <li class="tg-list-item">
                        <input class="tgl tgl-light" id="cb1" name="cb1" type="checkbox" value="1" checked/>
                        <label class="tgl-btn" for="cb1"></label>
                    </li>
                </ul>
                <input type="hidden" name="hacer" id="hacer" value="addusuario">
				<input type="submit" name="botaduser" id="botaduser" value="Agregar>>">
			</form>
        </div>';
    
echo $cadena;

?>
<script>
$("#fadusuario").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadusuario"));

	$.ajax({
		url: "usuarios/usuarios.php",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#contenido").html(echo);
	});
});
</script>