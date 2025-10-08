<?php
date_default_timezone_set('America/Mexico_City');
//Inicio la sesion 
session_start();

include('../conexion.php');

$fechahoy=date("Y-m-d");

// Recibir las variables POST
$mes = isset($_POST['mes']) ? (int)$_POST['mes'] : date('n');
$anno = isset($_POST['anno']) ? (int)$_POST['anno'] : date('Y');

// Calcular el primer día del mes y cuántos días tiene
$primerDia = mktime(0, 0, 0, $mes, 1, $anno);
$diasEnMes = date('t', $primerDia);

// Día de la semana del primer día (1=Lunes, 7=Domingo)
$diaSemana = date('N', $primerDia);

// Nombres de los días
$dias = ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'];

$meses = [
  1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
  'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];

$cadena='<h2>'.$meses[$mes].' de '.$anno.'</h2>
        <div class="c100" style="text-align: right; padding: 10px;">| <a href="#" onclick="agenda(document.getElementById(\'fechacita\').value)">Vista diaria</a> | <input type="date" name="fechacita" id="fechacita" value="'.$fechahoy.'" style="width:130px" onchange="agenda(this.value)"> | <a href="#" onclick="add_cita(';if($_SESSION["perfil"]!='admin'){$cadena.='\''.$fechahoy.'\', \'1.0\', \''.$_SESSION["Id"].'\'';}$cadena.=')">Nueva Cita</a> |</div>
        <table class="calendario">
            <tr>';
foreach ($dias as $d)
{
    $cadena.='  <th>'.$d.'</th>';
}
$cadena.='  </tr>
            <tr>';
// Rellenar celdas vacías antes del primer día del mes
for ($i = 1; $i < $diaSemana; $i++) {
    $cadena.='  <td></td>';
}

$contador = $diaSemana;
for ($dia = 1; $dia <= $diasEnMes; $dia++) {
    $cadena.='  <td onclick="agenda(\''.$anno.'-'.$mes.'-'.($dia < 10 ? '0' . $dia : $dia).'\')" style="cursor: pointer;">
                    <div class"dia-numero">'.$dia.'</div>';
    $dia = ($dia < 10) ? '0' . $dia : $dia;
    $ResCitas=mysqli_query($conn, "SELECT s.Nombre AS Servicio, u.Color AS Color FROM citas AS c 
                                    INNER JOIN servicios AS s ON s.Id = c.Servicio
                                    INNER JOIN usuarios AS u ON u.Id = c.Usuario 
                                    WHERE c.Fecha = '".$anno.'-'.$mes.'-'.$dia."' ORDER BY c.Hora ASC");
    while($RResC = mysqli_fetch_array($ResCitas)){
        $cadena.='<div style="background: '.$RResC["Color"].'; width: 100%; display: block; text-overflow: ellipsis; text-align: left; padding: 5px; border-radius: 5px;">'.$RResC["Servicio"].'</div>';
    }
    $cadena.='  </td>';

    // Si llega al domingo, nueva fila
    if ($contador % 7 == 0) {
        $cadena.='</tr><tr>';
    }
    $contador++;
}

// Rellenar celdas vacías al final si es necesario
while (($contador - 1) % 7 != 0) {
    $cadena.='  <td></td>';
    $contador++;
}
$cadena.='  </tr>
        </table>';

echo $cadena;
?>
<style>
  table.calendario {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
    font-family: Arial, sans-serif;
  }
  .calendario th {
    background: #4CAF50;
    color: white;
    padding: 10px;
  }
  .calendario td {
    height: auto;
    vertical-align: top;
    border: 1px solid #ddd;
    position: relative;
  }
  .dia-numero {
    position: absolute;
    top: 5px;
    right: 5px;
    background: #4CAF50;
    color: white;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    line-height: 25px;
    font-size: 12px;
  }
</style>