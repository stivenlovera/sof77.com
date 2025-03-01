<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Calendario PHP</title>
	<link rel="STYLESHEET" type="text/css" href="estilo.css">
</head>

<body>
<div align="center">
<?php
require ("calendario.php");

if ($_POST) {
	$mes = $_POST["nuevo_mes"];
	$ano = $_POST["nuevo_ano"];
}elseif ($_GET){
	$mes = $_GET["nuevo_mes"];
	$ano = $_GET["nuevo_ano"];
}else{
	$tiempo_actual = time();
	$mes = date("n", $tiempo_actual);
	$ano = date("Y", $tiempo_actual);
}

mostrar_calendario($mes,$ano);
formularioCalendario($mes,$ano);
?>
</div>
</body>
</html>
