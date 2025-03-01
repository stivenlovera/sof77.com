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
					<legend>Level 0  Info</legend>

					<form id="Form_Edificio_Nuevo" name="Form_Edificio_Nuevo">
						<table  cellpadding="2" cellspacing="2">
						<tr>
							<td width="131"><strong>Name:</strong></td>
							<td width="167" ><input name="Nombre" type="text" id="Nombre" /><label for="Nombre" generated="true" class="error"></label></td>
						</tr>						
						<tr>
							<td ><strong>Notes:</strong></td>
							<td><input name="Descripcion" type="text" id="Descripcion" Size="30"/></td>
						</tr>
							<td ><strong>%:</strong></td>
							<td>
								<input name="Porcentaje" type="text" id="Porcentaje"/>
								<input name="Aux1" type="hidden" id="Aux1"/>
								<input name="Aux2" type="hidden" id="Aux2"/>
								<input name="Horas_Estimadas" type="hidden" id="Horas_Estimadas"/>
								<input name="Material_Estimado" type="hidden" id="Material_Estimado"/>
								<input name="Pro_ID" type="hidden" id="Pro_ID" value="<?php echo $Pro_ID;?>"/>
							</td>
						</tr>	
					</table>
					</form>

					<div style="display:block" id="div_res_new_edificio">
						<INPUT  id="Bnt_Edificio_Nuevo"  name="Bnt_Edificio_Nuevo" type="button" value="Add" >
	                </div>   
				</fieldset>	
        	</td> 

        	<td width="500" valign="top">
				<fieldset>
					<legend>Level 1  Info</legend>
						<div id="Div_Proyecto_Piso_Nuevo" name="Div_Proyecto_Piso_Nuevo"></div>
				</fieldset>	
        	</td>                             			

        	<td width="500" valign="top">             

				<fieldset id="fs_Area">

					<legend>Level 2   Info</legend>

					<div id="Div_Proyecto_Piso_Area_Nueva" name="Div_Proyecto_Piso_Area_Nueva">

						

					</div>

				</fieldset>				

        	</td>

			<td width="589" valign="top">             

				<fieldset id="fs_Tarea">

					<legend>Level 3 Task Info</legend>

					<div id="Div_Proyecto_Piso_Area_Task_Nueva" name="Div_Proyecto_Piso_Area_Task_Nueva">						

					</div>					

				</fieldset>

				

        	</td>                             

        </tr>

	</table>

<!--<img src='images/spacer.gif' onload='Iniciar_Validacion_Piso_Nuevo();' />-->
<img src='images/spacer.gif' onload='Iniciar_Validacion_Edificio_Nuevo();' />

<?php

	require('Library/Close_Conexion.php');

?>

