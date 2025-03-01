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

	$Area_ID=$_GET["Area_ID"];
	$Fila=$_GET["Fila"];
	
	$RDA_ID=$_GET["RDA_ID"];
	$Task_ID=-1;

	$sql = "SELECT * FROM registro_diario_actividad rda INNER JOIN task t ON rda.Task_ID=t.Task_ID ";
		$sql = $sql . " INNER JOIN area_control a ON t.Area_ID=a.Area_ID ";
		$sql = $sql . " INNER JOIN floor f ON f.Floor_ID=a.Floor_ID ";
		$sql = $sql . " INNER JOIN edificios e ON e.Edificio_ID=f.Edificio_ID ";
		$sql = $sql . " WHERE RDA_ID=".$RDA_ID;														
	$result77=$bd->ejecutar($sql); 			

	while (($row77 = mysqli_fetch_array($result77) ))	
	{
		$Task_ID=$row77["Task_ID"];
	}
	mysqli_free_result($result77);
	
	$Cantidad=0;
	$sql = "select COUNT(*) AS Cantidad FROM task WHERE Area_ID=".$Area_ID;												
	$result=$bd->ejecutar($sql); 		
	if (($row = mysqli_fetch_array($result) ))	
	{
		$Cantidad=$row["Cantidad"];
	}
	mysqli_free_result($result);	
	
	if ($Cantidad>1)
	{	
?>		 
		<select name="Task_ID_<?php echo $Fila; ?>" size="1"  class="cuadro" id="Task_ID_<?php echo $Fila; ?>" >  
			<option value="-1">Select_one</option>  	   
			<?php				
			$sql = "select Task_ID,Nombre,Tas_IDT FROM task WHERE Area_ID=".$Area_ID." order by NumAct";														
			$result=$bd->ejecutar($sql); 		
			while (($row = mysqli_fetch_array($result) ))	
			{	
				if ($Task_ID==$row["Task_ID"])
					$estado="selected='selected'";
				else
					$estado="";
			?>
				<option value="<?php echo $row["Task_ID"];?>" <?php echo $estado;?> ><?php echo $row["Tas_IDT"]."=".$row["Nombre"];?></option>  
			<?php
			}
			mysqli_free_result($result);	
			?>
	  </select>
<?php
	}
	else
	{					   
		$sql = "select Task_ID, Nombre,Tas_IDT  FROM task WHERE Area_ID=".$Area_ID." order by Nombre";																
		$result=$bd->ejecutar($sql); 		
		while (($row = mysqli_fetch_array($result) ))	
		{	
?>
			<input type="text" value="<?php echo $row["Tas_IDT"]."=".$row["Nombre"];?>" size="10" />
			<input type="hidden" id="Task_ID_<?php echo $Fila; ?>" name="Task_ID_<?php echo $Fila; ?>" value="<?php echo $row["Task_ID"];?>" />
<?php
		}
		mysqli_free_result($result);	

	}
	
	require('Library/Close_Conexion.php');	
?>