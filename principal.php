<?php 
date_default_timezone_set('America/Mexico_City');
//Inicio la sesion 
//ini_set("session.cookie_lifetime","7200");
//ini_set("session.gc_maxlifetime","7200");
session_start();
//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la p?gina de autentificacion 
    header("Location: index.php"); 
    //ademas salgo de este script 
    exit(); 
} 



include ("conexion.php");



include ("funciones.php");
?>
<html lang="es-mx">
<head>
	<meta charset="UTF-8" />
	<title>Administración</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	
	<link rel="stylesheet" href="estilos/estilos_principal.css">
	<link rel="stylesheet" href="estilos/estilos.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/2df1cf6d50.js" crossorigin="anonymous"></script>
	<script language="JavaScript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
	<script src="js/codigo.js"></script>


</head>
<body onload="agenda('<?php echo date("Y-m-d");?>', '1'); ini()" onkeypress="parar()" onclick="parar()">

	<input type="checkbox" id="check">
	<header>
		<div class="menu_bar"><label for="check" id="chk_btn"><i class="fas fa-bars"></i></label></div>
		<div class="logo_img"><img src="images/logo.jpg"></div>
	</header>

	<div class="menu_principal">
		<div><a href="#" onclick="agenda('<?php echo date("Y-m-d");?>')"><i class="fas fa-calendar-alt"></i></a></div>
		<div><a href="#" onclick="clientes()"><i class="fas fa-address-book"></i></a></div>
		<?php
		if($_SESSION["perfil"]=='admin')
		{
			echo '<div><a href="#" onclick="servicios()"><i class="fas fa-person-booth"></i></a></div>';
		}
		?>
		<div><a href="#" onclick="usuarios()"><i class="fas fa-users"></i></a></div>
		<?php
		if($_SESSION["perfil"]=='admin')
		{
			echo '<div><a href="#" onclick="estadisticos()"><i class="fas fa-chart-pie"></i></a></div>';
		}
		?>
		<div><i class="fas fa-sign-out-alt" onclick="location='logout.php'"></i></div>
	</div>

	<div class="contenido" id="contenido">
		
	</div>

	<!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-body" id="modal-body">
    
            </div>
    
        </div>
    </div>
	
</body>
</html>
<script>
//definimos el modal
var modal = document.getElementById('myModal');

function limpiar(){
    document.getElementById("modal-body").innerHTML="";
}

function abrirmodal(){
	modal.style.display = "block";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}

//funciones ajax
function datos_negocio(){
	$.ajax({
				type: 'POST',
				url : 'negocio/datosnegocio.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});

}
function clientes(){
	$.ajax({
				type: 'POST',
				url : 'clientes/clientes.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function servicios(){
	$.ajax({
				type: 'POST',
				url : 'servicios/servicios.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function usuarios(){
	$.ajax({
				type: 'POST',
				url : 'usuarios/usuarios.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}	
function agenda(fecha){
	$.ajax({
				type: 'POST',
				url : 'agenda/agenda.php',
				data: 'fechacita=' + fecha
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}	
function estadisticos(){
	$.ajax({
				type: 'POST',
				url : 'estadisticos/estadisticos.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}	

//cerrar sesion
var bloqueo;
  function ini() {
    bloqueo = setTimeout('location="logout.php"', 780000);
  }

  function parar() {
    clearTimeout(bloqueo);
    bloqueo = setTimeout('location="logout.php"', 780000);
  }
</script>