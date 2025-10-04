<?php
//Inicio la sesion 
session_start();

include('../conexion.php');

$ResServ=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM servicios WHERE Id='".$_POST["servicio"]."' LIMIT 1"));

$cadena='<div class="c100 card">
            <h2>Eliminar usuario</h2>
            <label class="l_form">Esta seguro de eliminar el servicio '.$ResServ["Nombre"].'</label>
            <label class="l_form"><a href="#" onclick="delete_serv_2(\''.$ResServ["Id"].'\')">Si</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="servicios()">No</a></label>
        </div>';
    
echo $cadena;

?>
<script>
function delete_serv_2(servicio){

    $.ajax({
                type: 'POST',
                url : 'servicios/servicios.php',
                data: 'hacer=borraservicio&servicio=' + servicio
    }).done (function ( info ){
        $('#contenido').html(info);
    });
}

</script>