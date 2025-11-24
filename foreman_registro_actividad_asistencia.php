<?php

 //on pageload 

	session_name("Administrador");
	session_start();
	include ("hora.php");		

	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 
	}	

	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');
	
	$Empleado_ID=$_SESSION["Empleado_ID"];		
	$Pro_ID=$_GET["Pro_ID"];
	$Actividad_ID=$_GET["Actividad_ID"];
	$_SESSION["Pro_ID"]=$Pro_ID;
	$Reg_ID=$_GET["Reg_ID"];	
	$Estilo="";	
	$Date_Work=$_SESSION["Date_Work"];
	//echo $Actividad_ID."  ActID en forregactasis<br>".$Pro_ID." Proy";
//	<td><?php echo $_SESSION['timestamp']; 
?></td>
<table border="1" cellpadding="0" cellspacing="0" id="table_personas">
	<tr align="center">
    
		<td></td>
		<td>-Employee-</td>
		<td>Check In</td>
		<td>Check  Out</td>
        <td><a href="index.php" class="enlaceboton">Exit/Close</a>&nbsp;&nbsp; </td>
        
        
  </tr>	
	<?php		
		
		$consulta = "SELECT pr.Pro_ID, p.Nick_Name,p.Nombre, p.Apellido_Paterno, p.Apellido_Materno, p.Empleado_ID,a.Actividad_ID,a.Hora FROM actividades a ";
		$consulta = $consulta . " INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID ";
		$consulta = $consulta . " INNER JOIN proyectos pr ON pr.Pro_ID=a.Pro_ID ";
		$consulta = $consulta . " INNER JOIN actividad_personal ap ON ap.Actividad_ID=a.Actividad_ID ";
		$consulta = $consulta . " INNER JOIN personal p ON p.Empleado_ID=ap.Empleado_ID ";
		$consulta = $consulta . " WHERE ((a.Fecha='".$Date_Work."' OR a.Fecha='2013-01-01') ";		
		$consulta = $consulta . " AND (  pr.Pro_ID= ".$Pro_ID.") AND (a.Actividad_ID=".$Actividad_ID." )) ";				
		$consulta = $consulta . " ORDER BY p.Nombre,pr.Pro_ID,a.Tipo_Actividad_ID,a.Fecha, Hora";		

		//echo "for_reg_act_asi:".$consulta."<br>";													
		$result77=$bd->ejecutar($consulta); 		
		$RDA_ID=-1;	
		$i=1;	
		
		while (($row77 = mysqli_fetch_array($result77) ))	
		{			
			$Nombre=$row77["Nombre"];
			$Nick_Name=$row77["Nick_Name"];
			$Apellido_Paterno=$row77["Apellido_Paterno"];
			$Apellido_Materno=$row77["Apellido_Materno"];
			$Empleado_ID=$row77["Empleado_ID"];
			$Actividad_ID=$row77["Actividad_ID"];
			$_SESSION["Actividad_ID"]=$Actividad_ID;
			$_SESSION["HoraStart"]=$row77["Hora"];
			
			$Nombre_Empleado = $Nombre. " ".$Apellido_Paterno. " ".$Apellido_Materno;
			
			$Hora_Ingreso="";
			$Hora_Salida="";
			$Foto_Ingreso="";
			$Foto_Salida="";
			
			$consulta = "SELECT Reg_ID,Hora_Ingreso, Hora_Salida, Foto_Ingreso, Foto_Salida FROM registro_diario  WHERE Empleado_ID=".$Empleado_ID." AND '".$Date_Work."'=Fecha "." AND '".$Actividad_ID."'=Actividad_ID";
			
			$result88=$bd->ejecutar($consulta); 
			//echo "////***////for_reg_act_asi 2nd:".$consulta."<br>";
			if (($row88 = mysqli_fetch_array($result88) ))							
			{				
				$Hora_Ingreso=$row88["Hora_Ingreso"];
				$Hora_Salida=$row88["Hora_Salida"];
				
				$Foto_Ingreso=$row88["Foto_Ingreso"];
				$Foto_Salida=$row88["Foto_Salida"];
				$Reg_ID=$row88["Reg_ID"];
				$Total_Horas=0;
				
				
				//echo "<img src='images/spacer.gif' onload='$(\"#Div_Hora_IN_".$Empleado_ID."\").html(\"".$Hora_Ingreso."\");' />";
				
				/////
				
				$consulta = "SELECT SUM(Horas_Contract) AS Total_Horas from registro_diario_actividad  WHERE Reg_ID=".$Reg_ID;
				//echo "tt55tt:".$consulta;
			
			$result44=$bd->ejecutar($consulta); 
			
			if (($row44 = mysqli_fetch_array($result44) ))							
			{				
				$Total_Horas=$row44["Total_Horas"];
				//echo "==".$Total_Horas."===";
				$_SESSION["Total_Horas"]=$Total_Horas;
				
			}
			mysqli_free_result($result44);
				
				////
					
			}
			mysqli_free_result($result88);
			
			if ($Hora_Ingreso=="00:00:00" || $Hora_Ingreso=="00:00:01" || $Hora_Ingreso=="")							
				$Hora_Ingreso="No Check In";
				
			if ($Hora_Salida=="00:00:00" || $Hora_Salida=="00:00:01" || $Hora_Salida=="")							
				$Hora_Salida="No Check Out";
					
			if ($Foto_Ingreso=="")	
				$img_Foto_Ingreso="images/sin_foto.png";			
			else		
				$img_Foto_Ingreso="pwt/fotos/".$Foto_Ingreso;

			if ($Foto_Salida=="")	
				$img_Foto_Salida="images/sin_foto.png";			
			else		
				$img_Foto_Salida="pwt/fotos/".$Foto_Salida;			
			
			//$Hora_Ingreso="qqqq";		
	?>	
			<tr>
				<td width="30" align="center" >
					<?php echo $i; ?>	
				</td>
				<td >
					<?php
						/*if  ( ($Foto_Salida!="") && (!(is_null($Foto_Salida))) )							
							echo "<img src='images/spacer.gif' onload='Poner_Foto(\"".$Foto_Salida."\");' />";	*/
					?>
					<a href="#" class="persona_id" data-id="<?php echo $Empleado_ID;?>" ><?php echo $Nick_Name; ?></a>
					</td>
				<td width="100" align="center">
					<span id="Div_Hora_IN_<?php echo $Empleado_ID; ?>"><?php echo $Hora_Ingreso; ?></span>
					<span id="Div_Foto_IN_<?php echo $Empleado_ID; ?>"><img id="Img_Foto_IN_<?php echo $Empleado_ID; ?>" src="<?php echo $img_Foto_Ingreso; ?>" height="50" width="50" /></span>
				</td>				
				<td width="100" align="center">
					<span id="Div_Hora_OUT_<?php echo $Empleado_ID; ?>"><?php echo $Hora_Salida; ?></span>
					<span id="Div_Foto_OUT_<?php echo $Empleado_ID; ?>"><img id="Img_Foto_OUT_<?php echo $Empleado_ID; ?>" src="<?php echo $img_Foto_Salida; ?>" height="50" width="50" /></span>
				</td>				
				<td width="100">
					<div id="Editar_<?php echo $Empleado_ID; ?>">
				<?php
					//echo $Hora_Ingreso.",".$Hora_Salida."<br>";
					//if ( ($Hora_Ingreso=="00:00:00") || ($Hora_Ingreso=="00:00:00") || ($Hora_Ingreso=="") || ($Hora_Salida=="00:00:00") || ($Hora_Salida=="") || ($Foto_Ingreso=="") || ($Total_Horas==0))	
					 
					$Date_Hoy= date('Y-m-d');
					//$Date_Hoy = date('Y-m-d H:i:s', strtotime($Date_Hoy.' +1 day'));
					$Date_Hoy = date('Y-m-d', strtotime($Date_Hoy.' +1 day'));
											
					// evita check in en diferente fecha
					//$Date_Hoy=$Date_Work;
					//echo $Date_Hoy."  dates ".$Date_Work;
					
					$d1=strtotime($Date_Hoy);
					$d0=strtotime($Date_Work);
					
					
					$days  = abs($d1-$d0);
					$daysa=$days/86400;// 86400 seconds in one day
// and you might want to convert to integer
					//echo $daysa." daysa";
					if ($daysa>0 and $daysa<1)
						$daysa=1;
					$days = intval($daysa);
					
									 
					
					//echo $days;
					
					//$horasaux = date('H:i:s', strtotime ($Hora_Ingreso.' +30 minutes'));
					//&& ($Hora_Ingreso > $horasaux || $Hora_Ingreso=="No Check In")
					
					//echo "hora aux:".$horasaux."HI:".$Hora_Ingreso."<br>";
					//$flag=1;
					$fechaact=$Date_Work;
					hora_actual($fechaact,$horaact);
					$hora10 = date('H:i:s', strtotime ($Hora_Salida.' + 10 minutes'));
					//echo "date:".$Date_Work."  ".$horaact." HS:".$Hora_Salida."  HS+10:".$hora10;
					if ( (($Hora_Ingreso=="00:00:00") || ($Hora_Ingreso=="No Check In") || ($Hora_Ingreso=="") || ($Hora_Salida=="No Check Out")|| ($Hora_Salida=="00:00:00") || ($Hora_Salida=="") || ($horaact<$hora10) ) && ($days==1 || $days==2 ) )  	 
					{
				?>
						<img src="images/icon_editar_1_png.png" onclick="foreman_registro_actividad_asistencia_reg(<?php echo $Empleado_ID; ?>,'<?php echo $Nombre_Empleado; ?>')" />
				<?php					
				
					}
				?>
					</div>
				</td>
			</tr>
	<?php
			$Fila++;
			$i++;
			//extra
		}
		mysqli_free_result($result77);
	?>	
	<tr>
		<td colspan="5"><div id="div_registro_actividad_registrar_xxx"></div></td>	
	</tr>
