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
				         					  
	$Ped_ID=$_GET['Ped_ID'];
	$Pro_ID=$_GET['Pro_ID'];
	
	$strSQL = "DELETE FROM pedidos WHERE Ped_ID=". $Ped_ID;		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		$strSQL = "DELETE FROM pedidos_material WHERE Ped_ID=". $Ped_ID;		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);  
	
		echo "Recorded DELETED"; 	
		echo "<img src='images/spacer.gif' onload='Proyectos_Pedidos_Lista($Pro_ID);' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>