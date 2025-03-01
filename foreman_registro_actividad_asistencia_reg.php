<?php

	session_name("Administrador");
	session_start();
	//////////////

 //on pageload 
$idletime=2700;//after x seconds the user gets logged out 
$secon=time()-$_SESSION['timestamp'];
//echo $secon,"  ".$idletime."  ".$_SESSION['timestamp']."  ".time();
 if (time()-$_SESSION['timestamp']>$idletime)
 	{ 
		echo "<script type='text/javascript'>alert('Please log in again due the session is expired each session has 45minutes!');</script>";
		echo "<script> window.location.href = 'https://www.sof77.com';</script>";
	  
 	} 
 	
/////////////
	
	
			
	include ("hora.php");
	
	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	

	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	
	require('Library/funciones.php');	
	
	
	
////////////////////////
/*	echo date_default_timezone_get();
   $currenttime = date('h:i:s:u');
   list($hrs,$mins,$secs,$msecs) = split(':',$currenttime);
   echo " => $hrs:$mins:$secs\n";

   date_default_timezone_set('US/Eastern');
   echo date_default_timezone_get();
   $currenttime = date('h:i:s:u');
   list($hrs,$mins,$secs,$msecs) = split(':',$currenttime);
   echo " => $hrs:$mins:$secs\n";

   date_default_timezone_set('America/New_York');
   echo date_default_timezone_get();
   $currenttime = date('h:i:s:u');
   list($hrs,$mins,$secs,$msecs) = split(':',$currenttime);
   echo " => $hrs:$mins:$secs\n";
///////////////////////////// */
	
	
	
	
	
	
	
	$Empleado_ID=$_GET["Empleado_ID"];
	
	$Actividad_ID=$_SESSION["Actividad_ID"];
	$Total_Horas=$_SESSION["Total_Horas"];
	$Date_Work=$_SESSION["Date_Work"];
	$Pro_ID=$_SESSION["Pro_ID"];
	$fecha1=$Date_Work;
	$HoraStart=$_SESSION["HoraStart"];
	$HoraStart2= ((strtotime ($HoraStart.'+120 minutes')));
	
   	date_default_timezone_set('US/Eastern');
	$Horaactu=date('h:i:s:u');
    $currenttime = date('h:i:s:u');
		

//////////
	$consulta="select a.Descripcion, a.Pro_ID, ap.Empleado_ID,a.Fecha,a.Actividad_ID,ap.Actividad_ID FROM actividad_personal ap join actividades a on ap.Actividad_ID=a.Actividad_ID where a.Actividad_ID=".$Actividad_ID." and a.Fecha ='".$fecha1."' and a.Pro_ID=".$Pro_ID." and ap.Empleado_ID=".$Empleado_ID;
	$result2=$bd->ejecutar($consulta); 
	//echo $consulta."<br>"; 
	if (($row2 = mysqli_fetch_array($result2) ))							
	{	
		//$xx3= $row2["descripcion"];
		//echo $xx3."  econtro algun registro <br >";
		//$xx=00;
		
	}	
	else
		{
			
			//echo "  Nooo   econtro algun registro <br >";
			//$xx3= $row2["a.descripcion"];
			//echo $xx3."  econtro algun registro <br >";
			echo "<script type='text/javascript'>alert('Please log in again due the session is expired each session has 45minutes!');</script>";
			echo "<script> window.location.href = 'https://www.sof77.com';</script>";
			
			
		
		}
	mysqli_free_result($result2);			
	
	///////////////
	
	
	
	
	if ($HoraStart2< $Horaactu)
	{
			$HoraStart2x=date('H:i', $HoraStart2);
			$Horaactux=date('H:i', $Horaactu);
			//echo $HoraStart2x."  hora start +2 and hora real ".$Horaactux;
			$tipoaux="Out";
			//exit ();
	}
		else
			$tipoaux="In";
	//echo $tipoaux."/*/";
	$consulta = "SELECT * FROM personal WHERE Empleado_ID=".$Empleado_ID;		
	$result2=$bd->ejecutar($consulta); 
	//echo $consulta."<br>"; 
