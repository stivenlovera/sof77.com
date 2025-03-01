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
				         					  
	foreach($_GET as $nombre_campo => $valor)
	{
	   	
	   	if  ( !empty($valor )  )
			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";			
		else
			$asignacion = "\$" . $nombre_campo . "='';";			
			
	   	eval($asignacion);
	} 	
	
	$strSQL = "DELETE FROM actividades  WHERE Actividad_ID=" . $Actividad_ID ;		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{		
	  ///
	$strSQL = "DELETE FROM report_daily_detalle WHERE actividad_id=" . $Actividad_ID ;		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	///
		echo "Deleted"; 	
		echo "<img src='images/spacer.gif' onload='Proyectos_Actividades_Lista($Pro_ID);' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>