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
				         					  
	$Actividad_ID=$_POST['Actividad_ID'];
	$Pro_ID=$_POST['Pro_ID'];
	$Fecha=$_POST['Fecha'];
	
	$strSQL = "DELETE FROM actividades WHERE Actividad_ID=". $Actividad_ID;		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		///
	$strSQL = "DELETE FROM report_daily_detalle WHERE actividad_id=" . $Actividad_ID ;		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL); 
		
		echo "DELETED"; 	
		echo "<img src='images/spacer.gif' onload='Actividades_Lista(\"$Fecha_Actividad\", $Pro_ID);' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>