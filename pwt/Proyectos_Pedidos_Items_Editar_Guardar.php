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
	
	$strSQL = "UPDATE pedidos_material SET Mat_ID=" . $Mat_ID_Pedido . ", Cantidad=" . $Cantidad. ", Aux1='" . $item_detalle . "'";	
	$strSQL = $strSQL . " WHERE Ped_Mat_ID=" . $Ped_Mat_ID ;		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Update Data"; 	
		echo "<img src='images/spacer.gif' onload='Proyectos_Pedidos_Items_Lista($Ped_ID_Item);' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>