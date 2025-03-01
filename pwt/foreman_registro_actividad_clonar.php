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

	$Fila=$_GET["Fila"];
	$FecWor=$_GET["FecWor"];
	
	$Empleado_ID=$_GET["Empleado_ID"];		
	$Nombre_Empleado=$_GET["Nombre_Empleado"];
	$Hora_Ingreso=$_GET["Hora_Ingreso"];
	$Hora_Salida=$_GET["Hora_Salida"];
	$Pro_ID=$_GET["Pro_ID"];
	$Reg_ID=$_GET["Reg_ID"];
	$RDA_ID=$_GET["RDA_ID"];
	$MiFila=$_GET["MiFila"];
	
	
	$MiFila++;
	//echo $MiFila."mi fila <br>";
	$Estado="readonly";
		
	$nueva_fila="";
	$filafec=$Fila." ".$FecWor;
	$nueva_fila="<tr>
				<td align='center'>".$filafec."</td>
				<td>".$Nombre_Empleado."</td>
				<td>
					<input name='Hora_Ingreso_".$Fila."' id='Hora_Ingreso_".$Fila."' type='text' value='".$Hora_Ingreso."' size='10' ".$Estado."><br />
					<input name='Hora_Salida_".$Fila."' id='Hora_Salida_".$Fila."' type='text' value='".$Hora_Salida."' size='10' ".$Estado.">					
				</td>
				<td width='5'>";							

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
							$nueva_fila=$nueva_fila."
							<select name='Edificio_ID_".$Fila."' size='1'  class='cuadro' id='Edificio_ID_".$Fila."' onchange='foreman_registro_actividad_piso(this.value,".$Fila.");'> 
							<option value='-1'>-Select one -</option> ";  
	
							$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
							$result=$bd->ejecutar($sql); 		
							while (($row = mysqli_fetch_array($result) ))	
							{									
								$nueva_fila=$nueva_fila."
								<option value='".$row["Edificio_ID"]."' >".$row["Nombre"]."</option>  ";

							}
							mysqli_free_result($result);	
					 

						}
						else
						{					   
							$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
							$result=$bd->ejecutar($sql); 		
							if (($row = mysqli_fetch_array($result) ))	
							{	
								$nueva_fila=$nueva_fila."
								<input type='text' value='".$row["Nombre"]."' size='10'/>
								<input type='hidden' id='Edificio_ID_".$Fila."' name='Edificio_ID_".$Fila."' value='".$row["Edificio_ID"]."' size='10' />
								<img src='images/spacer.gif' onload='foreman_registro_actividad_piso(".$row["Edificio_ID"].",".$Fila.",".$RDA_ID.");' />	 ";
							}
							mysqli_free_result($result);	
					
						}
				$nueva_fila=$nueva_fila."	
				
						</td>				
				<td width='10'>	
					<div id='div_registro_actividad_piso_".$Fila."'>
					<input type='hidden' id='Floor_ID_".$Fila."' name='Floor_ID_".$Fila."' value='-1' />
					</div>				</td>
				<td width='10'>	
					<div id='div_registro_actividad_area_".$Fila."'>
						<input type='hidden' id='Area_ID_".$Fila."' name='Area_ID_".$Fila."' value='-1' />
					</div>				</td>
				<td width='10'>	
					<div id='div_registro_actividad_task_".$Fila."'>
						<input type='hidden' id='Task_ID_".$Fila."' name='Task_ID_".$Fila."' value='-1' />
					</div>				</td>			
				<td width='10'><input name='Horas_Contract_".$Fila."' id='Horas_Contract_".$Fila."' value='' size='5' /></td>		
				<td width='5'><input type='hidden' name='Horas_TM_".$Fila."' id='Horas_TM_".$Fila."' value='' size='1' /></td>
				<td width='30'><input  name='Detalle_".$Fila."' id='Detalle_".$Fila."' size='15' />
								<input type='hidden' name='Reg_ID_".$Fila."' id='Reg_ID_".$Fila."' value='".$Reg_ID."' />
								<input type='hidden' name='RDA_ID_".$Fila."' id='RDA_ID_".$Fila."' value='".$RDA_ID."' />
								<input type='hidden' name='Empleado_ID_".$Fila."' id='Empleado_ID_".$Fila."' value='".$Empleado_ID."' />				</td>
				<td ><input type='checkbox' name='Verificado_Foreman_".$Fila."' id='Verificado_Foreman_".$Fila."' /></td>
				<td>
				</td>	
			</tr>";			
	
	$Fila++;
	$id=9;
	echo $nueva_fila."|<img src='images/spacer.gif' onload='Fila=".$Fila.";Nueva_Fila(".$MiFila.");' />";
	
	require('Library/Close_Conexion.php');	
?>

