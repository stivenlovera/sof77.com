<?php
require ("calendario_modificado.php");
$mes = $_GET["nuevo_mes"];
$ano = $_GET["nuevo_ano"];
mostrar_calendario($mes,$ano);
?>