//	exit ();

	
	if (($row2 = mysqli_fetch_array($result2) ))							
	{	
		$P[0] = $row2["P1"];
		$R[0] = $row2["R1"];
		$P[1] = $row2["P2"];
		$R[1] = $row2["R2"];
		$P[2] = $row2["P3"];
		$R[2] = $row2["R3"];	
	}	
	mysqli_free_result($result2);		
	
	$i=rand(0, 2);		

	$Reg_ID=-1;
	$hora00=0;
	$consulta = "SELECT Reg_ID, Hora_Ingreso AS Hora_Ingreso, Hora_Salida AS Hora_Salida,(ADDTIME(Hora_Ingreso,'0:05:0.00')) as Paso_5_Minutos,  (ADDTIME(Hora_Salida,'0 0:05:0.00')) as Paso_5_Minutos_Salida, Foto_Ingreso, Foto_Salida FROM registro_diario WHERE Empleado_ID=".$Empleado_ID." AND '".$Date_Work."'=Fecha "." AND '".$Actividad_ID."'=Actividad_ID";		
		//echo "Foreman_reg_act_asi_reg:".$consulta."<br>"; 
	$result2=$bd->ejecutar($consulta); 

	
	if (($row2 = mysqli_fetch_array($result2) ))							
	{	
		
		$Reg_ID = $row2["Reg_ID"];
		
		$Hora_Ingreso=$row2["Hora_Ingreso"];
	}
	
	$hora240 = date('Y-m-d H:i:s', strtotime ($HoraStart.' +360 minutes'));
	//$hora240 = (strtotime ($HoraStart.' +360 minutes'));
	//$hora240t = date('H:i:s',$hora240);
	//$hora240=$hora240t;
	//$horaact=$Hora_Igreso;
	//echo date('Y-m-d H:i:s', $hora240)."<br>";
	//echo date('Y-m-d H:i:s', $horaact)."<br>";
	//echo $date = date('Y-m-d H:i:s')."<br>";
	hora_actual($fecha1,$horaact);  // gets fecha1 only 
	$horaact=date('Y-m-d H:i:s');
