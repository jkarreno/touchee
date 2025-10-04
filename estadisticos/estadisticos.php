<?php
date_default_timezone_set('America/Mexico_City');
//Inicio la sesion 
session_start();

include('../conexion.php');

$ResTCitas=mysqli_fetch_array(mysqli_query($conn, "SELECT count(Id) AS TCitas FROM citas"));
$ResTCCanc=mysqli_fetch_array(mysqli_query($conn, "SELECT count(Id) AS TCitas FROM citas wHERE Activa=0"));
$ResTCReal=mysqli_fetch_array(mysqli_query($conn, "SELECT count(Id) AS TCitas FROM citas wHERE Activa=1"));

$ResUsuarios=mysqli_query($conn, "SELECT Usuario FROM usuarios WHERE Agenda='1' ORDER BY Usuario ASC");
$CRU=mysqli_num_rows($ResUsuarios);
$i=1;
while($RResUsuarios=mysqli_fetch_array($ResUsuarios))
{
    $label.='\''.$RResUsuarios["Usuario"].'\'';if($i<$CRU){$label.=', ';}
    $i++;
}

$ResCitasU=mysqli_query($conn, "SELECT count(c.id) AS citas, u.Usuario AS Nombre FROM citas AS c 
                                INNER JOIN usuarios AS u ON u.id=c.Usuario 
                                WHERE c.Activa='1'
                                GROUP BY c.Usuario ORDER BY u.Usuario");
$CRCU=mysqli_num_rows($ResCitasU);
$j=1;
while($RResCitasU=mysqli_fetch_array($ResCitasU))
{
    $data.='\''.$RResCitasU["citas"].'\'';if($j<$CRCU){$data.=', ';}
    $j++;
}

$ResCitasCU=mysqli_query($conn, "SELECT count(c.id) AS citas, u.Usuario AS Nombre FROM citas AS c 
                                INNER JOIN usuarios AS u ON u.id=c.Usuario 
                                WHERE c.Activa='0'
                                GROUP BY c.Usuario ORDER BY u.Usuario");
$CRCCU=mysqli_num_rows($ResCitasCU);
$k=1;
while($RResCitasCU=mysqli_fetch_array($ResCitasCU))
{
    $datac.='\''.$RResCitasCU["citas"].'\'';if($k<$CRCCU){$datac.=', ';}
    $k++;
}

//grafica citas por usuario
$cadena='<div class="c70 card">
            <h2>Estadisticos de usuarios</h2>
            <canvas id="myChart"></canvas>
        </div>
        
        <script>
            var ctx = document.getElementById(\'myChart\').getContext(\'2d\');
            var myChart = new Chart(ctx, {
                type: \'line\',
                data: {
                    labels: ['.$label.'],
                    datasets: [{
                        label: \'Citas\',
                        data: ['.$data.'],
                        borderColor: [
                            \'rgba(55,184,60, 1)\'
                        ],
                        fill: false
                    },
                    {
                        label: \'Citas Canceladas\',
                        data: ['.$datac.'],
                        borderColor: [
                            \'rgba(105,93,233, 1)\'
                        ],
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>';

//total de citas
$cadena.='<div class="c100 estadisticos">
            <div class="c30">
                <div class="c80 card">
                    <h3><i class="far fa-calendar-alt"></i> Total de citas agendadas: '.$ResTCitas["TCitas"].'</h3>
                </div>
            </div>
            <div class="c30">
                <div class="c80 card">
                    <h3><i class="fas fa-calendar-check"></i> Total de citas realizadas: '.$ResTCReal["TCitas"].'</h3>
                </div>
            </div>
            <div class="c30">
                <div class="c80 card">
                    <h3><i class="fas fa-calendar-times"></i> Total de citas canceladas: '.$ResTCCanc["TCitas"].'</h3>
                </div>
            </div>
        </div>';

//estadisticos de servicios
$ResServicios=mysqli_query($conn, "SELECT Nombre FROM servicios ORDER BY Nombre ASC");
$TRS=mysqli_num_rows($ResServicios);
$a=1;
while($RResServicios=mysqli_fetch_array($ResServicios))
{
    $labels.='\''.$RResServicios["Nombre"].'\'';if($a<$TRS){$labels.=', ';}
    $a++;
}

$ResServiciosI=mysqli_query($conn, "SELECT count(c.id) AS citas, s.Nombre AS Nombre FROM citas AS c 
                                INNER JOIN servicios AS s ON s.id=c.Servicio 
                                WHERE c.Activa='1'
                                GROUP BY s.Nombre ORDER BY s.Nombre");
$TRSI=mysqli_num_rows($ResServiciosI);
$b=1;
while($RResServiciosI=mysqli_fetch_array($ResServiciosI))
{
    $datas.='\''.$RResServiciosI["citas"].'\'';if($b<$TRSI){$datas.=', ';}
    $b++;
}

$cadena.='<div class="c70 card">
            <h2>Estadisticos de Servicios</h2>
            <canvas id="myChart2"></canvas>
        </div>
        
        <script>
            var ctx = document.getElementById(\'myChart2\').getContext(\'2d\');
            var myChart2 = new Chart(ctx, {
                type: \'line\',
                data: {
                    labels: ['.$labels.'],
                    datasets: [{
                        label: \'Servicios\',
                        data: ['.$datas.'],
                        borderColor: [
                            \'rgba(55,184,60, 1)\'
                        ],
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>';
        


echo $cadena;
?>