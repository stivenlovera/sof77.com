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
	
	$Fecha_Pedido=ConvertDateToMysqlFormat($Fecha_Pedido);	
	
	$strSQL = "UPDATE pedidos SET Ven_ID=" . $Ven_ID . ", Fecha='" . $Fecha_Pedido. "', PO='" . $PO. "', Note='" . $Note. "'";	
	$strSQL = $strSQL . " WHERE Ped_ID=".$Ped_ID;	
  
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Saved"; 								
		echo "<img src='images/spacer.gif' onload='Proyectos_Pedidos_Lista($Pro_ID);' />"; 	
	}
	else
	{
		echo "ERROR";
	}
	
	require('Library/Close_Conexion.php');	
?>