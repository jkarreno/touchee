<?php
//Inicio la sesion 
session_start();

include('../conexion.php');

$mensaje='';

//acciones
if(isset($_POST["hacer"]))
{
	//agregar cliente
	if($_POST["hacer"]=='addcliente')
	{
        if($_POST["fechanac"]==''){$_POST["fechanac"]='1900-01-01';}
        if($_POST["cb1"]==''){$_POST["cb1"]='0';}
        if($_POST["cb2"]==''){$_POST["cb2"]='0';}
        if($_POST["cb3"]==''){$_POST["cb3"]='0';}
		mysqli_query($conn, "INSERT INTO clientes (Nombre, Genero, FechaNacimiento, Celular, CorreoE, ContactoCorreo, ContactoTel, ContactoWhats, NombreContactoE, TelefonoContactoE, CorreoEContactoE)
											VALUES ('".$_POST["nombre"]."', '".$_POST["genero"]."', '".$_POST["fechanac"]."', '".$_POST["celular"]."', '".$_POST["correoe"]."', '".$_POST["cb1"]."', '".$_POST["cb2"]."', 
													'".$_POST["cb3"]."', '".$_POST["nombrecontacto"]."', '".$_POST["celularcontacto"]."', '".$_POST["correoecontacto"]."')");

		$mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se agrego el cliente '.$_POST["nombre"].'</div>';
	}

	//editar cliente
	if($_POST["hacer"]=='editcliente')
	{
        if($_POST["fechanac"]==''){$_POST["fechanac"]='1900-01-01';}
        if($_POST["cb1"]==''){$_POST["cb1"]='0';}
        if($_POST["cb2"]==''){$_POST["cb2"]='0';}
        if($_POST["cb3"]==''){$_POST["cb3"]='0';}

		mysqli_query($conn, "UPDATE clientes SET Nombre='".$_POST["nombre"]."',
                                                    Genero='".$_POST["genero"]."',
                                                    FechaNacimiento='".$_POST["fechanac"]."',
                                                    Celular='".$_POST["celular"]."',
                                                    CorreoE='".$_POST["correoe"]."',
                                                    ContactoCorreo='".$_POST["cb1"]."',
                                                    ContactoTel='".$_POST["cb2"]."',
                                                    ContactoWhats='".$_POST["cb3"]."',
													NombreContactoE='".$_POST["nombrecontacto"]."',
													TelefonoContactoE='".$_POST["celularcontacto"]."',
													CorreoEContactoE='".$_POST["correoecontacto"]."'
                                            WHERE Id='".$_POST["idcliente"]."'");

		$mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se actualizo el usuario '.$_POST["nombre"].'</div>';
	}

	//eliminar cliente
	if($_POST["hacer"]=='borracliente')
	{
		mysqli_query($conn, "DELETE FROM clientes WHERE Id='".$_POST["cliente"]."'");

		$mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se elimino el cliente</div>';
	}
}

$cadena=$mensaje.'<table>
            <thead>
                <tr>
                    <td colspan="7" style="text-align: right">| <a href="#" onclick="add_cliente()" class="liga">Nuevo Cliente</a> |</td>
                </tr>
                <tr>
                    <th colspan="7" align="center" class="textotitable">Clientes</td>
                </tr>
                <tr>
                    <th align="center" class="textotitable">&nbsp;</th>
                    <th align="center" class="textotitable">Nombre</th>
                    <th align="center" class="textotitable">Correo Electrónico</th>
                    <th align="center" class="textotitable">Telefono</th>
                    <th align="center" class="textotitable">&nbsp;</th>
                    <th align="center" class="textotitable">&nbsp;</th>
                    <th align="center" class="textotitable">&nbsp;</th>
                </tr>
            </thead>
            <tbody>';
$bgcolor="#ffffff"; $J=1;
$ResClientes=mysqli_query($conn, "SELECT * FROM clientes ORDER BY Nombre ASC");
while($RResClientes=mysqli_fetch_array($ResClientes))
{
    $cadena.='	<tr style="background: '.$bgcolor.'" id="row_'.$J.'">
					<td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$J.'</td>
					<td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$RResClientes["Nombre"].'</td>
					<td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">';if($_SESSION["perfil"]=='admin'){if($RResClientes["ContactoCorreo"]==1){$cadena.='<a href="mailto:'.$RResClientes["CorreoE"].'">';}}$cadena.=$RResClientes["CorreoE"];if($_SESSION["perfil"]=='admin'){if($RResClientes["ContactoCorreo"]==1){$cadena.='</a>';}}$cadena.='</td>
					<td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">';if($_SESSION["perfil"]=='admin'){if($RResClientes["ContactoTel"]==1){$cadena.='<a href="tel:'.$RResClientes["Celular"].'">';}}$cadena.=$RResClientes["Celular"];if($_SESSION["perfil"]=='admin'){if($RResClientes["ContactoTel"]==1){$cadena.='</a>';}}$cadena.='</td>
					<td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">';if($_SESSION["perfil"]=='admin'){if($RResClientes["ContactoWhats"]==1){$cadena.='<a href="https://wa.me/+521'.$RResClientes["Celular"].'"><i class="fab fa-whatsapp"></i></a>';}}$cadena.='</td>
					<td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">
						';if($_SESSION["perfil"]=='admin'){$cadena.='<a href="#" onclick="edit_cliente(\''.$RResClientes["Id"].'\')"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';} 
	$cadena.='		</td>
					<td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">
						';if($_SESSION["perfil"]=='admin'){$cadena.='<a href="#" onclick="delete_cliente(\''.$RResClientes["Id"].'\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';}
	$cadena.='		</td>
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
function add_cliente(){
	$.ajax({
				type: 'POST',
				url : 'clientes/add_cliente.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function edit_cliente(cliente){
	$.ajax({
				type: 'POST',
				url : 'clientes/edit_cliente.php',
                data: 'cliente=' + cliente
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function delete_cliente(cliente){
	$.ajax({
				type: 'POST',
				url : 'clientes/del_cliente.php',
                data: 'cliente=' + cliente
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}

//mostrar mensaje despues de los cambios
setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>