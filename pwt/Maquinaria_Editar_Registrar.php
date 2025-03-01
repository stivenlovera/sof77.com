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
	
	if ($Activo)
		$Activo="True";
	else
		$Activo="False";
		
	$strSQL = "UPDATE maquinarias SET Nombre='".$Nombre."', Note='".$Note."', Aux1='".$Aux1."', Aux2='".$Aux2."', Aux3='".$Aux3."', Activo=".$Activo." WHERE Maq_ID=".$Maq_ID;	
			
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Saved"; 	
		echo "<img src='images/spacer.gif' onload='Maquinaria_Lista();' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>