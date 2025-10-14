<?php
date_default_timezone_set('America/Mexico_City');
//Inicio la sesion 
session_start();

include('../conexion.php');

$mensaje='';

if(isset($_POST["fechacita"]))
{
    $fechahoy=$_POST["fechacita"];
}
else
{
    $fechahoy=date("Y-m-d");
}
//acciones
if(isset($_POST["hacer"]))
{
    //agregar cita
    if($_POST["hacer"]=='addcita')
    {
        $ResCliente=mysqli_fetch_array(mysqli_query($conn, "SELECT Id FROM clientes WHERE Nombre LIKE '".$_POST["cliente"]."' LIMIT 1 "));

        if($ResCliente["Id"]=='' OR $ResCliente["Id"]==NULL)
        {
            mysqli_query($conn, "INSERT INTO clientes (Nombre, Celular, CorreoE)
                                        VALUES ('".$_POST["nombre"]."', '".$_POST["celular"]."', '".$_POST["correoe"]."')");

            $IdCliente=mysqli_insert_id($conn);
            
        }
        else
        {
            $IdCliente=$ResCliente["Id"];
        }

        mysqli_query($conn, "INSERT INTO citas (Cliente, Usuario, Servicio, Fecha, Hora, Activa".(isset($_POST["va1"]) ? ", VistaAsistente" : '').")
                                        VALUES ('".$IdCliente."', '".$_POST["usuario"]."', '".$_POST["servicio"]."', '".$_POST["fechacita"]."', '".$_POST["hora"]."', '1'".(isset($_POST["va1"]) ? ", '".$_POST["va1"]."'" : "").")");

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se agrego la cita</div>';

        
    }

    //Actualizar cita
    if($_POST["hacer"]=='editcita')
    {
        $ResCliente=mysqli_fetch_array(mysqli_query($conn, "SELECT Id FROM clientes WHERE Nombre LIKE '".$_POST["cliente"]."' LIMIT 1 "));

        mysqli_query($conn, "UPDATE citas SET Cliente='".$ResCliente["Id"]."',
                                            Usuario='".$_POST["usuario"]."', 
                                            Servicio='".$_POST["servicio"]."', 
                                            Fecha='".$_POST["fechacita"]."', 
                                            Hora='".$_POST["hora"]."'
                                    WHERE Id='".$_POST["idcita"]."'");

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se actualizo la cita</div>';
    }

    //borra cita
    if($_POST["hacer"]=='borracita')
    {
        mysqli_query($conn, "UPDATE citas SET Activa='0' WHERE Id='".$_POST["cita"]."'");

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se elimino la cita</div>';
    }
}

$cadena=$mensaje.'<div class="c100" style="text-align: right; padding: 10px;">| <a href="#" onclick="vista_mensual(\''.date("m").'\', \''.date("Y").'\')">Vista mensual</a> | <input type="date" name="fechacita" id="fechacita" value="'.$fechahoy.'" style="width:130px" onchange="agenda(this.value)"> | <a href="#" onclick="add_cita(';if($_SESSION["perfil"]!='admin'){$cadena.='\''.$fechahoy.'\', \'1.0\', \''.$_SESSION["Id"].'\'';}$cadena.=')">Nueva Cita</a> |</div>
        <div class="agenda">
            <div class="horarios_agenda">
                <div><span>Horario</span></div>
                <div><span>7:00 a 8:00</span></div>
                <div><span>8:00 a 9:00</span></div>
                <div><span>9:00 a 10:00</span></div>
                <div><span>10:00 a 11:00</span></div>
                <div><span>11:00 a 12:00</span></div>
                <div><span>12:00 a 13:00</span></div>
                <div><span>13:00 a 14:00</span></div>
                <div><span>14:00 a 15:00</span></div>
                <div><span>15:00 a 16:00</span></div>
                <div><span>16:00 a 17:00</span></div>
                <div><span>17:00 a 18:00</span></div>
                <div><span>18:00 a 19:00</span></div>
                <div><span>19:00 a 20:00</span></div>
                <div><span>20:00 a 21:00</span></div>
            </div>';
if($_SESSION["perfil"]=='admin')
{
    $ResUsuarios=mysqli_query($conn, "SELECT Id, Nombre, Color FROM usuarios WHERE Agenda='1' ORDER BY Nombre ASC");
    $NumResUsuarios=mysqli_num_rows($ResUsuarios);
}
elseif($_SESSION["perfil"]=='usuar')
{
    $ResUsuarios=mysqli_query($conn, "SELECT Id, Nombre, Color FROM usuarios WHERE Id = '".$_SESSION["Id"]."' AND Agenda='1' ORDER BY Nombre ASC");
    $NumResUsuarios=1;
}
elseif($_SESSION["perfil"]=='asist')
{
    $ResUsuarios=mysqli_query($conn, "SELECT Id, Nombre, Color FROM usuarios WHERE Id = '".$_SESSION["IdUsuario"]."' AND Agenda='1' ORDER BY Nombre ASC");
    $NumResUsuarios=1;
}

while($RResUsu=mysqli_fetch_array($ResUsuarios))
{
    $cadena.='<div class="horarios_agenda">
                <div style="background: '.$RResUsu["Color"].'">'.$RResUsu["Nombre"].'</div>
                <div class="hora_agenda" ';if($_SESSION["perfil"]=='admin' OR $_SESSION["Id"]==$RResUsu["Id"]){$cadena.='onclick="add_cita(\''.$fechahoy.'\', \'07:00\', \''.$RResUsu["Id"].'\')"';}$cadena.='></div>
                <div class="hora_agenda" ';if($_SESSION["perfil"]=='admin' OR $_SESSION["Id"]==$RResUsu["Id"]){$cadena.='onclick="add_cita(\''.$fechahoy.'\', \'08:00\', \''.$RResUsu["Id"].'\')"';}$cadena.='></div>
                <div class="hora_agenda" ';if($_SESSION["perfil"]=='admin' OR $_SESSION["Id"]==$RResUsu["Id"]){$cadena.='onclick="add_cita(\''.$fechahoy.'\', \'09:00\', \''.$RResUsu["Id"].'\')"';}$cadena.='></div>
                <div class="hora_agenda" ';if($_SESSION["perfil"]=='admin' OR $_SESSION["Id"]==$RResUsu["Id"]){$cadena.='onclick="add_cita(\''.$fechahoy.'\', \'10:00\', \''.$RResUsu["Id"].'\')"';}$cadena.='></div>
                <div class="hora_agenda" ';if($_SESSION["perfil"]=='admin' OR $_SESSION["Id"]==$RResUsu["Id"]){$cadena.='onclick="add_cita(\''.$fechahoy.'\', \'11:00\', \''.$RResUsu["Id"].'\')"';}$cadena.='></div>
                <div class="hora_agenda" ';if($_SESSION["perfil"]=='admin' OR $_SESSION["Id"]==$RResUsu["Id"]){$cadena.='onclick="add_cita(\''.$fechahoy.'\', \'12:00\', \''.$RResUsu["Id"].'\')"';}$cadena.='></div>
                <div class="hora_agenda" ';if($_SESSION["perfil"]=='admin' OR $_SESSION["Id"]==$RResUsu["Id"]){$cadena.='onclick="add_cita(\''.$fechahoy.'\', \'13:00\', \''.$RResUsu["Id"].'\')"';}$cadena.='></div>
                <div class="hora_agenda" ';if($_SESSION["perfil"]=='admin' OR $_SESSION["Id"]==$RResUsu["Id"]){$cadena.='onclick="add_cita(\''.$fechahoy.'\', \'14:00\', \''.$RResUsu["Id"].'\')"';}$cadena.='></div>
                <div class="hora_agenda" ';if($_SESSION["perfil"]=='admin' OR $_SESSION["Id"]==$RResUsu["Id"]){$cadena.='onclick="add_cita(\''.$fechahoy.'\', \'15:00\', \''.$RResUsu["Id"].'\')"';}$cadena.='></div>
                <div class="hora_agenda" ';if($_SESSION["perfil"]=='admin' OR $_SESSION["Id"]==$RResUsu["Id"]){$cadena.='onclick="add_cita(\''.$fechahoy.'\', \'16:00\', \''.$RResUsu["Id"].'\')"';}$cadena.='></div>
                <div class="hora_agenda" ';if($_SESSION["perfil"]=='admin' OR $_SESSION["Id"]==$RResUsu["Id"]){$cadena.='onclick="add_cita(\''.$fechahoy.'\', \'17:00\', \''.$RResUsu["Id"].'\')"';}$cadena.='></div>
                <div class="hora_agenda" ';if($_SESSION["perfil"]=='admin' OR $_SESSION["Id"]==$RResUsu["Id"]){$cadena.='onclick="add_cita(\''.$fechahoy.'\', \'18:00\', \''.$RResUsu["Id"].'\')"';}$cadena.='></div>
                <div class="hora_agenda" ';if($_SESSION["perfil"]=='admin' OR $_SESSION["Id"]==$RResUsu["Id"]){$cadena.='onclick="add_cita(\''.$fechahoy.'\', \'19:00\', \''.$RResUsu["Id"].'\')"';}$cadena.='></div>
                <div class="hora_agenda" ';if($_SESSION["perfil"]=='admin' OR $_SESSION["Id"]==$RResUsu["Id"]){$cadena.='onclick="add_cita(\''.$fechahoy.'\', \'20:00\', \''.$RResUsu["Id"].'\')"';}$cadena.='></div>';
    if($_SESSION["perfil"]=='admin')
    {
        $ResCitas=mysqli_query($conn, "SELECT * FROM citas WHERE usuario='".$RResUsu["Id"]."' AND Fecha='".$fechahoy."' AND Activa='1' ORDER BY Hora ASC");
    }
    else
    {
        $ResCitas=mysqli_query($conn, "SELECT * FROM citas WHERE usuario='".$_SESSION["Id"]."' AND usuario='".$RResUsu["Id"]."' AND Fecha='".$fechahoy."' AND Activa='1' ORDER BY Hora ASC");
    }
    
    while($RResCitas=mysqli_fetch_array($ResCitas))
    {
        $ResServicio=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM servicios WHERE Id ='".$RResCitas["Servicio"]."' LIMIT 1"));
        $ResCliente=mysqli_fetch_array(mysqli_query($conn, "SELECT Id, Nombre, ContactoWhats, ContactoCorreo, ContactoTel FROM clientes WHERE Id='".$RResCitas["Cliente"]."' LIMIT 1"));

        $tiempo=$ResServicio["Duracion"];
        $v_HorasPartes = explode(":", $tiempo);
        $minutosTotales= ($v_HorasPartes[0] * 60) + $v_HorasPartes[1];

        $porcentaje=($minutosTotales*9)/60;



        switch($RResCitas["Hora"])
        {
            case '07:00': $hora='1.0'; break;
            case '07:30': $hora='1.5'; break;
            case '08:00': $hora='2.0'; break;
            case '08:30': $hora='2.5'; break;

            case '09:00': $hora='3.0'; break;    //1.0
            case '09:30': $hora='3.5'; break;    //1.5
            case '10:00': $hora='4.0'; break;   //2.0
            case '10:30': $hora='4.5'; break;   //2.5
            case '11:00': $hora='5.0'; break;   //3.0
            case '11:30': $hora='5.5'; break;   //3.5
            case '12:00': $hora='6.0'; break;   //4.0
            case '12:30': $hora='6.5'; break;   //4.5
            case '13:00': $hora='7.0'; break;   //5.0
            case '13:30': $hora='7.5'; break;   //5.5
            case '14:00': $hora='8.0'; break;   //6.0
            case '14:30': $hora='8.5'; break;   //6.5
            case '15:00': $hora='9.0'; break;   //7.0
            case '15:30': $hora='9.5'; break;   //7.5
            case '16:00': $hora='10.0'; break;   //8.0
            case '16:30': $hora='10.5'; break;   //8.5
            case '17.00': $hora='11.0'; break;   //9.0
            case '17:30': $hora='11.5'; break;   //9.5
            case '18:00': $hora='12.0'; break;  //10.0
            case '18:30': $hora='12.5'; break;  //10.5
            case '19:00': $hora='13.0'; break;  //10.5
            case '19:30': $hora='13.5'; break;  //10.5
            case '20:00': $hora='14.0'; break;  //10.5
        }


        $cadena.='<div class="cita" style="top: calc(9% * '.$hora.'); height: '.$porcentaje.'%; background-color: '.$RResUsu["Color"].';">
                    <h5>'.$RResCitas["Hora"].'<span><i class="fas fa-ellipsis-h"></i></span></h5>
                    <h6>'.$ResServicio["Nombre"].'</h6>
                    <p>'.$ResCliente["Nombre"].'</p>
                    <p>';if($ResCliente["ContactoWhats"]==1){$cadena.='<a href="https://wa.me/+521'.$ResCliente["Celular"].'"><i class="fab fa-whatsapp-square"></i></a> | ';}if($ResCliente["ContactoCorreo"]==1){$cadena.='<a href="mailto:'.$ResCliente["CorreoE"].'"><i class="fas fa-envelope-square"></i></a> | ';}if($ResCliente["ContactoTel"]==1){$cadena.='<a href="tel:'.$ResCliente["Celular"].'"><i class="fas fa-phone-square"></i></a> | ';}$cadena.=($_SESSION["perfil"]!='asist' OR ($_SESSION["perfil"]=='asist' AND $RResCitas["VistaAsisten"]==1) ? '<a href="#" onclick="edit_cita(\''.$RResCitas["Id"].'\')"><i class="fas fa-pen-square"></i></a> | <a href="#" onclick="delete_cita(\''.$RResCitas["Id"].'\')"><i class="fas fa-calendar-times"></i></a>' : '' ).'</p>
                    <div class="menu_cita"></div>
                </div>';
    }

    $cadena.='</div>';
}

$cadena.='</div>';


echo $cadena;

?>
<script>
function add_cita(fecha, hora, usuario){
	$.ajax({
				type: 'POST',
				url : 'agenda/add_cita.php',
                data: 'fecha=' + fecha +'&hora=' + hora + '&usuario=' + usuario
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function edit_cita(cita){
	$.ajax({
				type: 'POST',
				url : 'agenda/edit_cita.php',
                data: 'cita=' + cita
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function delete_cita(cita){
	$.ajax({
				type: 'POST',
				url : 'agenda/del_cita.php',
                data: 'cita=' + cita
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function vista_mensual(mes, anno){
    $.ajax({
				type: 'POST',
				url : 'agenda/agenda_mensual.php',
                data: 'mes=' + mes +'&anno=' + anno 
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
//mostrar mensaje despues de los cambios
setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>