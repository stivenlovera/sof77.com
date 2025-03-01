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

	

	$strSQL = "INSERT INTO edificios (Pro_ID, Nombre, Descripcion, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Porcentaje ) ";	

	$strSQL = $strSQL . " values (".$Pro_ID.",'" . $Nombre . "','" . $Descripcion . "','" . $Horas_Estimadas. "','" . $Horas_Estimadas . "','" . $Aux1. "','" . $Aux2. "', '" . $Porcentaje. "')";		

	//echo $strSQL."<br>";				

	$res1=$bd->ejecutar($strSQL);  		

	if ($res1)

	{

		//echo "Saved"; 	

		echo "<img src='images/spacer.gif' onload='Proyectos_Edificio_Lista(".$Pro_ID.");' />"; 

		

		$consulta = "SELECT MAX(Edificio_ID) as Edificio_ID FROM edificios WHERE Pro_ID=".$Pro_ID;	

		//echo $consulta;			

		$result2=$bd->ejecutar($consulta); 	

		while (($row2 = mysqli_fetch_array($result2) ))							

		{		

			$Edificio_ID = $row2["Edificio_ID"];

		}

		mysqli_free_result($result2);		

?>

		<form id="Form_Piso_Nuevo" name="Form_Piso_Nuevo">

				<table  cellpadding="2" cellspacing="2">  
				<tr>
					<td width="131"><strong>Name:</strong></td>
				  <td width="167" ><input name="Nombre" type="text" id="Nombre" /><label for="Nombre" generated="true" class="error"></label></td>
				</tr>

			<!-- <tr>

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

				</tr>-->	

				<tr>

					<td ><strong>Notes:</strong></td>

					<td><input name="Aux4" type="text" id="Aux4" Size="30"/></td>

				</tr>

				<!--<tr>

					<td ><strong>Aux5:</strong></td>

					<td><input name="Aux5" type="text" id="Aux5"/></td>

				</tr>

				<tr>

					<td ><strong>Aux6:</strong></td>

					<td><input name="Aux6" type="text" id="Aux6"/></td>

				</tr>

				<tr>-->

					<td ><strong>%:</strong></td>

					<td>

						<input name="Porcentaje" type="text" id="Porcentaje"/>
						<input name="Edificio_ID" type="hidden" id="Edificio_ID" value="<?php echo $Edificio_ID;?>"/>
						<input name="Pro_ID" type="hidden" id="Pro_ID" value="<?php echo $Pro_ID;?>"/>

					</td>

				</tr>												

			</table>

			</form>

			<div style="display:block" id="div_res_new_piso">

				<INPUT  id="Bnt_Piso_Nuevo"  name="Bnt_Piso_Nuevo" type="button" value="Add" >

			</div> 

		

			<img src='images/spacer.gif' onload='Iniciar_Validacion_Piso_Nuevo();' />

			<img src='images/spacer.gif' onload='$("#div_res_new_edificio").hide();' />

			

<?php

	}

	else

		echo "ERROR";



	

	require('Library/Close_Conexion.php');	

?>