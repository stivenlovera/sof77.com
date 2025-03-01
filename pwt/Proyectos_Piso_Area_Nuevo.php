<?php	 		

	session_name("Administrador");

	session_start();		

	if ($_SESSION["EntityID"] == "")

	{

		header("Location:sessionexpired.php"); 	

	}	 			

	require('Library/Control_Cache.php');

	require('Library/Open_Conexion.php');		

	$Floor_ID=$_GET['Floor_ID'];	

	

	$consulta = "SELECT Pro_ID,Nombre FROM floor WHERE Floor_ID=".$Floor_ID;		

	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Pro_ID = $row2["Pro_ID"];

		$Floor_Name=$row2["Nombre"];

		//$Nombre=mb_substr($Floor_Name,0,2);

	}

	mysqli_free_result($result2);

?>     

    <table>

    	<tr>        	                             			

        	<td width="325" valign="top">             

				<fieldset id="fs_Area">

					<legend>Level 2   Info</legend>

					<form id="Form_Area_Nuevo" name="Form_Area_Nuevo">

						<table  cellpadding="2" cellspacing="2">
                        
                        <tr>

								<td width="131"><strong>Area Code:</strong></td>

							  <td width="167" ><input name="Are_IDT" type="text" id="Are_IDT" onclick="$Are_IDT=2;" size="25" /><label for="Are_IDT" generated="true" class="error"></label></td>

							</tr>

							<tr>

								<td width="131"><strong>Name:</strong></td>

							  <td width="167" ><input name="Nombre" type="text" id="Nombre" onclick="$Nombre=2;" size="25" /><label for="Nombre" generated="true" class="error"></label></td>

							</tr>

							<tr>

								<td><strong>Estimated Hours:</strong></td>

								<!--<td ><input name="Horas_Estimadas" type="text" id="Horas_Estimadas"/></td>-->

							</tr>

							<tr>							

								<td><strong>Estimated Material</strong>:</td>

								<td>

									<!--<input name="Material_Estimado" type="text" id="Material_Estimado"/>	-->						

								</td>

							</tr>

							<tr>

								<td ><strong># Units:</strong></td>

						  <td>

									<input name="Aux1" type="text" id="Aux1" size="15"/>						

								</td>

							</tr>	

							<!--<tr>

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

							</tr>   -->	

							<tr>

								<td ><strong>Notes:</strong></td>

								<td><textarea name="Aux4" cols="30" id="Aux4"></textarea></td>

							</tr>

							<!--<tr>

								<td ><strong>Aux5:</strong></td>

								<td><input name="Aux5" type="text" id="Aux5"/></td>

							</tr>

							<tr>

								<td ><strong>Aux6:</strong></td>

								<td><input name="Aux6" type="text" id="Aux6"/></td>

							</tr>

							<tr>   -->

								<td ><strong>%:</strong></td>

								<td>

									<input name="Porcentaje" type="hidden" id="Porcentaje" size="15"/>

									<input name="Pro_ID" type="hidden" id="Pro_ID" value="<?php echo $Pro_ID;?>"/>

									<input name="Floor_ID" type="hidden" id="Floor_ID" value="<?php echo $Floor_ID;?>"/>

								</td>

							</tr>												

						</table>

						<div style="display:block" id="div_res_new_area">

							<INPUT  id="Bnt_Area_Nuevo"  name="Bnt_Area_Nuevo" type="button" value="Add" >

						</div>  

					</form> 

					<img src='images/spacer.gif' onload='Iniciar_Validacion_Piso_Area_Nuevo();' />

				</fieldset>				

        	</td>

			<td width="246" valign="top">             

				<fieldset id="fs_Tarea">

					<legend>Level 3 Task Info</legend>

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

