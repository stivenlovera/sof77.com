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

	

	$strSQL = "INSERT INTO floor (Flo_IDT,Pro_ID, Edificio_ID, Nombre, Aux4, Porcentaje ) ";	

	$strSQL = $strSQL . " values ('".$Flo_IDT."',".$Pro_ID.",".$Edificio_ID.",'" . $Nombre . "','" . $Aux4  .  "','" .$Porcentaje. "')";		

	//echo $strSQL."<br>";				

	$res1=$bd->ejecutar($strSQL);  		

	if ($res1)

	{

		//echo "Saved"; 	

		echo "<img src='images/spacer.gif' onload='Proyectos_Edificio_Piso_Lista(".$Edificio_ID.");' />"; 

		

		$consulta = "SELECT MAX(Floor_ID) as Floor_ID FROM floor WHERE Pro_ID=".$Pro_ID;	

		//echo $consulta;			

		$result2=$bd->ejecutar($consulta); 	

		while (($row2 = mysqli_fetch_array($result2) ))							

		{		

			$Floor_ID = $row2["Floor_ID"];

		}

		mysqli_free_result($result2);		

?>

		<form id="Form_Area_Nuevo" name="Form_Area_Nuevo">

			<table  cellpadding="2" cellspacing="2">
            
            <tr>

					<td width="131"><strong>Floor or Area Code:</strong></td>

				  <td width="167" ><input name="Are_IDT" type="text" id="Are_IDT" /><label for="Are_IDT" generated="true" class="error"></label></td>

			  </tr>
            
            

				<tr>

					<td width="131"><strong>Name:</strong></td>

				  <td width="167" ><input name="Nombre" type="text" id="Nombre" /><label for="Nombre" generated="true" class="error"></label></td>

				</tr>

				<!--<tr>

					<td><strong>Estimated Hours:</strong></td>

					<td ><input name="Horas_Estimadas" type="text" id="Horas_Estimadas"/></td>

				</tr>

				<tr>							

					<td><strong>Estimated Material:</strong>:</td>

					<td>

						<input name="Material_Estimado" type="text" id="Material_Estimado"/>							

					</td>

				</tr>-->

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

				</tr>-->	

				<tr>

					<td ><strong>Notes:</strong></td>

					<td><input name="Aux4" type="text" id="Aux4"/></td>

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

			<img src='images/spacer.gif' onload='$("#div_res_new_piso").hide();' />

			

<?php

	}

	else

		echo "ERROR";



	

	require('Library/Close_Conexion.php');	

?>