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

	

	$consulta = "SELECT Codigo, Nombre FROM proyectos p 		

		INNER JOIN actividades a ON p.Pro_ID=a.Pro_ID

		WHERE a.Actividad_ID=".$Actividad_ID;				

	//echo $consulta;

	$contador=1;	 	  	 	  	  



	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{

		$Codigo = $row2["Codigo"];

		$Nombre = $row2["Nombre"];	

	}	

	mysqli_free_result($result2);
		

?> 

    <table width="99%" align="right">

    	<tr>

        	<td width="95%">             

				<fieldset>

					<legend>
						<strong> Employees: <?php echo FormatDateTime($Fecha, 8);?> For <?php echo $Codigo,$Nombre;?></strong>
					<img src="images/actializar.png" height="30" width="30" onclick='Actividades_Personal_Lista(<?php echo $Actividad_ID; ?>);' /></legend>

					<div id="Actividad_Personal"></div>

				</fieldset>

				

        	</td>
			<td>
				<div id="Div_Res_Personal"></div>
			</td>                             

        </tr>

		<tr>

			<td width="80%">             

				<fieldset>

					<legend>
						<strong> Staff: <?php echo FormatDateTime($Fecha, 8);?> For <?php echo "$Codigo-$Nombre";?> </strong>
						<img src="images/actializar.png" height="30" width="30" onclick="Actividades_Personal_a_Asignar(<?php echo $Actividad_ID; ?>,'<?php echo $Fecha;?>');" />
                        
				    <img src="images/detjob.png" alt="Update with jobs" width="35" height="30" onclick="Actividades_Personal_a_Asignardet(<?php echo $Actividad_ID; ?>,'<?php echo $Fecha;?>');" /></legend>
  
					<div id="Actividad_Personal_Disponible"></div>

			  </fieldset>				


       	  </td>  
			 
			<td>
				<div id="Div_Res_Personal_Asignar"></div>
			</td>      

		</tr>		

	</table>

<?php

	echo "<img src='images/spacer.gif' onload='Actividades_Personal_Lista($Actividad_ID);' />";

	echo "<img src='images/spacer.gif' onload='Actividades_Personal_a_Asignar($Actividad_ID,\"$Fecha\");' />"; 

	require('Library/Close_Conexion.php');

?>