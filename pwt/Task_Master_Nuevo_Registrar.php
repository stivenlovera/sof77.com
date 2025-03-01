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
	
	$strSQL = "INSERT INTO task_master (Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje ) ";	
	$strSQL = $strSQL . " values ('" . $Nombre . "','" . $Horas_Estimadas. "','" . $Horas_Estimadas . "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje. "')";		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Saved"; 	
		echo "<img src='images/spacer.gif' onload='Task_Master_Lista();' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>