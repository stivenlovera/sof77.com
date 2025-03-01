<?php	 		
	session_name("Administrador");
	session_start();		
	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	 	
		
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	
	require('Library/funciones.php');	
				         					  
	<?php

//Almacenamos en variables lo ingresado en el formulario
$Nro_act = $_POST["Nro_act"];
echo $Nro_act;
	
	
	require('Library/Close_Conexion.php');	
?>