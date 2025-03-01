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
	include ("pwt/Empresas_Pro_Etapas_Registrar.php");

	$Pro_ID=$_GET['Pro_ID'];

	

	$consulta = "SELECT e.Nombre as Company, p.* FROM proyectos p INNER JOIN empresas e ON p.Emp_ID=p.Emp_ID WHERE Pro_ID=".$Pro_ID;	

	//echo $consulta;	

	$result2=$bd->ejecutar($consulta); 	

	if (($row2 = mysqli_fetch_array($result2) ))							

	{		
		$Company = $row2["Company"];
		$Emp_ID = $row2["Emp_ID"];
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
		$Co1=$row2["Adi1"];
		$Co2=$row2["Adi2"];
		$Co3=$row2["Adi3"];
		$Co4=$row2["Adi4"];
		$Co5=$row2["Adi5"];
		$Notes=$row2["Notes"];
		$Report_P_Done=$row2["Report_P_Done"];
		$UpdateH=$row2["UpdateH"];
		$Project_Manager_ID=$row2["Project_Manager_ID"];
		$Coordinador_Obra_ID=$row2["Coordinador_Obra_ID"];
		$Foreman_ID=$row2["Foreman_ID"];
		$Lead_ID=$row2["Lead_ID"];
		$Asistant_Proyect_ID=$row2["Asistant_Proyect_ID"];//nuevo
		$Coordinador_ID=$row2["Coordinador_ID"];
		$Manager_ID=$row2["Manager_ID"];
		$Emails=$row2["emails"];	
		$Codigo_Bono=$row2["Codigo_Bono"];
		$Monto_Bono=$row2["Monto_Bono"];		
		$Bono_General=$row2["Bono_General"];
		$MilPay=$row2["Miles_Pay"];
		$MilNote=$row2["Miles_Note"];
		$ParkHel=$row2["Park_Help"];
		$ParkNote=$row2["Park_Note"];
		if ($MilNote==null || $MilNote=="")
			$MilNote="Distance Office to Job->    miles,$ per mile after 80miles=$ ";
		if ($ParkNote==null || $ParkNote=="")
			$ParkNote="Report no free parking by:";
		
			
	}

	mysqli_free_result($result2);	

					

?> 

    <form action="#" id="Form_Proyecto_Editar" name="Form_Proyecto_Editar">

    <table width="98%">

    	<tr>

        	<td width="100%">             

				<fieldset>

					<legend><strong>Company: <?php echo $Company; ?> - Project: <?php echo $Codigo; ?>  <?php echo $Nombre; ?></strong></legend>

				  <table  cellpadding="2" cellspacing="2" width="100%">

						<tr>

							<td width="13%"><strong>GC-Company-:</strong></td>

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

						  <img src="images/spacer.gif" height="1" width="1" onload="$('#Emp_ID').val(<?php echo $Emp_ID;?>)" /></td>

						</tr>

					</table>

					<table  cellpadding="2" cellspacing="2" width="97%">						

						<tr>

							<td width="5">&nbsp;</td>

					  	  <td width="1062">

								Job#:
						  <input type='text' id='Codigo' name='Codigo' value='<?php echo $Codigo; ?>'  size='10' onblur="Empresas_Nuevo_Proyecto_Validar_Codigo(this.value, '<?php echo $Pro_ID; ?>');"/> 
						  <span id='Div_Validar_Codigo'>OK</span>____________________Need Report % done by Foreman Y/N: 
						  <input type="text" id="Per_Done" name="Per_Done" size="2" value="<?php echo $Report_P_Done; ?>"/>
						  Update hrs.automatic: 
				          <input type="text" id="UpdateH" name="UpdateH" size="2" value="<?php echo $UpdateH; ?>"/></td>

						</tr>						

						<tr>

							<td width="5">&nbsp;</td>

					  	  <td  >Name:

								<input name="Nombre" type="text" id="Nombre" size="30" value="<?php echo $Nombre; ?>"/> 

								<strong>Street:</strong> 

							  <input name="Calle" type="text" id="Calle" size="30" value="<?php echo $Calle; ?>"/>
							  City:
                              <input name="Ciudad" type="text" id="Ciudad" size="15" value="<?php echo $Ciudad; ?>"/>
                              <strong>State:</strong>
                              <input type="text" id="Estado" name="Estado" size="8" value="<?php echo $Estado; ?>"/>
                              <strong>Zip Code: </strong>
                              <input name="Zip_Code" type="text" id="Zip_Code" size="8" value="<?php echo $Zip_Code; ?>"/>
                              <input name="Numero" type="hidden" id="Numero" size="10" value="<?php echo $xx; ?>"/></td>

						</tr>						

						<tr>

						

							

						</tr>													

						<tr>

							<td><p>&nbsp;</p></td>

					      <td >

							<p><strong>Status:</strong>
                              <?php

									$sql = "select Estatus_ID, Nombre_Estatus FROM estatus order by Nombre_Estatus";														

									$result=$bd->ejecutar($sql); 		 

								?>
                              <select size="1" name="Estatus_ID" id="Estatus_ID"  class="cuadro">
                                <option  value="-1">--Select Status--</option>
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
                              <img src="images/spacer.gif" height="1" width="1" onload="$('#Estatus_ID').val(<?php echo $Estatus_ID;?>)" /> <strong>Type:</strong>
                              <?php

									$sql = "select Tipo_ID, Codigo, Nombre_Tipo FROM tipo_proyecto order by Codigo";														

									$result=$bd->ejecutar($sql); 		 

								?>
                              <select size="1" name="Tipo_ID" id="Tipo_ID"  class="cuadro">
                                <option  value="-1">--Select Type--</option>
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
                              <img src="images/spacer.gif" height="1" width="1" onload="$('#Tipo_ID').val(<?php echo $Tipo_ID;?>)" />Start Date
  <input name="Fecha_Inicio_Proyecto" type="text" id="Fecha_Inicio_Proyecto" size="10" datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo $Fecha_Inicio; ?>"/>
								  
  <img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Inicio_Proyecto"));' />
								  
								  End Date:								
								  
								  <input name="Fecha_Fin_Proyecto" type="text" id="Fecha_Fin_Proyecto" size="10" datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo $Fecha_Fin; ?>"/>
								  
  <img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Fin_Proyecto"));' />
								  
								  <strong>Price:</strong> 
								  
								  <input name="Precio" type="text" id="Precio" size="8"  value="<?php echo $Precio; ?>"/>
							</p>
							  <p>
								  
							    <strong>Hrs.Con.: </strong>
                                <input name="Horas" type="text" id="Horas" class="hora" size="8" value="<?php echo $Horas; ?>"/>
