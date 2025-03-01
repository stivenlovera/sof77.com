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

	

	$consulta = "select * FROM actividades WHERE Actividad_ID=".$Actividad_ID;

	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Fecha = $row2["Fecha"];

	}

	mysqli_free_result($result2);		

?>

<fieldset>

<legend>Daily Repport Small Jobs:</legend>

<legend><em><a href="#" onclick="Actividad_Material_Information_Maximizar(<?php echo $Actividad_ID;?>, <?php echo $Pro_ID;?>);"><strong>Report Material Used Small Jobs:</strong></a></em></legend> 

<table class="tabla_Datos_Task">

		<thead>	

		  <tr>

		  		<th width="60" style="font-size:x-small">Date</th>												   								   							

				<th width="90" style="font-size:x-small;">Control Area</th>

                <th width="30" style="font-size:x-small">Hours</th>

				<th width="80" style="font-size:x-small">Workers</th>

								

				<th width="300" style="font-size:x-small">Description of work done</th>

				<th width="100" style="font-size:x-small">Is there material <bR />

				for next time/how much</th>

				<th width="100" style="font-size:x-small">Visitors</th>

				<th width="100" style="font-size:x-small">Painters to return/when/why</th>

				<th width="80" style="font-size:x-small">Aux1</th>			

				

                <th width="80" style="font-size:x-small">Aux2</th>

				<th width="80" style="font-size:x-small">Aux3</th>

                <th width="80" style="font-size:x-small">Note</th>

		  </tr>	

		 </thead>	

		 <tbody>

<?php   				       	

	//$consulta = "SELECT m.* FROM materiales m WHERE m.Pro_ID=".$Pro_ID." OR p.Nombre='General Sundries' ";

	$consulta = "SELECT * FROM area_control WHERE Pro_ID=".$Pro_ID." ORDER BY Nombre ";			

	//echo $consulta;

	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Area_ID = $row2["Area_ID"];

		$Nombre = $row2["Nombre"];

		$Note = $row2["Note"];

		$Aux1 = $row2["Aux1"];

		$Aux2 = $row2["Aux2"];

		$Aux3 = $row2["Aux3"];				

		

		$consulta = "SELECT * FROM dayli_task ";

		$consulta = $consulta."  WHERE Fecha='".$Fecha."' AND Area_ID=".$Area_ID." AND Pro_ID=".$Pro_ID;	

		//echo $consulta."<bR>";

		$result=$bd->ejecutar($consulta); 	

		if (($row = mysqli_fetch_array($result) ))							

		{	

			$Task_ID = $row["Task_ID"];

			$Descp1 = $row["Descp1"];

			$Descp2 = $row["Descp2"];

			$Descp3 = $row["Descp3"];

			$Descp4 = $row["Descp4"];

			$Hours = $row["Hours"];

			$Workers = $row["Workers"];

			$Aux1 = $row["Aux1"];

		}

		else

		{

			$Task_ID = -1;

			$Descp1 = ".";

			$Descp2 = ".";

			$Descp3 = ".";

			$Descp4 = ".";

			$Hours=0;

			$Workers=".";

			$Aux1=".";

		}		

		

		mysqli_free_result($result);	

		

		?>		

			<tr >											

				<td align="right" style="font-size:x-small"><?php echo  $Fecha; ?></td>				

				<td align="left" style="font-size:x-small"><?php echo  $Nombre; ?></td>

                 <td align="right" style="font-size:x-small">

                 <div id="Hours-<?php echo  $Pro_ID;?>-<?php echo  $Area_ID;?>-<?php echo  $Actividad_ID;?>"><?php echo $Hours;?></div>

                  <img src="images/spacer.gif" onload="Atividades_Reporte_Diario_Task('Hours-<?php echo  $Pro_ID;?>-<?php echo  $Area_ID;?>-<?php echo  $Actividad_ID;?>');" />

                <td align="right" style="font-size:x-small">

                 <div id="Workers-<?php echo  $Pro_ID;?>-<?php echo  $Area_ID;?>-<?php echo  $Actividad_ID;?>"><?php echo $Workers;?></div>

                  <img src="images/spacer.gif" onload="Atividades_Reporte_Diario_Task('Workers-<?php echo  $Pro_ID;?>-<?php echo  $Area_ID;?>-<?php echo  $Actividad_ID;?>');" />

                 

                

                

                

                

								

				<td align="right" style="font-size:x-small">

					<div id="Descp1-<?php echo  $Pro_ID;?>-<?php echo  $Area_ID;?>-<?php echo  $Actividad_ID;?>"><?php echo $Descp1;?></div>

					<img src="images/spacer.gif" onload="Atividades_Reporte_Diario_Task('Descp1-<?php echo  $Pro_ID;?>-<?php echo  $Area_ID;?>-<?php echo  $Actividad_ID;?>');" />

				</td>

				<td align="right" style="font-size:x-small">

					<div id="Descp2-<?php echo  $Pro_ID;?>-<?php echo  $Area_ID;?>-<?php echo  $Actividad_ID;?>"><?php echo $Descp2;?></div>

					<img src="images/spacer.gif" onload="Atividades_Reporte_Diario_Task('Descp2-<?php echo  $Pro_ID;?>-<?php echo  $Area_ID;?>-<?php echo  $Actividad_ID;?>');" />

				</td>

				<td align="right" style="font-size:x-small">

					<div id="Descp3-<?php echo  $Pro_ID;?>-<?php echo  $Area_ID;?>-<?php echo  $Actividad_ID;?>"><?php echo $Descp3;?></div>

					<img src="images/spacer.gif" onload="Atividades_Reporte_Diario_Task('Descp3-<?php echo  $Pro_ID;?>-<?php echo  $Area_ID;?>-<?php echo  $Actividad_ID;?>');" />

				</td>

				<td align="right" style="font-size:x-small">

					<div id="Descp4-<?php echo  $Pro_ID;?>-<?php echo  $Area_ID;?>-<?php echo  $Actividad_ID;?>"><?php echo $Descp4;?></div>

					<img src="images/spacer.gif" onload="Atividades_Reporte_Diario_Task('Descp4-<?php echo  $Pro_ID;?>-<?php echo  $Area_ID;?>-<?php echo  $Actividad_ID;?>');" />

				</td>

				<td align="right" style="font-size:x-small">

                 <div id="Aux1-<?php echo  $Pro_ID;?>-<?php echo  $Area_ID;?>-<?php echo  $Actividad_ID;?>"><?php echo $Aux1;?></div>

                   <img src="images/spacer.gif" onload="Atividades_Reporte_Diario_Task('Aux1-<?php echo  $Pro_ID;?>-<?php echo  $Area_ID;?>-<?php echo  $Actividad_ID;?>');" />

				<td align="right" style="font-size:x-small"><?php echo  $Aux2;?></td>

				<td align="right" style="font-size:x-small"><?php echo  $Aux3;?></td>

                <td align="right" style="font-size:x-small"><?php echo  $Note; ?></td>

		  </tr>

