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
	
	$strSQL = "INSERT INTO actividad_personal (Empleado_ID, Actividad_ID) ";	
	$strSQL = $strSQL . " values (" . $Empleado_ID . ", " . $Actividad_ID . ")";		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		echo "Saved"; 
		
		$consulta = "SELECT Pro_ID FROM actividades WHERE Actividad_ID=".$Actividad_ID;			
		$result2=$bd->ejecutar($consulta); 	
		while (($row2 = mysqli_fetch_array($result2) ))							
		{	
			$Pro_ID = $row2["Pro_ID"];	
		}
		mysqli_free_result($result2);
		
		$consulta = "SELECT Estado, Cargo FROM personal WHERE Empleado_ID=".$Empleado_ID;			
		$result2=$bd->ejecutar($consulta); 	
		while (($row2 = mysqli_fetch_array($result2) ))							
		{	
			$Estado=strtoupper($row2["Estado"]);	
			$Cargo=strtoupper($row2["Cargo"]);
		}
		mysqli_free_result($result2);
		
		
		
		
		//record in registro_diario 
		
		$strSQL = "INSERT INTO registro_diario (Empleado_ID, Actividad_ID,Pro_ID,Fecha,Direc_Estado,Cargo) ";	
		$strSQL = $strSQL . " values (" . $Empleado_ID . ", " . $Actividad_ID . ",".$Pro_ID.",'".$Fecha. "','".$Estado."','".$Cargo. "')";		
//	echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  	
	
	
		$consulta = "SELECT Reg_ID FROM registro_diario WHERE Actividad_ID=".$Actividad_ID." AND	Empleado_ID=".$Empleado_ID." AND Pro_ID=".$Pro_ID." AND	Fecha ='".$Fecha."'";			
		//echo $consulta."<br>";
		$result2=$bd->ejecutar($consulta); 	
		while (($row2 = mysqli_fetch_array($result2) ))							
		{	
			$Reg_ID = $row2["Reg_ID"];	
		}
		mysqli_free_result($result2);
	
	
		$strSQL = "INSERT INTO registro_diario_actividad (Reg_ID) ";	
		$strSQL = $strSQL . " values (" . $Reg_ID.")";		
		$res1=$bd->ejecutar($strSQL);  	
		//echo $strSQL."<br>";
		
		// end record in registro diario 
	

		echo "<img src='images/spacer.gif' onload='reporte_cronograma_actividades_lista($Pro_ID);' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>