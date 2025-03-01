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

	

	$Task_ID=$_GET['Task_ID'];

	$Actividad_ID=$_GET['Actividad_ID'];

	



?> 

<fieldset id="Fs_Lista_Cliente" class="" >

	<legend>List Daily Report- Records</legend>	

		<table>

			<thead>	

			  <tr>

					<th width="100">&nbsp;</th>							 

					<th width="150" >Hours Worked</th>

					<th width="100">Units Done</th>

                    <th width="100">Fecha y-m-d</th>

					<th width="300">Notes </th>

					<!--<th width="100">%</th>

					<th width="100">Note %</th>

					<th width="100">Note Number</th>

					<th width="100">Aux1</th>

					<th width="100">Note Aux1</th>

					<th width="100">Aux2</th>

					<th width="100">Note Aux2</th>				

					<th width="100">Aux3</th>

					<th width="100">Note Aux3</th>-->								

			  </tr>	

			 </thead>	

			 <tbody>

	<?php   	

       	

		$consulta = "SELECT d.*,a.Fecha,a.Actividad_ID FROM dayli_report_task d INNER JOIN actividades a on a.Actividad_ID=d.Actividad_ID WHERE d.Task_ID=".$Task_ID;

		//.$Actividad_ID;		

		//echo $consulta."<br>";

		$contador=1;	 	  	 	  	  

	

		$result2=$bd->ejecutar($consulta); 	

		while (($row2 = mysqli_fetch_array($result2) ))							

		{		

			$Dayli_ID = $row2["Dayli_ID"];

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

			$Fecha_Ac=$row2["Fecha"];

			

		?>		

			<tr >											

				<td>									

					 <a style =" cursor: pointer;">

						<img src="images/button_edit.gif" border="0" width="16" onclick="Dayli_Report_Piso_Area_Tareas_Task_Editar(<?php echo $Dayli_ID; ?>,<?php echo $Task_ID; ?>,<?php echo $Actividad_ID; ?>);" alt="Edit"/>					</a>

                        <a style =" cursor: pointer;">

                        <img src="images/icon_eliminar_0_gif.gif" border="0" width="16" onclick="Dayli_Report_Piso_Area_Tareas_Task_Eliminar(<?php echo $Dayli_ID; ?>,<?php echo $Task_ID; ?>,<?php echo $Actividad_ID; ?>);" alt="Delete"/></a></td>

			  <td align="right" style="font-size:x-small"><?php echo  $Horas; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Numero; ?></td>

                <td align="right" style="font-size:x-small"><?php echo  $Fecha_Ac; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Nota_Horas; ?></td>						

				<!--<td align="right" style="font-size:x-small"><?php echo  $Porcentaje; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Nota_Porcentaje; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Nota_Numero; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Aux1; ?></td>							

				<td align="right" style="font-size:x-small"><?php echo  $Aux1_Nota; ?></td>		

				<td align="right" style="font-size:x-small"><?php echo  $Aux2; ?></td>							

				<td align="right" style="font-size:x-small"><?php echo  $Aux2_Nota; ?></td>		

				<td align="right" style="font-size:x-small"><?php echo  $Aux3; ?></td>							

				<td align="right" style="font-size:x-small"><?php echo  $Aux3_Nota; ?></td>		-->

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