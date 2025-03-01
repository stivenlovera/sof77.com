<?php

	session_name("Administrador");
	session_start();
//////////////  este es el que pasa parametros 
$idletime=2700;//after x seconds the user gets logged out 
$secon=time()-$_SESSION['timestamp'];
//echo $secon,"  ".$idletime."  ".$_SESSION['timestamp']."  ".time();

 if (time()-$_SESSION['timestamp']>$idletime)
 	{ 
	 	
		echo "<script type='text/javascript'>alert('Please log in again due the session is expired each session has 45minutes!');</script>";
		echo "<script> window.location.href = 'https://www.sof77.com';</script>";
	  
 	} 
 	
/////////////
	
	
	
	
	echo 	$_SESSION["EntityID"]."<br>";
	echo $_SESSION["Nick_Name"]."<br>";

	if ($_SESSION["EntityID"] == "" && $_SESSION["Nick_Name"] != "SuperUser")
	{

		echo "<script>alert('Not autorized option')</script>";
		echo "<script> window.location.href = 'https://www.sof77.com';</script>";
		//header("Location:sessionexpired.php"); 
	}	

	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');
	
	
	
	$Empleado_ID=$_SESSION["Empleado_ID"];
	$Actividad_ID=$_SESSION["Actividad_ID"];		
	$UserNick=$_SESSION["Nick_Name"];



	//echo "Actividad ID:".$Actividad_ID."  Foreman review and approve the hours:";
	$Pro_ID=$_GET["Pro_ID"];
	$_SESSION["Pro_ID"]=$Pro_ID;
	$Reg_ID=$_GET["Reg_ID"];	
	$Estilo="";
	

	
	if ( isset($_GET["Fecha"]) )
		$Date_Work=$_GET["Fecha"];
	else
		$Date_Work=$_SESSION["Date_Work"];

	$Estado="";
	if ($_SESSION["EntityID"] == "Foreman")
	{
		$Estado=" readonly ";
	}
	
	//echo $Estado."<br>";
	
?> 
<!--<a href="empleado_registro_actividad_detalle.php">empleado_registro_actividad_detalle</a>  -->

