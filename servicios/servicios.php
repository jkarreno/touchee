<?php
//Inicio la sesion 
session_start();

include('../conexion.php');

$mensaje='';

//acciones
if(isset($_POST["hacer"]))
{
    //agregar servicio
	if($_POST["hacer"]=='addservicio')
	{
		mysqli_query($conn, "INSERT INTO servicios (Nombre, Duracion, IdUsuario)
											VALUES ('".$_POST["nombre"]."', '".$_POST["duracion"]."', '".$_POST["usuario"]."')");

		$mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se agrego el servicio '.$_POST["nombre"].'</div>';
	}

	//editar servicio
	if($_POST["hacer"]=='editservicio')
	{
		mysqli_query($conn, "UPDATE servicios SET Nombre='".$_POST["nombre"]."',
													Duracion='".$_POST["duracion"]."',
													IdUsuario='".$_POST["usuario"]."'
											WHERE Id='".$_POST["idservicio"]."'");

		$mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se actualizo el servicio '.$_POST["nombre"].'</div>';									
	}

	//eliminar servicio
	if($_POST["hacer"]=='borraservicio')
	{
		mysqli_query($conn, "DELETE FROM servicios WHERE Id='".$_POST["servicio"]."'");

		$mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se elimino el servicio</div>';
	}
}

$cadena=$mensaje.'<table style="width:80%">
            <thead>
                <tr>
                    <td colspan="6" style="text-align: right">| <a href="#" onclick="add_servicio()" class="liga">Nuevo Servicio</a> |</td>
                </tr>
                <tr>
                    <th colspan="6" align="center" class="textotitable">Servicios</td>
                </tr>
                <tr>
                    <th align="center" class="textotitable">&nbsp;</th>
                    <th align="center" class="textotitable">Nombre</th>
                    <th align="center" class="textotitable">Duración</th>
                    <th align="center" class="textotitable">Responsable</th>
                    <th align="center" class="textotitable">&nbsp;</th>
                    <th align="center" class="textotitable">&nbsp;</th>
                </tr>
            </thead>
            <tbody>';
$bgcolor="#ffffff"; $J=1;
$ResServicios=mysqli_query($conn, "SELECT * FROM servicios ORDER BY Nombre ASC");
while($RResServ=mysqli_fetch_array($ResServicios))
{
	$ResUsuario = mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM usuarios WHERE Id='".$RResServ["IdUsuario"]."'"));
    $cadena.='	<tr style="background: '.$bgcolor.'" id="row_'.$J.'">
					<td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$J.'</td>
					<td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$RResServ["Nombre"].'</td>
					<td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$RResServ["Duracion"].'</td>
					<td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$ResUsuario["Nombre"].'</td>
					<td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">
						<a href="#" onclick="edit_servicio(\''.$RResServ["Id"].'\')"><i class="fa fa-pencil-square" aria-hidden="true"></i></a> 
					</td>
					<td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">
						<a href="#" onclick="del_servicio(\''.$RResServ["Id"].'\')"><i class="fa fa-trash" aria-hidden="true"></i></a>
					</td>
				</tr>';
		$J++;
		if($bgcolor=="#ffffff"){$bgcolor='#cccccc';}
		else if($bgcolor=="#cccccc"){$bgcolor="#ffffff";}
}
$cadena.='  </tbody>
        </table>';

echo $cadena;

?>
<script>
function add_servicio(){
	$.ajax({
				type: 'POST',
				url : 'servicios/add_servicio.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function edit_servicio(servicio){
	$.ajax({
				type: 'POST',
				url : 'servicios/edit_servicio.php',
				data: 'servicio=' + servicio
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function del_servicio(servicio){
	$.ajax({
				type: 'POST',
				url : 'servicios/del_servicio.php',
				data: 'servicio=' + servicio
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}

//mostrar mensaje despues de los cambios
setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>