Hrs.Co#1:
<input name="Co1" type="text" id="Co1" value="<?php echo $Co1; ?>" size="9" />
								  
							    Hrs.Co#2:
								  
							    <input name="Co2" type="text" id="Co2" value="<?php echo $Co2; ?>" size="7" />
				           
						  Hrs.Co#3:

						  <input name="Co3" type="text" id="Co3" value="<?php echo $Co3; ?>" size="10" />
Hrs.Co#4:
<input name="Co4" type="text" id="Co4" value="<?php echo $Co4; ?>" size="10" />
Hrs.Co#5:
<input name="Co5" type="text" id="Co5" value="<?php echo $Co5; ?>" size="10" />
						  </p></td>

					  </tr>

						<tr>							

							<td colspan="2"> 

							  <p><strong># or Code of Bonus:</strong>
								<input name="Codigo_Bono" type="text" id="Codigo_Bono" size="10"  value="<?php echo $Codigo_Bono; ?>"/>
								<strong>$Total Bonus for workers did in the job site:				      		  </strong>
								<input name="Monto_Bono" type="text" id="Monto_Bono" size="8" value="<?php echo $Monto_Bono; ?>"/>
                                
                                <strong>$Bonus per each PWT employee:				      		  </strong>
								<input name="Bono_General" type="text" id="Bono_General" size="8" value="<?php echo $Bono_General; ?>"/>
						  </p>
							  <p>$ Travel Miles each worker per day:
                                <input name="MilPay" type="text" id="MilPay" value="<?php echo $MilPay; ?>" size="10" /> 
	Miles Note:

						  <input name="MilNote" type="text" id="MilNote" value="<?php echo $MilNote; ?>" size="65" />
						  </p>
							  <p>$ to help in Parking each workers per day:
                                <input name="ParkHel" type="text" id="ParkHel" value="<?php echo $ParkHel; ?>" size="10" />
							    
							    Parking Note:
							    
							    <input name="ParkNote" type="text" id="ParkNote" value="<?php echo $ParkNote; ?>" size="45" />
						      </p>
							  <p>Notes:

						        <textarea name="Notes" cols="135" rows="2" id="Notes"><?php echo $Notes; ?></textarea>

						  </p>

						  </td>

			  	      </tr>	                     				

						<tr>

							<td colspan="2" > 

								<table width="92%">

									<tr>

										<td width="38%" valign="top">											

											<fieldset>

												<legend><strong>Staff Contractor</strong></legend>

													<div id="Div_Proyecto_Empleados_Empresa" name="Div_Proyecto_Empleados_Empresa">

														<table>

															<tr>

																<td width="106"><strong>GC PMr:</strong></td>

																<td width="187"> 								  

																	<?php

																		$sql = "select Empleado_ID, Nombre, Apellido_Paterno, Apellido_Materno FROM personal WHERE Emp_ID=".$Emp_ID." ORDER BY Nombre";														

																		$result=$bd->ejecutar($sql); 		 

																	?>

																		<select size="1" name="Project_Manager_ID" id="Project_Manager_ID"  class="cuadro">      

																			<option  value="-1">--Select Project Manager--</option>

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

																		<img src="images/spacer.gif" height="1" width="1" onload="$('#Project_Manager_ID').val(<?php echo $Project_Manager_ID;?>)" />																</td>

															</tr>

															<tr>

																<td><strong>Superintendent:</strong></td>

																<td> 							  

																	<?php

																		$sql = "select Empleado_ID, Nombre, Apellido_Paterno, Apellido_Materno FROM personal WHERE Emp_ID=".$Emp_ID." ORDER BY Nombre";														

																		$result=$bd->ejecutar($sql); 		 

																	?>

																		<select size="1" name="Coordinador_Obra_ID" id="Coordinador_Obra_ID"  class="cuadro">      

																			<option  value="-1">--Select Superintendent--</option>

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

																		<img src="images/spacer.gif" height="1" width="1" onload="$('#Coordinador_Obra_ID').val(<?php echo $Coordinador_Obra_ID;?>)" />																</td>

															</tr>

														</table>

													</div>

													<div style="display:block" id="div_res_new_proyecto">

														<INPUT id="button" type="button" value="Save" name="button" onClick="Proyecto_Editar_Registrar();">
													</div>	

											</fieldset>										</td>

										<td width="62%" valign="top">

											<fieldset>

												<legend><strong>Staff PWT</strong></legend>

													<table width="591">

														<tr>

															<td width="246"><strong>PM:</strong></td>

															<td width="333">

															  <?php

																	$sql = "select p.Nick_Name, p.Empleado_ID, p.Nombre, p.Apellido_Paterno, p.Apellido_Materno FROM personal p INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID WHERE e.Codigo='PWT' and (p.Aux5='F' or p.Aux5='FB'or p.Aux5='FX' or p.Aux5='FY') ORDER BY p.Aux5,Nick_name";		

																	$result=$bd->ejecutar($sql); 		 

																?>

																	<select size="1" name="Manager_ID" id="Manager_ID"  class="cuadro">      

																		<option  value="-1">--Select Manager--</option>

																<?php		

																		while (($row = mysqli_fetch_array($result) ))							

																		{								

																?>

																			<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row["Nick_Name"]."  /".$row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>

																<?php

																		}

																		mysqli_free_result($result);	

																?>

																	</select>

																	<img src="images/spacer.gif" height="1" width="1" onload="$('#Manager_ID').val(<?php echo $Manager_ID;?>)" />	

																	<input name="Emp_ID_Ant" type="hidden" id="Emp_ID_Ant" size="8" value="<?php echo $Emp_ID; ?>"/>

																	<input name="Pro_ID" type="hidden" id="Pro_ID" size="8" value="<?php echo $Pro_ID; ?>"/>															</td>

														</tr>

														<tr>

															<td><strong>Field Superintendent:</strong></td>

											  <td>

																<?php

															//		$sql = "select p.Nick_Name, p.Empleado_ID, p.Nombre, p.Apellido_Paterno, p.Apellido_Materno FROM personal p 	INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID  WHERE e.Codigo='PWT' and (p.Aux5='F' or p.Aux5='FB'or p.Aux5='FX' or p.Aux5='FY') ORDER BY p.Aux5,Nick_name";		

		$sql = "select p.Nick_Name, p.Empleado_ID, p.Nombre, p.Apellido_Paterno, p.Apellido_Materno FROM personal p 	INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID  WHERE (p.Aux5='F' or p.Aux5='FB'or p.Aux5='FX' or p.Aux5='FY') ORDER BY p.Aux5,Nick_name";		
																	$result=$bd->ejecutar($sql); 		 

																?>

																	<select size="1" name="Coordinador_ID" id="Coordinador_ID"  class="cuadro">      

																		<option  value="-1">--Select PWT-Super.--</option>

																<?php		

																		while (($row = mysqli_fetch_array($result) ))							

																		{								

																?>

																			<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row["Nick_Name"]."  /".$row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>

																<?php

																		}

																		mysqli_free_result($result);	

																?>

																	</select>

																	<img src="images/spacer.gif" height="1" width="1" onload="$('#Coordinador_ID').val(<?php echo $Coordinador_ID;?>)" />															</td>

														</tr>

														<tr>

															<td><strong>Foreman : </strong></td>

															<td>

															  <?php

																	//$sql = "select p.Nick_Name, p.Empleado_ID,p.Emp_ID, p.Nombre, p.Apellido_Paterno, p.Apellido_Materno,p.Cargo FROM personal p INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID  WHERE (p.Aux5='F' or p.Aux5='FB' or p.Aux5='FT'or p.Aux5='FS'or p.Aux5='FX' or p.Aux5='FY' or p.Cargo like '%Sub%') and p.Emp_ID=6 ORDER BY p.Aux5,Nick_name";														

