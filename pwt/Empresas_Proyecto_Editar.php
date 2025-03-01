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
	include ("Empresas_Pro_Etapas_Registrar.php");				         					  	
	
	$Emp_ID=$_GET['Emp_ID'];
	$Pro_ID=$_GET['Pro_ID'];
	
	$consulta = "SELECT e.Nombre as Company, p.* FROM proyectos p INNER JOIN empresas e ON p.Emp_ID=p.Emp_ID WHERE Pro_ID=".$Pro_ID;	
	//echo $consulta;	
	$result2=$bd->ejecutar($consulta); 	
	if (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Company = $row2["Company"];
		$Pro_ID = $row2["Pro_ID"];
		$Codigo = $row2["Codigo"];
		$Nombre = $row2["Nombre"];
		$Estatus_ID=$row2["Estatus_ID"];
		$Tipo_ID=$row2["Tipo_ID"];
		$Estado = $row2["Estado"];	
		$Ciudad = $row2["Ciudad"];	
		$Zip_Code = $row2["Zip_Code"];			
		$Calle = $row2["Calle"];
		$Numero=$row2["Numero"];
		$Fecha_Inicio=FormatDateTime($row2["Fecha_Inicio"], 6);
		$Fecha_Fin=FormatDateTime($row2["Fecha_Fin"], 6);
		$Horas=$row2["Horas"];
		$Precio=$row2["Precio"];
		
		$Project_Manager_ID=$row2["Project_Manager_ID"];
		$Coordinador_Obra_ID=$row2["Coordinador_Obra_ID"];
		
		$Foreman_ID=$row2["Foreman_ID"];
		$Coordinador_ID=$row2["Coordinador_ID"];
		$Manager_ID=$row2["Manager_ID"];
		$Codigo_Bono=$row2["Codigo_Bono"];
		$Monto_Bono=$row2["Monto_Bono"];
		$Bono_General=$row2["Bono_General"];
						
	}
	mysqli_free_result($result2);	
					
?> 
    <form action="#" id="Form_Empresas_Proyecto_Editar" name="Form_Empresas_Proyecto_Editar">
    <table width="100%">
    	<tr>
        	<td width="100%">             
				<fieldset>
					<legend><strong>Company: <?php echo $Company; ?> - Project: <?php echo $Codigo; ?>  <?php echo $Nombre; ?></strong></legend>
					<table  cellpadding="2" cellspacing="2" width="100%">
						<tr>
							<td width="13%"><strong>GC-Company:::</strong></td>
							<td width="87%"> 								  
								<?php
									$sql = "select Emp_ID, Nombre FROM empresas order by Nombre";														
									$result=$bd->ejecutar($sql); 		 
								?>
									<select size="1" name="Emp_ID" id="Emp_ID"  class="cuadro" onchange="Proyecto_Empleados_Empresa(this.value);">      
										<option  value="">--Select GC-Company--</option>
								<?php		
										while (($row = mysqli_fetch_array($result) ))							
										{								
								?>
											<option value="<?php echo  $row["Emp_ID"];?>"><?php echo $row["Nombre"];?></option>
								<?php
										}
										mysqli_free_result($result);	
								?>
									</select>
									<img src="images/spacer.gif" height="1" width="1" onload="$('#Emp_ID').val(<?php echo $Emp_ID;?>)" />
						  </td>
						</tr>
					</table>
					<table  cellpadding="2" cellspacing="2" width="100%">						
						<tr>
							<td width="82"><strong># Job:</strong></td>
						  	<td>
								<input type='text' id='Codigo' name='Codigo' value='<?php echo $Codigo; ?>'  size='10' onblur="Empresas_Nuevo_Proyecto_Validar_Codigo(this.value, '<?php echo $Pro_ID; ?>');"/> <span id='Div_Validar_Codigo'>OK</span>
							</td>
						</tr>						
						<tr>
							<td width="82"><strong>Name:</strong></td>
						  	<td  >
								<input name="Nombre" type="text" id="Nombre" size="40" value="<?php echo $Nombre; ?>"/> 
								<strong>Street:</strong> 
							  <input name="Calle" type="text" id="Calle" size="40" value="<?php echo $Calle; ?>"/>								
</td>
						</tr>						
						<tr>
							<td ><strong>City: </strong></td>
							<td>
								<input name="Ciudad" type="text" id="Ciudad" size="20" value="<?php echo $Ciudad; ?>"/>
								<strong>State:</strong> 
							  <input type="text" id="Estado" name="Estado" size="15" value="<?php echo $Estado; ?>"/>								
								<strong>Zip Code: </strong>
								<input name="Zip_Code" type="text" id="Zip_Code" size="12" value="<?php echo $Zip_Code; ?>"/>
								<input name="Numero" type="hidden" id="Numero" size="10" value="<?php echo $xx; ?>"/>
