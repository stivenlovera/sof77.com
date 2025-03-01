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
				         					  
	foreach($_POST as $nombre_campo => $valor)
	{
	   	
	   	if  ( !empty($valor )  )
			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";			
		else
			$asignacion = "\$" . $nombre_campo . "='';";			
			
	   	eval($asignacion);
	} 		
		
	$strSQL = "UPDATE area_control SET Nombre='" . $Nombre . "', Note='" . $Note. "', Aux1='" . $Aux1. "', Aux2='" . $Aux2. "', Aux3='" . $Aux3. "' ";	
	$strSQL = $strSQL . " WHERE Area_ID=" . $Area_ID ;	
	
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Updated"; 	
		echo "<img src='images/spacer.gif' onload='Proyectos_Area_Lista($Pro_ID);' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>