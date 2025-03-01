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



	



	$Proyecto=ConvertDateToMysqlFormat($_GET['Proyecto']);



	$Pro_ID=ConvertDateToMysqlFormat($_GET['Pro_ID']);



	$From_Date=ConvertDateToMysqlFormat($_GET['From_Date']);



	$To_Date=ConvertDateToMysqlFormat($_GET['To_Date']);	



?> 



<table class="Tabla_Lista_Actividades"  >



	<thead>	



	  <tr>



       		<th width="30">Nro</th>



			<th width="80">&nbsp;</th>				 



			<th width="350">Projects</th>			



			<th width="150">Date</th>		



			<th width="70">Hour</th>		



			<th width="70">Type</th>		



			<th width="250">Desciption</th>				



			<th width="250">Personal</th>				



			<th width="80">Aux1</th>								   								   			



			<th width="80">Aux2</th>



			<th width="80">Aux3</th>



	  </tr>	



	 </thead>	



	 <tbody>



<?php   				       	



	$consulta = "SELECT p.Pro_ID, p.Nombre, p.Fecha_Inicio, p.Fecha_Fin, p.Horas, a.*, ta.Actividad_Nombre FROM actividades a 



		INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID 



		INNER JOIN proyectos p ON p.Pro_ID=a.Pro_ID



		WHERE ((a.Fecha>='".$From_Date."' AND a.Fecha<='".$To_Date."') OR a.Fecha='01-01-2013') ";	



		//echo $consulta;		



		if ($_GET['Proyecto'] != ""  )



			$consulta = $consulta." AND p.Nombre like '%".$_GET['Proyecto']."%'  ";	



		



		if ($_GET['Pro_ID'] != ""  )



			$consulta = $consulta." AND p.Pro_ID=".$_GET['Pro_ID'];			







		//$consulta = $consulta." ORDER BY a.Fecha, p.Pro_ID, Hora";



		$consulta = $consulta." ORDER BY p.Pro_ID,a.Tipo_Actividad_ID,a.Fecha, Hora";



	//echo $consulta."<br>";



	$contador=0;



	$Pro_ID_Ant=-33;	 	  	 	  	  







	$result2=$bd->ejecutar($consulta); 	



	while (($row2 = mysqli_fetch_array($result2) ))							



	{	



		$Pro_ID = $row2["Pro_ID"];



		$Nombre = $row2["Nombre"];



		$Fecha_Inicio = $row2["Fecha_Inicio"];



		$Fecha_Fin = $row2["Fecha_Fin"];



		$Fecha = $row2["Fecha"];



		$Horas = $row2["Horas"];



		$Actividad_ID = $row2["Actividad_ID"];



		$Tipo_Actividad_ID = $row2["Tipo_Actividad_ID"];



		$Actividad_Nombre = $row2["Actividad_Nombre"];



		$Descripcion  = $row2["Descripcion"];	



		$Hora = $row2["Hora"];



		$Aux1 = $row2["Aux1"];	



		$Aux2 = $row2["Aux2"];



		$Aux3 = $row2["Aux3"];



		$Fecha = $row2["Fecha"];			



		



		$consulta = "SELECT p.* FROM personal p 



		INNER JOIN actividad_personal ap ON ap.Empleado_ID=p.Empleado_ID 



		WHERE ap.Actividad_ID=".$Actividad_ID;		



		//echo $consulta."<br>";		



		$result33=$bd->ejecutar($consulta); 	



		$empleados="";



		while (($row33 = mysqli_fetch_array($result33) ))							



		{		



			if ($empleados=="")		



				$empleados=$row33["Nombre"]." ".$row33["Apellido_Paterno"];



			else



				$empleados=$empleados.", ".$row33["Nombre"]." ".$row33["Apellido_Paterno"];



		}



		mysqli_free_result($result33);



		



		$consulta = "SELECT p.*, ";



		$consulta = $consulta . " CONCAT(em1.Nombre, ' ', em1.Apellido_Paterno, ' ',  em1.Apellido_Materno) as Foreman, em1.Telefono as TelefonoF,  em1.Celular as  CelularF, ";



	$consulta = $consulta . " CONCAT(em5.Nombre, ' ',  em5.Apellido_Paterno, ' ',  em5.Apellido_Materno) as Coordinador_Obra, em5.Telefono as TelefonoC,  em5.Celular as  CelularC  FROM proyectos p ";



		$consulta = $consulta . " LEFT JOIN personal em1 ON em1.Empleado_ID=p.Foreman_ID ";		



		$consulta = $consulta . " LEFT JOIN personal em5 ON em5.Empleado_ID=p.Coordinador_Obra_ID ";				



		$consulta = $consulta . " WHERE p.Pro_ID=".$Pro_ID;		



		//echo $consulta."<br>";		



	



		$result33=$bd->ejecutar($consulta); 	



		while (($row33 = mysqli_fetch_array($result33) ))							



		{		



			$Pro_ID = $row33["Pro_ID"];



			$Codigo = $row33["Codigo"];



			$Foreman=$row33["Foreman"];



			$TelefonoF=$row33["TelefonoF"];



			$CelularF = $row33["CelularF"];	



			$Coordinador_Obra = $row33["Coordinador_Obra"];	



			$TelefonoC = $row33["TelefonoC"];			



			$CelularC = $row33["CelularC"];



			$Numero = $row33["Numero"];



			$Calle = $row33["Calle"];



			$Ciudad = $row33["Ciudad"];



			$Estado = $row33["Estado"];



			$Zip_Code = $row33["Zip_Code"];



			



			$Address= $Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code;



			



		}



		mysqli_free_result($result33);



	?>		



		<tr >											



			<?php



			$contador++;



			?>



			<td ><?php echo  $contador?></td>						



			<!--<td>



				<a href="#" onclick="Actividades_Asignar_Personal(<?php echo $Actividad_ID; ?>, '<?php echo $Fecha; ?>');">



					<img src="images/icon_asignar_0_gif.gif"/>



				</a>				



				<a href="#">



					<img src="images/icon_editar_0_gif.gif" border="0" onclick="Proyectos_Actividades_Editar(<?php echo $Actividad_ID; ?>,<?php echo $Pro_ID; ?>);" alt="Edit"/>	



				</a>								



				<a href="#">



					<img src="images/icon_eliminar_0_gif.gif" border="0" onclick="Proyectos_Actividades_Eliminar(<?php echo $Actividad_ID; ?>,<?php echo $Pro_ID; ?>);" alt="Delete"/>		



				</a>



			</td>-->

<td>



				<a style =" cursor: pointer;" onclick="Actividades_Asignar_Personal(<?php echo $Actividad_ID; ?>, '<?php echo $Fecha; ?>');">



					<img src="images/icon_asignar_0_gif.gif"/>



				</a>				



				<a style =" cursor: pointer;">



					<img src="images/icon_editar_0_gif.gif" border="0" onclick="Proyectos_Actividades_Editar(<?php echo $Actividad_ID; ?>,<?php echo $Pro_ID; ?>);" alt="Edit"/>	



				</a>								



				<a style =" cursor: pointer;">



					<img src="images/icon_eliminar_0_gif.gif" border="0" onclick="Proyectos_Actividades_Eliminar(<?php echo $Actividad_ID; ?>,<?php echo $Pro_ID; ?>);" alt="Delete"/>		



				</a>



			</td>













			<td align="right"  style="font-size:x-small">







    



        <?php echo "$Codigo/$Nombre/$Address<br><b>Contact:</b>$Coordinador_Obra <b>Movil:</b>$CelularC<br><b>Foreman:</b>$Foreman  <b>Movil:</b>$CelularF<br>"; ?></td>



			<td align="right"  style="font-size:x-small"><?php echo FormatDateTime($Fecha,8); ?></td>	



			<td align="right"  style="font-size:x-small"><?php echo $Hora; ?></td>			



			<td align="center" style="font-size:x-small"><?php echo $Actividad_Nombre; ?></td>		



			<td align="right"  style="font-size:x-small"><?php echo $Descripcion; ?></td>		



			<td align="Center" style="font-size:x-small"><?php echo $empleados; ?></td>	



			<td align="right"  style="font-size:x-small"><?php echo $Aux1; ?></td>		



			<td align="center" style="font-size:x-small"><?php echo $Aux2; ?></td>		



			<td align="Center" style="font-size:x-small"><?php echo $Aux3; ?></td>				



	  </tr>



		<?php    		



			$Pro_ID_Ant=$Pro_ID;											 								



	}



	mysqli_free_result($result2);		



			?>



		</tbody>



	</table>   	 



<img src="images/spacer.gif" onload="$('.Tabla_Lista_Actividades').flexigrid({nowrap: false, title : 'Activity List',showTableToggleBtn : true,width : 1100,height :300, singleSelect: true	});" />	 



<?php



	require('Library/Close_Conexion.php');	



?>