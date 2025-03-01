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

?> 



<fieldset id="Fs_Lista_Cliente" class="" >

	<legend></legend>

<div>

	<b>Person Selected:</b><bR />

	<b>Foreman:</b><span id='Name_Foreman_Aux'></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<b>Project Manager:</b><span id='Name_Manager_Aux'></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>PWT Super:</b><span id='Name_Super_Aux'></span>

<table class="Tabla_Lista_Empleados"  >

	<thead>	

	  <tr>

       		<th width="150">&nbsp;</th>	

			<th width="70">Position</th>

			<th width="100">Nick_Name</th>

			<th width="200">Name</th>		

		    <th width="200">Address</th>

			<th width="200">Phone</th>

			<th width="200">Movil</th>

			<th width="200">email</th>

			<th width="100">Social Security Number</th>

			<th width="100">Driver Licence Number</th>

			<th width="100">Resident Number</th>

			<th width="100">Job Number</th>

            <th width="80">Date of Birth</th>

			<th width="100">Aux1</th>		

			<th width="100">Aux2</th>		

			<th width="100">Aux3</th>		

			<th width="100">Aux4</th>		

			<th width="100">Aux5</th>		

	  </tr>	

	 </thead>	

	 <tbody>

<?php   				       	



	$consulta = "SELECT p.* FROM personal p INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID AND e.Codigo='PWT' ORDER BY Nick_Name, Nombre";

																		 //WHERE e.Codigo='PWT' ORDER BY Nick_name	

	//echo $consulta."<br>";

	$contador=1;	 	  	

	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Empleado_ID = $row2["Empleado_ID"];

		$Nick_Name = $row2["Nick_Name"];

		$Nombre = $row2["Nombre"];

		$Apellido_Paterno  = $row2["Apellido_Paterno"];	

		$Apellido_Materno = $row2["Apellido_Materno"];

		$Estado = $row2["Estado"];	

		$Ciudad = $row2["Ciudad"];	

		$Zip_Code = $row2["Zip_Code"];			

		$Calle = $row2["Calle"];

		$Numero=$row2["Numero"];

		$Cargo=$row2["Cargo"];

		$Numero_Seguro_Social=$row2["Numero_Seguro_Social"];

		$Fecha_Nacimiento=$row2["Fecha_Nacimiento"];

		$Numero_Licencia_Conducir=$row2["Numero_Licencia_Conducir"];

		$Numero_Permiso_Trabajo=$row2["Numero_Permiso_Trabajo"];

		$Numero_Residente=$row2["Numero_Residente"];

		$email=$row2["email"];

		$Telefono=$row2["Telefono"];	

		$Celular=$row2["Celular"];	

		$Aux1=$row2["Aux1"];	

		$Aux2=$row2["Aux2"];	

		$Aux3=$row2["Aux3"];	

		$Aux4=$row2["Aux4"];	

		$Aux5=$row2["Aux5"];	

	?>		



		<tr >					

			<td> 	

				 <a href="#" onclick="Proyectos_reporte_dayli_report_b_Personal_Asignar('Foreman',<?php echo  $Empleado_ID; ?>,'<?php echo  $Cargo; ?>','<?php echo  $Nick_Name; ?>','<?php echo $Nombre . " ".$Apellido_Paterno . " ".$Apellido_Materno; ?>');">Foreman</a>								

				<a href="#" onclick="Proyectos_reporte_dayli_report_b_Personal_Asignar('Manager',<?php echo  $Empleado_ID; ?>,'<?php echo  $Cargo; ?>','<?php echo  $Nick_Name; ?>','<?php echo $Nombre . " ".$Apellido_Paterno . " ".$Apellido_Materno; ?>');">P. Manager</a>	

             <a href="#" onclick="Proyectos_reporte_dayli_report_b_Personal_Asignar('Super',<?php echo  $Empleado_ID; ?>,'<?php echo  $Cargo; ?>','<?php echo  $Nick_Name; ?>','<?php echo $Nombre . " ".$Apellido_Paterno . " ".$Apellido_Materno; ?>');">PWT Super</a>   

                			

			</td>

			<td align="right" style="font-size:x-small"><?php echo  $Cargo; ?></td>

			<td align="right" style="font-size:x-small"><?php echo  $Nick_Name; ?></td>

			<td align="left">

				<a href="javascript:Empresas_Menu(<?php echo  $Emp_ID?>);">

					<?php echo $Nombre . " ".$Apellido_Paterno . " ".$Apellido_Materno; ?> 

				</a>

			</td>	

			<td align="left" style="font-size:x-small"><?php echo  $Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code; ?></td>

			<td align="right" style="font-size:x-small"><?php echo  $Telefono; ?></td>		

			<td align="right" style="font-size:x-small"><?php echo  $Celular; ?></td>		

			<td align="right" style="font-size:x-small"><?php echo  $email; ?></td>		

			<td align="right" style="font-size:x-small"><?php echo  $Numero_Seguro_Social; ?></td>		

			<td align="right" style="font-size:x-small"><?php echo  $Numero_Licencia_Conducir; ?></td>	

			<td align="right" style="font-size:x-small"><?php echo  $Numero_Permiso_Trabajo; ?></td>	

			<td align="right" style="font-size:x-small"><?php echo  $Numero_Residente; ?></td>

			<td align="right" style="font-size:x-small"><?php echo  FormatDateTime($Fecha_Nacimiento, 8);?></td>

			<td align="right" style="font-size:x-small"><?php echo  $Aux1; ?></td>

			<td align="right" style="font-size:x-small"><?php echo  $Aux2; ?></td>

			<td align="right" style="font-size:x-small"><?php echo  $Aux3; ?></td>

			<td align="right" style="font-size:x-small"><?php echo  $Aux4; ?></td>

			<td align="right" style="font-size:x-small"><?php echo  $Aux5; ?></td>

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

		echo "<br><br>No hay Registros<br>";

	}				

?>

</div>

<img src="images/spacer.gif" onload="$('.Tabla_Lista_Empleados').flexigrid({nowrap: false, showTableToggleBtn : true,width : 1000,height :350, singleSelect: true	});" />	 

</fieldset>	

<?php

	require('Library/Close_Conexion.php');	

?>