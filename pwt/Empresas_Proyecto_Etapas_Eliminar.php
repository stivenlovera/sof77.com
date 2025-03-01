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
				         					  
	$Etapas_ID=$_GET['Etapas_ID'];
	$Pro_ID=$_GET['Pro_ID'];
		
	$strSQL = "DELETE FROM etapas WHERE Etapas_ID=".$Etapas_ID;	
	
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{		
		echo "Record Deleted"; 	
		echo "<img src='images/spacer.gif' onload='Empresas_Proyectos_Etapas_Lista($Pro_ID);' />"; 
	}
	else
	{
		echo "ERROR EN LA ELIMINACION";	
	?>
		<img src='images/icon_recargar.gif' onclick='Empresas_Proyectos_Etapas_Lista(<?php echo $Pro_ID; ?>);' />
	<?php
	}	

	
	require('Library/Close_Conexion.php');	
?>