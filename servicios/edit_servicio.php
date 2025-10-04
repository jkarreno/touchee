<?php
//Inicio la sesion 
session_start();

include('../conexion.php');

$ResServ=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM servicios WHERE Id='".$_POST["servicio"]."'"));

$cadena='<div class="c100 card">
            <h2>Editar Servicio</h2>
            <form name="feditservicio" id="feditservicio">
                <label class="l_form">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="'.$ResServ["Nombre"].'">
                <label class="l_form">Duración:</label>
                <input type="text" name="duracion" id="duracion" placeholder="HH:MM" pattern="[0-9]{2}:[0-9]{2}" maxlength="5" value="'.date('H:i', strtotime($ResServ["Duracion"])).'">
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
	$cadena.='      <option value="'.$RResUsu["Id"].'"'.($RResUsu["Id"]==$ResServ["IdUsuario"] ? ' selected' : '').'>'.$RResUsu["Nombre"].'</option>';
}
$cadena.='      </select>
                <input type="hidden" name="hacer" id="hacer" value="editservicio">
                <input type="hidden" name="idservicio" id="idservicio" value="'.$ResServ["Id"].'">
				<input type="submit" name="boteditservicio" id="boteditservicio" value="Actualizar>>">
			</form>
        </div>';
    
echo $cadena;

?>
<script>
$("#feditservicio").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditservicio"));

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