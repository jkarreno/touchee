<?php
//Inicio la sesion 
session_start();

include('../conexion.php');

$cadena='<div class="c100 card">
            <h2>Nuevo cliente</h2>
            <form name="fadcliente" id="fadcliente">
                <label class="l_form">Nombre:</label>
                <input type="text" name="nombre" id="nombre">
                <label class="l_form">Telefono celular:</label>
                <input type="text" name="celular" id="celular">
                <label class="l_form">Correo Electrónico:</label>
                <input type="text" name="correoe" id="correoe">
                <label class="l_form">Genero:</label>
                <select name="genero" id="genero">
                    <option value="">Selecciona</option>
                    <option value="H">Hombre</option>
                    <option value="M">Mujer</option>
                </select>
                <label class="l_form">Fecha de Nacimiento:</label>
                <input type="date" name="fechanac" id="fechanac">
                <label class="l_form">Forma de contacto:</label>
                <ul class="tg-list">
                    <li class="tg-list-item">
                        <h4>Correo Electrónico</h4>
                        <input class="tgl tgl-light" id="cb1" name="cb1" type="checkbox" value="1"/>
                        <label class="tgl-btn" for="cb1"></label>
                    </li>
                    <li class="tg-list-item">
                        <h4>Telefono celular</h4>
                        <input class="tgl tgl-light" id="cb2" name="cb2"  type="checkbox" value="1"/>
                        <label class="tgl-btn" for="cb2"></label>
                    </li>
                    <li class="tg-list-item">
                        <h4>Whatsapp</h4>
                        <input class="tgl tgl-light" id="cb3" name="cb3" type="checkbox" value="1"/>
                        <label class="tgl-btn" for="cb3"></label>
                    </li>
                </ul>
                <label class="l_form">Contacto en caso de emergencia:</label>
                <label class="l_form">Nombre:</label>
                <input type="text" name="nombrecontacto" id="nombrecontacto">
                <label class="l_form">Telefono:</label>
                <input type="text" name="celularcontacto" id="celularcontacto">
                <label class="l_form">Correo Electrónico:</label>
                <input type="text" name="correoecontacto" id="correoecontacto">
                <input type="hidden" name="hacer" id="hacer" value="addcliente">
				<input type="submit" name="botaduser" id="botaduser" value="Agregar>>">
			</form>
        </div>';
    
echo $cadena;

?>
<script>
$("#fadcliente").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadcliente"));

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