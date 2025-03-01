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
    <form id="Form_Maquinaria_Nuevo" name="Form_Maquinaria_Nuevo">
    <table>
    	<tr>
        	<td width="500">             
				<fieldset>
					<legend>Company Info</legend>
					<table  cellpadding="2" cellspacing="2">
						<tr>
							<td width="250"><strong>Name:</strong></td>
							<td ><input name="Nombre" type="text" id="Nombre" size="16"/><label for="Nombre" generated="true" class="error"></label></td>
						</tr>
						<tr>
							<td><strong>Note:</strong></td>
						    <td ><input name="Note" type="text" id="Note" size="50"/></td>
						</tr>
						<tr>							
							<td><strong>Aux 1:</strong>:</td>
							<td><input name="Aux1" type="text" id="Aux1" size="50"/></td>
					  	</tr>
						<tr>
							<td ><strong>Aux 2:</strong></td>
							<td><input name="Aux2" type="text" id="Aux2" size="50"/></td>
						</tr>	
						<tr>
							<td ><strong>Aux 3:</strong></td>
							<td><input name="Aux3" type="text" id="Aux3"  size="50"/></td>
						</tr>												
					</table>
				</fieldset>
				
        	</td>                             
        </tr>
		<tr>
			<td valign="top">                                            
				<div style="display:block" id="div_res_new_maquinaria">
					<INPUT  id="Bnt_Maquinaria_Nueva"  name="Bnt_Maquinaria_Nueva" type="button" value="Add" >
                </div>                                  					
           	</td>       
		</tr>
	</table>
</form>
<img src='images/spacer.gif' onload='iniciar_validacion_maquinaria_nuevo();' />
<?php
	require('Library/Close_Conexion.php');
?>
