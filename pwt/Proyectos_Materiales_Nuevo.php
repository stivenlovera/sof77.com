<?php	 		
	session_name("Administrador");
	session_start();		
	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	 			
	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');
	$Pro_ID=$_GET['Pro_ID'];
	
	$consulta = "SELECT * FROM proyectos WHERE Pro_ID=".$Pro_ID;    		
	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Codigo = $row2["Codigo"];	
		$Nombre = $row2["Nombre"];
	}
	mysqli_free_result($result2);
				
?> 
    <form action="#" id="Form_Proyectos_Materiales_Nuevo" name="Form_Proyectos_Materiales_Nuevo">
    <table width="100%">
    	<tr>
        	<td width="100%">             
				<fieldset>
					<legend><strong>Submittals Info for <?php echo $Codigo." ".$Nombre; ?></strong></legend>
					<table  cellpadding="2" cellspacing="2" width="100%">
						<tr>
							<td width="150"><strong>Denomination:</strong></td>
					  	    <td  >
								<input name="Denominacion" type="text" id="Denominacion" size="40"/><label for="Denominacion" generated="true" class="error"></label>
							</td>
						</tr>						
						<tr>
							<td ><strong>Note:</strong></td>
							<td><input type="text" id="Nombre_Generico" name="Nombre_Generico" size="40"/></td>
						</tr>													
						<tr>
							<td><strong>Apply to :</strong></td>
						    <td >
								<input name="Area_donde_va" type="text" id="Area_donde_va" size="20"/>
							</td>
						</tr>
						<tr>
							<td><strong>Unit gl/yd/lf/lb .....:</strong></td>
						    <td >
								<input name="Unidad_Medida" type="text" id="Unidad_Medida" size="10"/><label for="Unidad_Medida" generated="true" class="error"></label>
								&nbsp;&nbsp;
								<strong>Quantity:								</strong>
								<input name="Cantidad" type="text" id="Cantidad" value="0" size="10"/>
								&nbsp;&nbsp;
								<strong>Unit Price:								</strong>
								<input name="Precio_Unitario" type="text" id="Precio_Unitario" value="0" size="10"/>
								&nbsp;&nbsp;

							</td>
						</tr>						
						<tr>							
							<td ><strong>Status: </strong></td>
						    <td ><?php
									$sql = "select Cat_ID, Nombre FROM categoria_material order by Nombre";														
									$result=$bd->ejecutar($sql); 		 
								?>
									<select size="1" name="Cat_ID" id="Cat_ID"  class="cuadro">      
										<option  value="-1">--Select Status--</option>
								<?php		
										while (($row = mysqli_fetch_array($result) ))							
										{								
								?>
											<option value="<?php echo  $row["Cat_ID"];?>"><?php echo $row["Nombre"];?></option>
								<?php
										}
										mysqli_free_result($result);	
								?>
									</select><label for="Cat_ID" generated="true" class="error"></label>
						            <strong>Vendor:</strong> 
							  <?php
									$sql = "select Ven_ID, Nombre FROM vendedor order by Nombre";														
									$result=$bd->ejecutar($sql); 		 
								?>
									<select size="1" name="Ven_ID" id="Ven_ID"  class="cuadro">      
										<option  value="-1">--Select Vendor--</option>
								<?php		
										while (($row = mysqli_fetch_array($result) ))							
										{								
								?>
											<option value="<?php echo  $row["Ven_ID"];?>"><?php echo $row["Nombre"];?></option>
								<?php
										}
										mysqli_free_result($result);	
								?>
									</select> <label for="Ven_ID" generated="true" class="error"></label>
									<input name="Pro_ID" type="hidden" id="Pro_ID" value="<?php echo $Pro_ID; ?>"/>
							</td>
				  	    </tr>
						<tr>
							<td><strong>Enter date:</strong></td>
						    <td >
								<input name="Fecha_Registro" type="text" id="Fecha_Registro" size="10" value="<?php echo date('m-d-Y'); ?>" datepicker="true" datepicker_format="MM-DD-YYYY" />
								<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Registro"));' />&nbsp;&nbsp;
								<strong>Send Date:</strong>
							  <input name="Fecha_Envio" type="text" id="Fecha_Envio" size="10" datepicker="true" datepicker_format="MM-DD-YYYY" />
								<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Envio"));' />&nbsp;&nbsp;
								<strong>Return date:								</strong>
								<input name="Fecha_Recibido" type="text" id="Fecha_Recibido" size="10" datepicker="true" datepicker_format="MM-DD-YYYY" />
								<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Recibido"));' />&nbsp;&nbsp;

							</td>
						</tr>
						
						<tr>
							<td><strong>Aux1:</strong></td>
						    <td >
								<input name="Aux1" type="text" id="Aux1" size="50"/>
							</td>
						</tr>
						<tr>
							<td><strong>Aux2:</strong></td>
						    <td >
								<input name="Aux2" type="text" id="Aux2" size="50"/>
							</td>
						</tr>
						<tr>
							<td><strong>Aux3:</strong></td>
						    <td >
								<input name="Aux3" type="text" id="Aux3" size="50"/>
							</td>
						</tr>											
					</table>
					<table >
						<tbody>
							<tr>
								<td colspan="7"><hr></td>
							</tr>
							<tr>
								<td>
									<strong>Sent to the vendor:</strong>
								</td>
								<td>
                                <input name="Fecha_to_vendor" type="text" id="Fecha_to_vendor" size="10" value="" datepicker="true" datepicker_format="MM-DD-YYYY" />
									
									<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_from_vendor"));' />
								</td>
								<td>
									<strong>Return from vendor:</strong>
								</td>
								<td>
                                <input name="Fecha_from_vendor" type="text" id="Fecha_from_vendor" size="10" datepicker="true" datepicker_format="MM-DD-YYYY" />
									
									<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_to_vendor"));' />
								</td>
								<td>
									<strong>Note Vendor:</strong>
								</td>
								<td colspan="2">
									<input  type="text" id="note_vendor" name="note_vendor" size="15" value="" />
								</td>
							</tr>
							<tr>
								<td>
									<strong>Sent to GC:</strong>
								</td>
								<td>
                                <input name="Fecha_to_gc" type="text" id="Fecha_to_gc" size="10" value="" datepicker="true" datepicker_format="MM-DD-YYYY" />
									
									<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_from_gc"));' />
								</td>
								<td>
									<strong>Return from GC:</strong>
								</td>
								<td>
                                <input name="Fecha_from_gc" type="text" id="Fecha_from_gc" size="10" value="" datepicker="true" datepicker_format="MM-DD-YYYY" />
									
									<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_to_gc"));' />
								</td>
								<td>
									<strong>Note GC:</strong>
								</td>
								<td colspan="2">
									<input  type="text" id="note_gc" name="note_gc" size="15" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</fieldset>
				
        	</td>                             
        </tr>
		<tr>
			<td valign="top">                                            
				<div style="display:block" id="div_res_new_material">
					<INPUT id="Bnt_Proyecto_Material_Nuevo" type="button" value="Add" name="Bnt_Proyecto_Material_Nuevo">                
				</div>				
           	</td>       
		</tr>		
	</table>
</form>	
<img src='images/spacer.gif' onload='Iniciar_Validacion_Proyecto_Material();' />
<?php
	require('Library/Close_Conexion.php');
?>