<table border="1" cellpadding="0" cellspacing="0" id="mitabla">
	<tr align="center">
		<td  width="20" align="center"></td>
		<td>-Employee Nick Name</td><td>Check In<br />Check Out</td><td width="15">Title Level 0</td><td width="15">Building</td><td width="15">Floor</td><td width="15">Area or Task</td>
		<td width="10">Hours Worked</td>
		<td>--*</td>
		<td width="25">Notes</td><td width="10">Check by Foreman</td><td></td><td></td>
	</tr>
	
	<?php
		$sql = "SELECT *,p.Nick_Name,Hora_Ingreso, Hora_Salida,Fecha_Hingreso,Fecha_Hsalida, TIMEDIFF(Hora_Salida,Hora_Ingreso) AS Horas ";
		$sql = $sql . " FROM registro_diario rd INNER JOIN registro_diario_actividad rda ON rd.Reg_ID=rda.Reg_ID AND rd.Fecha='".$Date_Work."' AND rd.Actividad_ID=".$Actividad_ID;
		$sql = $sql . " INNER JOIN task t ON rda.Task_ID=t.Task_ID AND ( t.Pro_ID= ".$Pro_ID." )";
		$sql = $sql . " INNER JOIN area_control a ON t.Area_ID=a.Area_ID ";
		$sql = $sql . " INNER JOIN floor f ON f.Floor_ID=a.Floor_ID ";
		$sql = $sql . " INNER JOIN edificios e ON e.Edificio_ID=f.Edificio_ID ";
		$sql = $sql . " INNER JOIN personal p ON p.Empleado_ID=rd.Empleado_ID  ORDER BY p.Nick_Name ";
		
		
		//echo " Primera: ".$sql."<br>";													
		$result77=$bd->ejecutar($sql); 		
		$RDA_ID=-1;
		$Fila=1;
		$Empleados_ID = "-777";
		$AuxEmpleado_ID="-1";
		$Conta_Emp=0;
		
		while (($row77 = mysqli_fetch_array($result77) ))	
		{
			$Task_ID=$row77["Task_ID"];
			$Area_ID=$row77["Area_ID"];
			$Floor_ID=$row77["Floor_ID"];
			$Edificio_ID=$row77["Edificio_ID"];				
			$Horas_Contract=$row77["Horas_Contract"];
			$Horas=$row77["Horas"];
			$Horas_aux=$Horas;
			$Horas_TM=$row77["Horas_TM"];
			$Detalles=$row77["Detalles"];
			$RDA_ID=$row77["RDA_ID"];
			$Nombre=$row77["Nombre"];
			$Apellido_Paterno=$row77["Apellido_Paterno"];
			$Apellido_Materno=$row77["Apellido_Materno"];
			$Nick_Name=$row77["Nick_Name"];
			$Empleado_ID=$row77["Empleado_ID"];
			if ($Empleado_ID != $AuxEmpleado_ID)
			{
				$AuxEmpleado_ID=$Empleado_ID;
				$Conta_Emp++;
				
			}
			
			$Hora_Ingreso=$row77["Hora_Ingreso"];
			//echo "1er. while HI:".$Hora_Ingreso." Horas:".$Horas;
			$Hora_Salida=$row77["Hora_Salida"];
			$Verificado_Foreman=$row77["Verificado_Foreman"];
			$Reg_ID=$row77["Reg_ID"];
			$Fecha_Hingreso=$row77["Fecha_Hingreso"];
			$Fecha_Hsalida=$row77["Fecha_Hsalida"];



			
/*			$sql55 = "select  TIMEDIFF(Hora_Salida,Hora_Ingreso) AS Horas FROM registro_diario WHERE Reg_ID=".$Reg_ID;														
			$result55=$bd->ejecutar($sql55); 		
			if (($row55 = mysqli_fetch_array($result55) ))	
			{
				$Horas_aux=$row["Horas"];
			}
			mysqli_free_result($result55);

			*/
			$Horas_aux=0;		
			if ($Fecha_Hingreso < $Fecha_Hsalida  )
			{
					$Horas_aux=$row77["Horas"]+24;
			}
					
			if ($Fecha_Hingreso == $Fecha_Hsalida)
			  {
					$Horas_aux=$row77["Horas"];
			  }
	
			if ($Horas_Contract == 0 &&  $Task_ID=="")
				$Horas_Contract = $Horas;
			
			//echo $sql; 
			
			//En nuestro ejemplo
			
			
			
			$array = explode(":", $Horas_aux);
			
				
			if ( $array[1]<47 && $array[1]>31 )
			{
				$Horas=$array[0]+0.5;
			}
			else
				if ( $array[1]<32 )
				{
					$Horas=$array[0]+0;
				}
				 else
					if ( $array[1]>46 )
					{
						$Horas=$array[0]+1;	
					}	
			if ($Horas==8.5)
				$Horas=8;
					
					
			if ($Horas_Contract == 0 && $Task_ID=="")
					$Horas_Contract = $Horas;
				
			$Empleados_ID = $Empleados_ID .",". $Empleado_ID ;
						
			$_SESSION["RDA_ID"]=$RDA_ID;
			
			$estado_foreman="";
			if ( ($Verificado_Foreman=="1") || ($Verificado_Foreman==true))
			{
				//echo $Verificado_Foreman."<br>";
				$estado_foreman="checked='checked'";
			}
			
			$Nombre_Empleado=$Nombre. " ".$Apellido_Paterno. " ".$Apellido_Materno;	
			
			if ($Hora_Ingreso=="00:00:00" || $Hora_Ingreso=="00:00:01")						
//				$Hora_Ingreso="00:00:01";
				$Hora_Ingreso="No check in";
				
			if ($Hora_Salida=="00:00:00" || $Hora_Salida=="00:00:01")								
				//$Hora_Salida="00:00:01";
				$Hora_Salida="No check out";
					
	?>
	
			<tr>
				<td width="45" align="center"><?php echo $Fila; ?></td>
				<td width="45" align="center"><?php echo $Nick_Name; ?></td>
				<td>					
                   <input name="Hora_Ingreso_<?php echo $Fila; ?>" id="Hora_Ingreso_<?php echo $Fila; ?>" type="text" value="<?php echo $Hora_Ingreso; ?>" size="12" <?php echo $Estado; ?>><br />   
     				<input name="Hora_Salida_<?php echo $Fila; ?>" id="Hora_Salida_<?php echo $Fila; ?>" type="text" value="<?php echo $Hora_Salida; ?>" size="12" <?php echo $Estado; ?>>
				</td>
				<td width="15">			
					<?php	
						$Cantidad=0;
						$sql = "select COUNT(*) AS Cantidad FROM edificios WHERE Pro_ID=".$Pro_ID;														
						$result=$bd->ejecutar($sql); 		
						if (($row = mysqli_fetch_array($result) ))	
						{
							$Cantidad=$row["Cantidad"];
						}
						mysqli_free_result($result);
						//echo $sql."<br>"; 	
						//echo $Cantidad."<br>"; 
						
						if ($Cantidad>1)
						{
							$eligio="No";	
					?>		
							<select name="Edificio_ID_<?php echo $Fila; ?>" size="1"  class="cuadro" id="Edificio_ID_<?php echo $Fila; ?>" onchange="foreman_registro_actividad_piso(this.value,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);"> 
							<option value="-1">Select one</option>   
					<?php		
							$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." and Nombre not like '%Material%' and Nombre not like '%Submittal%' and Nombre not like '%Closeout%' and Nombre not like '%SubCont%' order by Nombre";														
							$result=$bd->ejecutar($sql); 		
							while (($row = mysqli_fetch_array($result) ))	
							{	
								if ($Edificio_ID==$row["Edificio_ID"])
								{
									$estado="selected='selected'";
									$eligio="Si";
								}
								else
									$estado="";
					?>
								<option value="<?php echo $row["Edificio_ID"];?>"  <?php echo $estado;?> ><?php echo $row["Nombre"];?></option>  
					<?php
							}
							mysqli_free_result($result);	
					?>					
							</select> 
							<?php
							if ($eligio=="Si")
							{
						?>		
								<img src="images/spacer.gif" onload="foreman_registro_actividad_piso(<?php echo $Edificio_ID;?>,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);" />
						<?php
							}							
					
						}
						else
						{					   
							$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
							$result=$bd->ejecutar($sql); 		
							if (($row = mysqli_fetch_array($result) ))	
							{	
								$_SESSION["RDA_ID"]=-1;
					?>
								<input type="text" value="<?php echo $row["Nombre"];?>" size="10" />
								<input type="hidden" id="Edificio_ID_<?php echo $Fila; ?>" name="Edificio_ID_<?php echo $Fila; ?>" value="<?php echo $row["Edificio_ID"];?>" />
								<img src="images/spacer.gif" onload="foreman_registro_actividad_piso(<?php echo $row["Edificio_ID"];?>,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);" />	 
								
					<?php
							}
							mysqli_free_result($result);	
					
						}
					?>				</td>				
				<td width="10">	
			  <div id="div_registro_actividad_piso_<?php echo $Fila; ?>"></div>				</td>
				<td width="12">	
					<div id="div_registro_actividad_area_<?php echo $Fila; ?>"></div>				</td>
				<td width="12">	
					<div id="div_registro_actividad_task_<?php echo $Fila; ?>"></div>				</td>			
				<td width="15"><input name="Horas_Contract_<?php echo $Fila; ?>" id="Horas_Contract_<?php echo $Fila; ?>" value="<?php echo $Horas_Contract; ?>" size="5" /></td>		
				<td width="10"><input type="hidden" name="Horas_TM_<?php echo $Fila; ?>" id="Horas_TM_<?php echo $Fila; ?>"   value="<?php echo $Horas_TM; ?>"  size="5" /></td>
				<td width="45"><textarea name="Detalle_<?php echo $Fila; ?>" id="Detalle_<?php echo $Fila; ?>"><?php echo $Detalles; ?></textarea>
								<input type="hidden" name="Reg_ID_<?php echo $Fila; ?>" id="Reg_ID_<?php echo $Fila; ?>" value="<?php echo $Reg_ID; ?>" />
								<input type="hidden" name="RDA_ID_<?php echo $Fila; ?>" id="RDA_ID_<?php echo $Fila; ?>" value="<?php echo $RDA_ID; ?>" />
								<input type="hidden" name="Empleado_ID_<?php echo $Fila; ?>" id="Empleado_ID_<?php echo $Fila; ?>" value="<?php echo $Empleado_ID; ?>" />				
				</td>
				<td width="10"><input type="checkbox" name="Verificado_Foreman_<?php echo $Fila; ?>" id="Verificado_Foreman_<?php echo $Fila; ?>" <?php echo $estado_foreman; ?> /></td>
				<td>
					<img src="images/copy_16.gif" width="32" height="32" onclick="foreman_registro_actividad_clonar(<?php echo $Empleado_ID; ?>,'<?php echo $Nick_Name; ?>','<?php echo $Hora_Ingreso; ?>','<?php echo $Hora_Salida; ?>',<?php echo $Pro_ID; ?>,<?php echo $Reg_ID; ?>,-1,<?php echo $Fila; ?>)" />                    
				</td>
                 
                <td>
                	<div id="div_registro_borrar_<?php echo $Fila; ?>">
	                	<img src="images/icon_delete.jpg" onClick="foreman_registro_actividad_borrarr(<?php echo $RDA_ID; ?>,<?php echo $Reg_ID; ?>,<?php echo $Pro_ID; ?>,<?php echo $Fila; ?>);">
    				</div>
                </td> 
			</tr>
	<?php
			$Fila++;

	
			
				
			
		}
		mysqli_free_result($result77);
		
	
		
		
		$consulta = "SELECT pr.Pro_ID, p.Nombre, p.Nick_Name, p.Apellido_Paterno, p.Apellido_Materno, p.Empleado_ID ";		
		$consulta = $consulta . " FROM actividades a ";		
		$consulta = $consulta . " INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID AND ((a.Fecha='".$Date_Work."') OR a.Fecha='2013-01-01') ";
		$consulta = $consulta . " INNER JOIN proyectos pr ON pr.Pro_ID=a.Pro_ID AND ( pr.Pro_ID= ".$Pro_ID." ) ";
		$consulta = $consulta . " INNER JOIN actividad_personal ap ON ap.Actividad_ID=a.Actividad_ID ";
		$consulta = $consulta . " INNER JOIN personal p ON p.Empleado_ID=ap.Empleado_ID AND (  p.Empleado_ID NOT IN (".$Empleados_ID.")   )";				
		$consulta = $consulta . " ORDER BY p.Nick_Name,pr.Pro_ID,a.Tipo_Actividad_ID,a.Fecha, Hora";	
		
		//echo $consulta."<br>";													
		$result77=$bd->ejecutar($consulta); 		
		$RDA_ID=-1;		
		
		while (($row77 = mysqli_fetch_array($result77) ))	
		{			
			$Nombre=$row77["Nombre"];
			$Nick_Name=$row77["Nick_Name"];
			$Apellido_Paterno=$row77["Apellido_Paterno"];
			$Apellido_Materno=$row77["Apellido_Materno"];
			$Empleado_ID=$row77["Empleado_ID"];
			$Nombre_Empleado=$Nombre. " ".$Apellido_Paterno. " ".$Apellido_Materno;		
			
			$Reg_ID=-1;
			$consulta = "SELECT rda.RDA_ID,rda.Horas_Contract,rd.Hora_Ingreso AS Hora_Ingreso,rd.Empleado_ID , rd.Hora_Salida as Hora_Salida, rd.Reg_ID as Reg_ID, TIMEDIFF(Hora_Salida,Hora_Ingreso) AS Horas ";		
			$consulta = $consulta . " FROM registro_diario rd LEFT JOIN registro_diario_actividad rda ON rd.Reg_ID=rda.Reg_ID ";						
			$consulta = $consulta . " WHERE rd.Empleado_ID=". $Empleado_ID . " AND rd.Fecha='".$Date_Work."' AND rd.Actividad_ID=".$Actividad_ID." ORDER BY rd.Empleado_ID";
			//echo "SEGUNDA:".$consulta."<br>";													
			$result877=$bd->ejecutar($consulta); 			
					
			while (($row77 = mysqli_fetch_array($result877) ))	
			{	
					
				$Hora_Ingreso=$row77["Hora_Ingreso"];
				//echo "<br> hI2:".$Hora_Ingreso."<br>";
				$Hora_Salida=$row77["Hora_Salida"];
				$RDA_ID=$row77["RDA_ID"];
				$Reg_ID=$row77["Reg_ID"];		
				$Horas_aux=$row77["Horas"];
				$Horas_aux=0;			
				$Horas_Contract=$row77["Horas_Contract"];
				if ($Fecha_Hingreso < $Fecha_Hsalida)
					$Horas_aux=$row77["Horas"]+24;
					
				if ($Fecha_Hingreso == $Fecha_Hsalida)
					$Horas_aux=$row77["Horas"];

				if ($Horas_Contract == 0)
				$Horas_Contract = $Horas;
	
				$array = explode(":", $Horas_aux);
				
				$Empleados_ID = $Empleados_ID .",". $Empleado_ID ;
			
				if ( $array[1]<47 && $array[1]>31 )
				{
					$Horas=$array[0]+0.5;
				}
				else
					if ( $array[1]<32 )
					{
						$Horas=$array[0]+0;
					}
					 else
						if ( $array[1]>46 )
						{
							$Horas=$array[0]+1;	
						}
				$Horas_Contract=$Horas;				
							//echo "2 while  Horas:".$Horas;	
				if (is_null($Reg_ID))
					$Reg_ID=-1;	
	
				if (is_null($RDA_ID))
					$RDA_ID=-1;	
				if ($Hora_Ingreso=="00:00:00" || $Hora_Ingreso=="00:00:01")						
//				$Hora_Ingreso="00:00:01";
				$Hora_Ingreso="No check in";
				
			if ($Hora_Salida=="00:00:00" || $Hora_Salida=="00:00:01")								
				//$Hora_Salida="00:00:01";
				$Hora_Salida="No check out";				
		?>	
				<tr>
					<td align="center"><?php echo $Fila; ?></td>
					<td><?php echo $Nick_Name; ?>				</td>
					<td>
                   
                    	<input name="Hora_Ingreso_<?php echo $Fila; ?>" id="Hora_Ingreso_<?php echo $Fila; ?>" type="text" value="<?php echo $Hora_Ingreso; ?>" size="12" <?php echo $Estado; ?>><br />
						<input name="Hora_Salida_<?php echo $Fila; ?>" id="Hora_Salida_<?php echo $Fila; ?>" type="text" value="<?php echo $Hora_Salida; ?>" size="12" <?php echo $Estado; ?>>
					</td>
					<td width="15">			
						<?php	
							$Cantidad=0;
							$sql = "select COUNT(*) AS Cantidad FROM edificios WHERE Pro_ID=".$Pro_ID;														
							$result=$bd->ejecutar($sql); 		
							if (($row = mysqli_fetch_array($result) ))	
							{
								$Cantidad=$row["Cantidad"];
							}
							mysqli_free_result($result);
							//echo $sql."<br>"; 	
							//echo $Cantidad."<br>"; 
							if ($Cantidad>1)
							{	
						?>		
								<select name="Edificio_ID_<?php echo $Fila; ?>" size="1"  class="cuadro" id="Edificio_ID_<?php echo $Fila; ?>" onchange="foreman_registro_actividad_piso(this.value,<?php echo $Fila; ?>);"> 
								<option value="-1">Select One</option>   
						<?php		
								$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
								$result=$bd->ejecutar($sql); 		
								while (($row = mysqli_fetch_array($result) ))	
								{									
						?>
									<option value="<?php echo $row["Edificio_ID"];?>" ><?php echo $row["Nombre"];?></option>  
						<?php
								}
								mysqli_free_result($result);	
						?>					
								</select> 
						<?php
							}
							else
							{					   
								$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
								$result=$bd->ejecutar($sql); 		
								if (($row = mysqli_fetch_array($result) ))	
								{	
						?>
									<input type="text" value="<?php echo $row["Nombre"];?>" size="10" />
									<input type="hidden" id="Edificio_ID_<?php echo $Fila; ?>" name="Edificio_ID_<?php echo $Fila; ?>" value="<?php echo $row["Edificio_ID"];?>" />
									<img src="images/spacer.gif" onload="foreman_registro_actividad_piso(<?php echo $row["Edificio_ID"];?>,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);" />	 
									
						<?php
								}
								mysqli_free_result($result);	
						
							}
						?>				</td>				
					<td width="10">	
						<div id="div_registro_actividad_piso_<?php echo $Fila; ?>">
						<input type="hidden" id="Floor_ID_<?php echo $Fila; ?>" name="Floor_ID_<?php echo $Fila; ?>" value="-1" />
						</div>				</td>
					<td width="12">	
						<div id="div_registro_actividad_area_<?php echo $Fila; ?>">
							<input type="hidden" id="Area_ID_<?php echo $Fila; ?>" name="Area_ID_<?php echo $Fila; ?>" value="-1" />
						</div>				</td>
					<td width="12">	
						<div id="div_registro_actividad_task_<?php echo $Fila; ?>">
							<input type="hidden" id="Task_ID_<?php echo $Fila; ?>" name="Task_ID_<?php echo $Fila; ?>" value="-1" />
						</div>				</td>			
					<td width="15"><input name="Horas_Contract_<?php echo $Fila; ?>" id="Horas_Contract_<?php echo $Fila; ?>" value="<?php echo $Horas_Contract; ?>"  size="5" /></td>		
				  <td width="10"><input type="hidden" name="Horas_TM_<?php echo $Fila; ?>" id="Horas_TM_<?php echo $Fila; ?>"  size="5" /></td>
					<td width="45"><textarea name="Detalle_<?php echo $Fila; ?>" id="Detalle_<?php echo $Fila; ?>"></textarea>
									<input type="hidden" name="Reg_ID_<?php echo $Fila; ?>" id="Reg_ID_<?php echo $Fila; ?>" value="<?php echo $Reg_ID; ?>" />
									<input type="hidden" name="RDA_ID_<?php echo $Fila; ?>" id="RDA_ID_<?php echo $Fila; ?>" value="<?php echo $RDA_ID; ?>" />
									<input type="hidden" name="Empleado_ID_<?php echo $Fila; ?>" id="Empleado_ID_<?php echo $Fila; ?>" value="<?php echo $Empleado_ID; ?>" />				</td>
					<td width="10" ><input type="checkbox" name="Verificado_Foreman_<?php echo $Fila; ?>" id="Verificado_Foreman_<?php echo $Fila; ?>" /></td>
					<td><img src="images/copy_16.gif" width="32" height="32" onclick="foreman_registro_actividad_clonar(<?php echo $Empleado_ID; ?>,'<?php echo $Nick_Name; ?>','<?php echo $Hora_Ingreso; ?>','<?php echo $Hora_Salida; ?>',<?php echo $Pro_ID; ?>,<?php echo $Reg_ID; ?>,-1,<?php echo $Fila; ?>)" />					
					</td>
                    
                    <td>
                  	<div id="div_registro_borrar_<?php echo $Fila; ?>">
	                	<img src="images/icon_delete.jpg" onClick="foreman_registro_actividad_borrarr(<?php echo $RDA_ID; ?>,<?php echo $Reg_ID; ?>,<?php echo $Pro_ID; ?>,<?php echo $Fila; ?>);">
    				</div>
                    
                    </td> 
				</tr>
		<?php
				$Fila++;


			}
			mysqli_free_result($result877);			
		}
		mysqli_free_result($result77);
		
		$consulta = "SELECT pr.Pro_ID, p.Nick_Name,p.Nombre, p.Apellido_Paterno, p.Apellido_Materno, p.Empleado_ID,a.Actividad_ID";		
		$consulta = $consulta . " FROM actividades a ";
		$consulta = $consulta . " INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID AND ((a.Fecha='".$Date_Work."') OR a.Fecha='2013-01-01') ";
		$consulta = $consulta . " INNER JOIN proyectos pr ON pr.Pro_ID=a.Pro_ID AND ( pr.Pro_ID= ".$Pro_ID." ) ";
		$consulta = $consulta . " INNER JOIN actividad_personal ap ON ap.Actividad_ID=a.Actividad_ID ";
		$consulta = $consulta . " INNER JOIN personal p ON p.Empleado_ID=ap.Empleado_ID AND (  p.Empleado_ID NOT IN (".$Empleados_ID.")   )";				
		$consulta = $consulta . " WHERE a.Actividad_ID=".$Actividad_ID." ORDER BY p.Nick_Name,pr.Pro_ID,a.Tipo_Actividad_ID,a.Fecha, Hora";	
		
		//echo "TERCERA".$consulta."<br>";													
		$result77=$bd->ejecutar($consulta); 		
		$RDA_ID=-1;		
		
		while (($row77 = mysqli_fetch_array($result77) ))	
		{			
			$Nombre=$row77["Nombre"];
			$Nick_Name=$row77["Nick_Name"];
			$Apellido_Paterno=$row77["Apellido_Paterno"];
			$Apellido_Materno=$row77["Apellido_Materno"];
			$Empleado_ID=$row77["Empleado_ID"];
			$Actividad_ID=$row77["Actividad_ID"];
			$Nombre_Empleado=$Nombre. " ".$Apellido_Paterno. " ".$Apellido_Materno;	
			//echo "<br> ingreso a tercera";
			
			//////////////////
			
			
			
			$sql= "Select *,TIMEDIFF(Hora_Salida,Hora_Ingreso) AS Horas from registro_diario rd where rd.Empleado_ID=$Empleado_ID and rd.Actividad_ID=".$Actividad_ID;
			$result77a=$bd->ejecutar($sql); 
			//echo "cuarto:".$sql;
			//echo "3 while  Horas:".$Horas;	
			$Hi="00:00:00";
			$Hs="00:00:00";
			while (($row77a = mysqli_fetch_array($result77a) ))
			{
			$Hi=$row77a["Hora_Ingreso"];									
			$Hs=$row77a["Hora_Salida"];									
			$Horas=$row77a["Horas"];
												
			}
			mysqli_free_result($result77a);
			

			
			$array = explode(":", $Horas);
			//echo "Hing".$Hi."HSal".$Hs." Horas: ".$Horas." Dif array:".$array[1];			
			if ( $array[1]<47 && $array[1]>31 )
	{
		$Horas=$array[0]+0.5;
	}
	else
		if ( $array[1]<32 )
		{
			$Horas=$array[0]+0;
		}
		 else
		    if ( $array[1]>46 )
			{
				$Horas=$array[0]+1;	
			}	
			
			
			if ($Hi=="00:00:00" || $Hi=="00:00:01")
				{
				$Hi="No Check In";
				$Horas=0;
				
				}
			if ($Hs=="00:00:00" || $Hs=="00:00:01")
				{
				$Hs="No Check Out";
				$Horas=0;
				}
	
			$Horas_Contract=$Horas;
			$RDA_ID=-1;
			$Reg_ID=-1;
			
			$Empleados_ID = $Empleados_ID .",". $Empleado_ID ;
									
		?>	
				<tr>
					<td align="center"><?php echo $Fila; ?></td>
					<td><?php echo $Nick_Name; ?>				</td>
					<td>
                    	<input name="Hora_Ingreso_<?php echo $Fila; ?>" id="Hora_Ingreso_<?php echo $Fila; ?>" type="text" value="<?php echo $Hi;?>" size="12"  <?php echo $Estado; ?>><br />
                    
                       
                                
                        
						<input name="Hora_Salida_<?php echo $Fila; ?>" id="Hora_Salida_<?php echo $Fila; ?>" type="text" value="<?php echo $Hs ;?>"  size="12"  <?php echo $Estado; ?>>
                    </td>								
					<td width="15">			
						<?php	
							$Cantidad=0;
							$sql = "select COUNT(*) AS Cantidad FROM edificios WHERE Pro_ID=".$Pro_ID;														
							$result=$bd->ejecutar($sql); 		
							if (($row = mysqli_fetch_array($result) ))	
							{
								$Cantidad=$row["Cantidad"];
							}
							mysqli_free_result($result);
							//echo $sql."<br>"; 	
							//echo $Cantidad."<br>"; 
							if ($Cantidad>1)
							{	
						?>		
								<select name="Edificio_ID_<?php echo $Fila; ?>" size="1"  class="cuadro" id="Edificio_ID_<?php echo $Fila; ?>" onchange="foreman_registro_actividad_piso(this.value,<?php echo $Fila; ?>);"> 
								<option value="-1">Select one</option>   
						<?php		
								$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
								$result=$bd->ejecutar($sql);
								//echo $sql; 		
								while (($row = mysqli_fetch_array($result) ))	
								{									
						?>
									<option value="<?php echo $row["Edificio_ID"];?>" ><?php echo $row["Nombre"];?></option>  
						<?php
								}
								mysqli_free_result($result);	
						?>					
								</select> 
						<?php
							}
							else
							{					   
								$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
								//echo "sql edif:".$sql;
								$result=$bd->ejecutar($sql); 		
								if (($row = mysqli_fetch_array($result) ))	
								{	
						?>
									<input type="text" value="<?php echo $row["Nombre"];?>" size="10" />
									<input type="hidden" id="Edificio_ID_<?php echo $Fila; ?>" name="Edificio_ID_<?php echo $Fila; ?>" value="<?php echo $row["Edificio_ID"];?>" />
									<img src="images/spacer.gif" onload="foreman_registro_actividad_piso(<?php echo $row["Edificio_ID"];?>,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);" />	 
									
						<?php
								}
								mysqli_free_result($result);	
						
							}
						?></td>				
					<td width="10">	
						<div id="div_registro_actividad_piso_<?php echo $Fila; ?>">
						<input type="hidden" id="Floor_ID_<?php echo $Fila; ?>" name="Floor_ID_<?php echo $Fila; ?>" value="-1" />
						</div>				</td>
					<td width="12">	
						<div id="div_registro_actividad_area_<?php echo $Fila; ?>">
							<input type="hidden" id="Area_ID_<?php echo $Fila; ?>" name="Area_ID_<?php echo $Fila; ?>" value="-1" />
						</div>				</td>
					<td width="12">	
						<div id="div_registro_actividad_task_<?php echo $Fila; ?>">
							<input type="hidden" id="Task_ID_<?php echo $Fila; ?>" name="Task_ID_<?php echo $Fila; ?>" value="-1" />
						</div>				</td>			
					<td width="15"><input name="Horas_Contract_<?php echo $Fila; ?>" id="Horas_Contract_<?php echo $Fila; ?>" value="<?php echo $Horas_Contract; ?>"  size="5" /></td>		
				  <td width="10"><input type="hidden" name="Horas_TM_<?php echo $Fila; ?>" id="Horas_TM_<?php echo $Fila; ?>"  size="5" /></td>
					<td width="35"><textarea name="Detalle_<?php echo $Fila; ?>" id="Detalle_<?php echo $Fila; ?>"></textarea>
									<input type="hidden" name="Reg_ID_<?php echo $Fila; ?>" id="Reg_ID_<?php echo $Fila; ?>" value="<?php echo $Reg_ID; ?>" />
									<input type="hidden" name="RDA_ID_<?php echo $Fila; ?>" id="RDA_ID_<?php echo $Fila; ?>" value="<?php echo $RDA_ID; ?>" />
									<input type="hidden" name="Empleado_ID_<?php echo $Fila; ?>" id="Empleado_ID_<?php echo $Fila; ?>" value="<?php echo $Empleado_ID; ?>" />				</td>
					<td width="10"><input type="checkbox" name="Verificado_Foreman_<?php echo $Fila; ?>" id="Verificado_Foreman_<?php echo $Fila; ?>" /></td>
					<td><img src="images/copy_16.gif" alt="" width="32" height="32" onclick="foreman_registro_actividad_clonar(<?php echo $Empleado_ID; ?>,'<?php echo $Nick_Name; ?>','<?php echo $Hora_Ingreso; ?>','<?php echo $Hora_Salida; ?>',<?php echo $Pro_ID; ?>,<?php echo $Reg_ID; ?>,-1,<?php echo $Fila; ?>)" />					
					</td>
                   
                  <td>
    	<div id="div_registro_borrar_<?php echo $Fila; ?>">
	                	<img src="images/icon_delete.jpg" onClick="foreman_registro_actividad_borrarr(<?php echo $RDA_ID; ?>,<?php echo $Reg_ID; ?>,<?php echo $Pro_ID; ?>,<?php echo $Fila; ?>);">
    				</div>  
                   </td>  
				</tr>
		<?php
				$Fila++;	
									
		}
		mysqli_free_result($result77);
		
		echo "<img src='images/spacer.gif' onload='Fila=".$Fila.";' />";
	?>		
	<tr>
		<td colspan="6"></td>	
	</tr>
