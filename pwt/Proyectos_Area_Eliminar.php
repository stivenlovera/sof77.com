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
				         					  
	$Area_ID=$_GET['Area_ID'];
	$Pro_ID=$_GET['Pro_ID'];
	
	$strSQL = "DELETE FROM area_control WHERE Area_ID=". $Area_ID;		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "DELETED"; 	
		echo "<img src='images/spacer.gif' onload='Proyectos_Area_Lista($Pro_ID);' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>