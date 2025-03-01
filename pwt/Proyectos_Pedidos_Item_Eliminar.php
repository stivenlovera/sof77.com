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
				         					  
	$Ped_Mat_ID=$_GET['Ped_Mat_ID'];
	$Ped_ID=$_GET['Ped_ID'];
	
	$strSQL = "DELETE FROM pedidos_material WHERE Ped_Mat_ID=". $Ped_Mat_ID;		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Recorded DELETED"; 	
		echo "<img src='images/spacer.gif' onload='Proyectos_Pedidos_Items_Lista($Ped_ID);' />"; 
		
		$consulta = "SELECT Pro_ID FROM pedidos WHERE Ped_ID=".$Ped_ID;		
		$result2=$bd->ejecutar($consulta); 	
		while (($row2 = mysqli_fetch_array($result2) ))							
		{		
			$Pro_ID = $row2["Pro_ID"];
		}		
		echo "<img src='images/spacer.gif' onload='Proyectos_Pedidos_Lista($Pro_ID) ;' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>