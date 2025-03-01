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

	

	$Floor_ID=$_GET['Floor_ID'];	

?> 

<fieldset id="Fs_Lista_Cliente" class="" >

	<legend>List Level 2: Floors and/or common areas<a href="#"><img src="images/icon_nuevo_sintxt_0_gif.gif" onclick='Proyectos_Piso_Area_Nuevo(<?php echo $Floor_ID; ?>);' alt="New Area"/></a></legend>	

		<table>

			<thead>	

			  <tr>

					<th width="100">&nbsp;</th>							 

					<th width="75" >Name</th>

					<th width="100">Hours Estimated </th>

					<th width="100">Stimated Material</th>

					<th width="80"># Units</th>

					<th width="100"><em>Hours Used</em></th>

					<!--<th width="100">Note</th>

				<th width="100">Aux 2</th>

					<th width="100">Aux 3</th>

					<th width="100">Aux 5</th>

					<th width="100">Aux 6</th>

					<th width="100">%</th>   -->

			  </tr>	

			 </thead>	

			 <tbody>

	<?php
	$sql="UPDATE area_control a INNER JOIN (SELECT t.Area_ID, SUM(Horas_Contract) 'suma' FROM registro_diario_actividad ra inner join task t on t.Task_ID=ra.Task_ID GROUP BY t.Area_ID) ah ON a.Area_ID=ah.Area_ID SET a.Total_HArea = ah.suma WHERE a.Floor_ID=".$Floor_ID;
	//echo $sql;
				$result89=$bd->ejecutar($sql);
		mysqli_free_result($result89);
	
	   				       	

		$consulta = "SELECT * FROM area_control WHERE Floor_ID=".$Floor_ID." ORDER BY Nombre ";		

		//echo $consulta."<br>";

		$contador=1;	 	  	 	  	  

	

		$result2=$bd->ejecutar($consulta); 	

		while (($row2 = mysqli_fetch_array($result2) ))							

		{		

			$Area_ID = $row2["Area_ID"];

			//$Nombre = "L2.ID[".$Floor_ID."] ".$row2["Nombre"];
			$Nombre = $row2["Nombre"];

			$Horas_Estimadas = $row2["Horas_Estimadas"];

			$Material_Estimado = $row2["Material_Estimado"];

			$Note = $row2["Note"];

			$Aux1 = $row2["Aux1"];

			$Aux2 = $row2["Aux2"];

			$Aux3 = $row2["Aux3"];

			$Aux4 = $row2["Aux4"];

			$Aux5 = $row2["Aux5"];

			$Aux6 = $row2["Aux6"];

			$Porcentaje = $row2["Porcentaje"];
			$Total_HArea=$row2["Total_HArea"];

		?>		

			<tr >											

				<td>

					<table>

						<tr>								 

							<td width="16">

								<span id="icon_tree_open_area_<?php echo $Area_ID;?>" style="display:block"><img src="images/desplegar.gif" onclick="Proyectos_Piso_Area_Expandir(<?php echo  $Area_ID; ?>);" width="16" /></span>

								<span id="icon_tree_close_area_<?php echo $Area_ID;?>" style="display:none" > <img src="images/contraer.gif" onclick="Proyectos_Piso_Area_Contraer(<?php echo  $Area_ID; ?>);" /></span>

							</td>

							<td>							

								 <a href="#">

									<img src="images/button_edit.gif" border="0" width="16" onclick="Proyectos_Piso_Area_Editar(<?php echo $Area_ID; ?>);" alt="Edit"/>	

								</a>									

							</td>

							<td>

								<a href="#">

									<img src="images/icon_eliminar_0_gif.gif" border="0" width="16" onclick="Proyectos_Piso_Area_Eliminar(<?php echo $Area_ID; ?>,<?php echo $Floor_ID; ?>);" alt="Delete"/>		

								</a>

							</td>

						</tr>

					</table>								 									

				</td>

				<td  style="font-size:x-small"><?php echo  $Nombre; ?></td>	

				<td align="right" style="font-size:x-small"><?php echo  $Horas_Estimadas; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Material_Estimado; ?></td>	

				<td align="right" style="font-size:x-small"><?php echo  $Aux1; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Total_HArea; ?></td>				

				<!--<td align="right" style="font-size:x-small"><?php echo  $Note; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Aux2; ?></td>							

				<td align="right" style="font-size:x-small"><?php echo  $Aux3; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Aux5; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Aux6; ?></td>		

				<td align="right" style="font-size:x-small"><?php echo  $Porcentaje; ?></td>	 -->						

		  </tr> 

		  <tr>

				<td width="100"><img src="images/spacer.gif" width="50" height="1" /></td>

				<td colspan="11">

					<div id="Div_tareas_<?php echo $Area_ID; ?>" style="display:none">

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