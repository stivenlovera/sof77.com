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

    <form id="Form_Task_Master_Nuevo" name="Form_Task_Master_Nuevo">

    <table>

    	<tr>

        	<td width="500">             

				<fieldset>

					<legend>Task Master  Info</legend>

					<table  cellpadding="2" cellspacing="2">

                    <tr>

								<td><strong>Activity # or Cost Code:</strong></td>

								<td ><input name="Num_Act" type="text" id="Num_Act"/></td>

							</tr>

                    

						<tr>

							<td width="131"><strong>Name:</strong></td>

						  <td width="351" ><input name="Nombre" type="text" id="Nombre" /><label for="Nombre" generated="true" class="error"></label></td>

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

							<td ><strong>Aux1:</strong></td>

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

							<td><input name="Porcentaje" type="text" id="Porcentaje"/></td>

						</tr>												

					</table>

				</fieldset>

				

        	</td>                             

        </tr>

		<tr>

			<td valign="top">                                            

				<div style="display:block" id="div_res_new_task_master">

					<INPUT  id="Bnt_Task_Master_Nuevo"  name="Bnt_Task_Master_Nuevo" type="button" value="Add" >

                </div>                                  					

           	</td>       

		</tr>

	</table>

</form>

<img src='images/spacer.gif' onload='Iniciar_Validacion_Task_Nuevo();' />

<?php

	require('Library/Close_Conexion.php');

?>

