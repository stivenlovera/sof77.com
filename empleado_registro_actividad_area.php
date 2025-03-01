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

	$Floor_ID=$_GET["Floor_ID"];
	$Fila=$_GET["Fila"];
	
	$RDA_ID=$_GET["RDA_ID"];
	$Area_ID=-1;

	$sql = "SELECT * FROM registro_diario_actividad rda INNER JOIN task t ON rda.Task_ID=t.Task_ID ";
		$sql = $sql . " INNER JOIN area_control a ON t.Area_ID=a.Area_ID ";
		$sql = $sql . " INNER JOIN floor f ON f.Floor_ID=a.Floor_ID ";
		$sql = $sql . " INNER JOIN edificios e ON e.Edificio_ID=f.Edificio_ID ";
		$sql = $sql . "  WHERE RDA_ID=".$RDA_ID;	
		
	//echo $sql."<br>";														
	$result77=$bd->ejecutar($sql); 			

	while (($row77 = mysqli_fetch_array($result77) ))	
	{
		$Area_ID=$row77["Area_ID"];
	}
	mysqli_free_result($result77);
		
		
	
	$Cantidad=0;
	$sql = "select COUNT(*) AS Cantidad FROM area_control WHERE Floor_ID=".$Floor_ID;												
	$result=$bd->ejecutar($sql); 		
	if (($row = mysqli_fetch_array($result) ))	
	{
		$Cantidad=$row["Cantidad"];
	}
	mysqli_free_result($result);	
	
	if ($Cantidad>1)
	{	
		$eligio="No";
?>		
		<select name="Area_ID_<?php echo $Fila; ?>" size="1"  class="cuadro" id="Area_ID_<?php echo $Fila; ?>" onchange="empleado_registro_actividad_task(this.value,<?php echo $Fila ?>,<?php echo $RDA_ID; ?>);">  
		<option value="-1">-Select one-</option>  	   
		<?php				
		$sql = "select Area_ID, RTRIM(Nombre) AS Nombre FROM area_control WHERE Floor_ID=".$Floor_ID." and Nombre not like '%Material%' and Nombre not like '%Submittal%' and Nombre not like '%Closeout%' and Nombre not like '%SubCont%'  and Nombre not like '%do not use%' order by Nombre";														
		$result=$bd->ejecutar($sql); 		
		while (($row = mysqli_fetch_array($result) ))	
		{	
			if ($Area_ID==$row["Area_ID"])
			{
				$estado="selected='selected'";
				$eligio="Si";
			}
			else
				$estado="";
		
		?>
			<option value="<?php echo $row["Area_ID"];?>" <?php echo $estado;?> ><?php echo $row["Nombre"];?></option>  
		<?php
		}
		mysqli_free_result($result);	
		?>
  </select>
  <?php
		if ($eligio=="Si")
		{
	?>		
			 <img src="images/spacer.gif" onload="empleado_registro_actividad_task(<?php echo $Area_ID;?>,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);" />
	<?php
		} 
	}
	else
	{					   
		$sql = "select Area_ID, RTRIM(Nombre) AS Nombre FROM area_control WHERE Floor_ID=".$Floor_ID." order by Nombre";																	
		$result=$bd->ejecutar($sql); 		
		while (($row = mysqli_fetch_array($result) ))	
		{	
?>
			<input type="text" value="<?php echo $row["Nombre"];?>" size="10" maxlength="25" />
			<input type="hidden" id="Area_ID_<?php echo $Fila; ?>" name="Area_ID_<?php echo $Fila; ?>" value="<?php echo $row["Area_ID"];?>" />
			<img src="images/spacer.gif" onload="empleado_registro_actividad_task(<?php echo $row["Area_ID"];?>,<?php echo $Fila ?>,<?php echo $RDA_ID; ?>);" />			
<?php
		}
		mysqli_free_result($result);	

	}

	require('Library/Close_Conexion.php');	
?>