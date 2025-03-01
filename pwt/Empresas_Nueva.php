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
    <form id="Form_Empresas_Nueva" name="Form_Empresas_Nueva">
    <table>
    	<tr>
        	<td width="500">             
				<fieldset>
					<legend>Company Info</legend>
					<table  cellpadding="2" cellspacing="2">
						<tr>
							<td width="250"><strong>Code:</strong></td>
							<td >
								<input name="Codigo" type="text" id="Codigo" size="16" onblur="Empresas_Nueva_Validar_Codigo(this.value, '');"/>
								<label for="Codigo" generated="true" class="error"></label><span id='Div_Validar_Codigo'></span>
							</td>
						</tr>
						<tr>
							<td><strong>Name:</strong></td>
						    <td ><input name="Nombre" type="text" id="Nombre" size="50"/><label for="Nombre" generated="true" class="error"></label></td>
						</tr>
						<tr>							
							<td><strong>General Manager</strong>:</td>
							<td><input name="Gerente_General" type="text" id="Gerente_General" size="50"/></td>
					  	</tr>
						<tr>
							<td ><strong>Street:</strong></td>
							<td><input name="Calle" type="text" id="Calle" size="50"/>
								<input name="Numero" type="hidden" id="Numero"/>
							</td>
						</tr>	
						<tr>
							<td ><strong>City:</strong></td>
							<td>
								 <input name="Ciudad" type="text" id="Ciudad"/>
								 <strong> State:</strong>
								 <input type="text" id="Estado" name="Estado" size="15"/> 
								 <strong>Zip Code: </strong>
								 <input name="Zip_Code" type="text" id="Zip_Code" size="15"/>
							</td>
						</tr>												
						<tr>
							<td ><strong>Phone:</strong></td>
						    <td><input name="Telefono" type="text" id="Telefono" size="15"/>
								<strong>Fax:</strong> 
							  <input name="Fax" type="text" id="Fax" size="15"/> 
								<strong>Web Site:								</strong>
								<input name="Web" type="text" id="Web" size="20"/>
								<strong>								email:</strong> 
							  <input name="email" type="text" id="email" size="20"/>
							</td>
						</tr>	
						<tr>
							<td ><strong>Industry:</strong></td>
							<td><input name="Rubro" type="text" id="Rubro" size="50"/></td>
						</tr>						
						<tr>
							<td ><strong>Details:</strong></td>
							<td><textarea  id="Detalles" name="Detalles" value="" rows="1" cols="96"> </textarea></td>
						</tr>	
					</table>
				</fieldset>
				
        	</td>                             
        </tr>
		<tr>
			<td valign="top">                                            
				<div style="display:block" id="div_res_new_empresa">
					<INPUT  id="Bnt_Empres_Nueva"  name="Bnt_Empres_Nueva" type="button" value="Add" >
                </div>                                  					
           	</td>       
		</tr>
	</table>
</form>
<img src='images/spacer.gif' onload='Iniciar_Validacion_Empresa_Nueva();' />
<?php
	require('Library/Close_Conexion.php');
?>
