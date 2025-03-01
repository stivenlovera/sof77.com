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
	$Pro_ID=$_GET["Pro_ID"];
	$_SESSION["Pro_ID"]=$Pro_ID;
	$Reg_ID=$_GET["Reg_ID"];	
	$Estilo="";	
	$Date_Work=$_SESSION["Date_Work"];
?> 
<table border="1" cellpadding="0" cellspacing="0">
	<tr align="center">
		<td></td><td>Employe</td><td>Hour IN</td><td>Hour Out</td><td></td>
	</tr>	
	<?php		
		
		$consulta = "SELECT pr.Pro_ID, p.Nombre, p.Apellido_Paterno, p.Apellido_Materno, p.Empleado_ID FROM actividades a ";
		$consulta = $consulta . " INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID ";
		$consulta = $consulta . " INNER JOIN proyectos pr ON pr.Pro_ID=a.Pro_ID ";
		$consulta = $consulta . " INNER JOIN actividad_personal ap ON ap.Actividad_ID=a.Actividad_ID ";
		$consulta = $consulta . " INNER JOIN personal p ON p.Empleado_ID=ap.Empleado_ID ";
		$consulta = $consulta . " AND p.Empleado_ID= ".$Empleado_ID;		
		$consulta = $consulta . " WHERE ((a.Fecha='".$Date_Work."') OR a.Fecha='2013-01-01') ";		
		$consulta = $consulta . " AND (  pr.Pro_ID= ".$Pro_ID." ) ";				
		$consulta = $consulta . " ORDER BY p.Nombre,pr.Pro_ID,a.Tipo_Actividad_ID,a.Fecha, Hora";		
		
		//echo $consulta."<br>";													
		$result77=$bd->ejecutar($consulta); 		
		$RDA_ID=-1;	
		$i=1;	
		
		while (($row77 = mysqli_fetch_array($result77) ))	
		{			
			$Nombre=$row77["Nombre"];
			$Apellido_Paterno=$row77["Apellido_Paterno"];
			$Apellido_Materno=$row77["Apellido_Materno"];
			$Empleado_ID=$row77["Empleado_ID"];
			
			$Nombre_Empleado = $Nombre. " ".$Apellido_Paterno. " ".$Apellido_Materno;
			
			$Hora_Ingreso="";
			$Hora_Salida="";
			$Foto_Ingreso="";
			$Foto_Salida="";
			
			$consulta = "SELECT ADDTIME(Hora_Ingreso, '-04:00:00.000') as Hora_Ingreso, ADDTIME(Hora_Salida, '-04:00:00.000') as Hora_Salida, Foto_Ingreso, Foto_Salida FROM registro_diario WHERE Empleado_ID=".$Empleado_ID." AND '".$Date_Work."'=Fecha ";	
			$result88=$bd->ejecutar($consulta); 
			if (($row88 = mysqli_fetch_array($result88) ))							
			{				
				$Hora_Ingreso=$row88["Hora_Ingreso"];
				$Hora_Salida=$row88["Hora_Salida"];
				
				$Foto_Ingreso=$row88["Foto_Ingreso"];
				$Foto_Salida=$row88["Foto_Salida"];
				
				echo "<img src='images/spacer.gif' onload='$(\"#Div_Hora_IN_".$Empleado_ID."\").html(\"".$Hora_Ingreso."\");' />";
			}
			mysqli_free_result($result88);
			
			if ($Hora_Salida=="-04:00:00")							
				$Hora_Salida="";
					
			if ($Foto_Ingreso=="")	
				$img_Foto_Ingreso="sin_foto.png";			
			else		
				$img_Foto_Ingreso="con_foto.jpg";
			
			if ($Foto_Salida=="")	
				$img_Foto_Salida="sin_foto.png";			
			else		
				$img_Foto_Salida="con_foto.jpg";			
					
	?>	
			<tr>
				<td width="30" align="center">
					<?php echo $i; ?>	
				</td>
				<td>
					<?php
						/*if  ( ($Foto_Salida!="") && (!(is_null($Foto_Salida))) )							
							echo "<img src='images/spacer.gif' onload='Poner_Foto(\"".$Foto_Salida."\");' />";	*/
					?>
					<?php echo $Nombre. " ".$Apellido_Paterno. " ".$Apellido_Materno; ?>				</td>
				<td width="100" align="center">
					<span id="Div_Hora_IN_<?php echo $Empleado_ID; ?>"><?php echo $Hora_Ingreso; ?></span>
					<span id="Div_Foto_IN_<?php echo $Empleado_ID; ?>"><img id="Img_Foto_IN_<?php echo $Empleado_ID; ?>" src="images/<?php echo $img_Foto_Ingreso; ?>" height="50" width="50" /></span>
				</td>				
				<td width="100" align="center">
					<span id="Div_Hora_OUT_<?php echo $Empleado_ID; ?>"><?php echo $Hora_Salida; ?></span>
					<span id="Div_Foto_OUT_<?php echo $Empleado_ID; ?>"><img id="Img_Foto_OUT_<?php echo $Empleado_ID; ?>" src="images/<?php echo $img_Foto_Salida; ?>" height="50" width="50" /></span>
				</td>				
				<td width="100">
					<div id="Editar_<?php echo $Empleado_ID; ?>">
				<?php
					if ( ($Hora_Ingreso=="00:00:00") || ($Hora_Salida=="-04:00:00") || ($Foto_Ingreso=="") || ($Foto_Salida=="") )	 
					{
				?>
						<img src="images/icon_editar_0_png.png" onclick="foreman_registro_actividad_asistencia_reg(<?php echo $Empleado_ID; ?>,'<?php echo $Nombre_Empleado; ?>')" />
				<?php					
					}
				?>
					</div>
				</td>
			</tr>
	<?php
			$Fila++;
			$i++;
		}
		mysqli_free_result($result77);
	?>	
	<tr>
		<td><div id="div_registro_actividad_registrar"></div></td>	
	</tr>
</table>	
<p>&nbsp;</p>
<canvas  id="canvas_test" width="320" height="240"></canvas>
  <?php

	require('Library/Close_Conexion.php');	

?>
</p>
