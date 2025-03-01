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
				         					  
	$Mat_ID=$_GET['Mat_ID'];
	$Pro_ID=$_GET['Pro_ID'];
	
	$strSQL = "DELETE FROM materiales WHERE Mat_ID=". $Mat_ID;		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Recorded DELETED"; 	
		echo "<img src='images/spacer.gif' onload='Proyectos_Materiales_Lista($Pro_ID);' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>