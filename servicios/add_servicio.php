<?php
//Inicio la sesion 
session_start();

include('../conexion.php');

$cadena='<div class="c100 card">
            <h2>Nuevo servicio</h2>
            <form name="fadservicio" id="fadservicio">
                <label class="l_form">Nombre:</label>
                <input type="text" name="nombre" id="nombre">
                <label class="l_form">Duración:</label>
                <input type="text" name="duracion" id="duracion" placeholder="HH:MM" pattern="[0-9]{2}:[0-9]{2}" maxlength="5">
				<label class="l_form">Responsable:</label>
				<select name="usuario" id="usuario">
					<option value="">Selecciona</option>';
if($_SESSION["perfil"]=='admin')
{
	$ResUsuarios=mysqli_query($conn, "SELECT Id, Nombre FROM usuarios WHERE	Agenda LIKE '1' ORDER BY Nombre");
}
elseif($_SESSION["perfil"]=='usuar')
{
	$ResUsuarios=mysqli_query($conn, "SELECT Id, Nombre FROM usuarios WHERE Id='".$_SESSION["Id"]."' AND Agenda LIKE '1' ORDER BY Nombre");
}
elseif($_SESSION["perfil"]=='asist')
{
	$ResUsuarios=mysqli_query($conn, "SELECT Id, Nombre FROM usuarios WHERE Id='".$_SESSION["IdUsuario"]."' AND Agenda LIKE '1' ORDER BY Nombre");
}
while($RResUsu=mysqli_fetch_array($ResUsuarios))
{
	$cadena.='      <option value="'.$RResUsu["Id"].'">'.$RResUsu["Nombre"].'</option>';
}
$cadena.='      </select>
                <input type="hidden" name="hacer" id="hacer" value="addservicio">
				<input type="submit" name="botadservicio" id="botadservicio" value="Agregar>>">
			</form>
        </div>';
    
echo $cadena;

?>
<script>
$("#fadservicio").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadservicio"));

	$.ajax({
		url: "servicios/servicios.php",
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

document.getElementById('duracion').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^0-9]/g, '');
    if (value.length >= 2) {
        value = value.slice(0, 2) + ':' + value.slice(2, 4);
    }
    e.target.value = value;
});
</script>