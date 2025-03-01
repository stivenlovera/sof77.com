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

?> 

<fieldset id="Fs_Lista_Cliente" class="" >

	<legend>List Level 1: </legend>

		<table class="moduletable" >

			<thead>	

			  <tr>

					<th width="80">&nbsp;</th>							 

					<th width="150" >Name</th>

					<th width="100">Stimated Hour</th>

					<th width="100">Stimated Material</th>

					<th width="100">Estimated Units</th>

					<th width="300">Notes</th>

					<!--<th width="100">Aux 2</th>

					<th width="100">Aux 3</th>

					<th width="100">Aux 5</th>

					<th width="100">Aux 6</th>

					<th width="100">%</th>  -->

			  </tr>	

			 </thead>	

			 <tbody>

	<?php   				       	

		$consulta = "SELECT * FROM floor WHERE Pro_ID=".$Pro_ID." ORDER BY Nombre ";		

		//echo $consulta."<br>";

		$contador=1;	 	  	 	  	  

	

		$result2=$bd->ejecutar($consulta); 	

		while (($row2 = mysqli_fetch_array($result2) ))							

		{		

			$Floor_ID = $row2["Floor_ID"];

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

		?>		

			<tr >											

				<td>

					<table>

						<tr>								 

							<td>

								<span id="icon_tree_open_<?php echo $Floor_ID;?>" style="display:block"><img src="images/desplegar.gif" onclick="Dayli_Report_Piso_Expandir(<?php echo  $Floor_ID; ?>,<?php echo  $Actividad_ID; ?>);" width="14" /></span>

								<span id="icon_tree_close_<?php echo $Floor_ID;?>" style="display:none" > <img src="images/contraer.gif" onclick="Dayli_Report_Piso_Contraer(<?php echo  $Floor_ID; ?>);" /></span>

							</td>

						</tr>

					</table>

				</td>

				<td  style="font-size:x-small"><?php echo  $Nombre; ?></td>						

				<td align="right" style="font-size:x-small"><?php echo  $Horas_Estimadas; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Material_Estimado; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Aux1; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Aux4; ?></td>

				<!--<td align="right" style="font-size:x-small"><?php echo  $Aux2; ?></td>							

				<td align="right" style="font-size:x-small"><?php echo  $Aux3; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Aux5; ?></td>							

				<td align="right" style="font-size:x-small"><?php echo  $Aux6; ?></td>							

				<td align="right" style="font-size:x-small"><?php echo  $Porcentaje; ?></td> -->							

		  </tr>

		  <tr>

				<td width="100"><img src="images/spacer.gif" width="50" height="1" /></td>

				<td colspan="10">

					<div id="Div_Areas_<?php echo $Floor_ID; ?>" style="display:none">

						Hola

					</div>

				</td>

		  </tr>

			<?php    		

				$contador++;								 								

		}

		mysqli_free_result($result2);		

				?>

			</tbody>

		</table>   

		<?php		

		if ($contador == 1 )

		{

			echo "<br><br>Record Not Found<br>";

		}				

		?>					 

</fieldset>	

<?php

	require('Library/Close_Conexion.php');	

?>