//	echo $Hora_Ingreso."////".$horaact."///".$hora240."///ddd".$fecha1."date work->".$Date_Work;
//	exit();
			
	
	if ( $Hora_Ingreso !="00:00:00" || $fecha1!=$Date_Work || $horaact>$hora240)
	{
		$Hora_Salida=$row2["Hora_Salida"];
		$_SESSION["Hora_Salida"]=$Hora_Salida;
		$hora1=$Hora_Ingreso;
		
		$Paso_5_Minutos=$row2["Paso_5_Minutos"];
		$Paso_5_Minutos_Salida=$row2["Paso_5_Minutos_Salida"];
		
		$Foto_Ingreso=$row2["Foto_Ingreso"];
		$Foto_Salida=$row2["Foto_Salida"];
		$horaact=$Hora_Igreso;
		hora_actual($fecha1,$horaact);
		$hora60 = date('H:i:s', strtotime ($Hora_Ingreso.' +60 minutes'));	
		
		//echo "**".$Hora_Ingreso.",".$Hora_Salida.",".$Paso_5_Minutos.",".$Foto_Ingreso.",".$Foto_Salida."//".$hora60."-/".$hora60."-/".$fecha1."-/".$Date_Work."<br>";
		//echo $HoraStart."////".$HoraStart2;
		//echo $Hora_Ingreso."////".$horaact."///".$hora240;
		//exit();
				
		if (($Hora_Ingreso=="00:00:00" || $Hora_Ingreso<$hora60 || $Hora_Ingreso="No Check In") && ($horaact < $hora60 && $fecha1==$Date_Work ))
		{
			$Tipo="In";	
			
		 	if ( ($horaact < $hora60 && $fecha1==$Date_Work) )
					{
					echo "<b>You already Check IN</b><br>";
						
					}	
		  		else	
					{
			
					echo "<b>Check In</b><br>";	
					?>
					<div id="div_asistencia_reg">
					<fieldset>
						<!--   <label>Step 1: -Respond the secret question: </label>   -->
                            <label>Step 1: -<strong>Verify</strong> your name and press [Register] bottom: </label>
					<form id="form1" name="form1" method="post" action="">
					  <input type="submit" name="cerrar" id="cerrar" value="Exit/Close" onclick= <?php echo "<script> window.location.href = 'https://www.sof77.com';</script>" ?>/>
					  
					</form>
					<label>  </label>
					<form>
					<?php echo $P[$i]; ?> :<input type="Text" id="Respuesta" value="<?php echo $R[$i]; ?>" size="3" /> 
					<a href="#"><input name="Find" type="button" id="Find" onfocus="Registrar la Hora" onclick="foreman_registro_actividad_asistencia_hora('<?php echo $Tipo; ?>',<?php echo $Empleado_ID; ?>,<?php echo $Reg_ID; ?>,'<?php echo $P[$i]; ?>','<?php echo $R[$i]; ?>');" value="Register <?php echo $Tipo; ?>"  /></a> 		
					</form>
					</fieldset>
					</div>
					<?php
					}
		
			$hora15 = date('H:i:s', strtotime ($Hora_Ingreso.' +15 minutes'));	
			if ( $Foto_Ingreso=="" &&  $horaact < $hora15 )
			{
				$Tipo="In";	
				echo "<b>Register Picture IN</b><br>";			
		?>
				<div id="div_asistencia_reg">            	
					<!--<table>
						<tr>
							<td>
								<div class="webcam-origin" style="margin-top:1em;-moz-border-radius:12px; background-color:#ddd;width:360px;text-align:center;height:260px;padding-top:15px;margin-bottom:1em;">			
									<object  id="iembedflash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="320" height="240">
										<param name="movie" value="include/camcanvas.swf" />
										<param name="quality" value="high" />
										<param name="allowScriptAccess" value="always" />
										<embed  allowScriptAccess="always"  id="embedflash" src="include/camcanvas.swf" quality="high" width="320" height="240" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" mayscript="true"  />
									</object>	
								</div>
                                
							</td>
							<td align="center">														
								<button style="font-size:18px" onClick="setFunction('passLineNormal')">Photo</button>&nbsp;<br /><br /><br />
								<button style="font-size:18px" onClick="foreman_registro_actividad_asistencia_foto('<?php echo $Tipo;?>',<?php echo $Empleado_ID;?>,<?php echo $Reg_ID;?> );">Save</button>
								<div id="Foto" style="display:none"></div>
								
							</td>
							<td>		
								<div class="webcam-target" style="margin-top:1em;-moz-border-radius:12px; background-color:#ddd;width:360px;text-align:center;height:260px;padding-top:15px;;">
								   <canvas  id="canvas" width="320" height="240"></canvas>
								</div>	
							</td>
						</tr>
					</table>
					<img src="images/spacer.gif" onload="initCanvas(320,240);" />-->                   
                    <form enctype="multipart/form-data" id="formuploadajax" method="post">           
                        <input  type="file" id="archivo1" name="archivo1" title="Take Pic"  accept="image/*" capture="camera" style="display:none;" />
					    <img src="images/camara.png" onclick="document.getElementById('archivo1').click();document.getElementById('mensaje').style.display = 'block';" ><br>
                        
                        <div id="mensaje" style="display:none"> 
                            <input type="button" name="Boton_Subir" value="Upload PIC" onClick="subir_foto_form();"/>        
                        </div>
                        <input type="hidden" name="Tipo" value="<?php echo $Tipo;?>">
                        <input type="hidden" name="Empleado_ID" value="<?php echo $Empleado_ID;?>">
                        <input type="hidden" name="Reg_ID" value="<?php echo $Reg_ID;?>">
                    </form>
                    	<img src="images/spacer.gif" onload="document.getElementById('archivo1').click();"> 
                  
				</div>
		<?php
			}
			
		}
			
			else
			{	
				$Tipo="Out";
				$horaact=$Hora_Salida;
				hora_actual($fecha1,$horaact);
				$hora15 = date('H:i:s', strtotime ($Hora_Salida.' +15 minutes'));
			//	echo "fecha hoy:".$fecha1."Fecha work".$Date_Work."  Hora Actual:".$horaact."Horasal + 60m:".$hora15."Hora Salida:".$Hora_Salida."<br>";
			
			
				
				//if ($Hora_Salida=="00:00:00" || $Hora_Salida=="No Check Out" || $Hora_Salida=="00:00:01" )
				//{
					//echo "//// entro al if//";
					
					/////////////////
					   $TotalHorasReg=0;
					   $horastext="";
					   $CheckFor="";
						$consulta = "SELECT Horas_Contract, Verificado_Foreman from registro_diario_actividad  WHERE Reg_ID=".$Reg_ID;
							//echo "tt66tt:".$consulta;
			
						$result44=$bd->ejecutar($consulta); 
						
						while ($row44 = mysqli_fetch_array($result44)) 
													
						{				
							$TotalHorasReg=$TotalHorasReg+$row44["Total_Contract"];
							if ($CheckFor!="Yes" && $row44["Verificado_Foreman"]==1 )
							{
								$CheckFor="Yes";
								}						
														
						}
						mysqli_free_result($result44);
						if ($TotalHorasReg>0)
						{
						$horastext="The foreman asigned you:".$TotalHorasReg." Hours";
						}
					//////////////////
				
				 	if ( (($horaact > $hora15 && $fecha1==$Date_Work) || $CheckFor=="Yes") && $Hora_Salida!="00:00:00" )
						{
						echo "<b>Your register TIME Out is completed</b><br>";
						echo $horastext."<br>";
							
						}
					
					else
				
					{
						
						echo "<b>Register Time OUT and Alocate Hours /</b><br>";				
					?>
						<div id="div_asistencia_reg">
						<fieldset>
							<!--   <label>Step 1: -Respond the secret question: </label>   -->
                            <label>Step 1: <strong>-Verify</strong> your name and press [Register] bottom: </label> 
							<form>
								<?php echo $P[$i]; ?> :<input type="Text" id="Respuesta" value="<?php echo $R[$i] ?>" size="3" />
							  <a href="#"><input type="button" value="Register <?php echo $Tipo; ?>" ID="Find" Name="Find" onClick="foreman_registro_actividad_asistencia_hora('<?php echo $Tipo; ?>',<?php echo $Empleado_ID; ?>,<?php echo $Reg_ID; ?>,'<?php echo $P[$i]; ?>','<?php echo $R[$i]; ?>');"  /></a> 
					
							</form>
						</fieldset>
					</div>
					<div id ="Div_Actividad_Personal_Information_x">
					</div>
					<?php
				if (!($Paso_5_Minutos))
					{
						echo "<b>Take Picture OUT</b><br>";
				?>
					<div id="div_asistencia_reg">
                       
                        <form enctype="multipart/form-data" id="formuploadajax" method="post">           
                            <input  type="file" id="archivo1" name="archivo1" title="Take Pic"  accept="image/*" capture="camera" style="display:none;" />
					  		<img src="images/camara.png" onclick="document.getElementById('archivo1').click();document.getElementById('mensaje').style.display = 'block';" ><br>
                        
                        
                            <div id="mensaje" style="display:none"> 
                                <input type="button" name="Boton_Subir" value="Upload PIC" onClick="subir_foto_form();"/>        
                            </div>
                            <input type="hidden" name="Tipo" value="<?php echo $Tipo;?>">
                            <input type="hidden" name="Empleado_ID" value="<?php echo $Empleado_ID;?>">
                            <input type="hidden" name="Reg_ID" value="<?php echo $Reg_ID;?>">
                        </form>
                                        
                        <img src="images/spacer.gif" onload="document.getElementById('archivo1').click();">
					</div>
	
    				<div id ="Div_Actividad_Personal_Information_x">
	    
    				</div>
			<?php
					//}
					
					//else
					//{
						//echo "  Llego al lugar :  ";
						echo "<div id ='Div_Actividad_Personal_Information_x'></div>";
						$Pro_ID=$_SESSION["Pro_ID"];	
						echo "<img src='images/spacer.gif' onload='empleado_registro_actividad_detalle_x(".$Reg_ID.", ".$Pro_ID.");' />";
					}
				}
			} 
		}
	
	else
	{
		$Tipo="In";	
		echo "<b>Check In </b><br>";	
	?>
<div id="div_asistencia_reg">
			<fieldset>
					<!--   <label>Step 1: -Respond the secret question: </label>   -->
                            <label>Step 1:/<strong>Verify </strong>your name and press [Register] bottom: </label>
				<form>
					<?php echo $P[$i]; ?> :<input type="Text" id="Respuesta" value="<?php echo $R[$i] ?>" size="3" />
				  <a href="#"><input type="button" value="Register <?php echo $Tipo; ?>" ID="Find" Name="Find" onClick="foreman_registro_actividad_asistencia_hora('<?php echo $Tipo; ?>',<?php echo $Empleado_ID; ?>,<?php echo $Reg_ID; ?>,'<?php echo $P[$i]; ?>','<?php echo $R[$i]; ?>');"  /></a> 		
				</form>
			</fieldset>
		</div>
<p>
  <?php
	}
	mysqli_free_result($result2);	
	
	require('Library/Close_Conexion.php');	
?>

