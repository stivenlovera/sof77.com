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

	<legend>Hour Information</legend>

	<div id="Div_Set_to_8_horas">

		<input type="button" value="Set to 8 Hours" onclick="Atividades_Reporte_Diario_Personal_8_horas(<?php echo  $Actividad_ID;?>,<?php echo  $Pro_ID;?>);" />

	</div>

	<table class="tabla_Datos_Personal">

		<thead>	

		  <tr>

				<th width="60" style="font-size:x-small;">Date</th>	

				<th width="75" style="font-size:x-small;">Nick Name</th>

				<th width="60" style="font-size:x-small;">Hr. Contract</th>	

				<th width="50" style="font-size:x-small;">Hr. TM</th>			

				<th width="50" style="font-size:x-small;">Total</th>

				<th width="250" style="font-size:x-small;">Note</th>

				<th width="150" style="font-size:x-small;">Nombre</th>

				<th width="50" style="font-size:x-small;">Movil</th>

		  </tr>	

		 </thead>	

		 <tbody>

<?php   				       	



	$consulta = "SELECT p.*, ap.HContract, ap.HTM, ap.Note FROM personal p 

					INNER JOIN actividad_personal ap ON ap.Empleado_ID=p.Empleado_ID 

					WHERE ap.Actividad_ID=".$Actividad_ID." ORDER BY p.Nick_Name";	

	//echo $consulta;

	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))
	{	
		$Empleado_ID = $row2["Empleado_ID"];
		$Nick_Name = $row2["Nick_Name"];
		$Nombre=$row2["Nombre"];
		$Apellido_Paterno = $row2["Apellido_Paterno"];	
		$Apellido_Materno = $row2["Apellido_Materno"];
		$Celular = $row2["Celular"];
		$HContract = $row2["HContract"];

		if (is_null($HContract))
			$HContract=0;
						
		$HTM = $row2["HTM"];
		if (is_null($HTM))
			$HTM=0;
		$Note = $row2["Note"];
		$Total = $HContract	+ $HTM;		
		
		/*$sql = "SELECT SUM(Horas_Contract) as Horas_Contract, SUM(Horas_TM) as Horas_TM FROM registro_diario rd INNER JOIN registro_diario_actividad rda ON rd.Reg_ID=rda.Reg_ID AND rd.Fecha=CURDATE() ";
		$sql = $sql . " INNER JOIN task t ON rda.Task_ID=t.Task_ID ";
		$sql = $sql . " INNER JOIN area_control a ON t.Area_ID=a.Area_ID ";
		$sql = $sql . " INNER JOIN floor f ON f.Floor_ID=a.Floor_ID ";
		$sql = $sql . " INNER JOIN edificios e ON e.Edificio_ID=f.Edificio_ID ";
		$sql = $sql . " WHERE rd.Empleado_ID=".$Empleado_ID;	
		
		
		//echo $sql."<br>";													
		$result77=$bd->ejecutar($sql); 		
		while (($row77 = mysqli_fetch_array($result77) ))	
		{
			$HContract=$row77["Horas_Contract"];
			$HTM=$row77["Horas_TM"];
			$Total=$HContract+$HTM;
		}
		mysqli_free_result($result77);*/
		?>		

			<tr >											

				<td align="left" style="font-size:x-small"><?php echo  $Fecha; ?></td>

				<td align="left" style="font-size:x-small"><?php echo  $Nick_Name; ?></td>

				<td align="right" style="font-size:x-small">

					<div id="HContract-<?php echo  $Pro_ID;?>-<?php echo  $Empleado_ID;?>-<?php echo  $Actividad_ID;?>"><?php echo $HContract;?></div>

					<img src="images/spacer.gif" onload="Atividades_Reporte_Diario_Personal('HContract-<?php echo  $Pro_ID;?>-<?php echo  $Empleado_ID;?>-<?php echo  $Actividad_ID;?>');" />

				</td>

				<td align="right" style="font-size:x-small">

					<div id="HTM-<?php echo  $Pro_ID;?>-<?php echo  $Empleado_ID;?>-<?php echo  $Actividad_ID;?>"><?php echo $HTM;?></div>

					<img src="images/spacer.gif" onload="Atividades_Reporte_Diario_Personal('HTM-<?php echo  $Pro_ID;?>-<?php echo  $Empleado_ID;?>-<?php echo  $Actividad_ID;?>');" />

				</td>

				<td align="right" style="font-size:x-small"><div id="Div_Total_Horas-<?php echo  $Empleado_ID;?>-<?php echo  $Actividad_ID;?>"><?php echo  $Total;?></div></td>	

				<td align="right" style="font-size:x-small">

					<div id="Note-<?php echo  $Pro_ID;?>-<?php echo  $Empleado_ID;?>-<?php echo  $Actividad_ID;?>"><?php echo $Note;?></div>

					<img src="images/spacer.gif" onload="Atividades_Reporte_Diario_Personal('Note-<?php echo  $Pro_ID;?>-<?php echo  $Empleado_ID;?>-<?php echo  $Actividad_ID;?>');" />

				</td>

				<td align="right" style="font-size:x-small"><?php echo  $Nombre;?> <?php echo  $Apellido_Paterno;?> <?php echo  $Apellido_Materno;?></td>

				<td align="right" style="font-size:x-small"><?php  echo  $Celular; ?></td>	

		  </tr>		

<?php

		$contador++;

	}

	mysqli_free_result($result2);

	

		/*$consulta = "SELECT p.*, ap.HContract, ap.HTM, ap.Note, a.Fecha FROM personal p 

					INNER JOIN actividad_personal ap ON ap.Empleado_ID=p.Empleado_ID 

					INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID 

					WHERE a.Fecha<'".$Fecha."' AND a.Pro_ID=".$Pro_ID;

					//WHERE a.Fecha<'".$Fecha."' AND a.Pro_ID=".$Pro_ID;	

	//echo $consulta;

	$contador=1;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Empleado_ID = $row2["Empleado_ID"];

		$Nick_Name = $row2["Nick_Name"];

		$Nombre=$row2["Nombre"];

		$Apellido_Paterno = $row2["Apellido_Paterno"];		

		$Apellido_Materno = $row2["Apellido_Materno"];			

		$Celular = $row2["Celular"];

		$HContract = $row2["HContract"];

		$Fecha = $row2["Fecha"];

		

		if (is_null($HContract))

			$HContract=0;

			

		$HTM = $row2["HTM"];

		if (is_null($HTM))

			$HTM=0;

			

		$Note = $row2["Note"];		

		

		$Total = $HContract	+ $HTM;

		?>		

			<tr style="background-color:#FFFF99" >											

				<td align="left" style="font-size:x-small; background-color:#FFFF99"><?php echo  $Fecha; ?></td>

				<td align="left" style="font-size:x-small; background-color:#FFFF99"><?php echo  $Nick_Name; ?></td>

				<td align="right" style="font-size:x-small; background-color:#FFFF99">

					<?php echo $HContract;?>

				</td>

				<td align="right" style="font-size:x-small; background-color:#FFFF99">

					<?php echo $HTM;?>

				</td>

				<td align="right" style="font-size:x-small; background-color:#FFFF99"><div id="Div_Total_Horas-<?php echo  $Empleado_ID;?>-<?php echo  $Actividad_ID;?>"><?php echo  $Total;?></div></td>	

				<td align="right" style="font-size:x-small; background-color:#FFFF99">

					<?php echo $Note;?>

				</td>

				<td align="right" style="font-size:x-small; background-color:#FFFF99"><?php echo  $Nombre;?> <?php echo  $Apellido_Paterno;?> <?php echo  $Apellido_Materno;?></td>

				<td align="right" style="font-size:x-small; background-color:#FFFF99"><?php  echo  $Celular; ?></td>	

		  </tr>		

<?php

		$contador++;

	}

	mysqli_free_result($result2);*/	

?>	

		</tbody>

	</table> 

	<img src="images/spacer.gif" onload="$('.tabla_Datos_Personal').flexigrid({nowrap: false, showTableToggleBtn : true,width : 600,height :150, singleSelect: true	});" /> 	

</fieldset> 
<img src="images/spacer.gif" onload="Actividad_Re_Scheduling(<?php echo $Actividad_ID;?>,<?php echo $Pro_ID;?>);" />	

<?php

	require('Library/Close_Conexion.php');	

?>