</td>
						</tr>													
						<tr>
							<td><strong>Start Date :</strong></td>
						    <td >
								<input name="Fecha_Inicio_Proyecto" type="text" id="Fecha_Inicio_Proyecto" size="20" datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo $Fecha_Inicio; ?>"/>
<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Inicio_Proyecto"));' />
								<strong>End Date:								</strong>
								<input name="Fecha_Fin_Proyecto" type="text" id="Fecha_Fin_Proyecto" size="20" datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo $Fecha_Fin; ?>"/>
<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Fin_Proyecto"));' />
							<strong>Price:</strong> 
							<input name="Precio" type="text" id="Precio" size="10"  value="<?php echo $Precio; ?>"/>
							<strong>Hours:				      		  </strong>
							<input name="Pro_Horas" type="text" id="Pro_Horas" size="8" value="<?php echo $Horas; ?>"/>	
							<input name="Aux_Horas" type="Hidden" id="Aux_Horas" value="<?php echo $Horas; ?>"/>							
							</td>
						</tr>
                        <tr>
							<td><strong>Codigo de Bono:</strong></td>
						    <td >
								<input name="Codigo_Bono" type="text" id="Codigo_Bono" size="10"  value="<?php echo $Codigo_Bono; ?>"/>
								<strong>Monto de Bono:				      		  </strong>
								<input name="Monto_Bono" type="text" id="Monto_Bono" size="8" value="<?php echo $Monto_Bono; ?>"/>	
                                 <strong>Monto para Todos:				      		  </strong>
								<input name="Bono_General" type="text" id="Bono_General" size="8" value="<?php echo $Bono_General; ?>"/>
							</td>
						</tr>
						<tr>							
							<td colspan="2"> 
								<strong>Status:</strong> 
							  <?php
									$sql = "select Estatus_ID, Nombre_Estatus FROM estatus order by Nombre_Estatus";														
									$result=$bd->ejecutar($sql); 		 
								?>
									<select size="1" name="Estatus_ID" id="Estatus_ID"  class="cuadro">      
										<option  value="">--Select Status--</option>
								<?php		
										while (($row = mysqli_fetch_array($result) ))							
										{								
								?>
											<option value="<?php echo  $row["Estatus_ID"];?>"><?php echo $row["Nombre_Estatus"];?></option>
								<?php
										}
										mysqli_free_result($result);	
								?>
									</select>
									<img src="images/spacer.gif" height="1" width="1" onload="$('#Estatus_ID').val(<?php echo $Estatus_ID;?>)" />
						            <strong>Type:</strong> 
							  <?php
									$sql = "select Tipo_ID, Codigo, Nombre_Tipo FROM tipo_proyecto order by Codigo";														
									$result=$bd->ejecutar($sql); 		 
								?>
									<select size="1" name="Tipo_ID" id="Tipo_ID"  class="cuadro">      
										<option  value="">--Select Type--</option>
								<?php		
										while (($row = mysqli_fetch_array($result) ))							
										{								
								?>
											<option value="<?php echo  $row["Tipo_ID"];?>"><?php echo $row["Codigo"]." ".$row["Nombre_Tipo"];?></option>
								<?php
										}
										mysqli_free_result($result);	
								?>
									</select>
									<img src="images/spacer.gif" height="1" width="1" onload="$('#Tipo_ID').val(<?php echo $Tipo_ID;?>)" /> 
						  </td>
				  	    </tr>						
						<tr>
							<td colspan="2" > 
								<table width="100%">
									<tr>
										<td width="50%" valign="top">
											<fieldset>
												<legend><strong>Staff Constractor</strong></legend>
													<div id="Div_Proyecto_Empleados_Empresa" name="Div_Proyecto_Empleados_Empresa">
														<table>
															<tr>
																<td><strong>Project Manager:</strong></td>
																<td> 								  
																	<?php
																		$sql = "select Empleado_ID, Nombre, Apellido_Paterno, Apellido_Materno FROM personal WHERE Emp_ID=".$Emp_ID." ORDER BY Nombre";														
																		$result=$bd->ejecutar($sql); 		 
																	?>
																		<select size="1" name="Project_Manager_ID" id="Project_Manager_ID"  class="cuadro">      
																			<option  value="">--Select Project Manager--</option>
																	<?php		
																			while (($row = mysqli_fetch_array($result) ))							
																			{								
																	?>
																				<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>
																	<?php
																			}
																			mysqli_free_result($result);	
																	?>
																		</select>
																		<img src="images/spacer.gif" height="1" width="1" onload="$('#Project_Manager_ID').val(<?php echo $Project_Manager_ID;?>)" />
																</td>
															</tr>
															<tr>
																<td><strong>Superintendent:</strong></td>
																<td> 							  
																	<?php
																		$sql = "select Empleado_ID, Nombre, Apellido_Paterno, Apellido_Materno FROM personal WHERE Emp_ID=".$Emp_ID." ORDER BY Nombre";														
																		$result=$bd->ejecutar($sql); 		 
																	?>
																		<select size="1" name="Coordinador_Obra_ID" id="Coordinador_Obra_ID"  class="cuadro">      
																			<option  value="">--Select Superintendent--</option>
																	<?php		
																			while (($row = mysqli_fetch_array($result) ))							
																			{								
																	?>
																				<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>
																	<?php
																			}
																			mysqli_free_result($result);	
																	?>
																		</select>
																		<img src="images/spacer.gif" height="1" width="1" onload="$('#Coordinador_Obra_ID').val(<?php echo $Coordinador_Obra_ID;?>)" />																	
																</td>
															</tr>
														</table>
													</div>	
													<div style="display:block" id="div_res_new_proyecto">
														<INPUT id="button" type="button" value="Save" name="button" onClick="Empresas_Proyecto_Editar_Registrar();">
													</div>
											</fieldset>
										</td>
										<td width="50%" valign="top">
											<fieldset>
												<legend><strong>Staff PWT</strong></legend>
													<table>
														<tr>
															<td><strong>Project Manager PWT:</strong></td>
															<td>
															  <?php
																	$sql = "select p.Empleado_ID, p.Nombre, p.Apellido_Paterno, p.Apellido_Materno, e.Codigo 
																			FROM personal p
																				INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID
																			 WHERE e.Codigo='PWT' and (p.Aux5='F' or p.Aux5='FB' or p.Aux5='FX' or p.Aux5='FY')ORDER BY p.Aux5,Nombre";		
																	$result=$bd->ejecutar($sql); 		 
																?>
																	<select size="1" name="Manager_ID" id="Manager_ID"  class="cuadro">      
																		<option  value="">--Select Manager--</option>
																<?php		
																		while (($row = mysqli_fetch_array($result) ))							
																		{								
																?>
																			<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>
																<?php
																		}
																		mysqli_free_result($result);	
																?>
																	</select>
																	<img src="images/spacer.gif" height="1" width="1" onload="$('#Manager_ID').val(<?php echo $Manager_ID;?>)" />	
																	<input name="Emp_ID_Ant" type="hidden" id="Emp_ID_Ant" size="8" value="<?php echo $Emp_ID; ?>"/>
																	<input name="Pro_ID" type="hidden" id="Pro_ID" size="8" value="<?php echo $Pro_ID; ?>"/>
															</td>
														</tr>
														<tr>
															<td><strong>Project Coordinator PWT:</strong></td>
															<td>
																<?php
																	$sql = "select p.Empleado_ID, p.Nombre, p.Apellido_Paterno, p.Apellido_Materno 
																			FROM personal p
																				INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID
																			 WHERE e.Codigo='PWT' and (p.Aux5='F' or p.Aux5='FB' or p.Aux5='FX' or p.Aux5='FY')ORDER BY p.Aux5,Nombre";		
																	$result=$bd->ejecutar($sql); 		 
																?>
																	<select size="1" name="Coordinador_ID" id="Coordinador_ID"  class="cuadro">      
																		<option  value="">--Select Cordinador--</option>
																<?php		
																		while (($row = mysqli_fetch_array($result) ))							
																		{								
																?>
																			<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>
																<?php
																		}
																		mysqli_free_result($result);	
																?>
																	</select>
																	<img src="images/spacer.gif" height="1" width="1" onload="$('#Coordinador_ID').val(<?php echo $Coordinador_ID;?>)" />
															</td>
														</tr>
														<tr>
															<td><strong>Foreman PWT: </strong></td>
															<td>
															  <?php
																	$sql = "select p.Empleado_ID, p.Nombre, p.Apellido_Paterno, p.Apellido_Materno 
																			FROM personal p
																				INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID
																			 WHERE e.Codigo='PWT' and (p.Aux5='F' or p.Aux5='FB' or p.Aux5='FX' or p.Aux5='FY')ORDER BY p.Aux5,Nombre";														
																	$result=$bd->ejecutar($sql); 		 
																?>
																	<select size="1" name="Foreman_ID" id="Foreman_ID"  class="cuadro">      
																		<option  value="">--Select Foreman--</option>
																<?php		
																		while (($row = mysqli_fetch_array($result) ))							
																		{								
																?>
																			<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>
																<?php
																		}
																		mysqli_free_result($result);	
																?>
																	</select>
																	<img src="images/spacer.gif" height="1" width="1" onload="$('#Foreman_ID').val(<?php echo $Foreman_ID;?>)" />
															</td>
														</tr>														
													</table>
											</fieldset>
										</td>
									</tr>
								</table>
							</td>
						</tr>							
					</table>
				</fieldset>				
        	</td>                             
        </tr>			
	</table>
</form>
	<table width="100%">
		<tr>
			<td width="100%">
				<div id="Div_Estapas_Proyecto" name="Div_Estapas_Proyecto" >					
				</div>
			</td>
		</tr>
	</table>
<?php
	echo "<img src='images/spacer.gif' onload='Empresas_Proyectos_Etapas($Pro_ID);' />"; 
	require('Library/Close_Conexion.php');
?>