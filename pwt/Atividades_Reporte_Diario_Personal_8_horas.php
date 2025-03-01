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
	
	$Pro_ID=$_GET['Pro_ID'];	
	$Actividad_ID=$_GET['Actividad_ID'];	

	$consulta = "SELECT p.*, ap.HContract, ap.HTM, ap.Note FROM personal p 
					INNER JOIN actividad_personal ap ON ap.Empleado_ID=p.Empleado_ID 
					WHERE ap.Actividad_ID=".$Actividad_ID;	
	//echo $consulta;
	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Empleado_ID = $row2["Empleado_ID"];		
		if (is_null($HContract))
		{			
			$Note = $row2["Note"];		
			$strSQL = "UPDATE actividad_personal SET HContract='8',Note='G.H.S.UP' WHERE Actividad_ID=".$Actividad_ID." AND Empleado_ID=".$Empleado_ID." AND (Note IS Null OR Note=' ') and (HContract=0 OR HContract IS Null OR HContract=' ' ) AND (HTM=0 OR HTM IS Null OR HTM=' ')";	
			
			
									
			$res1=$bd->ejecutar($strSQL);  	
		}		
	}
	mysqli_free_result($result2);
	
?>	
	<img src="images/spacer.gif" onload="Atividades_Reporte_Diario(<?php echo $Actividad_ID; ?>, <?php echo $Pro_ID; ?>);" width="1" height="1" /> 
<?php
	require('Library/Close_Conexion.php');	
?>