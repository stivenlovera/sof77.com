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

?> 

<fieldset id="Fs_Lista_Cliente" class="" >

	<legend>List Level 3: Areas or  Tasks<a href="#"><img src="images/icon_nuevo_sintxt_0_gif.gif" onclick='Proyectos_Piso_Area_Tarea_Nuevo(<?php echo $Area_ID; ?>);' alt="New Task"/></a></legend>	

		<table>

			<thead>	

			  <tr>

					<th width="100">&nbsp;</th>	

                    <th width="50" >Num.Act/ CostCode</th>						 

					<th width="250" >Name</th>

					<th width="100">Estimated Hours</th>

					<th width="100">Estimated Material</th>
					
					<th width="100"><strong><em>Hours Used</em></strong></th>

					<th width="100"># Units</th>

					<th width="150">Notes</th>

					<!--<th width="100">Aux2</th>

					<th width="100">Aux3</th>

					<th width="100">Aux5</th>

					<th width="100">Aux6</th>				

					<th width="100">%</th>  -->

			  </tr>	

			 </thead>	

			 <tbody>

	<?php   		
	///   put cero to all sums 
			$sql="UPDATE task t SET t.Total_HCode = 0 WHERE t.Area_ID=".$Area_ID;
				$result89=$bd->ejecutar($sql);
				mysqli_free_result($result89);
		
	
			$sql="UPDATE task t INNER JOIN (SELECT Task_ID, SUM(Horas_Contract) 'suma' FROM registro_diario_actividad GROUP BY Task_ID) ra ON t.Task_ID=ra.Task_ID SET t.Total_HCode = ra.suma WHERE t.Area_ID=".$Area_ID;
				$result89=$bd->ejecutar($sql);
		mysqli_free_result($result89);
		$consulta = "SELECT * FROM task WHERE Area_ID=".$Area_ID." ORDER BY NumAct ASC";		

		//echo $consulta."<br>";

		$contador=1;	 	  	 	  	  

	

		$result2=$bd->ejecutar($consulta); 	

		while (($row2 = mysqli_fetch_array($result2) ))							

		{		

			$Task_ID = $row2["Task_ID"];

			$Num_Act = $row2["NumAct"];

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
			$Precio_Unitario = $row2["Precio_Unitario"];
			$Total_HCode= $row2["Total_HCode"];

			

		?>		

			<tr >											

				<td>									

					<a href="#">

						<img src="images/button_edit.gif" border="0" width="16" onclick="Proyectos_Piso_Area_Tarea_Editar(<?php echo $Task_ID; ?>);" alt="Edit"/>	

					</a>									

					<a href="#">

						<img src="images/icon_eliminar_0_gif.gif" border="0" width="16" onclick="Proyectos_Piso_Area_Tarea_Eliminar(<?php echo $Task_ID; ?>,<?php echo $Area_ID; ?>);" alt="Delete"/>		

					</a>

				</td>

                <td align="center" style="font-size:x-small"><?php echo  $Num_Act; ?></td>

				<td  style="font-size:x-small"><?php echo  $Nombre; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Horas_Estimadas; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Material_Estimado; ?></td>	
				
				<td align="right" style="font-size:x-small"><?php echo  $Total_HCode; ?></td>									

				<td align="right" style="font-size:x-small"><?php echo  $Aux1; ?></td>		

				<td align="right" style="font-size:x-small"><?php echo  $Aux4; ?></td>

                

			<!--	<td align="right" style="font-size:x-small"><?php echo  $Aux2; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Aux3; ?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Aux5; ?></td>							

				<td align="right" style="font-size:x-small"><?php echo  $Aux6; ?></td>		

				<td align="right" style="font-size:x-small"><?php echo  $Porcentaje; ?></td> -->	

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