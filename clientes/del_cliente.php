<?php
//Inicio la sesion 
session_start();

include('../conexion.php');

$ResCliente=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM clientes WHERE Id='".$_POST["cliente"]."' LIMIT 1"));

$cadena='<div class="c100 card">
            <h2>Eliminar Cliente</h2>
            <label class="l_form">Esta seguro de eliminar el cliente '.$ResCliente["Nombre"].'</label>
            <label class="l_form"><a href="#" onclick="delete_cliente_2(\''.$ResCliente["Id"].'\')">Si</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="clientes()">No</a></label>
        </div>';
    
echo $cadena;

?>
<script>
function delete_cliente_2(cliente){

    $.ajax({
                type: 'POST',
                url : 'clientes/clientes.php',
                data: 'hacer=borracliente&cliente=' + cliente
    }).done (function ( info ){
        $('#contenido').html(info);
    });
}

</script>