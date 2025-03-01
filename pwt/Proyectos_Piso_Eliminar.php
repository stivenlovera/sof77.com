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
				         					  
	$Floor_ID=$_GET['Floor_ID'];	
	$Pro_ID=$_GET['Pro_ID'];	
	
	$consulta = "SELECT * FROM area_control WHERE Floor_ID=".$Floor_ID;	
	echo $consulta."  llego a piso eliminar <br>"	;
	$result2=$bd->ejecutar($consulta); 	
	if (!(($row2 = mysqli_fetch_array($result2) )))
	{			
		$strSQL = "DELETE FROM floor WHERE Floor_ID=".$Floor_ID;		
		echo $strSQL."<br>";				
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
		echo "Not is possible delete. Floor has other  information";	
	
	mysqli_free_result($result2);	
	require('Library/Close_Conexion.php');	
?>