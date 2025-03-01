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
	$UserNick=$_SESSION["Nick_Name"];
	$Tip_Per=$_SESSION["Tip_Per"];
	$Reg_ID=$_GET["Reg_ID"];
	$Estilo="";
	$Date_Work=$_SESSION["Date_Work"];
	$EmpID_NIckName=$Empleado_ID."-".$UserNick;
	$UserNickID = $Empleado_ID."-".(rtrim($UserNick));
		
	//echo "Empleado_ID=".$Empleado_ID."User Nick N:".$UserNick."<br>";
	//echo "Actividad_ID=".$Actividad_ID."<br>";
?> 	
<table border="2" cellpadding="0" cellspacing="0">
	<thead>	
	  <tr>		
		<th width="410">Project--/*</th>		
	  </tr>	
	 </thead>	
	 <tbody>
<?php 

	/*$consulta = "SELECT COUNT(*) AS Proyectos FROM actividades a 
	INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID 
	INNER JOIN proyectos p ON p.Pro_ID=a.Pro_ID ";
	$consulta = $consulta . " WHERE ((a.Fecha=CURDATE()) OR a.Fecha='2013-01-01') ";		

	$Proyectos=-1;	
	$result2=$bd->ejecutar($consulta);
	while (($row2 = mysqli_fetch_array($result2) ))
	{	
		$Proyectos = $row2["Proyectos"];
	}
	mysqli_free_result($result2);*/
		/// olde 	
	/* $consulta = "SELECT p.Pro_ID, p.Nombre, p.Fecha_Inicio, p.Fecha_Fin, p.Horas, a.*, ta.Actividad_Nombre FROM actividades a 
		INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID 
		INNER JOIN proyectos p ON p.Pro_ID=a.Pro_ID ";
		//$consulta = $consulta . " WHERE ((a.Fecha='".$Date_Work."') OR a.Fecha='2013-01-01') ";
		$consulta = $consulta . " WHERE ((a.Fecha='".$Date_Work."') OR a.Fecha='2013-01-01') and (p.Foreman_ID=$Empleado_ID or p.Lead_ID=$Empleado_ID or p.Coordinador_ID=$Empleado_ID or '".$UserNick."'='SuperUser' or '".$Tip_Per."'!='F') ";		
		$consulta = $consulta." ORDER BY p.Nombre,p.Pro_ID,a.Tipo_Actividad_ID,a.Fecha, Hora";    */
	//	*** end old 12/11/23
		
		/// new
		
		$consulta = "SELECT p.Pro_ID, p.Nombre, p.Fecha_Inicio, p.Fecha_Fin, p.Horas, a.*,ap.Empleado_ID,ap.Actividad_ID,pe.Empleado_ID,pe.Aux5,ta.Actividad_Nombre FROM actividades a INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID INNER JOIN proyectos p ON p.Pro_ID=a.Pro_ID INNER JOIN actividad_personal ap on ap.Actividad_ID=a.Actividad_ID INNER JOIN personal pe on pe.Empleado_ID=ap.Empleado_ID ";
		$consulta = $consulta . " WHERE ((a.Fecha='".$Date_Work."') OR a.Fecha='2013-01-01') and (p.Foreman_ID=".$Empleado_ID." or p.Lead_ID=".$Empleado_ID." or p.Coordinador_ID=".$Empleado_ID." or '".$UserNick."'='SuperUser' or (pe.Aux5!='F' and pe.Empleado_ID=".$Empleado_ID."))";
		$consulta = $consulta." ORDER BY p.Nombre,p.Pro_ID,a.Tipo_Actividad_ID,a.Fecha, Hora";
		//echo $consulta."<br>";
		
		$contador=0;
		$Pro_ID_Ant=-33;		
		$Actividad_ID_Ant=-33;	
		$pro_ID_x=-1;
		$result2=$bd->ejecutar($consulta);
		while (($row2 = mysqli_fetch_array($result2) ))
		{				
			$Pro_ID = $row2["Pro_ID"];
			$Nombre = $row2["Nombre"];
			$Fecha_Inicio = $row2["Fecha_Inicio"];
			$Fecha_Fin = $row2["Fecha_Fin"];
			$Fecha = $row2["Fecha"];
			$Fechar=FormatDateTime($Fecha, 8);
			$Horas = $row2["Hora"];
			$Actividad_ID = $row2["Actividad_ID"];
			$_SESSION["Actividad_ID"]=$Actividad_ID;
			$Tipo_Actividad_ID = $row2["Tipo_Actividad_ID"];
			$Actividad_Nombre = $row2["Actividad_Nombre"];
			$Descripcion  = $row2["Descripcion"];
			$Hora = $row2["Hora"];
			$Aux1 = $row2["Aux1"];
			$Aux2 = $row2["Aux2"];
			$Aux3 = $row2["Aux3"];
			$Aux5 = $row2["Aux5"];
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
					$empleadosID_Nicks=$empleadosID_Nicks.", ".$row33["Empleado_ID"]."-".$row33["Nick_Name"];
					//$empleados=$empleados.", ".$row33["Nombre"]." ".$row33["Apellido_Paterno"];
					
				}
			}
			//echo "Empleados rrr:".$empleados."<br>";
			mysqli_free_result($result33);
		
			$consulta = "SELECT p.*, ";	
			$consulta = $consulta . " CONCAT(em1.Nombre, ' ', em1.Apellido_Paterno, ' ',  em1.Apellido_Materno) as Foreman, em1.Telefono as TelefonoF,  em1.Celular as  CelularF, ";	
			$consulta = $consulta . " CONCAT(em7.Nombre, ' ', em7.Apellido_Paterno, ' ',  em7.Apellido_Materno) as Lead, ";
			$consulta = $consulta . " CONCAT(em2.Nick_Name) as Pwtpm, ";	
			$consulta = $consulta . " CONCAT(em3.Nick_Name) as Pwtsuper, ";	
			$consulta = $consulta . " CONCAT(em5.Nombre, ' ',  em5.Apellido_Paterno, ' ',  em5.Apellido_Materno) as Coordinador_Obra, em5.Telefono as TelefonoC,  em5.Celular as  CelularC, em6.Emp_ID,em6.Codigo as Gc FROM proyectos p ";
			$consulta = $consulta . " LEFT JOIN personal em1 ON em1.Empleado_ID=p.Foreman_ID ";	
			$consulta = $consulta . " LEFT JOIN personal em2 ON em2.Empleado_ID=p.Manager_ID ";
			$consulta = $consulta . " LEFT JOIN personal em3 ON em3.Empleado_ID=p.Coordinador_ID ";
			$consulta = $consulta . " LEFT JOIN personal em5 ON em5.Empleado_ID=p.Coordinador_Obra_ID ";
			$consulta = $consulta . " LEFT JOIN empresas em6 ON em6.Emp_ID=p.Emp_ID ";	
				$consulta = $consulta . " LEFT JOIN personal em7 ON em7.Empleado_ID=p.Lead_ID";				
			$consulta = $consulta . " WHERE p.Pro_ID=".$Pro_ID;		
			//echo $consulta."  project wwwww <br>";	
			$result33=$bd->ejecutar($consulta); 
			while (($row33 = mysqli_fetch_array($result33) ))							
			{				
				$Codigo = $row33["Codigo"];
				$Gc = $row33["Gc"];
				$Foreman=$row33["Foreman"];
				$Lead=$row33["Lead"];
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
				$PwtSuper=$row33["Coordinador_ID"];
				$Lead_ID=$row33["Lead_ID"];
				$Address= $Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code;	
			}
			mysqli_free_result($result33);
		
			if (is_null($Color) ) 
				$Estilo="background-color:#FFFFFF"; 
			else
				$Estilo="background-color:".$Color;
			
			//echo "Empleado_ID=".$EmpID_NIckName."<br>";
			//echo "Empleados_ID=".$empleadosID_Nicks."<br>";
			//echo "Super user:".$UserNick."<br>";
			//if ($Foreman_ID==$_SESSION["Empleado_ID"])
			
			$resultado = strpos($empleadosID_Nicks,$UserNickID);
			//echo $UserNickID." zzzz///".$empleadosID_Nicks."///".$resultado."<br><br>";
			if ( ($resultado !== FALSE) || ($Empleado_ID==$Foreman_ID) || ($Empleado_ID==$Lead_ID) || $UserNick=="SuperUser" || $Empleado_ID==$PwtSuper || $Aux5!='F')
						
			{
				//echo "entro 44444 <br>";
				if ($Pro_ID_Ant != $Pro_ID || $Actividad_ID !=$Actividad_ID_Ant)	
				{	
					$contador++;
					$Pro_ID_x=$Pro_ID;
					$Actividad_ID_x=$Actividad_ID;
				?>	
				<tr>		
					<td align="left"  style="font-size:x-small; <?php echo $Estilo; ?>">	
							<a style =" cursor: pointer;" onclick="foreman_menu(<?php echo $Reg_ID; ?>,<?php echo $Actividad_ID; ?>,<?php echo $Pro_ID; ?>);">
							<?php echo "$Fechar:($Gc)$Codigo/$Nombre/$Address<br><b>Contac:</b>$Coordinador_Obra <b>:</b>$CelularC<br><b>Foreman:</b>$Foreman <b>:</b>$CelularF<b>Lead:</b>$Lead<br><b>PWT Super.:</b>$Pwtsuper <b>/</b>$empleados<b>//</b>$Horas<br>"; ?>				</a>			
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
					$pro_ID_x=$Pro_ID;
					$Actividad_ID_x=$Actividad_ID;
					$empleadosID_Nicks="";
				}	
				else	
				{	
					//echo "<td></td><td></td><td></td><td></td><td></td>";	
				}	

			}//fin empleado
			$Pro_ID_Ant=$Pro_ID;				
			$Actividad_ID_Ant=$Actividad_ID;
			
		}
		mysqli_free_result($result2);
			?>
		</tbody>
	</table>
	
	<div id="basic-modal-content-espera" style="display:none; height:300px; width:300px;">Hola es un demo</div>	
	
<?php
	if ($contador==1)
		echo "<img src='images/spacer.gif' onload='foreman_menu(".$Reg_ID.",".$Actividad_ID_x.",".$pro_ID_x.");' />";	 
?>
	<div id="Div_Actividad_Personal_Information"></div>
	
<?php

	require('Library/Close_Conexion.php');	

?>