</table>
<?php
					$Date_Hoy= date('Y-m-d');
					//$Date_Hoy = date('Y-m-d H:i:s', strtotime($Date_Hoy.' +1 day'));
					$Date_Hoy = date('Y-m-d', strtotime($Date_Hoy.' +1 day'));
											
					// evita check in en diferente fecha
					//$Date_Hoy=$Date_Work;
					
					
					$d1=strtotime($Date_Hoy);
					$d0=strtotime($Date_Work);
					
					
					$days  = abs($d1-$d0);
					$daysa=$days/86400;// 86400 seconds in one day
// and you might want to convert to integer
					
					$days = intval($daysa);

//echo $Date_Hoy."  dates ".$Date_Work."Days:".$days."<br>";
//echo  $UserNick;
//echo $Fila." fila".$Conta_Emp."contaEmp <br>";
if ($days==1 || $days==2 || $UserNick=="SuperUser")
 
{
	
?>
<div id="div_registro">
  <table align="center">
        <tr>
            <td colspan="6" align="right">
                <button style="font-size:18px;" onclick="foreman_registro_actividad_registrar(<?php echo $Pro_ID; ?>, <?php echo $Fila; ?>);">Save</button>			
            </td>
        
      </tr>
    </table>
  <p><a href="index.php" class="enlaceboton">[Cancel and Exit</a>]</p>
</div>
<?php
}
?>

<div id="aux_div_res"></div>

<div id="Tabla_Lista_Actividades"></div>

<!--<img src="images/spacer.gif" onload="empleado_registro_actividad_lista(<?php echo $Reg_ID; ?>);" />	-->
 
<div id="Div_Actividad_Personal_Information"></div>
	
<?php
	

	require('Library/Close_Conexion.php');
		

?>

