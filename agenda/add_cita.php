<?php
date_default_timezone_set('America/Mexico_City');
//Inicio la sesion 
session_start();

include('../conexion.php');

$cadena='<div class="c100 card">
            <h2>Nueva cita</h2>
            <form name="fadcita" id="fadcita">
                <label class="l_form">Fecha:</label>
                <input type="date" name="fechacita" id="fechacita" value="';if(isset($_POST["fecha"])){$cadena.=$_POST["fecha"];}else{$cadena.=date("Y-m-d");}$cadena.='">
                <label class="l_form">Cliente:</label>
                <input list="cliente" name="cliente" id="input-cliente" type="text" autocomplete="off">
                <datalist id="cliente">';
$ResClientes=mysqli_query($conn, "SELECT Nombre FROM clientes ORDER BY Nombre");
while($RResClientes=mysqli_fetch_array($ResClientes))
{
    $cadena.='      <option value="'.$RResClientes["Nombre"].'"></option>';
}
$cadena.='      </datalist>
<div id="campos-nuevo-cliente" style="display: none;" class="c100">
    <h4>Nuevo Cliente</h4>
    <label class="l_form">Nombre:</label>
    <input type="text" name="nombre" id="nombre">
    <label class="l_form">Telefono celular:</label>
    <input type="text" name="celular" id="celular">
    <label class="l_form">Correo Electrónico:</label>
    <input type="text" name="correoe" id="correoe">
</div>
                <label class="l_form">Atiende:</label>
                <select name="usuario" id="usuario">
                    <option value="">Selecciona</option>';
if($_SESSION["perfil"]=='admin')
{
    $ResUsuarios=mysqli_query($conn, "SELECT Id, Nombre FROM usuarios WHERE	Agenda LIKE '1' ORDER BY Nombre");
}
else
{
    $ResUsuarios=mysqli_query($conn, "SELECT Id, Nombre FROM usuarios WHERE Id='".$_SESSION["Id"]."' AND Agenda LIKE '1' ORDER BY Nombre");
}

while($RResUsu=mysqli_fetch_array($ResUsuarios))
{
    $cadena.='      <option value="'.$RResUsu["Id"].'"';if($_POST["usuario"]==$RResUsu["Id"]){$cadena.=' selected';}$cadena.='>'.$RResUsu["Nombre"].'</option>';
}
$cadena.='      </select>
                <label class="l_form">Servicio:</label>
                <select name="servicio" id="servicio">
                    <option value="">Selecciona</option>';
if($_SESSION["perfil"]=='admin')
{
    $ResServ=mysqli_query($conn, "SELECT Id, Nombre FROM servicios ORDER BY Nombre ASC");
}
elseif($_SESSION["perfil"]=='usuar')
{
    $ResServ=mysqli_query($conn, "SELECT Id, Nombre FROM servicios WHERE IdUsuario='".$_SESSION["Id"]."' ORDER BY Nombre ASC");
}
elseif($_SESSION["perfil"]=='asist')    
{
    $ResServ=mysqli_query($conn, "SELECT Id, Nombre FROM servicios WHERE IdUsuario='".$_SESSION["IdUsuario"]."' ORDER BY Nombre ASC");
}

$ResServ=mysqli_query($conn, "SELECT Id, Nombre FROM servicios ORDER BY Nombre ASC");
while($RResServ=mysqli_fetch_array($ResServ))
{
    $cadena.='      <option value="'.$RResServ["Id"].'">'.$RResServ["Nombre"].'</option>';
}
$cadena.='      </select>
                <label class="l_form">Hora:</label>
                <select name="hora" id="hora">
                    <option value="">Selecciona</option>
                    <option value="07:00"';if($_POST["hora"]=='07:00'){$cadena.=' selected';}$cadena.='>07:00</option>
                    <option value="07:30">07:30</option>
                    <option value="08:00"';if($_POST["hora"]=='08:00'){$cadena.=' selected';}$cadena.='>08:00</option>
                    <option value="08:30">08:30</option>
                    <option value="09:00"';if($_POST["hora"]=='09:00'){$cadena.=' selected';}$cadena.='>09:00</option>
                    <option value="09:30">09:30</option>
                    <option value="10:00"';if($_POST["hora"]=='10:00'){$cadena.=' selected';}$cadena.='>10:00</option>
                    <option value="10:30">10:30</option>
                    <option value="11:00"';if($_POST["hora"]=='11:00'){$cadena.=' selected';}$cadena.='>11:00</option>
                    <option value="11:30">11:30</option>
                    <option value="12:00"';if($_POST["hora"]=='12:00'){$cadena.=' selected';}$cadena.='>12:00</option>
                    <option value="12:30">12:30</option>
                    <option value="13:00"';if($_POST["hora"]=='13:00'){$cadena.=' selected';}$cadena.='>13:00</option>
                    <option value="13:30">13:30</option>
                    <option value="14:00"';if($_POST["hora"]=='14:00'){$cadena.=' selected';}$cadena.='>14:00</option>
                    <option value="14:30">14:30</option>
                    <option value="15:00"';if($_POST["hora"]=='15:00'){$cadena.=' selected';}$cadena.='>15:00</option>
                    <option value="15:30">15:30</option>
                    <option value="16:00"';if($_POST["hora"]=='16:00'){$cadena.=' selected';}$cadena.='>16:00</option>
                    <option value="16:30">16:30</option>
                    <option value="17:00"';if($_POST["hora"]=='17:00'){$cadena.=' selected';}$cadena.='>17:00</option>
                    <option value="17:30">17:30</option>
                    <option value="18:00"';if($_POST["hora"]=='18:00'){$cadena.=' selected';}$cadena.='>18:00</option>
                    <option value="18:30">18:30</option>
                </select>
                <label class="l_form">Vista Asistente:</label>
                <ul class="tg-list">
                    <li class="tg-list-item">
                        <input class="tgl tgl-light" id="va1" name="va1" type="checkbox" value="1"/>
                        <label class="tgl-btn" for="va1"></label>
                    </li>
                </ul>
                <input type="hidden" name="hacer" id="hacer" value="addcita">
				<input type="submit" name="botadcita" id="botadcita" value="Agregar>>">
			</form>
        </div>';
    
echo $cadena;

?>
<script>
$("#fadcita").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadcita"));

	$.ajax({
		url: "agenda/agenda.php",
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

$(document).ready(function() {
    $('#input-cliente').on('blur', function() {
        const valorIngresado = $(this).val().trim().toLowerCase();
        const opcionesValidas = $('#cliente option').map(function() {
            return $(this).val().toLowerCase();
        }).get();
        
        if (valorIngresado && $.inArray(valorIngresado, opcionesValidas) === -1) {
            $('#campos-nuevo-cliente').fadeIn(300); // Fade in
            $('#nuevo-nombre').val($(this).val()).focus();
        } else {
            $('#campos-nuevo-cliente').fadeOut(300); // Fade out
            $('#nuevo-nombre, #nuevo-telefono, #nuevo-email').val('');
        }
    });
    
    $('#input-cliente').on('input', function() {
        if (!$(this).val().trim()) {
            $('#campos-nuevo-cliente').fadeOut(300);
        }
    });
});
</script>