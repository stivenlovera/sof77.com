<?php
include ("calendario/calendario.php");
?>

<html>
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=ISO-8859-1"> 
	<title>Utilización del calendario</title>
	<script language="JavaScript" src="calendario/javascripts.js"></script>
	<link rel="STYLESHEET" type="text/css" href="calendario/estilo.css">
</head>

<body>
<h1>Uso de la librería del calendario</h1>
Para seleccionar una fecha que se colocaría en un campo de formulario
<br>
<br>
<br>
<form name="fcalen">
Fecha inicio: 
<?php
escribe_formulario_fecha_vacio("fecha1","fcalen");
?>
<br>
<br>
Fecha final:
<?php
escribe_formulario_fecha_vacio("fecha2","fcalen");
?>

</form>

</body>
</html>
	