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

	$RDA_ID=$_GET["RDA_ID"];
	$Reg_ID=$_GET["Reg_ID"];
	$Pro_ID=$_GET["Pro_ID"];
	$MiFila=$_GET["MiFila"];
	
	$sql = "DELETE FROM registro_diario_actividad WHERE RDA_ID=".$RDA_ID;														
	$result=$bd->ejecutar($sql); 		
	if ($result)	
	{
		echo "<img src='images/indicator.gif' width='5' height='5' onload='foreman_registro_actividad_detalle(".$Reg_ID.",".$Pro_ID.");'/>";	
	}
	else
	{
		echo "Error";
	}
	require('Library/Close_Conexion.php');	
?>
