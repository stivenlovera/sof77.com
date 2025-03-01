<?php	 		



	session_name("Administrador");



	session_start();		



	if ($_SESSION["EntityID"] == "")



	{



		header("Location:sessionexpired.php"); 	



	}	 			



	require('Library/Control_Cache.php');



	require('Library/Open_Conexion.php');



?> 



    <form action="#" id="Form_Proyecto_Proyecto_Nuevo" name="Form_Proyecto_Proyecto_Nuevo">



    <table width="100%">



    	<tr>



        	<td width="100%">             



				<fieldset>



					<legend><strong>Job</strong></legend>



					<table  cellpadding="2" cellspacing="2" width="100%">



						<tr>



							<td width="13%"><strong>GC-Company:</strong></td>



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



						  </td>



						</tr>



					</table>



					<div id="Div_Proyecto_Proyecto_Nuevo_Datos" name="Div_Proyecto_Proyecto_Nuevo_Datos" style="display:block" >											



						<table  cellpadding="2" cellspacing="2" width="100%">



						<tr>



							<td width="82"><strong># Project:</strong></td>



						  	<td >



								<span id='Div_Numero_proyecto'></span>



								<label for="Codigo" generated="true" class="error"></label><span id='Div_Validar_Codigo'></span>



							</td>



						</tr>			



						<tr>



							<td width="82"><strong>Name:</strong></td>



						  	<td  >



								<input name="Nombre" type="text" id="Nombre" size="40"/> <label for="Nombre" generated="true" class="error"></label>



								<strong>Street:</strong> 



							  <input name="Calle" type="text" id="Calle" size="40"/><label for="Calle" generated="true" class="error"></label>																						



							</td>



						</tr>						



						<tr>



							<td ><strong>City: </strong></td>



							<td>



								<input name="Ciudad" type="text" id="Ciudad" size="20"/><label for="Ciudad" generated="true" class="error"></label>	



								<strong>State: </strong>



								<input type="text" id="Estado" name="Estado" size="15"/> <label for="Estado" generated="true" class="error"></label>



								<strong>Zip Code:</strong>



								<input name="Zip_Code" type="text" id="Zip_Code" size="12"/><label for="Zip_Code" generated="true" class="error"></label>



								<input name="Numero" type="hidden" id="Numero" size="10"/>						  



							</td>



						</tr>													



						<tr>



							<td><strong>Start Date :</strong></td>



						    <td >



								<input name="Fecha_Inicio_Proyecto" type="text" id="Fecha_Inicio_Proyecto" size="20" datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>" />



								<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Inicio_Proyecto"));' />



								<strong>End Date:</strong>	



								<input name="Fecha_Fin_Proyecto" type="text" id="Fecha_Fin_Proyecto" size="20" datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>" /> 



								<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Fin_Proyecto"));' />													  



							    <strong>Price:							    </strong>



							    <input name="Precio" type="text" id="Precio" size="10"/>



								<strong>Hours:</strong>	<input name="Horas" type="text" id="Horas" size="8"/>



							</td>



						</tr>



						<tr>							



							<td colspan="2"> 



								<strong>Staus:</strong> 



							  <?php



									$sql = "select Estatus_ID, Nombre_Estatus FROM estatus order by Nombre_Estatus";														



									$result=$bd->ejecutar($sql); 		 



								?>



									<select size="1" name="Estatus_ID" id="Estatus_ID"  class="cuadro">      



										<option  value="">--Select Staus--</option>



								<?php		



										while (($row = mysqli_fetch_array($result) ))							



										{								



								?>



											<option value="<?php echo  $row["Estatus_ID"];?>"><?php echo $row["Nombre_Estatus"];?></option>



								<?php



										}



										mysqli_free_result($result);	



								?>



									</select><label for="Estatus_ID" generated="true" class="error"></label>



						            <strong>Type:</strong> 



							  <?php



									$sql = "select Tipo_ID, Codigo, Nombre_Tipo FROM tipo_proyecto order by Codigo";														



									$result=$bd->ejecutar($sql); 		 



								?>



									<select size="1" name="Tipo_ID" id="Tipo_ID"  class="cuadro" onchange="Proyecto_Nuevo_Proyecto_Codigo(this.value);">      



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



									</select> <label for="Tipo_ID" generated="true" class="error"></label>



								    <strong>Stage Numbers:</strong> 



			      		  <input name="Numero_Etapas" type="text" id="Numero_Etapas" size="8" value="1"/>							



						  </td>



				  	    </tr>						



						<tr>



							<td colspan="2" > 



								<table width="100%">



									<tr>



										<td width="43%" valign="top">

											

		    <fieldset>



													<legend><strong>Staff Constractor</strong></legend>

													<div id="Div_Proyecto_Empleados_Empresa" name="Div_Proyecto_Empleados_Empresa">



														<table>



															<tr>



																<td width="140"><strong>Project Manager:</strong></td>



																<td width="238"> 								  



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



																		</select><label for="Project_Manager_ID" generated="true" class="error"></label>



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



																		</select><label for="Coordinador_Obra_ID" generated="true" class="error"></label>



																</td>



															</tr>



														</table>	

													</div>

												</fieldset>											



										</td>



								  <td width="53%" valign="top">



