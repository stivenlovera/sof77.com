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
				         					  
	$Dayli_ID=$_GET['Dayli_ID'];
	$Task_ID=$_GET['Task_ID'];	
	$Actividad_ID=$_GET['Actividad_ID'];
	
	$strSQL = "DELETE FROM dayli_report_task WHERE Dayli_ID=".$Dayli_ID;		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Saved"; 	
		echo "<img src='images/spacer.gif' onload='Dayli_Report_Piso_Area_Task_Expandir(".$Task_ID.",".$Actividad_ID.");' />"; 	
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>