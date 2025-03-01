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

	$strSQL = "INSERT INTO area_control (Are_IDT,Pro_ID, Nombre, Note, Aux1, Aux2, Aux3) ";	
	$strSQL = $strSQL . " values ('".$Are_IDT."',".$Pro_ID.",'" . $Nombre . "', '" . $Note. "','" . $Aux1 . "','" . $Aux2. "', '". $Aux3. "')";		
  
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Saved"; 								
		echo "<img src='images/spacer.gif' onload='Proyectos_Area_Lista($Pro_ID);' />"; 
	}
	else
	{
		echo "ERROR";
	}
	
	require('Library/Close_Conexion.php');	
?>