</table>	
<!-- <script src="https://unpkg.com/emodal@1.2.69/dist/eModal.min.js"></script> -->
<?php
	$auth = "SELECT personal.* FROM personal
		WHERE personal.Empleado_ID=".$_SESSION["Empleado_ID"];
		//echo $consulta."<br>";	
		$result00=$bd->ejecutar($auth); 	
		while (($row00 = mysqli_fetch_array($result00) ))
		{
			?>		
			<script>
				var usuario="<?php echo $row00["Usuario"];?>";
				var password="<?php echo $row00["Password"];?>";
				var actividad_id="<?php echo $Actividad_ID;?>";
			</script>
			<?php	
		}
?>
<script>
	//console.log(usuario,password)
	$("#view_Notas").on('click', function(evt) {
	var options = {
			url: `https://app.sof77.com/auto-login/<?php echo $_SESSION["Pro_ID"];?>?username=${usuario}&password=${password}`,
			title: 'Preview',
			size: eModal.size.lg,
			buttons: [{
				text: 'ok',
				style: 'info',
				close: true,
				size: 'lg',
			}],
		};
		eModal.iframe(options);
	});
	$("#view_Report").on('click', function(evt) {
	var options = {
			url: `https://app.sof77.com/auto-login/<?php echo $_SESSION["Pro_ID"];?>?username=${usuario}&password=${password}&actividad=${actividad_id}&redirrect=reportDaily`,
			title: 'Preview',
			size: eModal.size.lg,
			buttons: [{
				text: 'Exit Daily Report',
				style: 'info',
				close: true,
				size: 'lg',
			}],
		};
		eModal.iframe(options);
	});
</script>

<script>
	 $(".persona_id").on('click', function(evt) {
		let persona_id=$(this).data('id')
		console.log(persona_id)
		var options = {
                url: `https://app.sof77.com/no-auth-cardex?personas=${persona_id}`,
                title: 'Preview',
                size: eModal.size.lg,
                buttons: [{
                    text: 'ok',
                    style: 'info',
                    close: true,
                    size: 'lg',
                }],
            };
            eModal.iframe(options);
        })
</script>
<script>
	$(document).on("click",".open_daily_report",function() {
		var options = {
				url: `https://app.sof77.com/auto-login/<?php echo $_SESSION["Pro_ID"];?>?username=${usuario}&password=${password}&actividad=${actividad_id}&redirrect=reportDaily`,
				title: 'Preview',
				size: eModal.size.lg,
				buttons: [{
					text: 'Exit Daily Report',
					style: 'info',
					close: true,
					size: 'lg',
				}],
			};
			eModal.iframe(options);
    });
</script>
  <?php
	require('Library/Close_Conexion.php');	
?>
</p>
