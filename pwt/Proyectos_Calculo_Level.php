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
?>     
    <table>
    	<tr>
        	<td width="500" valign="top">             
				<fieldset>
					<legend>Level 1 or Floor Infoxxxxxxxxxx</legend>
					<form id="Form_Piso_Nuevo" name="Form_Task_Master_Nuevo">
						<table  cellpadding="2" cellspacing="2">
						<tr>
							<td width="131"><strong>Name:</strong></td>
						  <td width="167" ><input name="Nombre" type="text" id="Nombre" /><label for="Nombre" generated="true" class="error"></label></td>
						</tr>
						<tr>
							<td><strong>Time Stimated:</strong></td>
						    <td ><input name="Horas_Estimadas" type="text" id="Horas_Estimadas"/></td>
						</tr>
						<tr>							
							<td><strong>Material Stimated</strong>:</td>
							<td>
								<input name="Material_Estimado" type="text" id="Material_Estimado"/>							
							</td>
					  	</tr>
						<tr>
							<td ><strong># Units:</strong></td>
					  <td>
								<input name="Aux1" type="text" id="Aux1"/>							
							</td>
						</tr>	
						<tr>
							<td ><strong>Aux2:</strong></td>
							<td>
								 <input name="Aux2" type="text" id="Aux2"/>
							</td>
						</tr>												
						<tr>
							<td ><strong>Aux3:</strong></td>
						    <td>
								<input name="Aux3" type="text" id="Aux3"/>
							</td>
						</tr>	
						<tr>
							<td ><strong>Aux4:</strong></td>
							<td><input name="Aux4" type="text" id="Aux4"/></td>
						</tr>
						<tr>
							<td ><strong>Aux5:</strong></td>
							<td><input name="Aux5" type="text" id="Aux5"/></td>
						</tr>
						<tr>
							<td ><strong>Aux6:</strong></td>
							<td><input name="Aux6" type="text" id="Aux6"/></td>
						</tr>
						<tr>
							<td ><strong>%:</strong></td>
							<td>
								<input name="Porcentaje" type="text" id="Porcentaje"/>
								<input name="Pro_ID" type="hidden" id="Pro_ID" value="<?php echo $Pro_ID;?>"/>
							</td>
						</tr>												
					</table>
					</form>
					<div style="display:block" id="div_res_new_piso">
						<INPUT  id="Bnt_Piso_Nuevo"  name="Bnt_Piso_Nuevo" type="button" value="Add" >
	                </div>   
				</fieldset>				
        	</td>                             			
        	<td width="500" valign="top">             
				<fieldset id="fs_Area">
					<legend>Area  Info</legend>
					<div id="Div_Proyecto_Piso_Area_Nueva" name="Div_Proyecto_Piso_Area_Nueva">
						
					</div>
				</fieldset>				
        	</td>
			<td width="500" valign="top">             
				<fieldset id="fs_Tarea">
					<legend>Task Info</legend>
					<div id="Div_Proyecto_Piso_Area_Task_Nueva" name="Div_Proyecto_Piso_Area_Task_Nueva">						
					</div>					
				</fieldset>
				
        	</td>                             
        </tr>
	</table>
<img src='images/spacer.gif' onload='Iniciar_Validacion_Piso_Nuevo();' />
<?php
	require('Library/Close_Conexion.php');
?>
