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



	



	$Actividad_ID=$_GET['Actividad_ID'];	



	



?> 



<table align="left" class="Tabla_Lista_Empleados"  >



	<thead>	



	  	<tr>



			<th width="50">&nbsp;</th>



       		<th width="20" >Count.</th>



			<th width="80">NickName</th>		



			<th width="180">Jobs enabled</th>		



			<th width="150">Notes</th>		



			<th width="70">Name</th>				



			<th width="50">Position</th>								   								   										 



	  	</tr>	



	</thead>	



<tbody>



<?php   				       	



	$consulta = "SELECT p.* , a.Fecha FROM personal p 		



		INNER JOIN actividad_personal ap ON ap.Empleado_ID=p.Empleado_ID 



		INNER JOIN actividades a ON ap.Actividad_ID=a.Actividad_ID 



		WHERE a.Actividad_ID=".$Actividad_ID." ORDER BY p.Nick_Name";	



			



	//echo $consulta."<br>";



	$contador=1;	 	  	 	  	  







	$result2=$bd->ejecutar($consulta); 	



	while (($row2 = mysqli_fetch_array($result2) ))							



	{		



		$Empleado_ID = $row2["Empleado_ID"];



		$Nick_Name = $row2["Nick_Name"];		



		$Nombre = $row2["Nombre"];



		$Apellido_Paterno = $row2["Apellido_Paterno"];



		$Cargo = $row2["Cargo"];



		$Aux1 = $row2["Aux1"];

		$Aux2 = $row2["Aux2"];



		$Fecha = $row2["Fecha"];



	?>		



		<tr >



			<td>



				<a href="#" onclick="Actividades_Personal_Eliminar(<?php echo $Empleado_ID; ?>,<?php echo $Actividad_ID; ?>,'<?php echo $Fecha; ?>');">



					<img src="images/icon_eliminar_0_gif.gif" />



				</a>



			</td>



			<td ><?php echo  $contador?></td>						



			<td align="left"  style="font-size:x-small"><?php echo $Nick_Name; ?></td>		



			<td align="left"  style="font-size:x-small"><?php echo $Aux1; ?></td>			



			<td align="center" style="font-size:x-small"><?php echo $Aux2; ?></td>	



            <td align="center" style="font-size:x-small"><?php echo $Nombre; ?></td>	



			<td align="left"  style="font-size:x-small"><?php echo $Cargo; ?></td>						



	  </tr>



		<?php    		



			$contador++;								 								



	}



	mysqli_free_result($result2);		



			?>



		</tbody>



	</table>   	 



<img src="images/spacer.gif" onload="$('.Tabla_Lista_Empleados').flexigrid({nowrap: false, title : 'Personel to the Activity ',showTableToggleBtn : true,width :800,height :150, singleSelect: true	});" />	 



<?php



	require('Library/Close_Conexion.php');	



?>