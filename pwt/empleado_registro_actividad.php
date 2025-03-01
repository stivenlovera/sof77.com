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
	
	$Empleado_ID=$_SESSION["Empleado_ID"];		
	$Reg_ID=$_GET["Reg_ID"];
	$Estilo="";
	$Date_Work=$_SESSION["Date_Work"];
?> 
<table class="Tabla_Lista_Actividades"  >
	<thead>	
	  <tr>		
		<th width="410">Project--</th>
		<!--<th width="80">Date</th>
		<th width="50">Hour</th>
		<th width="80">Type</th>
		<th width="150">Employees</th>
        <th width="162">Description</th>
		<th width="100">Aux1</th>
		<th width="100">Aux2</th>
		<th width="100">Aux3</th>-->
	  </tr>	
	 </thead>	
	 <tbody>
<?php 

	/*$consulta = "SELECT COUNT(*) AS Proyectos FROM actividades a 
	INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID 
	INNER JOIN proyectos p ON p.Pro_ID=a.Pro_ID ";
	$consulta = $consulta . " WHERE ((a.Fecha='".$Date_Work."') OR a.Fecha='2013-01-01') ";		

	$Proyectos=-1;	
	$result2=$bd->ejecutar($consulta);
	while (($row2 = mysqli_fetch_array($result2) ))
	{	
		$Proyectos = $row2["Proyectos"];
	}
	mysqli_free_result($result2);*/
			
	$consulta = "SELECT p.Pro_ID, p.Nombre, p.Fecha_Inicio, p.Fecha_Fin, p.Horas, a.*, ta.Actividad_Nombre FROM actividades a 
		INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID 
		INNER JOIN proyectos p ON p.Pro_ID=a.Pro_ID ";
		$consulta = $consulta . " WHERE ((a.Fecha='".$Date_Work."') OR a.Fecha='2013-01-01') ";		

		$consulta = $consulta." ORDER BY p.Nombre,p.Pro_ID,a.Tipo_Actividad_ID,a.Fecha, Hora";
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
			$Color = $row2["Color"];
	
			$consulta = "SELECT p.* FROM personal p 
			INNER JOIN actividad_personal ap ON ap.Empleado_ID=p.Empleado_ID 
			WHERE ap.Actividad_ID=".$Actividad_ID;
			//echo $consulta."<br>";	
			$result33=$bd->ejecutar($consulta); 	
			$empleados="";
			while (($row33 = mysqli_fetch_array($result33) ))
			{	
				if ($empleados=="")	
				{
					$empleados=$row33["Nick_Name"];
					$empleados_ID=$row33["Empleado_ID"];
				}
				else
				{
					$empleados=$empleados.", ".$row33["Nick_Name"];
					$empleados_ID=$empleados_ID.", ".$row33["Empleado_ID"];
					//$empleados=$empleados.", ".$row33["Nombre"]." ".$row33["Apellido_Paterno"];
				}
			}
			mysqli_free_result($result33);
		
			$consulta = "SELECT p.*, ";	
			$consulta = $consulta . " CONCAT(em1.Nombre, ' ', em1.Apellido_Paterno, ' ',  em1.Apellido_Materno) as Foreman, em1.Telefono as TelefonoF,  em1.Celular as  CelularF, ";	
			$consulta = $consulta . " CONCAT(em2.Nick_Name) as Pwtpm, ";	
			$consulta = $consulta . " CONCAT(em3.Nick_Name) as Pwtsuper, ";	
			$consulta = $consulta . " CONCAT(em5.Nombre, ' ',  em5.Apellido_Paterno, ' ',  em5.Apellido_Materno) as Coordinador_Obra, em5.Telefono as TelefonoC,  em5.Celular as  CelularC, em6.Emp_ID,em6.Codigo as Gc FROM proyectos p ";
			$consulta = $consulta . " LEFT JOIN personal em1 ON em1.Empleado_ID=p.Foreman_ID ";	
			$consulta = $consulta . " LEFT JOIN personal em2 ON em2.Empleado_ID=p.Manager_ID ";
			$consulta = $consulta . " LEFT JOIN personal em3 ON em3.Empleado_ID=p.Coordinador_ID ";
			$consulta = $consulta . " LEFT JOIN personal em5 ON em5.Empleado_ID=p.Coordinador_Obra_ID ";
			$consulta = $consulta . " LEFT JOIN empresas em6 ON em6.Emp_ID=p.Emp_ID ";				
			$consulta = $consulta . " WHERE p.Pro_ID=".$Pro_ID;		
			//echo $consulta."<br>";	
			$result33=$bd->ejecutar($consulta); 
			while (($row33 = mysqli_fetch_array($result33) ))							
			{				
				$Codigo = $row33["Codigo"];
				$Gc = $row33["Gc"];
				$Foreman=$row33["Foreman"];
				$TelefonoF=$row33["TelefonoF"];
				$CelularF = $row33["CelularF"];
				$Pwtpm	= $row33["Pwtpm"];
				$Pwtsuper	= $row33["Pwtsuper"];
				$Coordinador_Obra = $row33["Coordinador_Obra"];	
				$TelefonoC = $row33["TelefonoC"];			 
				$CelularC = $row33["CelularC"];
				$Numero = $row33["Numero"];
				$Calle = $row33["Calle"];
				$Ciudad = $row33["Ciudad"];
				$Estado = $row33["Estado"];
				$Zip_Code = $row33["Zip_Code"];
				$Foreman_ID = $row33["Foreman_ID"];
				$Address= $Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code;	
			}
			mysqli_free_result($result33);
		
			if (is_null($Color) ) 
				$Estilo="background-color:#FFFFFF"; 
			else
				$Estilo="background-color:".$Color;
			
		
			//echo $empleados_ID."<br>";
			//if ($Foreman_ID==$_SESSION["Empleado_ID"])			
			$resultado = strpos($empleados_ID, $Empleado_ID);
			if($resultado !== FALSE)
			{
			?>		
				
				<?php	
				if ($Pro_ID_Ant!=$Pro_ID)	
				{	
					$contador++;
					$Pro_ID_x=$Pro_ID;
				?>	
				<tr>		
					<td align="right"  style="font-size:x-small; <?php echo $Estilo; ?>">	
							<a style =" cursor: pointer;" onclick="empleado_registro_actividad_detalle(<?php echo $Reg_ID; ?>, <?php echo $Pro_ID; ?>);">
                            <!--<a style =" cursor: pointer;" onclick="empleado_registro_actividad_asistencia(<?php echo $Reg_ID; ?>, <?php echo $Pro_ID; ?>);">-->
                            
							<?php echo "($Gc)$Codigo/$Nombre/$Address<br><b>Contac:</b>$Coordinador_Obra <b>Movil:</b>$CelularC<br><b>Foreman:</b>$Foreman <b>Movil:</b>$CelularF<br><b>PWT:</b>$Pwtpm <b>/</b>$Pwtsuper<br>"; ?>				</a>			
					</td>	
					<!--<td align="right"  style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo FormatDateTime($Fecha,8); ?></td>	
					<td align="right"  style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Hora; ?></td>			
					<td align="center" style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Actividad_Nombre; ?></td>
					<td align="Center" style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $empleados; ?></td>		
					<td align="right"  style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Descripcion; ?></td>		
					<td align="right"  style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Aux1; ?></td>		
					<td align="center" style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Aux2; ?></td>		
					<td align="Center" style="font-size:x-small; <?php echo $Estilo; ?>"><?php echo $Aux3; ?></td>		-->		
				</tr>	
			<?php  
				}	
				else	
				{	
					//echo "<td></td><td></td><td></td><td></td><td></td>";	
				}	

			}//fin empleado	
			$Pro_ID_Ant=$Pro_ID;
		}
		mysqli_free_result($result2);
			?>
		</tbody>
	</table>
    <div id="basic-modal-content-espera" style="display:none; height:300px; width:300px;">Hola es un demo</div>
    
	<img src="images/spacer.gif" onload="$('.Tabla_Lista_Actividades').flexigrid({nowrap: false, title : 'Activity List',showTableToggleBtn : true,width : 1100,height :150, singleSelect: true	});" />	 
<?php
	if ($contador==1)
	{
		echo "<img src='images/spacer.gif' onload='empleado_registro_actividad_detalle(".$Reg_ID.", ".$Pro_ID_x.");' />";	 
		//echo "<img src='images/spacer.gif' onload='empleado_registro_actividad_asistencia(".$Reg_ID.", ".$Pro_ID_x.");' />";	 
	}
?>
	<div id="Div_Actividad_Personal_Information"></div>
	
<?php

	require('Library/Close_Conexion.php');	

?>