<?php

		$contador++;

	}

	mysqli_free_result($result2);	

	

	//$consulta = "SELECT ac.*, d.Task_ID, d.Descp1, d.Descp2, d.Descp3, d.Descp4,d.hours,d.workers,d.Aux1, d.Fecha FROM dayli_task d INNER JOIN area_control ac ON ac.Area_ID=d.Area_ID WHERE d.Pro_ID=".$Pro_ID." AND d.Fecha<'".$Fecha."' ORDER BY  Fecha DESC, Nombre ASC LIMIT 1";

	$consulta = "SELECT ac.*, d.Task_ID, d.Descp1, d.Descp2, d.Descp3, d.Descp4,d.hours,d.workers,d.Aux1, d.Fecha FROM dayli_task d INNER JOIN area_control ac ON ac.Area_ID=d.Area_ID WHERE d.Pro_ID=".$Pro_ID." AND d.Fecha<'".$Fecha."' ORDER BY  Fecha DESC, Nombre ASC";			

	//echo $consulta;

	$result2=$bd->ejecutar($consulta); 	

	$Areaid=" ";

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Area_ID = $row2["Area_ID"];

		$Nombre = $row2["Nombre"];

		$Note = $row2["Note"];

		$Aux2 = $row2["Aux2"];

		$Aux3 = $row2["Aux3"];				

		$Task_ID = $row2["Task_ID"];

		$Descp1 = $row2["Descp1"];

		$Descp2 = $row2["Descp2"];

		$Descp3 = $row2["Descp3"];

		$Descp4 = $row2["Descp4"];

		$Fecha = $row2["Fecha"];

		$Aux1=$row2["Aux1"];

		$Hours=$row2["Hours"];

		$Workers=$row2["Workers"];

		

	if ($Areaid<>$Area_ID)

	{

	?>		

			<tr >											

				<td align="right" style="font-size:x-small; background-color:#FFFF99"><?php echo  $Fecha; ?></td>				

				<td align="left" style="font-size:x-small; background-color:#FFFF99"><?php echo  $Nombre; ?></td>

                <td align="right" style="font-size:x-small; background-color:#FFFF99"><?php echo  $Hours; ?></td>

                <td align="right" style="font-size:x-small; background-color:#FFFF99"><?php echo  $Workers; ?></td>

								

				<td align="right" style="font-size:x-small; background-color:#FFFF99">

					<?php echo $Descp1;?>

				</td>

				<td align="right" style="font-size:x-small; background-color:#FFFF99">

					<?php echo $Descp2;?>

				</td>

				<td align="right" style="font-size:x-small; background-color:#FFFF99">

					<?php echo $Descp3;?>

				</td>

				<td align="right" style="font-size:x-small; background-color:#FFFF99">

					<?php echo $Descp4;?>

				</td>

               

				<td align="right" style="font-size:x-small; background-color:#FFFF99"><?php echo  $Aux1; ?></td>

				<td align="right" style="font-size:x-small; background-color:#FFFF99"><?php echo  $Aux2;?></td>

				<td align="right" style="font-size:x-small; background-color:#FFFF99"><?php echo  $Aux3;?></td>

                <td align="right" style="font-size:x-small; background-color:#FFFF99"><?php echo  $Note; ?></td>

		  </tr>

<?php

}

$Areaid=$Area_ID;

	}

	mysqli_free_result($result2);

?>	

		</tbody>

	</table> 

	<img src="images/spacer.gif" onload="$('.tabla_Datos_Task').flexigrid({nowrap: false, showTableToggleBtn : true,width : 600,height :150, singleSelect: true	});" />  	

</fieldset>
<img src="images/spacer.gif" onload="Actividad_Personal_Information(<?php echo $Actividad_ID;?>,<?php echo $Pro_ID;?>);" />

<?php

	require('Library/Close_Conexion.php');	

?>