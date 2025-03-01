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

?> 

<table width="1100">

	<tr>

		<td width="100%">             				

			<fieldset>

				<legend>New Activity Info</legend>

				<form id="form_reporte_proyecto" name="form_reporte_proyecto">	

					<table  cellpadding="2" cellspacing="2" width="100%">

						<tr>

							<td width="98"><strong>GC-Company:</strong></td>

							<td ><input type="text" name="Company" id="Company" size="20" value="">

								<b>Job:</b> 

								<input type="text" name="Nombre" id="Nombre" size="12" value="" />

								<img src="images/buscar.jpg" onclick="Reporte_Actividades_lista_Proyectos();" />

							</td>

						</tr>

						<tr>

							<td colspan="2">

								<div id="lista_proyectos"></div>

							</td>

						</tr>

					</table>

				</form>

				<div id="div_datos_nueva_actividad" style="display:block">

					<fieldset>

						<legend><strong>New Activity for: <div id="div_titulo_nuevo"></div></strong></legend>

						<form id="Form_Actividad_Nueva" name="Form_Actividad_Nueva">							

							<table  cellpadding="2" cellspacing="2" width="100%">

								<tr>

									<td ><b>Date:</b></td>

									<td><input type="text" name="Fecha_Actividad" id="Fecha_Actividad" size="12" datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo FormatDateTime($Fecha, 6);?>" />

										<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Actividad"));' />					     

										<b>Hour:</b><input type="text" name="Hora" id="Hora" size="12"/>						     

										<b>Type:</b> <?php

											$sql = "select Tipo_Actividad_ID, Actividad_Nombre FROM tipo_actividad order by Actividad_Nombre";														

											$result=$bd->ejecutar($sql); 		 

										?>

											<select size="1" name="Tipo_Actividad_ID" id="Tipo_Actividad_ID"  class="cuadro">      

												<option  value="">--Select Type--</option>

										<?php		

												while (($row = mysqli_fetch_array($result) ))							

												{								

										?>

													<option value="<?php echo  $row["Tipo_Actividad_ID"];?>" ><?php echo $row["Actividad_Nombre"];?></option>

										<?php

												}

												mysqli_free_result($result);	

										?>

											</select>

										<input type="hidden" id="color" name="color" size="10" value="FFFFFF" />										

									</td>

								</tr>	

								<tr>

									<td width="82"><b>Description</b></td>

									<td >

											<textarea id="Descripcion" name="Descripcion" cols="80" rows="4"></textarea>														

									</td>

								</tr>						

								<tr>

									<td ><b>Aux1/ Source Schedule:</b></td>

									<td><input name="Aux1" id="Aux1" type="text" size="20"/> 

									&nbsp;&nbsp;						     

										<b>Aux 2:</b><input name="Aux2" id="Aux2" type="text" size="20"/>

										&nbsp;&nbsp;						     

										<b>Aux 3:</b><input name="Aux3" id="Aux3" type="text" size="20"/>	

										<input name="Pro_ID" id="Pro_ID" type="hidden" value="<?php echo $Pro_ID; ?>" size="20"/>	

									</td>

								</tr>																			

								<tr>

									<td valign="top">                                            

										<div id="div_res_nueva_actividad">						

											<INPUT id="button" type="button" value="Add" name="button" onClick="Reporte_Actividades_Nuevo_Registrar();">   		

										</div>

									</td>       

								</tr>		

							</table>

						</form>

					</fieldset>

				</div>				

			</fieldset>

		</td>                             

	</tr>

</table>



<?php

	require('Library/Close_Conexion.php');

?>