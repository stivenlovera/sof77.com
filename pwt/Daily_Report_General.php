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
	$Actividad_ID=$_GET['Actividad_ID'];				
?> 
    <form action="#" id="Form_Empresas_Empleado_Nuevo" name="Form_Empresas_Empleado_Nuevo">
    <table width="100%">
    	<tr>
        	<td width="100%">             
				<fieldset>
					<legend><strong>Employee Info.</strong></legend>
					<table  cellpadding="2" cellspacing="2" width="100%">
						<tr>
							<td width="100"><strong>Name:</strong></td>
						    <td  ><input name="Nombre" type="text" id="Nombre" size="20"/> </td>
						</tr>						
						<tr>
							<td ><strong>Last Name:</strong></td>
						    <td ><input name="Apellido_Paterno" type="text" id="Apellido_Paterno" size="25"/>
						      <strong>Midle:</strong> 
						      <input name="Apellido_Materno" type="text" id="Apellido_Materno" size="25"/></td>
						</tr>
						<tr>
							<td width="82"><strong>Nick Name:</strong></td>
						    <td  ><input name="Nick_Name" type="text" id="Nick_Name" size="20"/> </td>
						</tr>
						<tr>
							<td><strong>Phone:</strong></td>
						    <td >
								<input name="Telefono" type="text" id="Telefono" size="20"/>
								<strong>								Movil:</strong> 
							  <input name="Celular" type="text" id="Celular" size="20"/> 
							</td>
						</tr>
						<tr>							
							<td><strong>Position:</strong></td>
						  <td><input name="Cargo" type="text" id="Cargo" size="30"/> 
							<strong>email:</strong> 
						    <input name="email" type="text" id="email" size="25"/></td>
					  	</tr>
						<tr>
							<td ><strong>Street:</strong></td>
							<td><input name="Calle" type="text" id="Calle" size="40"/>
								<input name="Numero" type="hidden" id="Numero" size="12"/></td>
						</tr>	
						<tr>
							<td ><strong>City:</strong></td>
							<td>
								<input name="Ciudad" type="text" id="Ciudad" size="20"/>
								<strong>State:</strong> 
							  <input type="text" id="Estado" name="Estado" size="15"/> 								
								<strong>Zip Code:</strong> 
							  <input name="Zip_Code" type="text" id="Zip_Code" size="12"/>
							</td>
						</tr>												
						<tr>
							<td colspan="2" >
								<strong>Social Security Number:</strong> 
							  <input name="Numero_Seguro_Social" type="text" id="Numero_Seguro_Social" size="14"/> 
								<strong>Driver's License Number</strong>: 
								<input name="Numero_Licencia_Conducir" type="text" id="Numero_Licencia_Conducir" size="14" />
						  </td>
						</tr>	
						<tr>
							<td colspan="2" >
								<strong>Permit Job #:</strong> 
							  <input name="Numero_Permiso_Trabajo" type="text" id="Numero_Permiso_Trabajo" size="14"/> 
								<strong>Resident #:</strong> 
							  <input name="Numero_Residente" type="text" id="Numero_Residente" size="14" />
						  </td>
						</tr>	
						<tr>
							<td ><strong>Date of Birth</strong></td>
							<td>
								<input name="Fecha_Nacimiento" type="text" id="Fecha_Nacimiento" size="20"  datepicker="true" datepicker_format="MM-DD-YYYY"/>
								<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Nacimiento"));' />&nbsp;&nbsp;
								<strong>Date Exp.Permit Job #:</strong>
							  <input name="Fecha_Expiracion_Trabajo" type="text" id="Fecha_Expiracion_Trabajo" size="20"  datepicker="true" datepicker_format="MM-DD-YYYY"/>
								<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Expiracion_Trabajo"));' />
							</td>
						</tr>						
						<tr>
							<td colspan="2" >
								<strong>Aux1:</strong>
								<input name="Aux1" type="text" id="Aux1" size="20"/>
								<strong>								Aux2:</strong>
								<input name="Aux2" type="text" id="Aux2" size="20"/> 							
								<strong>Aux2:</strong>
								<input name="Aux3" type="text" id="Aux3" size="20"/> 							
						  </td>
						</tr>	
												<tr>
							<td colspan="2" >
								<strong>Aux4:</strong>
								<input name="Aux4" type="text" id="Aux4" size="30"/>
								<em><strong>Type <em><u>Adm</u></em>=(Administrative or Sub) F=(Field worker)-&gt;</strong>:</em>
								<input name="Aux5" type="text" id="Aux5" size="30"/> 							
							</td>
						</tr>	

					</table>
				</fieldset>
				
        	</td>                             
        </tr>
		<tr>
			<td valign="top">                                            
				<div style="display:block" id="div_res_new_empresa">
					<INPUT id="button" type="button" value="Add" name="button" onClick="Empresas_Nuevo_Empleado_Registrar(<?php echo $Emp_ID; ?>);">					
                </div>                                  					
           	</td>       
		</tr>
	</table>
</form>
<?php
	require('Library/Close_Conexion.php');
?>
        
   