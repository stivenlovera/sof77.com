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



	$Actividad_ID=$_GET['Actividad_ID'];	



	



?> 



<table align="left" class="Tabla_Lista_Empleados"  >



	<thead>	



	  <tr>



	  		<th width="90">&nbsp;</th>				 



       		<th width="20" >Count</th>



			<th width="100">Nick Name</th>	

			<th width="120">ScheduledFor </th>

            <th width="130">Email/Cel/Emp#</th>

			<th width="100">Notes</th>	
            <th width="100">Emp.#/Position</th>	

	  </tr>	

	 </thead>	



	 <tbody>



<?php  



	







 				       	



	$consulta = "SELECT p.* FROM personal p WHERE  (p.Aux5 <>'z.Adm' and p.Aux5<>'' and p.Aux5 IS NOT NULL)   ORDER BY p.Aux5,p.Nick_Name ";	

			



	$contador=1;	 	  	 	  	  

	$datos_proyecto="-";





	$result2=$bd->ejecutar($consulta); 	



	while (($row2 = mysqli_fetch_array($result2) ))							



	{		



		$Empleado_ID = $row2["Empleado_ID"];

		$Nick_Name = $row2["Nick_Name"];

		$Nombre = $row2["Nombre"];

		$Apellido_Paterno = $row2["Apellido_Paterno"];

		$Aux1 = $row2["Aux1"];

		$Aux2 = $row2["Aux2"];

		$Cargo = $row2["Cargo"];
		$emacel= $row2["email"]."/ ".$row2["Celular"];
		$numpos=" E#".$row2["Numero"]." P:".$row2["Cargo"];
		

		

		/*$consulta = "SELECT p.Codigo, p.Nombre FROM personal p1 

			INNER JOIN actividad_personal ap ON ap.Empleado_ID=p1.Empleado_ID 

			INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID 

			INNER JOIN proyectos p ON p.Pro_ID=a.Pro_ID 

			WHERE a.Fecha='".$Fecha."' AND p1.Empleado_ID=".$Empleado_ID;	

		$datos_proyecto="";	 	  	 	  	  

	

		$result22=$bd->ejecutar($consulta); 	

		while (($row22 = mysqli_fetch_array($result22) ))							

		{

			$datos_proyecto=$datos_proyecto."    -*".$row22["Codigo"]." ".substr(($row22["Nombre"]),0,12);

		}

		mysqli_free_result($result22);	

		

		if ($datos_proyecto!="")			

			$estilo="style=' font-size:x-small; background-color:#FFFF99'";	 

		else

			$estilo="style=' font-size:x-small'";*/

	?>		



		<tr align="left"  style="font-size:x-small">



			<td align="left"  style="font-size:x-small">



				<a href="#" onclick="Actividades_Asignar_Personal_Registrar(<?php echo $Empleado_ID; ?>, <?php echo $Actividad_ID; ?>, '<?php echo $Fecha; ?>');">					</a><a href="#" onclick="Actividades_Asignar_Personal_Registrar(<?php echo $Empleado_ID; ?>, <?php echo $Actividad_ID; ?>, '<?php echo $Fecha; ?>');">  </a><a href="#" onclick="Actividades_Asignar_Personal_Registrar(<?php echo $Empleado_ID; ?>, <?php echo $Actividad_ID; ?>, '<?php echo $Fecha; ?>');">.  . . . . .. . .<img src="images/icon_asignar_0_gif.gif" /></a></td>		



			<td align="left"  style="font-size:x-small"><?php echo  $contador?></td>						



			<td align="left"  style="font-size:x-small"><?php echo $Nick_Name; ?></td>

			<td align="left"  style="font-size:x-small"><?php echo $datos_proyecto; ?></td>

              <td align="left" style="font-size:x-small"><?php echo $emacel; ?></td>

		  <td align="left"  style="font-size:x-small"><?php echo $Aux2; ?></td>			
<td align="left"  style="font-size:x-small"><?php echo $numpos; ?></td>		


	  </tr>

<img src="images/spacer.gif" onload="$('.Tabla_Lista_Empleados').flexigrid({nowrap: false, title : '.........................  ...............       to update hours go to: Report by Job/ Select Dates/ Totals/ Print Prev/',showTableToggleBtn : true,width : 800,height :150, singleSelect: true	});" />

		<?php    		



			$contador++;								 								



	}



	mysqli_free_result($result2);		



			?>

		</tbody>

	</table>
<?php



	require('Library/Close_Conexion.php');	



?>