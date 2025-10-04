<?php
date_default_timezone_set('America/Mexico_City');
//Inicio la sesion 
session_start();

include('../conexion.php');

$ResCita=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM citas WHERE Id='".$_POST["cita"]."' LIMIT 1"));

$cadena='<div class="c100 card">
            <h2>Actualizar cita</h2>
            <form name="feditcita" id="feditcita">
                <label class="l_form">Fecha:</label>
                <input type="date" name="fechacita" id="fechacita" value="'.$ResCita["Fecha"].'">
                <label class="l_form">Cliente:</label>';
$ResCliente=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM clientes WHERE Id='".$ResCita["Cliente"]."' LIMIT 1"));
$cadena.='      <input list="cliente" name="cliente" type="text" value="'.$ResCliente["Nombre"].'">
                <datalist id="cliente">';
$ResClientes=mysqli_query($conn, "SELECT Nombre FROM clientes ORDER BY Nombre");
while($RResClientes=mysqli_fetch_array($ResClientes))
{
    $cadena.='      <option value="'.$RResClientes["Nombre"].'"></option>';
}
$cadena.='      </datalist>
                <label class="l_form">Atiende:</label>
                <select name="usuario" id="usuario">
                    <option value="">Selecciona</option>';
if($_SESSION["perfil"]=='admin')
{
    $ResUsuarios=mysqli_query($conn, "SELECT Id, Nombre FROM usuarios WHERE Agenda LIKE '1' ORDER BY Nombre");
}
else
{
    $ResUsuarios=mysqli_query($conn, "SELECT Id, Nombre FROM usuarios WHERE Id='".$_SESSION["Id"]."' AND Agenda LIKE '1' ORDER BY Nombre");
}
while($RResUsu=mysqli_fetch_array($ResUsuarios))
{
    $cadena.='      <option value="'.$RResUsu["Id"].'"';if($ResCita["Usuario"]==$RResUsu["Id"]){$cadena.=' selected';}$cadena.='>'.$RResUsu["Nombre"].'</option>';
}
$cadena.='      </select>
                <label class="l_form">Servicio:</label>
                <select name="servicio" id="servicio">
                    <option value="">Selecciona</option>';
$ResServ=mysqli_query($conn, "SELECT Id, Nombre FROM servicios ORDER BY Nombre ASC");
while($RResServ=mysqli_fetch_array($ResServ))
{
    $cadena.='      <option value="'.$RResServ["Id"].'"';if($ResCita["Servicio"]==$RResServ["Id"]){$cadena.=' selected';}$cadena.='>'.$RResServ["Nombre"].'</option>';
}
$cadena.='      </select>
                <label class="l_form">Hora:</label>
                <select name="hora" id="hora">
                    <option value="">Selecciona</option>
                    <option value="07:00"';if($ResCita["Hora"]=="07:00"){$cadena.=' selected';}$cadena.='>07:00</option>
                    <option value="07:30"';if($ResCita["Hora"]=="07:30"){$cadena.=' selected';}$cadena.='>07:30</option>
                    <option value="08:00"';if($ResCita["Hora"]=="08:00"){$cadena.=' selected';}$cadena.='>08:00</option>
                    <option value="08:30"';if($ResCita["Hora"]=="08:30"){$cadena.=' selected';}$cadena.='>08:30</option>
                    <option value="09:00"';if($ResCita["Hora"]=="09:00"){$cadena.=' selected';}$cadena.='>09:00</option>
                    <option value="09:30"';if($ResCita["Hora"]=="09:30"){$cadena.=' selected';}$cadena.='>09:30</option>
                    <option value="10:00"';if($ResCita["Hora"]=="10:00"){$cadena.=' selected';}$cadena.='>10:00</option>
                    <option value="10:30"';if($ResCita["Hora"]=="10:30"){$cadena.=' selected';}$cadena.='>10:30</option>
                    <option value="11:00"';if($ResCita["Hora"]=="11:00"){$cadena.=' selected';}$cadena.='>11:00</option>
                    <option value="11:30"';if($ResCita["Hora"]=="11:30"){$cadena.=' selected';}$cadena.='>11:30</option>
                    <option value="12:00"';if($ResCita["Hora"]=="12:00"){$cadena.=' selected';}$cadena.='>12:00</option>
                    <option value="12:30"';if($ResCita["Hora"]=="12:30"){$cadena.=' selected';}$cadena.='>12:30</option>
                    <option value="13:00"';if($ResCita["Hora"]=="13:00"){$cadena.=' selected';}$cadena.='>13:00</option>
                    <option value="13:30"';if($ResCita["Hora"]=="13:30"){$cadena.=' selected';}$cadena.='>13:30</option>
                    <option value="14:00"';if($ResCita["Hora"]=="14:00"){$cadena.=' selected';}$cadena.='>14:00</option>
                    <option value="14:30"';if($ResCita["Hora"]=="14:30"){$cadena.=' selected';}$cadena.='>14:30</option>
                    <option value="15:00"';if($ResCita["Hora"]=="15:00"){$cadena.=' selected';}$cadena.='>15:00</option>
                    <option value="15:30"';if($ResCita["Hora"]=="15:30"){$cadena.=' selected';}$cadena.='>15:30</option>
                    <option value="16:00"';if($ResCita["Hora"]=="16:00"){$cadena.=' selected';}$cadena.='>16:00</option>
                    <option value="16:30"';if($ResCita["Hora"]=="16:30"){$cadena.=' selected';}$cadena.='>16:30</option>
                    <option value="17:00"';if($ResCita["Hora"]=="17:00"){$cadena.=' selected';}$cadena.='>17:00</option>
                    <option value="17:30"';if($ResCita["Hora"]=="17:30"){$cadena.=' selected';}$cadena.='>17:30</option>
                    <option value="18:00"';if($ResCita["Hora"]=="18:00"){$cadena.=' selected';}$cadena.='>18:00</option>
                    <option value="18:30"';if($ResCita["Hora"]=="18:30"){$cadena.=' selected';}$cadena.='>18:30</option>
                </select>
                <input type="hidden" name="idcita" id="idcita" value="'.$ResCita["Id"].'">
                <input type="hidden" name="hacer" id="hacer" value="editcita">
				<input type="submit" name="boteditcita" id="boteditcita" value="Actualizar>>">
			</form>
        </div>';
    
echo $cadena;

?>
<script>
$("#feditcita").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditcita"));

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
</script>