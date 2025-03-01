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

	$data  = explode("-",$_POST['id']);
	
	$campo = $data[0]; // nombre del campo
	$Pro_ID = $data[1]; // nombre del campo
	$Area_ID = $data[2]; // nombre del campo
	$Actividad_ID = $data[3]; // nombre del campo
	
	$value = $_POST['value']; // valor por el cual reemplazar
	$consulta = "SELECT Fecha FROM actividades WHERE Actividad_ID=".$Actividad_ID;	
	$result2=$bd->ejecutar($consulta); 	
	if (($row = mysqli_fetch_array($result2) ))							
	{	
		$Fecha=$row["Fecha"];
	}
	mysqli_free_result($result2);			
	
	$consulta = "SELECT * FROM dayli_task ";
	$consulta = $consulta."  WHERE Fecha='".$Fecha."' AND Area_ID=".$Area_ID." AND Pro_ID=".$Pro_ID;	
	//echo $strSQL."<br>";				
		
	$result=$bd->ejecutar($consulta); 	
	if (($row = mysqli_fetch_array($result) ))							
	{	
		$Task_ID = $row["Task_ID"];
		$strSQL = "UPDATE dayli_task SET ".$campo."='".$value."' WHERE Task_ID=".$Task_ID;					
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);  		
		if ($res1)
		{
			echo $value;
		}
		else
			echo "ERROR";
	}
	else
	{	
		$strSQL = "INSERT INTO dayli_task (Pro_ID, Area_ID, ".$campo.", Fecha) ";	
		$strSQL = $strSQL . " values (".$Pro_ID.",".$Area_ID.", '" .$value. "', '" . $Fecha. "')";				
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);  		
		if ($res1)
		{
			echo $value;
		}
		else
			echo "ERROR";
	}	
	mysqli_free_result($result);					
	
	require('Library/Close_Conexion.php');	
?>