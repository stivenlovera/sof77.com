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
	
	$Empleado_ID=$_SESSION["Empleado_ID"];		
	$Pro_ID=$_GET["Pro_ID"];	
	$Reg_ID=$_GET["Reg_ID"];	
	$Estilo="";
	
	$sql = "select  TIMEDIFF(Hora_Salida,Hora_Ingreso) AS Horas FROM registro_diario WHERE Reg_ID=".$Reg_ID;														
	$result=$bd->ejecutar($sql); 		
	if (($row = mysqli_fetch_array($result) ))	
	{
		$Horas_aux=$row["Horas"];
	}
	mysqli_free_result($result);
	//echo $sql; 
		
	
	//En nuestro ejemplo
	$array = split(":", $Horas_aux);
	
	if ( $array[1]<31 )
		$Horas=$array[0]+0.5;
	else
		$Horas=$array[0]+1;	
?> 
<table border="1" cellpadding="0" cellspacing="0">
	<tr align="center">
		<td>Building</td><td>Floor</td><td>Area</td><td>Task</td><td>Hour Contract</td><td>Hour TM</td><td>Detail</td>
	</tr>
	
	<?php
		$sql = "SELECT * FROM registro_diario_actividad rda INNER JOIN task t ON rda.Task_ID=t.Task_ID ";
		$sql = $sql . " INNER JOIN area_control a ON t.Area_ID=a.Area_ID ";
		$sql = $sql . " INNER JOIN floor f ON f.Floor_ID=a.Floor_ID ";
		$sql = $sql . " INNER JOIN edificios e ON e.Edificio_ID=f.Edificio_ID ";
		$sql = $sql . "  WHERE Reg_ID=".$Reg_ID;	
		
		//echo $sql."<br>";													
		$result77=$bd->ejecutar($sql); 		
		$RDA_ID=-1;
		$Fila=1;
		while (($row77 = mysqli_fetch_array($result77) ))	
		{
			$Task_ID=$row77["Task_ID"];
			$Area_ID=$row77["Area_ID"];
			$Floor_ID=$row77["Floor_ID"];
			$Edificio_ID=$row77["Edificio_ID"];				
			$Horas_Contract=$row77["Horas_Contract"];
			$Horas_TM=$row77["Horas_TM"];
			$Detalles=$row77["Detalles"];
			$RDA_ID=$row77["RDA_ID"];
			
			$_SESSION["RDA_ID"]=$RDA_ID;
	?>
	
			<tr>
				<td width="100">			
					<?php	
						$Cantidad=0;
						$sql = "select COUNT(*) AS Cantidad FROM edificios WHERE Pro_ID=".$Pro_ID;														
						$result=$bd->ejecutar($sql); 		
						if (($row = mysqli_fetch_array($result) ))	
						{
							$Cantidad=$row["Cantidad"];
						}
						mysqli_free_result($result);
						//echo $sql."<br>"; 	
						//echo $Cantidad."<br>"; 
						if ($Cantidad>1)
						{
							$eligio="No";	
					?>		
							<select name="Edificio_ID_<?php echo $Fila; ?>" size="1"  class="cuadro" id="Edificio_ID_<?php echo $Fila; ?>" onchange="empleado_registro_actividad_piso(this.value,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);"> 
							<option value="-1">---Select one ---</option>   
					<?php		
							$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
							$result=$bd->ejecutar($sql); 		
							while (($row = mysqli_fetch_array($result) ))	
							{	
								if ($Edificio_ID==$row["Edificio_ID"])
								{
									$estado="selected='selected'";
									$eligio="Si";
								}
								else
									$estado="";
					?>
								<option value="<?php echo $row["Edificio_ID"];?>"  <?php echo $estado;?> ><?php echo $row["Nombre"];?></option>  
					<?php
							}
							mysqli_free_result($result);	
					?>					
							</select> 
							<?php
							if ($eligio=="Si")
							{
						?>		
								<img src="images/spacer.gif" onload="empleado_registro_actividad_piso(<?php echo $Edificio_ID;?>,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);" />
						<?php
							}							
					
						}
						else
						{					   
							$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
							$result=$bd->ejecutar($sql); 		
							if (($row = mysqli_fetch_array($result) ))	
							{	
								$_SESSION["RDA_ID"]=-1;
					?>
								<input type="text" value="<?php echo $row["Nombre"];?>" />
								<input type="hidden" id="Edificio_ID_<?php echo $Fila; ?>" name="Edificio_ID_<?php echo $Fila; ?>" value="<?php echo $row["Edificio_ID"];?>" />
								<img src="images/spacer.gif" onload="empleado_registro_actividad_piso(<?php echo $row["Edificio_ID"];?>,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);" />	 
								
					<?php
							}
							mysqli_free_result($result);	
					
						}
					?>
				  
				</td>				
				<td width="100">	
					<div id="div_registro_actividad_piso_<?php echo $Fila; ?>"></div>			
				</td>
				<td width="100">	
					<div id="div_registro_actividad_area_<?php echo $Fila; ?>"></div>			
				</td>
				<td width="100">	
					<div id="div_registro_actividad_task_<?php echo $Fila; ?>"></div>			
				</td>			
				<td width="100"><input name="Horas_Contract_<?php echo $Fila; ?>" id="Horas_Contract_<?php echo $Fila; ?>" value="<?php echo $Horas_Contract; ?>" /></td>		
				<td width="100"><input name="Horas_TM_<?php echo $Fila; ?>" id="Horas_TM_<?php echo $Fila; ?>"   value="<?php echo $Horas_TM; ?>" /></td>
				<td width="100"><input name="Detalle_<?php echo $Fila; ?>" id="Detalle_<?php echo $Fila; ?>" value="<?php echo $Detalles; ?>"  />
								<input type="hidden" name="RDA_ID_<?php echo $Fila; ?>" id="RDA_ID_<?php echo $Fila; ?>" value="<?php echo $RDA_ID; ?>" /></td>
			</tr>
	<?php
			$Fila++;
			
		}
		mysqli_free_result($result77);
		

		while ($Fila<4)	
		{			
	?>	
			<tr>
				<td width="100">			
					<?php	
						$Cantidad=0;
						$sql = "select COUNT(*) AS Cantidad FROM edificios WHERE Pro_ID=".$Pro_ID;														
						$result=$bd->ejecutar($sql); 		
						if (($row = mysqli_fetch_array($result) ))	
						{
							$Cantidad=$row["Cantidad"];
						}
						mysqli_free_result($result);
						//echo $sql."<br>"; 	
						//echo $Cantidad."<br>"; 
						if ($Cantidad>1)
						{	
					?>		
							<select name="Edificio_ID_<?php echo $Fila; ?>" size="1"  class="cuadro" id="Edificio_ID_<?php echo $Fila; ?>" onchange="empleado_registro_actividad_piso(this.value,<?php echo $Fila; ?>);"> 
							<option value="-1">---Select one ---</option>   
					<?php		
							$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
							$result=$bd->ejecutar($sql); 		
							while (($row = mysqli_fetch_array($result) ))	
							{									
					?>
								<option value="<?php echo $row["Edificio_ID"];?>" ><?php echo $row["Nombre"];?></option>  
					<?php
							}
							mysqli_free_result($result);	
					?>					
							</select> 
					<?php
						}
						else
						{					   
							$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
							$result=$bd->ejecutar($sql); 		
							if (($row = mysqli_fetch_array($result) ))	
							{	
					?>
								<input type="text" value="<?php echo $row["Nombre"];?>" />
								<input type="hidden" id="Edificio_ID_<?php echo $Fila; ?>" name="Edificio_ID_<?php echo $Fila; ?>" value="<?php echo $row["Edificio_ID"];?>" />
								<img src="images/spacer.gif" onload="empleado_registro_actividad_piso(<?php echo $row["Edificio_ID"];?>,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);" />	 
								
					<?php
							}
							mysqli_free_result($result);	
					
						}
					?>
				  
				</td>				
				<td width="100">	
					<div id="div_registro_actividad_piso_<?php echo $Fila; ?>">
						<input type="hidden" name="Floor_ID_<?php echo $Fila; ?>" id="Floor_ID_<?php echo $Fila; ?>" value="-1" />
					</div>			
				</td>
				<td width="100">	
					<div id="div_registro_actividad_area_<?php echo $Fila; ?>">
						<input type="hidden" name="Area_ID_<?php echo $Fila; ?>" id="Area_ID_<?php echo $Fila; ?>" value="-1" />
					</div>			
				</td>
				<td width="100">	
					<div id="div_registro_actividad_task_<?php echo $Fila; ?>">
						<input type="hidden" name="Task_ID_<?php echo $Fila; ?>" id="Task_ID_<?php echo $Fila; ?>" value="-1" />
					</div>			
				</td>			
				<td width="100"><input name="Horas_Contract_<?php echo $Fila; ?>" id="Horas_Contract_<?php echo $Fila; ?>" value="<?php echo $Horas; ?>" size="5" /></td>		
				<td width="100"><input name="Horas_TM_<?php echo $Fila; ?>" id="Horas_TM_<?php echo $Fila; ?>"  size="5"/></td>
				<td width="100"><input name="Detalle_<?php echo $Fila; ?>" id="Detalle_<?php echo $Fila; ?>" />
								<input type="hidden" name="RDA_ID_<?php echo $Fila; ?>" id="RDA_ID_<?php echo $Fila; ?>" value="-1" /></td>
			</tr>
	<?php
			$Fila++;
		}
	?>		
</table>
<div id="div_registro_actividad_registrar">
    <table>
        <tr>
            <td colspan="6" align="right">
                <button onclick="empleado_registro_actividad_registrar(<?php echo $Pro_ID; ?>, <?php echo $Reg_ID; ?>);">Save</button>			
            </td>
        </tr>
    </table>
</div>

<div id="Tabla_Lista_Actividades"></div>

<!--<img src="images/spacer.gif" onload="empleado_registro_actividad_lista(<?php echo $Reg_ID; ?>);" />	-->
 
<div id="Div_Actividad_Personal_Information"></div>
	
<?php

	require('Library/Close_Conexion.php');	

?>