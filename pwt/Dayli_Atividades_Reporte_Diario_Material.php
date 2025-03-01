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
	
	$tipo = $data[0]; // nombre del campo
	$Pro_ID = $data[1]; // nombre del campo
	$Mat_ID = $data[2]; // nombre del campo
	$Actividad_ID = $data[3]; // nombre del campo
	$Task_ID = $data[4]; // nombre del campo
	
	$value = $_POST['value']; // valor por el cual reemplazar
	$consulta = "SELECT Fecha FROM actividades WHERE Actividad_ID=".$Actividad_ID;	
	$result2=$bd->ejecutar($consulta); 	
	if (($row = mysqli_fetch_array($result2) ))							
	{	
		$Fecha_Pedido=$row["Fecha"];
	}
	mysqli_free_result($result2);	
		
	
	//$consulta = "SELECT * FROM pedidos_material pm INNER JOIN pedidos p ON pm.Ped_ID=p.Ped_ID AND p.Fecha='".$Fecha_Pedido."' ";
	$consulta = "SELECT * FROM pedidos_material pm INNER JOIN pedidos p ON pm.Ped_ID=p.Ped_ID ";
	$consulta = $consulta."  WHERE pm.Mat_ID=".$Mat_ID." AND pm.Actividad_ID=".$Actividad_ID." AND pm.Task_ID=".$Task_ID." AND (NOT (pm.".$tipo." is NULL)) ";	
	//echo $strSQL."<br>";				
		
	$result=$bd->ejecutar($consulta); 	
	if (($row = mysqli_fetch_array($result) ))							
	{	
		$Ped_Mat_ID_Usada = $row["Ped_Mat_ID"];
		$strSQL = "UPDATE pedidos_material SET ".$tipo."=".$value." WHERE Ped_Mat_ID=".$Ped_Mat_ID_Usada;					
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
		$strSQL = "INSERT INTO pedidos (Pro_ID, Ven_ID, OperatorID, Fecha) ";	
		$strSQL = $strSQL . " values (".$Pro_ID.",-1," . $_SESSION["OperatorID"]. ",'" . $Fecha_Pedido. "')";				
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);  		
		
		$consulta = "SELECT Max(Ped_ID) AS Ped_ID FROM pedidos ";	
		$result2=$bd->ejecutar($consulta); 	
		if (($row = mysqli_fetch_array($result2) ))							
		{	
			$Ped_ID=$row["Ped_ID"];
		}
		mysqli_free_result($result2);		

		$strSQL = "INSERT INTO pedidos_material (Ped_ID, Mat_ID, Task_ID, Actividad_ID, ".$tipo.") ";	
		$strSQL = $strSQL . " values (".$Ped_ID."," . $Mat_ID . ",".$Task_ID.",".$Actividad_ID."," .$value. ")";
			
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