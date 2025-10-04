<?php
//Inicio la sesion 
session_start();

include('../conexion.php');

$ResCita=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM citas WHERE Id='".$_POST["cita"]."' LIMIT 1"));
$ResUsuario=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM usuarios WHERE Id='".$ResCita["Usuario"]."' LIMIT 1"));
$ResCliente=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM clientes WHERE Id='".$ResCita["Cliente"]."' LIMIT 1"));

$cadena='<div class="c100 card">
            <h2>Eliminar Cita</h2>
            <label class="l_form">Se eliminara la cita de '.$ResCliente["Nombre"].' con '.$ResUsuario["Nombre"].'</label>
            <label class="l_form"><a href="#" onclick="delete_cita_2(\''.$ResCita["Id"].'\')">Si</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="agenda()">No</a></label>
        </div>';
    
echo $cadena;

?>
<script>
function delete_cita_2(cita){

    $.ajax({
                type: 'POST',
                url : 'agenda/agenda.php',
                data: 'hacer=borracita&cita=' + cita
    }).done (function ( info ){
        $('#contenido').html(info);
    });
}

</script>