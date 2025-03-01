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

	$Edificio_ID=$_GET["Edificio_ID"];
	$Fila=$_GET["Fila"];
	
	$RDA_ID=$_GET["RDA_ID"];
	$Floor_ID=-1;

	$sql = "SELECT * FROM registro_diario_actividad rda INNER JOIN task t ON rda.Task_ID=t.Task_ID ";
		$sql = $sql . " INNER JOIN area_control a ON t.Area_ID=a.Area_ID ";
		$sql = $sql . " INNER JOIN floor f ON f.Floor_ID=a.Floor_ID ";
		$sql = $sql . " INNER JOIN edificios e ON e.Edificio_ID=f.Edificio_ID ";
		$sql = $sql . "  WHERE Reg_ID=".$Reg_ID;	
	//echo $sql."<br>";																
	
	$result77=$bd->ejecutar($sql); 			

	if ($result77)
	{
	while (($row77 = mysqli_fetch_array($result77) ))	
	{
		$Floor_ID=$row77["Floor_ID"];
	}
	mysqli_free_result($result77);
	}
	
	$Cantidad=0;
	$sql = "select COUNT(*) AS Cantidad FROM floor WHERE Edificio_ID=".$Edificio_ID;												
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
		<select name="Floor_ID_<?php echo $Fila; ?>" size="1"  class="cuadro" id="Floor_ID_<?php echo $Fila; ?>" onchange="empleado_registro_actividad_area(this.value,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);">  
			<option value="-1">-Select one-</option>  		   
			<?php				
			$sql = "select Floor_ID, RTRIM(Nombre) AS Nombre FROM floor WHERE Edificio_ID=".$Edificio_ID." and Nombre not like '%Material%' and Nombre not like '%Submittal%' and Nombre not like '%Closeout%' and Nombre not like '%SubCont%' and Nombre not like '%do not use%' order by Nombre";														
			$result=$bd->ejecutar($sql); 		
			while (($row = mysqli_fetch_array($result) ))	
			{	
				if ($Floor_ID==$row["Floor_ID"])
				{
					$estado="selected='selected'";
					$eligio="Si";
				}
				else
					$estado="";
			?>
				<option value="<?php echo $row["Floor_ID"];?>" <?php echo $estado;?> ><?php echo $row["Nombre"];?></option>  
			<?php
			}
			mysqli_free_result($result);	
			?>
		</select>
	<?php
		if ($eligio=="Si")
		{
	?>		
			<img src="images/spacer.gif" onload="empleado_registro_actividad_area(<?php echo $Floor_ID;?>,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);" />
	<?php
		}
	}
	else
	{					   
		$sql = "select Floor_ID, RTRIM(Nombre) AS Nombre FROM floor WHERE Edificio_ID=".$Edificio_ID." order by Nombre";															
		$result=$bd->ejecutar($sql); 		
		while (($row = mysqli_fetch_array($result) ))	
		{	
?>
			<input type="text" value="<?php echo $row["Nombre"];?>" size="10" maxlength="25" />
			<input type="hidden" id="Floor_ID_<?php echo $Fila; ?>" name="Floor_ID_<?php echo $Fila; ?>" value="<?php echo $row["Floor_ID"];?>" />
			<img src="images/spacer.gif" onload="empleado_registro_actividad_area(<?php echo $row["Floor_ID"];?>,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);" />	 
			
<?php
		}
		mysqli_free_result($result);	

	}

	require('Library/Close_Conexion.php');	
?>