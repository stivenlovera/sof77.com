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
	
	$strSQL = "UPDATE proyectos SET  Estatus_ID='".$Estatus_ID."' WHERE Pro_ID=".$Pro_ID;	
	//echo $strSQL;
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Saved"; 			
	}
	else
	{
		echo "ERROR";
	}	

	require('Library/Close_Conexion.php');	
?>