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

	

	$Area_ID=$_GET['Area_ID'];	

	$Actividad_ID=$_GET['Actividad_ID'];

?> 

<fieldset id="Fs_Lista_Cliente" class="" >

	<legend>List Level 3 or Task</legend>	

		<table>

			<thead>	

			  <tr>

					<th width="100">&nbsp;</th>						 

					<th width="50" >Num.Act</th>						 

					<th width="250" >Name</th>

					<th width="100">Stimated Hours</th>

					<th width="100">Stimated Material</th>

					<th width="100">Stimated Units</th>

					<th width="150">Notes</th>

					<!--<th width="100">Aux2</th>

					<th width="100">Aux3</th>

					<th width="100">Aux5</th>

					<th width="100">Aux6</th>				

					<th width="100">%</th>-->

			  </tr>	

			 </thead>	

			 <tbody>

	<?php   				       	

		$consulta = "SELECT * FROM task WHERE Area_ID=".$Area_ID." ORDER BY NumAct ASC";		

		//echo $consulta."<br>";

		$contador=1;	 	  	 	  	  

	

		$result2=$bd->ejecutar($consulta); 	

		while (($row2 = mysqli_fetch_array($result2) ))							

		{		

			$Task_ID = $row2["Task_ID"];

			$NumAct = $row2["NumAct"];

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

								<span id="icon_tree_open_area_task_<?php echo $Task_ID;?>" style="display:block"><img src="images/desplegar.gif" onclick="Dayli_Report_Piso_Area_Task_Expandir(<?php echo  $Task_ID; ?>,<?php echo  $Actividad_ID; ?>);" width="14" /></span>

								<span id="icon_tree_close_area_task_<?php echo $Task_ID;?>" style="display:none" > <img src="images/contraer.gif" onclick="Dayli_Report_Piso_Area_Task_Contraer(<?php echo  $Task_ID; ?>);" /></span>

							</td>

							<td>	

                            <a style =" cursor: pointer;"><img src="images/materiales.jpg" onclick='Dayli_Report_Piso_Area_Tareas_Task_Material(<?php echo $Task_ID; ?>,<?php echo $Actividad_ID; ?>);' alt="New Report Dayli Task" width="20" height="22"/></a>						

								<!--<a href="#"><img src="images/materiales.jpg" onclick='Dayli_Report_Piso_Area_Tareas_Task_Material(<?php echo $Task_ID; ?>,<?php echo $Actividad_ID; ?>,<?php echo $NumAct; ?>);' alt="New Report Dayli Task" width="20" height="22"/></a>-->									

							</td>

							<td>

                            

								<a style =" cursor: pointer;"><img src="images/icon_nuevo_sintxt_0_gif.gif" onclick='Dayli_Report_Piso_Area_Tareas_Task_Nuevo(<?php echo $Task_ID; ?>,<?php echo $Actividad_ID; ?>,<?php echo $NumAct; ?>);' alt="New Report Dayli Task" width="20" height="22"/></a>

							</td>

						</tr>

					</table>

				</td>

                <td align="center" style="font-size:x-small"><?php echo  $NumAct; ?></td>

				<td  style="font-size:x-small"><?php echo  $Nombre; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Horas_Estimadas; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Material_Estimado; ?></td>						

				<td align="right" style="font-size:x-small"><?php echo  $Aux1; ?></td>		

				<td align="right" style="font-size:x-small"><?php echo  $Aux4; ?></td>

				<!--<td align="right" style="font-size:x-small"><?php echo  $Aux2; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Aux3; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Aux5; ?></td>							

				<td align="right" style="font-size:x-small"><?php echo  $Aux6; ?></td>		

				<td align="right" style="font-size:x-small"><?php echo  $Porcentaje; ?></td>   -->	

		  </tr>	

		   <tr>

				<td width="100"><img src="images/spacer.gif" width="50" height="1" /></td>

				<td colspan="11">

					<div id="Div_tareas_task_<?php echo $Task_ID; ?>" style="display:none">

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