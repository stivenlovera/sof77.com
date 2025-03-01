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
				         					  
	$Empleado_ID=$_GET['Empleado_ID'];	
	$Actividad_ID=$_GET['Actividad_ID'];	
	$Fecha=$_GET['Fecha'];	
	
	$strSQL = "DELETE FROM actividad_personal WHERE Empleado_ID=" . $Empleado_ID . " AND Actividad_ID=" . $Actividad_ID;	

	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Deleted"; 
		
		$consulta = "SELECT Pro_ID FROM actividades WHERE Actividad_ID=".$Actividad_ID;			
		$result2=$bd->ejecutar($consulta); 	
		while (($row2 = mysqli_fetch_array($result2) ))							
		{	
			$Pro_ID = $row2["Pro_ID"];	
		}
		mysqli_free_result($result2);
		
		// delete from registro_diario 
		
		$consulta = "SELECT Reg_ID FROM registro_diario WHERE Actividad_ID=".$Actividad_ID." AND	Empleado_ID=".$Empleado_ID." AND Pro_ID=".$Pro_ID." AND	Fecha ='".$Fecha."'";			
		$result2=$bd->ejecutar($consulta); 	
		while (($row2 = mysqli_fetch_array($result2) ))							
		{	
			$Reg_ID = $row2["Reg_ID"];	
		}
		mysqli_free_result($result2);
		
		
		$strSQL = "DELETE FROM registro_diario WHERE Empleado_ID=" . $Empleado_ID . " AND Actividad_ID=" . $Actividad_ID. " AND Pro_ID=" . $Pro_ID;	
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);  	
		
		$strSQL = "DELETE FROM registro_diario_actividad WHERE Reg_ID=" .$Reg_ID;	
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);  	
		
				
		// end from registro_diario 
			
		
		echo "<img src='images/spacer.gif' onload='reporte_cronograma_actividades_lista($Pro_ID);' />";  
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>