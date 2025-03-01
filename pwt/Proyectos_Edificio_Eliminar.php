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
				         					  
	$Edificio_ID=$_GET['Edificio_ID'];	
	$Pro_ID=$_GET['Pro_ID'];	
	
	$consulta = "SELECT * FROM floor WHERE Edificio_ID=".$Edificio_ID;	
	//echo $consulta."  llego a edificio eliminar <br>"	;
	$result2=$bd->ejecutar($consulta); 	
	if (!(($row2 = mysqli_fetch_array($result2) )))
	{			
		$strSQL = "DELETE FROM edificios WHERE Edificio_ID=".$Edificio_ID;		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);  		
		if ($res1)
		{
			//echo "Deleted"; 	
			echo "<img src='images/spacer.gif' onload='Proyectos_Piso_Lista(".$Pro_ID.");' />"; 	
		}
		else
			echo "ERROR";
	}
	else
		echo "It is not possible delete.Bldg.has other information";	
	
	mysqli_free_result($result2);	
	require('Library/Close_Conexion.php');	
?>