$sql = "select p.Nick_Name, p.Empleado_ID,p.Emp_ID, p.Nombre, p.Apellido_Paterno, p.Apellido_Materno,p.Cargo FROM personal p INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID  WHERE (p.Aux5='F' or p.Aux5='FB' or p.Aux5='FT' or p.Aux5='FX' or p.Aux5='FY' or p.Cargo like '%Sub%') ORDER BY p.Aux5,Nick_name";														

																	$result=$bd->ejecutar($sql); 		 

																?>

																	<select size="1" name="Foreman_ID" id="Foreman_ID"  class="cuadro">      

																		<option  value="-1">--Select Foreman--</option>


														<?php		

																		while (($row = mysqli_fetch_array($result) ))							

																		{								

																?>

																			<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row["Nick_Name"]."  /".$row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>

																<?php

																		}

																		mysqli_free_result($result);	

																?>

																	</select>

																	<img src="images/spacer.gif" height="1" width="1" onload="$('#Foreman_ID').val(<?php echo $Foreman_ID;?>)" />															</td>

														</tr>														

<!  /////////–– inicio lead person and the comment closes with ––> 

												<td><strong>Lead: </strong></td>

															<td>

															  <?php

																	$sql = "select p.Nick_Name, p.Empleado_ID, p.Nombre, p.Apellido_Paterno, p.Apellido_Materno,p.Cargo  FROM personal p INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID  WHERE (p.Aux5='F' or p.Aux5='FB'or p.Aux5='FX' or p.Aux5='FY' or p.Cargo like '%Sub%') ORDER BY p.Aux5,Nick_name";														

																	$result=$bd->ejecutar($sql); 		 

																?>

																	<select size="1" name="Lead_ID" id="Lead_ID"  class="cuadro">      

																		<option  value="-1">--Select Lead--</option>


														<?php		

																		while (($row = mysqli_fetch_array($result) ))							

																		{								

																?>

																			<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row["Nick_Name"]."  /".$row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>

																<?php

																		}

																		mysqli_free_result($result);	

																?>

																	</select>

																	<img src="images/spacer.gif" height="1" width="1" onload="$('#Lead_ID').val(<?php echo $Lead_ID;?>)" />															</td>

														</tr>														






