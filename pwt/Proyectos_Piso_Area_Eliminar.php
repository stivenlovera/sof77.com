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
	$Area_ID=$_GET['Area_ID'];	
	
	$consulta = "SELECT * FROM task WHERE Area_ID=".$Area_ID;		
	$result2=$bd->ejecutar($consulta); 	
	if (!(($row2 = mysqli_fetch_array($result2) )))
	{			
		$strSQL = "DELETE FROM area_control WHERE Area_ID=".$Area_ID;		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);  		
		if ($res1)
		{
			//echo "Deleted"; 	
			echo "<img src='images/spacer.gif' onload='Proyectos_Piso_Expandir(".$Floor_ID.");' />"; 	
		}
		else
			echo "ERROR";
	}
	else
		echo "Not is possible delete. Area has other  information";	
	
	mysqli_free_result($result2);	
	require('Library/Close_Conexion.php');	
?>