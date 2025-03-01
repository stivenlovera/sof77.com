<?php	 		

	session_name("Administrador");

	session_start();		

	if ($_SESSION["EntityID"] == "")

	{

		header("Location:sessionexpired.php"); 	

	}	 			

	require('Library/Control_Cache.php');

	require('Library/Open_Conexion.php');	

	

	$Num_act=$_GET['Num_act'];	

	$Task_ID=$_GET['Task_ID'];	

	$Actividad_ID=$_GET['Actividad_ID'];	

	

	/**$consulta = "SELECT * FROM dayli_report_task WHERE Dayli_ID=".$_GET['Dayli_ID'];		

	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Dayli_ID = $row2["Dayli_ID"];

		$Task_ID = $row2["Task_ID"];

		$Actividad_ID = $row2["Actividad_ID"];

		$Horas = $row2["Horas"];

		$Nota_Horas = $row2["Nota_Horas"];

		$Porcentaje = $row2["Porcentaje"];

		$Nota_Porcentaje = $row2["Nota_Porcentaje"];

		$Numero = $row2["Numero"];

		$Nota_Numero = $row2["Nota_Numero"];

		$Aux1 = $row2["Aux1"];

		$Aux1_Nota = $row2["Aux1_Nota"];

		$Aux2 = $row2["Aux2"];

		$Aux2_Nota = $row2["Aux2_Nota"];

		$Aux3 = $row2["Aux3"];

		$Aux3_Nota = $row2["Aux3_Nota"];

			$MatUse = $row2["MatUse"];

			$PerCom = $row2["Porcentaje"];

	}

	mysqli_free_result($result2);			

?>     **/

    <table>

    	<tr>        	                             			        	

			<td width="500" valign="top">             

				<fieldset id="fs_Tarea">

					<legend>Daily Report Level 3 or Task Info (Edit Record)</legend>

					<form id="FORM_Dayli_Report_Piso_Area_Tareas_Task_Editar" name="FORM_Dayli_Report_Piso_Area_Tareas_Task_Editar">

						<table width="775"  cellpadding="2" cellspacing="2">

<tr>

								<td width="133"><strong>Hours Worked:</strong></td>

	  	    <td width="626" ><input name="Horas" type="text" id="Horas" size="12" value="<?php echo $Horas;?>" />

                              Material Used:

							      <input name="MatUse" type="text" id="MatUse" size="12" value="<?php echo $MatUse;?>" /> 

							      %Completed at today:

      <input name="PerCom" type="text" id="PerCom" size="12" value="<?php echo $Porcentaje;?>" />

							</tr>

							<tr>

								<td><strong>Notes:</strong></td>

								<td ><input name="Nota_Horas" type="text" id="Nota_Horas" size="70" value="<?php echo $Nota_Horas;?>"/></td>

							</tr>

							<!--<tr>							

								<td><strong>%</strong>:</td> 

								<td>

									<input name="Porcentaje" type="text" id="Porcentaje" value="<?php echo $Porcentaje;?>"/>							

								</td>

							</tr> 

							<tr>

								<td ><strong>Note %:</strong></td>

								<td>

									<input name="Nota_Porcentaje" type="text" id="Nota_Porcentaje" value="<?php echo $Nota_Porcentaje;?>"/>							

								</td>

							</tr>-->

							<tr>							

								<td><strong>Number Units Done:</strong></td>

								<td>

									<input name="Numero" type="text" id="Numero" value="<?php echo $Numero;?>"/></td>

							</tr>

							<!--<tr>

								<td ><strong>Note Number:</strong></td>

								<td>

									<input name="Nota_Numero" type="text" id="Nota_Numero" value="<?php echo $Nota_Numero;?>"/>							

								</td>

							</tr>			

							<tr>

								<td ><strong>Aux1:</strong></td>

								<td>

									 <input name="Aux1" type="text" id="Aux1" value="<?php echo $Aux1;?>"/>

								</td>

							</tr>												

							<tr>

								<td ><strong>Aux1_Nota:</strong></td>

								<td>

									<input name="Aux1_Nota" type="text" id="Aux1_Nota" value="<?php echo $Aux1_Nota;?>"/>

								</td>

							</tr>	

							<tr>

								<td ><strong>Aux2:</strong></td>

								<td><input name="Aux2" type="text" id="Aux2" value="<?php echo $Aux2;?>"/></td>

							</tr> 

							<tr>

								<td ><strong>Aux2_Nota:</strong></td>

								<td><input name="Aux2_Nota" type="text" id="Aux2_Nota" value="<?php echo $Aux2_Nota;?>"/></td>

							</tr>

							<tr>

								<td ><strong>Aux3:</strong></td>

								<td><input name="Aux3" type="text" id="Aux3" value="<?php echo $Aux3;?>"/></td>

							</tr>-->

							<tr>

								<td ><strong>Aux_Notes:</strong></td>

								<td>

									<input name="Aux3_Nota" type="text" id="Aux3_Nota" Size="70" value="<?php echo $Aux3_Nota;?>"/>

									<input name="Dayli_ID" type="hidden" id="Dayli_ID" value="<?php echo $Dayli_ID;?>"/>

									<input name="Task_ID" type="hidden" id="Task_ID" value="<?php echo $Task_ID;?>"/>

									<input name="Actividad_ID" type="hidden" id="Area_ID" value="<?php echo $Actividad_ID;?>"/>

								</td>

							</tr>												

						</table>															       

<div style="display:block" id="Div_Dayli_Report_Piso_Area_Tareas_Task_Nuevo_res">				

							<INPUT  id="Bnt_Dayli_Report_Nuevo"  name="Bnt_Dayli_Report_Nuevo" type="button" value="Save" onclick="Dayli_Report_Piso_Area_Tareas_Task_Editar_Registrar();" >

						</div>					

					</form>

				</fieldset>				

        	</td>                             

        </tr>

	</table>

<?php

	require('Library/Close_Conexion.php');

?>

