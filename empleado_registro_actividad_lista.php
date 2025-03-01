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
	
	$Reg_ID=$_GET["Reg_ID"];

?>

<table class="Tabla_Lista_Actividades"  >
	<thead>	
	  <tr>
			<th width="110">&nbsp;</th>	
		<th width="150">Project--</th>
		<th width="80">Edificio</th>
		<th width="50">Piso</th>
		<th width="80">Area</th>					
		<th width="150">Tarea</th>
		<th width="80">Horas Contract</th>		
		<th width="80">Horas TM</th>
	  </tr>	
	 </thead>	
	 <tbody>
<?php   				       	



	$consulta = "SELECT p.Nombre AS Proyecto, e.Nombre AS Edificio, f.Nombre AS Piso, ac.Nombre AS Area, t.Nombre AS Task, rd.* 
		FROM registro_diario_actividad rd INNER JOIN  task t ON  rd.Task_ID=t.Task_ID 
		INNER JOIN area_control ac ON t.Area_ID=ac.Area_ID      
		INNER JOIN floor f ON ac.Floor_ID=f.Floor_ID
		INNER JOIN edificios e ON f.Edificio_ID=e.Edificio_ID
		INNER JOIN proyectos p ON e.Pro_ID=p.Pro_ID
		WHERE rd.Reg_ID=".$Reg_ID;	
	
	$result2=$bd->ejecutar($consulta); 	
	//echo $consulta."<br>";
	while (($row2 = mysqli_fetch_array($result2) ))							
	{	
		$contador++;
		
		$RDA_ID = $row2["RDA_ID"];
		$Pro_ID = $row2["Pro_ID"];
		$Proyecto = $row2["Proyecto"];
		$Edificio = $row2["Edificio"];
		$Piso = $row2["Piso"];
		$Area = $row2["Area"];
		$Task = $row2["Task"];
		$Horas_Contract = $row2["Horas_Contract"];
		$Horas_TM = $row2["Horas_TM"];
	?>	
		<td >			
			<a style =" cursor: pointer;" onclick="empleado_registro_actividad_Eliminar(<?php echo $RDA_ID; ?>);">
				<img src="images/icon_eliminar_0_gif.gif" />				</a>	
		</td>	
		<td align="right"  style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Proyecto; ?></td>	
		<td align="right"  style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Edificio; ?></td>			
		<td align="center" style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Piso; ?></td>
		<td align="Center" style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Area; ?></td>		
		<td align="right"  style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Task; ?></td>		
		<td align="right"  style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Horas_Contract; ?></td>		
		<td align="center" style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Horas_TM; ?></td>		
	  </tr>	
	<?php    													 								

	}
	mysqli_free_result($result2);		
			?>
		</tbody>
	</table>


	<img src="images/spacer.gif" onload="$('.Tabla_Lista_Actividades').flexigrid({nowrap: false, title : 'Activity List',showTableToggleBtn : true,width : 1100,height :350, singleSelect: true	});" />		


<?php
	require('Library/Close_Conexion.php');	
?>