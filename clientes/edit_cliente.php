<?php
//Inicio la sesion 
session_start();

include('../conexion.php');

$ResCliente=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM clientes WHERE Id='".$_POST["cliente"]."' LIMIT 1"));

$cadena='<div class="c100 card">
            <h2>Editar cliente</h2>
            <form name="feditcliente" id="feditcliente">
                <label class="l_form">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="'.$ResCliente["Nombre"].'">
                <label class="l_form">Telefono celular:</label>
                <input type="text" name="celular" id="celular" value="'.$ResCliente["Celular"].'">
                <label class="l_form">Correo Electrónico:</label>
                <input type="text" name="correoe" id="correoe" value="'.$ResCliente["CorreoE"].'">
                <label class="l_form">Genero:</label>
                <select name="genero" id="genero">
                    <option value="">Selecciona</option>
                    <option value="H"';if($ResCliente["Genero"]=='H'){$cadena.=' selected';}$cadena.='>Hombre</option>
                    <option value="M"';if($ResCliente["Genero"]=='M'){$cadena.=' selected';}$cadena.='>Mujer</option>
                </select>
                <label class="l_form">Fecha de Nacimiento:</label>
                <input type="date" name="fechanac" id="fechanac"';if($ResCliente["FechaNacimiento"]!='1900-01-01'){$cadena.=' value="'.$ResCliente["FechaNacimiento"].'"';}$cadena.='>
                <label class="l_form">Forma de contacto:</label>
                <ul class="tg-list">
                    <li class="tg-list-item">
                        <h4>Correo Electrónico</h4>
                        <input class="tgl tgl-light" id="cb1" name="cb1" type="checkbox" value="1"';if($ResCliente["ContactoCorreo"]==1){$cadena.=' checked';}$cadena.='/>
                        <label class="tgl-btn" for="cb1"></label>
                    </li>
                    <li class="tg-list-item">
                        <h4>Telefono celular</h4>
                        <input class="tgl tgl-light" id="cb2" name="cb2"  type="checkbox" value="1"';if($ResCliente["ContactoTel"]==1){$cadena.=' checked';}$cadena.='/>
                        <label class="tgl-btn" for="cb2"></label>
                    </li>
                    <li class="tg-list-item">
                        <h4>Whatsapp</h4>
                        <input class="tgl tgl-light" id="cb3" name="cb3" type="checkbox" value="1"';if($ResCliente["ContactoWhats"]==1){$cadena.=' checked';}$cadena.='/>
                        <label class="tgl-btn" for="cb3"></label>
                    </li>
                </ul>
                <input type="hidden" name="hacer" id="hacer" value="editcliente">
                <input type="hidden" name="idcliente" id="idcliente" value="'.$ResCliente["Id"].'">
				<input type="submit" name="boteditcliente" id="boteditcliente" value="Actualizar>>">
			</form>
        </div>';
    
echo $cadena;

?>
<script>
$("#feditcliente").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditcliente"));

	$.ajax({
		url: "clientes/clientes.php",
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