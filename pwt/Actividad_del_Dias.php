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
	
?> 
<table class="Tabla_Lista_Actividades"  >
	<thead>	
	  <tr>
       		<th width="30">Nro</th>
			<th width="250">Project</th>			
			<th width="70">Hour</th>		
			<th width="70">Type</th>		
			<th width="250">Desciption</th>				
			<th width="80">Aux1</th>								   								   			
			<th width="80">Aux2</th>
			<th width="80">Aux3</th>
			<th width="20">&nbsp;</th>				 
	  </tr>	
	 </thead>	
	 <tbody>
<?php   				       	
	$consulta = "SELECT p.Pro_ID, p.Nombre, p.Fecha_Inicio, p.Fecha_Fin, p.Horas, a.*, ta.Actividad_Nombre FROM actividades a 
		INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID 
		INNER JOIN proyectos p ON p.Pro_ID=a.Pro_ID
		WHERE a.Fecha='".$Fecha."' ORDER BY p.Pro_ID, a.Fecha, a.Hora";		
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
		$Horas = $row2["Horas"];
		$Actividad_ID = $row2["Actividad_ID"];
		$Tipo_Actividad_ID = $row2["Tipo_Actividad_ID"];
		$Actividad_Nombre = $row2["Actividad_Nombre"];
		$Descripcion  = $row2["Descripcion"];	
		$Hora = $row2["Hora"];
		$Aux1 = $row2["Aux1"];	
		$Aux2 = $row2["Aux2"];
		$Aux3 = $row2["Aux3"];	
		
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
				if ($Pro_ID_Ant!=$Pro_ID)
				{
			?>
						
			<?php
					$contador++;
				}
				else
				{
					//echo "<td></td><td></td><td></td><td></td><td></td>";
				}
			?>
			<td ><?php echo  $contador?></td>						
			<td align="right"  style="font-size:x-small"><?php echo "$Codigo/$Nombre/$Address<br>$Foreman/$TelefonoF/$CelularF<br>$Coordinador_Obra/$TelefonoC/$CelularC"; ?></td>
			<td align="right"  style="font-size:x-small"><?php echo $Hora; ?></td>			
			<td align="center" style="font-size:x-small"><?php echo $Actividad_Nombre; ?></td>		
			<td align="right"  style="font-size:x-small"><?php echo $Descripcion; ?></td>		
			<td align="right"  style="font-size:x-small"><?php echo $Aux1; ?></td>		
			<td align="center" style="font-size:x-small"><?php echo $Aux2; ?></td>		
			<td align="Center" style="font-size:x-small"><?php echo $Aux3; ?></td>	
			<td>&nbsp;</td>	
	  </tr>
		<?php    		
			$Pro_ID_Ant=$Pro_ID;											 								
	}
	mysqli_free_result($result2);		
			?>
		</tbody>
	</table>   	 
<img src="images/spacer.gif" onload="$('.Tabla_Lista_Actividades').flexigrid({nowrap: false, title : 'Activity List of <?php echo FormatDateTime($Fecha,8)	;?>',showTableToggleBtn : true,width : 900,height :300, singleSelect: true	});" />	 
<?php
	require('Library/Close_Conexion.php');	
?>