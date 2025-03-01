<?php	 		
	session_name("Administrador");
	session_start();		
	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	 			
	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');
	
	foreach($_POST as $nombre_campo => $valor)
	{
	   	
	   	if  ( !empty($valor )  )
			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";			
		else
			$asignacion = "\$" . $nombre_campo . "='';";			
			
	   	eval($asignacion);
	} 		
	
	$strSQL = "INSERT INTO pedidos_material (Ped_ID, Mat_ID, Cantidad, Aux1) ";	
	$strSQL = $strSQL . " values (".$Ped_ID_Item."," . $Mat_ID_Pedido . "," .$Cantidad. ", '".$item_detalle."')";		
  
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Saved"; 								
		echo "<img src='images/spacer.gif' onload='Proyectos_Pedidos_Items_Lista($Ped_ID_Item);' />"; 
		
		$consulta = "SELECT Pro_ID FROM pedidos WHERE Ped_ID=".$Ped_ID_Item;		
		$result2=$bd->ejecutar($consulta); 	
		while (($row2 = mysqli_fetch_array($result2) ))							
		{		
			$Pro_ID = $row2["Pro_ID"];
		}		
		echo "<img src='images/spacer.gif' onload='Proyectos_Pedidos_Lista($Pro_ID) ;' />"; 
	}
	else
	{
		echo "ERROR";
	}
	
	require('Library/Close_Conexion.php');	
?>