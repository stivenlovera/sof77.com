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

	

	$consulta = "SELECT * FROM floor WHERE Floor_ID=".$_GET['Floor_ID'];		

	//echo $consulta."<br>";

	$contador=1;	 	  	 	  	  



	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{			

		$Pro_ID = $row2["Pro_ID"];
		$Flo_IDT= $row2["Flo_IDT"];
		$Nombre = $row2["Nombre"];
		$Horas_Estimadas = $row2["Horas_Estimadas"];	
		$Material_Estimado = $row2["Material_Estimado"];
		$Aux1 = $row2["Aux1"];			
		$Aux2 = $row2["Aux2"];
		$Aux3=$row2["Aux3"];
		$Aux4=$row2["Aux4"];
		$Aux5=$row2["Aux5"];
		$Aux6=$row2["Aux6"];
		$Porcentaje=$row2["Porcentaje"];

	}

	mysqli_free_result($result2);			

?>

<form id="Form_Piso_Editar" name="Form_Piso_Editar">

    <table>

    	<tr>

        	<td width="500">             

				<fieldset>

					<legend>Level 1  Info</legend>

					<table  cellpadding="2" cellspacing="2">
                    
                    <tr>

							<td width="131"><strong>Bldg. or Floor Code:</strong></td>

						  <td width="20" ><input name="Flo_IDT" type="text" id="Flo_IDT" Size="15" value="<?php echo $Flo_IDT; ?>" /><label for="Flo_IDT" generated="true" class="error"></label></td>

						</tr>

						<tr>

							<td width="131"><strong>Name:</strong></td>

						  <td width="351" ><input name="Nombre" type="text" id="Nombre" Size="50" value="<?php echo $Nombre; ?>" /><label for="Nombre" generated="true" class="error"></label></td>

						</tr>

						<!--<tr>

							<td><strong> Stimated Hours:</strong></td>

						    <td ><input name="Horas_Estimadas" type="text" id="Horas_Estimadas" value="<?php echo $Horas_Estimadas; ?>" /></td> 

						</tr>

						<tr>							

							<td><strong>Stimated Material</strong>:</td>

							<td>

								<input name="Material_Estimado" type="text" id="Material_Estimado" value="<?php echo $Material_Estimado; ?>" />							

							</td>

					  	</tr>

						<tr>

							<td ><strong># Units:</strong></td>

							<td>

								<input name="Aux1" type="text" id="Aux1" value="<?php echo $Aux1; ?>" />							

							</td>

						</tr>	

						<tr>

							<!-- <td ><strong>Aux2:</strong></td>

							<td>

								 <input name="Aux2" type="text" id="Aux2" value="<?php echo $Aux2; ?>" />

							</td>

						</tr>												

						<tr>

							<td ><strong>Aux3:</strong></td>

						    <td>

								<input name="Aux3" type="text" id="Aux3" value="<?php echo $Aux3; ?>" />

							</td>

						</tr>     -->	

						<tr>

							<td ><strong>Notes:</strong></td>

							<td><input name="Aux4" type="text" id="Aux4" Size="70" value="<?php echo $Aux4; ?>" /></td>

						</tr>

					<!-- <tr>

							<td ><strong>Aux5:</strong></td>

							<td><input name="Aux5" type="text" id="Aux5" value="<?php echo $Aux5; ?>" /></td>

						</tr>

						<tr>

							<td ><strong>Aux6:</strong></td>

							<td><input name="Aux6" type="text" id="Aux6" value="<?php echo $Aux6; ?>" /></td>

						</tr> -->

						<tr>

							<td ><strong>%:</strong></td>

							<td>

								<input name="Porcentaje" type="text" id="Porcentaje" value="<?php echo $Porcentaje; ?>" />

								<input name="Pro_ID" type="hidden" id="Pro_ID" value="<?php echo $Pro_ID; ?>" />								

								<input name="Floor_ID" type="hidden" id="Floor_ID" value="<?php echo $Floor_ID; ?>" />								

							</td>

						</tr>												

					</table>

				</fieldset>

				

        	</td>                             

        </tr>

		<tr>

			<td valign="top">                                            

				<div style="display:block" id="div_res_edit_piso">

					<INPUT  id="Bnt_Piso_Editar"  name="Bnt_Piso_Editar" type="button" value="Save" >

                </div>                                  					

           	</td>       

		</tr>

	</table>

</form>

<img src='images/spacer.gif' onload='Iniciar_Validacion_Piso_Editar();' />

<?php

	require('Library/Close_Conexion.php');

?>

