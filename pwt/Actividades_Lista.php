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

	

	$Fecha=$_GET['Fecha'];	

	$Pro_ID=$_GET['Pro_ID'];	

	

?> 

<table class="Tabla_Lista_Actividades"  >

	<thead>	

	  <tr>

       		<th width="20" >Nro.</th>

			<th width="200">Date</th>

			<th width="70">Hour</th>			

			<th width="70">Status</th>					

			<th width="70">Type</th>		

			<th width="250">Description</th>				

			<th width="80">Aux1</th>								   								   			

			<th width="80">Aux2</th>

			<th width="80">Aux3</th>

			<th width="160">&nbsp;</th>					

	  </tr>	

	 </thead>	

	 <tbody>

<?php   				       	

	$consulta = "SELECT a.*, Actividad_Nombre FROM actividades a INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID WHERE Fecha='".$Fecha."' AND Pro_ID=".$Pro_ID." ORDER BY Hora";		

	//echo $consulta."<br>";

	$contador=0;	 	  	 	  	  



	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Actividad_ID = $row2["Actividad_ID"];

		$Tipo_Actividad_ID = $row2["Tipo_Actividad_ID"];

		$Actividad_Nombre = $row2["Actividad_Nombre"];

		$Descripcion  = $row2["Descripcion"];	

		$Hora = $row2["Hora"];

		$Aux1 = $row2["Aux1"];	

		$Aux2 = $row2["Aux2"];

		$Aux3 = $row2["Aux3"];				

	?>		

		<tr >											

			<td ><?php echo  $contador?></td>						

			<td align="right"  style="font-size:x-small"><?php echo $Hora; ?></td>			

			<td align="center" style="font-size:x-small"><?php echo $Actividad_Nombre; ?></td>		

			<td align="right"  style="font-size:x-small"><?php echo $Descripcion; ?></td>		

			<td align="right"  style="font-size:x-small"><?php echo $Aux1; ?></td>		

			<td align="center" style="font-size:x-small"><?php echo $Aux2; ?></td>		

			<td align="Center" style="font-size:x-small"><?php echo $Aux3; ?></td>	

			<td>

				<a href="#" onclick="Actividades_Editar(<?php echo $Actividad_ID; ?>,'<?php echo $Hora; ?>', <?php echo $Tipo_Actividad_ID; ?>, '<?php echo $Descripcion; ?>', '<?php echo $Aux1; ?>', '<?php echo $Aux2; ?>', '<?php echo $Aux3; ?>');">

					<img src="images/icon_editar_0_gif.gif"/>

				</a>

				<a href="#" onclick="Actividades_Eliminar(<?php echo $Actividad_ID; ?>,<?php echo $Pro_ID; ?>,'<?php echo $Fecha; ?>');">

					<img src="images/icon_eliminar_0_gif.gif" />

				</a>

			</td>	

	  </tr>

		<?php    		

			$contador++;								 								

	}

	mysqli_free_result($result2);		

			?>

		</tbody>

	</table>   	 

<img src="images/spacer.gif" onload="$('.Tabla_Lista_Actividades').flexigrid({nowrap: false, title : 'Activity List',showTableToggleBtn : true,width : 850,height :250, singleSelect: true	});" />	 

<?php

	require('Library/Close_Conexion.php');	

?>