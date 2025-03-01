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
				         					  
	$Maq_ID=$_GET['Maq_ID'];			
	$strSQL = "DELETE FROM maquinarias WHERE Maq_ID=".$Maq_ID;				
	//echo $strSQL;
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Deleted"; 	
		echo "<img src='images/spacer.gif' onload='Maquinaria_Lista();' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>