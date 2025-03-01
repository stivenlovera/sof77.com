<head>
<title>Fecha Actual</title>
</head>
<body>
Hora del Servidor: <?php echo date("l jS \of F Y h:i:s A - \G\M\T: P", time());?><br />
Hora actual: <?php echo date("h:i:s", time());?><br />
Hora actual: <?php echo date();?><br />
<?php
function mifechagmt($fecha_timestamp,$gmt=0)
{
	$timestamp=$fecha_timestamp; //puedes poner aqui la hora en formato "Unix timestamp" obtenida de una tabla
	$diferenciahorasgmt = (date('Z', time()) / 3600 - $gmt) * 3600; //La diferencia de horas entre el GMT del servidor y el GMT que queremos, en mi caso mi servidor es GTM-4, y si quiero un GTM -5 la diferencia será de -1 hora
	$timestamp_ajuste = $timestamp - $diferenciahorasgmt; //restamos a la hora actual la diferencia horaria en mi caso será -1 hora
	$fecha = date("l jS \of F Y h:i:s A", $timestamp_ajuste); //mostramos la fecha/hora
	return $fecha;
}
?>
<table border="1">
<?php 
for ($i=-12;$i<=12;$i++)
{
echo "<tr><td>GMT $i</td><td>".mifechagmt(time(),$i)."</td></tr>";
}
?>
</table>
 
</body>
</html>