<!  /////////–– Fin lead person and the comment closes with ––> 
<!  /////////–– inicio asistente de proyecto ––> 

												<td><strong>Asistant Proyect Manager: </strong></td>

														<td>

															<?php

																$sql = "select p.Nick_Name, p.Empleado_ID,p.Emp_ID, p.Nombre, p.Apellido_Paterno, p.Apellido_Materno,p.Cargo FROM personal p INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID  WHERE (p.Aux5='F' or p.Aux5='FB' or p.Aux5='FT'or p.Aux5='FS'or p.Aux5='FX' or p.Aux5='FY' or p.Cargo like '%Sub%') and p.Emp_ID=6 ORDER BY p.Aux5,Nick_name";														

																$result=$bd->ejecutar($sql); 	 

															?>

																<select size="1" name="Asistant_Proyect_ID" id="Asistant_Proyect_ID"  class="cuadro">      

																	<option  value="-1">--Select asistant project--</option>


														<?php		

																		while (($row = mysqli_fetch_array($result) ))							

																		{								

																?>

																			<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row["Nick_Name"]."  /".$row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>

																<?php

																		}

																		mysqli_free_result($result);	

																?>

																	</select>

																	<img src="images/spacer.gif" height="1" width="1" onload="$('#Asistant_Proyect_ID').val(<?php echo $Asistant_Proyect_ID;?>)" />															</td>

														</tr>	
<!  /////////–– fin asistente de proyecto ––> 
													</table>
													<p>Emails separate by , :

											          <input name="Emails" type="text" id="Emails" size="60" value="<?php echo $Emails; ?>"/>

									        </p>

										  </fieldset>										</td>

									</tr>

						  </table>							</td>

						</tr>							

					</table>

			  </fieldset>

				

        	</td>                             

        </tr>

		<tr>

			<td valign="top">                                            				

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
//$Pro_ID,$Fecha_Inicio,$Fecha_Fin,$Total_Horas
	$Total_Horas=$Horas+$Co1+$Co2+$Co3+$Co4+$Co5;
	echo "<img src='images/spacer.gif' onload='Empresas_Proyectos_Etapas($Pro_ID);' />"; 

	require('Library/Close_Conexion.php');

?>