<fieldset>



												<legend><strong>Staff PWT</strong></legend>



													<table width="98%">



<tr>



															<td width="50%"><strong>Project Manager PWT:</strong></td>



<td width="50%">

<?php



				$sql = "select p.Nick_Name, p.Empleado_ID, p.Nombre, p.Apellido_Paterno, p.Apellido_Materno 																			FROM personal p INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID WHERE e.Codigo='PWT' ORDER BY Nick_Name";		



																	$result=$bd->ejecutar($sql); 		 



																?>

<select size="1" name="Manager_ID" id="Manager_ID"  class="cuadro">      



																		<option  value="">--Select Manager--</option>



																<?php		



																		while (($row = mysqli_fetch_array($result) ))							



																		{								



																?>



																			<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row["Nick_Name"]." /".$row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>



																<?php



																		}



																		mysqli_free_result($result);	



																?>

																	</select>

<label for="Manager_ID" generated="true" class="error"></label></td>

													  </tr>



														<tr>



															<td><strong>Field Coordinator PWT:</strong></td>



															<td>



																<?php



																	$sql = "select p.Nick_Name, p.Empleado_ID, p.Nombre, p.Apellido_Paterno, p.Apellido_Materno 



																			FROM personal p



																				INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID



																			 WHERE e.Codigo='PWT' ORDER BY Nick_Name";		



																	$result=$bd->ejecutar($sql); 		 



																?>



																	<select size="1" name="Coordinador_ID" id="Coordinador_ID"  class="cuadro">      



																		<option  value="">--Select F.Cordinador--</option>



																<?php		



																		while (($row = mysqli_fetch_array($result) ))							



																		{								



																?>



																			<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row["Nick_Name"]." /".$row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>



																<?php



																		}



																		mysqli_free_result($result);	



																?>

																	</select><label for="Coordinador_ID" generated="true" class="error"></label></td>

														</tr>



														<tr>



															<td><strong>Foreman PWT:</strong></td>



													    <td>



															  <?php



																	$sql = "select p.Nick_Name,p.Empleado_ID, p.Nombre, p.Apellido_Paterno, p.Apellido_Materno 



																			FROM personal p



																				INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID



																			 WHERE e.Codigo='PWT' ORDER BY Nick_Name";														



																	$result=$bd->ejecutar($sql); 		 



																?>



																	<select size="1" name="Foreman_ID" id="Foreman_ID"  class="cuadro">      



																		<option  value="">--Select Foreman--</option>



																<?php		



																		while (($row = mysqli_fetch_array($result) ))							



																		{								



																?>



																			<option value="<?php echo  $row["Empleado_ID"];?>"><?php echo $row[Nick_Name]." /".$row["Nombre"]." ".$row["Apellido_Paterno"]." ".$row["Apellido_Materno"];?></option>



																<?php



																		}



																		mysqli_free_result($result);	



																?>

																	</select><label for="Foreman_ID" generated="true" class="error"></label></td>

														</tr>														

													</table>



									</fieldset>



										</td>



								  </tr>



								</table>



							</td>



						</tr>							



					</table>



						<div style="display:block" id="div_res_new_proyecto">						



							<INPUT id="Bnt_Proyecto_Nueva" type="button" value="Add" name="button">



						</div>						



					</div>



				</fieldset>



				



        	</td>                             



        </tr>



		<tr>



			<td valign="top">                                            				                                  									



           	</td>       



		</tr>		



	</table>



</form>



	<table>



		<tr>



			<td>



				<div id="Div_Estapas_Proyecto" name="Div_Estapas_Proyecto" >					



				</div>



			</td>



		</tr>



	</table>



	<!--<img src='images/spacer.gif' onload='Iniciar_Validacion_Proyecto_Nueva();' />-->



      <?php



	require('Library/Close_Conexion.php');



?>