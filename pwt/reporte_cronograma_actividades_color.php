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
				         					  
	$Actividad_ID=$_GET["Actividad_ID"];
	$Color=$_GET["Color"];
	
	$strSQL = "UPDATE actividades SET Color='" . $Color. "' ";	
	$strSQL = $strSQL . " WHERE Actividad_ID=" . $Actividad_ID ;		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{		
		echo "Saved"; 	
		echo "<img src='images/spacer.gif' onload='reporte_cronograma_actividades_lista();' />"; 
	}
	else
		echo "ERROR";	
	
	require('Library/Close_Conexion.php');	
?>