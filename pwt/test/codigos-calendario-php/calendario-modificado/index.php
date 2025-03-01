<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title></title>
	<link rel="STYLESHEET" type="text/css" href="estilo.css">
</head>

<body>
<div align="center">
<?
require ("calendario.php");

if (!$HTTP_POST_VARS && !$HTTP_GET_VARS){
	$tiempo_actual = time();
	$mes = date("n", $tiempo_actual);
	$ano = date("Y", $tiempo_actual);
	$dia=date("d");
	$fecha=$ano . "-" . $mes . "-" . $dia;
}else {
	$mes = $nuevo_mes;
	$ano = $nuevo_ano;
	$dia = $dia;
	$fecha=$ano . "-" . $mes . "-" . $dia;
}

echo"Fecha Seleccionada <input type=text name=fecha value=$fecha>";
mostrar_calendario($dia,$mes,$ano);

?>
</div>
</body>
</html>
