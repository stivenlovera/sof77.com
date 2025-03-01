<?php	 		

	session_name("Administrador");

	session_start();		

	if ($_SESSION["EntityID"] == "")

	{

		header("Location:sessionexpired.php"); 	

	}	 	

		

	require('Library/Control_Cache.php');	

	require('Library/Open_Conexion.php');	

	require('Library/funciones.php');	

				         					  

	foreach($_POST as $nombre_campo => $valor)

	{

	   	

	   	if  ( !empty($valor )  )

			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";			

		else

			$asignacion = "\$" . $nombre_campo . "='';";			

			

	   	eval($asignacion);

	} 	

	

	$consulta = "SELECT LEFT(Nombre, 5) AS Piso_Ini FROM floor WHERE Floor_ID=".$Floor_ID;				

	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		//$Piso_Ini = $row2["Piso_Ini"]."/";

		$Piso_Ini='';

	}

	mysqli_free_result($result2);		

	

	$strSQL = "INSERT INTO area_control (Are_IDT,Pro_ID, Floor_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje ) ";	

	$strSQL = $strSQL . " values ('".$Are_IDT."',".$Pro_ID.",".$Floor_ID.",'" . $Piso_Ini . $Nombre . "','" . $Horas_Estimadas. "','" . $Horas_Estimadas . "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje. "')";		

	//echo $strSQL."<br>";				

	$res1=$bd->ejecutar($strSQL);  		

	if ($res1)

	{

		//echo "Saved"; 	

		//echo "<img src='images/spacer.gif' onload='Proyectos_Piso_Lista();' />"; 

		

		$consulta = "SELECT MAX(Area_ID) AS Area_ID FROM area_control WHERE Pro_ID=".$Pro_ID. " AND Floor_ID=".$Floor_ID;				

		$result2=$bd->ejecutar($consulta); 	

		while (($row2 = mysqli_fetch_array($result2) ))							

		{		

			$Area_ID = $row2["Area_ID"];

		}

		mysqli_free_result($result2);		

		

	echo "<b>Select Task From Task Master:</b><select id='task_master' name='task_master' onchange='Proyectos_Piso_Area_Tarea_Nuevo_Copiar_Task(this.value);'><bR>";	

		$consulta = "SELECT * FROM task_master";				

		$result2=$bd->ejecutar($consulta); 	

		while (($row2 = mysqli_fetch_array($result2) ))							

		{		

			$Task_Master_ID = $row2["Task_ID"];

			$Nombre = $row2["Nombre"];

			$Horas_Estimadas = $row2["Horas_Estimadas"];

			$Material_Estimado = $row2["Material_Estimado"];

			$Aux1 = $row2["Aux1"];

			$Aux2 = $row2["Aux2"];

			$Aux3 = $row2["Aux3"];

			$Aux4 = $row2["Aux4"];

			$Aux5 = $row2["Aux5"];

			$Aux6 = $row2["Aux6"];

			$Porcentaje = $row2["Porcentaje"];

			

			echo "<option value='".$Nombre."|".$Horas_Estimadas."|".$Material_Estimado."|".$Aux1."|".$Aux2."|".$Aux3."|".$Aux4."|".$Aux5."|".$Aux6."|".$Porcentaje."'>".$Nombre."</option>";

		}

		mysqli_free_result($result2);		

		echo "</select>";

		echo "<br><b>Or Input next</b>";

?>		

		<form id="Form_Area_Task_Nuevo" name="Form_Area_Task_Nuevo">

			<table width="415"  cellpadding="2" cellspacing="2">

            <tr>

								<td><strong>Activity # or Cost Code:</strong></td>

								<td ><input name="Num_Act" type="text" id="Num_Act"/><label for="Num_Act" generated="true" class="error"></label></td>

							</tr>

            

            

            

				<tr>

					<td width="131"><strong>Name:</strong></td>

				  <td width="167" ><input name="Nombre" type="text" id="Nombre" /><label for="Nombre" generated="true" class="error"></label></td>

				</tr>

				<tr>

					<td><strong>Estimated Hours:</strong></td>

					<td ><input name="Horas_Estimadas" type="text" id="Horas_Estimadas"/></td>

				</tr>

				<tr>							

					<td><strong>Estimated Material:</strong>:</td>

					<td>

						<input name="Material_Estimado" type="text" id="Material_Estimado"/>							

					</td>

				</tr>
				<tr>

					<td ><strong># Price Units:</strong></td>

			  		<td>

						<input name="Precio_Unitario" type="text" id="Precio_Unitario"/>							

					</td>

				</tr>	
				<tr>

					<td ><strong># Units:</strong></td>

					<td>

						<input name="Aux1" type="text" id="Aux1"/>							

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

				</tr>	-->

				<tr>

					<td ><strong>Notes:</strong></td>

					<td><textarea name="Aux4" cols="25" id="Aux4"></textarea></td>

				</tr>

				<!--<tr>

					<td ><strong>Aux5:</strong></td>

					<td><input name="Aux5" type="text" id="Aux5"/></td>

				</tr>

				<tr>

					<td ><strong>Aux6:</strong></td>

					<td><input name="Aux6" type="text" id="Aux6"/></td>

				</tr>-->

				<tr>

					<td ><strong>%:</strong></td>

					<td>

						<input name="Porcentaje" type="text" id="Porcentaje"/>

						<input name="Pro_ID" type="hidden" id="Pro_ID" value="<?php echo $Pro_ID;?>"/>

						<input name="Floor_ID" type="hidden" id="Floor_ID" value="<?php echo $Floor_ID;?>"/>

						<input name="Area_ID" type="hidden" id="Area_ID" value="<?php echo $Area_ID;?>"/>

					</td>

				</tr>												

			</table>

			<INPUT  id="Bnt_Area_Task_Nuevo"  name="Bnt_Area_Task_Nuevo" type="button" value="Add" >									       

			<div style="display:block" id="Div_Proyecto_Piso_Area_Task_res_Nueva">				

			</div>   

			<img src='images/spacer.gif' onload='Iniciar_Validacion_Piso_Area_Task_Nuevo();' />

			<img src='images/spacer.gif' onload='Proyectos_Piso_Expandir(<?php echo $Floor_ID;?>);' /> 

			<img src='images/spacer.gif' onload='$("#div_res_new_area").hide();' />

<?php

	}

	else

		echo "ERROR";



	

	require('Library/Close_Conexion.php');	

?>