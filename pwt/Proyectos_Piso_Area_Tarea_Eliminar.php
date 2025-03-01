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
				         					  
	$Task_ID=$_GET['Task_ID'];	
	$Area_ID=$_GET['Area_ID'];	
	
	$strSQL = "DELETE FROM task WHERE Task_ID=".$Task_ID;		
	echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Saved"; 	
		echo "<img src='images/spacer.gif' onload='Proyectos_Piso_Area_Expandir(".$Area_ID.");' />"; 	
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>