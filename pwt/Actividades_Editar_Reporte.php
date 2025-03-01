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



	$Pro_ID=$_GET['Pro_ID'];	

	$Actividad_ID=$_GET['Actividad_ID'];	

	

	$sql = "SELECT Codigo, Nombre FROM proyectos WHERE Pro_ID=".$Pro_ID;

	//echo $sql;														

	$result=$bd->ejecutar($sql); 		 

	while (($row = mysqli_fetch_array($result) ))							

	{								

		$Nombre=$row["Nombre"];

		$Codigo=$row["Codigo"];

	}

	mysqli_free_result($result);	

	

	$consulta = "SELECT a.*, ta.Actividad_Nombre  FROM actividades a";

	$consulta = $consulta . " INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID ";

	$consulta = $consulta . " WHERE a.Actividad_ID=".$Actividad_ID;		

	$consulta = $consulta . " ORDER BY a.Fecha, a.Hora";		

	//echo $consulta."<br>";

	$contador=1;	 	  	 	  	  



	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Tipo_Actividad_ID = $row2["Tipo_Actividad_ID"];

		$Actividad_Nombre=$row2["Actividad_Nombre"];

		$Descripcion=$row2["Descripcion"];

		$Fecha = $row2["Fecha"];	

		$Hora = $row2["Hora"];	

		$Aux1 = $row2["Aux1"];			

		$Aux2 = $row2["Aux2"];

		$Aux3 = $row2["Aux3"];

		$Aux4 = $row2["Aux4"];

		$color = $row2["color"];	

	}

	mysqli_free_result($result2);					

?> 

<form id="Form_Proyectos_Actividades_Editar" name="Form_Proyectos_Actividades_Editar">

    <table width="100%">

    	<tr>

        	<td width="100%">             

				<fieldset>

					<legend><strong>New Activity : <?php echo $Nombre."-".$Codigo."-".FormatDateTime($Fecha, 8);?></strong></legend>

					<table  cellpadding="4" cellspacing="2" width="100%">

						<tr>

							<td ><b>Date:</b></td>

							<td><input type="text" name="Fecha_Actividad" id="Fecha_Actividad" size="12" datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo FormatDateTime($Fecha, 6);?>" />

								<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Actividad"));' />					     

								<b>Hour:</b><input type="text" name="Hora" id="Hora" size="12" value="<?php echo $Hora;?>"/>						     

							   	<b>Type:</b> <?php

									$sql = "select Tipo_Actividad_ID, Actividad_Nombre FROM tipo_actividad order by Actividad_Nombre";														

									$result=$bd->ejecutar($sql); 		 

								?>

									<select size="1" name="Tipo_Actividad_ID" id="Tipo_Actividad_ID"  class="cuadro">      

										<option  value="">--Select Type--</option>

								<?php		

										while (($row = mysqli_fetch_array($result) ))							

										{								

								?>

											<option value="<?php echo  $row["Tipo_Actividad_ID"];?>" ><?php echo $row["Actividad_Nombre"];?></option>

								<?php

										}

										mysqli_free_result($result);	

								?>

									</select>																		

									<img src="images/spacer.gif" height="1" width="1" onload="$('#Tipo_Actividad_ID').val(<?php echo $Tipo_Actividad_ID;?>)" /> 															

								<input type="hidden" id="color" name="color" value="<?php echo $color; ?>" />							</td>

						</tr>	

						<tr>

							<td width="82" height="95"><b>Aditional Instructions/ Description Work need be done</b></td>

			  	  <td >

						  <textarea id="Descripcion" name="Descripcion" cols="75" rows="5"><?php echo $Descripcion;?></textarea>							</td>

						</tr>						

						<tr>

							<td ><p>&nbsp;</p>

						    <p><strong> daily report:</strong></p></td>

						  <td><p>Source Schedule:

					          <input name="Aux1" id="Aux1" type="text" size="70" value="<?php echo $Aux1;?>"/>

&nbsp;&nbsp;</p>

						    <p>						     

						      <b> Visitors (Who?/What Time? / How Long?):</b>
						      <input name="Aux2" id="Aux2" type="text" size="70" value="<?php echo $Aux2;?>"/>

&nbsp;&nbsp;					        </p>

						    <p><b>						      Does 
					        the painters need return ?  when?:</b>

						      <input name="Aux3" id="Aux3" type="text" size="70" value="<?php echo $Aux3;?>"/>

						    </p>

						    <p>News (Power problems/Equipment got broke?/To many people is working in the same place?/Othes: 

						      <textarea name="Aux4" cols="75" rows="3" id="Aux4"><?php echo $Aux4;?></textarea>

					        </p>

						    <p>	

						      <input name="Pro_ID" id="Pro_ID" type="hidden" value="<?php echo $Pro_ID; ?>" />	

						      <input type="hidden" id="Actividad_ID" name="Actividad_ID" value="<?php echo $Actividad_ID; ?>" />					     

					        </p></td>

						</tr>													

					</table>

			  </fieldset>

				

        	</td>                             

        </tr>

		<tr>

			<td height="61" valign="top">                                            

		  <div style="display:block" id="div_res_nueva_actividad">

					<INPUT id="button" type="button" value="Save" name="button" onClick="Actividades_Editar_Reporte_Guardar();">   					

                </div>

           	</td>       

	  </tr>		

	</table>

</form>

<?php

	require('Library/Close_Conexion.php');

?>