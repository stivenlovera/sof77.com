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

	$Empleado_ID=$_GET["Empleado_ID"];
	$Date_Work=$_SESSION["Date_Work"];	
	
	$consulta = "SELECT * FROM personal WHERE Empleado_ID=".$Empleado_ID;		
	$result2=$bd->ejecutar($consulta); 
	//echo $consulta."<br>"; 
	
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
	
	$consulta = "SELECT *,ADDTIME(Hora_Ingreso, '-04:00:00.000') as Hora_Ingreso, ADDTIME(Hora_Salida, '-04:00:00.000') as Hora_Salida, (ADDTIME(Hora_Ingreso,'0 0:05:0.00')<UTC_TIME()) as Paso_5_Minutos FROM registro_diario WHERE Empleado_ID=".$Empleado_ID." AND '".$Date_Work."'=Fecha ";		
	$result2=$bd->ejecutar($consulta); 
	//echo $consulta."<br>"; 
	
	if (($row2 = mysqli_fetch_array($result2) ))							
	{	
		$Reg_ID = $row2["Reg_ID"];
		
		$Hora_Ingreso=$row2["Hora_Ingreso"];
		$Hora_Salida=$row2["Hora_Salida"];
		
		$Paso_5_Minutos=$row2["Paso_5_Minutos"];
		
		$Foto_Ingreso=$row2["Foto_Ingreso"];
		$Foto_Salida=$row2["Foto_Salida"];
		if ( ($Hora_Ingreso!="-04:00:00") || ($Hora_Ingreso!="00:00:00") )
		{
			if ( ($Foto_Ingreso=="") && (!($Paso_5_Minutos)) )
			{
				$Tipo="In";	
				echo "<b>Register Picture IN</b><br>";			
		?>
				<div id="div_asistencia_reg">            	
					<table>
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
								<button onClick="setFunction('passLineNormal')">Photo</button>&nbsp;<br />
								<button onClick="foreman_registro_actividad_asistencia_foto('<?php echo $Tipo;?>',<?php echo $Empleado_ID;?>,<?php echo $Reg_ID;?> );">Save</button>
								<div id="Foto" style="display:none"></div>
								<!--<input type="text" id="Foto" name="Foto" />		-->
							</td>
							<td>		
								<div class="webcam-target" style="margin-top:1em;-moz-border-radius:12px; background-color:#ddd;width:360px;text-align:center;height:260px;padding-top:15px;;">
								   <canvas  id="canvas" width="320" height="240"></canvas>
								</div>	
							</td>
						</tr>
					</table>
					<img src="images/spacer.gif" onload="initCanvas(320,240);" />
				</div>
		<?php
			}
			else
			{	
				$Tipo="Out";
				if ($Hora_Salida=="-04:00:00")
				{
						
					echo "<b>Register Time OUT</b><br>";				
			?>
					<div id="div_asistencia_reg">
						<fieldset>
							<label>Step 1: Question Secret </label>
							<form>
								<?php echo $P[$i]; ?> :<input type="Text" id="Respuesta" />
								 <a href="#"><input type="button" value="Register <?php echo $Tipo; ?>" ID="Find" Name="Find" onClick="foreman_registro_actividad_asistencia_hora('<?php echo $Tipo; ?>',<?php echo $Empleado_ID; ?>,<?php echo $Reg_ID; ?>,'<?php echo $P[$i]; ?>','<?php echo $R[$i]; ?>');"  /></a> 
					
							</form>
						</fieldset>
					</div>
					<div id ="Div_Actividad_Personal_Information_x">
					</div>
	<?php
				}
				else
				{
						echo "<b>Register Picture OUT</b><br>";
				?>
					<div id="div_asistencia_reg">
						<table>
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
									<button onClick="setFunction('passLineNormal')">Photo</button>&nbsp;<br />							
									<button onClick="foreman_registro_actividad_asistencia_foto('<?php echo $Tipo;?>',<?php echo $Empleado_ID;?>,<?php echo $Reg_ID;?> );">Save</button>
									<div id="Foto" style="display:none"></div>
									<!--<input type="text" id="Foto" name="Foto" />		-->
								</td>
								<td>		
									<div class="webcam-target" style="margin-top:1em;-moz-border-radius:12px; background-color:#ddd;width:360px;text-align:center;height:260px;padding-top:15px;;">
									   <canvas  id="canvas" width="320" height="240"></canvas>
									</div>	
								</td>
							</tr>
						</table>
						<img src="images/spacer.gif" onload="initCanvas(320,240);" />
					</div>
					<div id ="Div_Actividad_Personal_Information_x">
					</div>
			<?php
					
				}
			}
		}
		else
		{
			$Tipo="In";	
			echo "<b>Register Time IN</b><br>";	
		?>
			<div id="div_asistencia_reg">
				<fieldset>
					<label>Step 1: Question Secret </label>
					<form>
						<?php echo $P[$i]; ?> :<input type="Text" id="Respuesta" />
						 <a href="#"><input type="button" value="Register <?php echo $Tipo; ?>" ID="Find" Name="Find" onClick="foreman_registro_actividad_asistencia_hora('<?php echo $Tipo; ?>',<?php echo $Empleado_ID; ?>,<?php echo $Reg_ID; ?>,'<?php echo $P[$i]; ?>','<?php echo $R[$i]; ?>');"  /></a> 		
					</form>
				</fieldset>
			</div>
	<?php
		}
	}
	else
	{
		$Tipo="In";	
		echo "<b>Register Time IN</b><br>";	
	?>
		<div id="div_asistencia_reg">
			<fieldset>
				<label>Step 1: Question Secret </label>
				<form>
					<?php echo $P[$i]; ?> :<input type="Text" id="Respuesta" />
					 <a href="#"><input type="button" value="Register <?php echo $Tipo; ?>" ID="Find" Name="Find" onClick="foreman_registro_actividad_asistencia_hora('<?php echo $Tipo; ?>',<?php echo $Empleado_ID; ?>,<?php echo $Reg_ID; ?>,'<?php echo $P[$i]; ?>','<?php echo $R[$i]; ?>');"  /></a> 		
				</form>
			</fieldset>
		</div>
<?php
	}
	mysqli_free_result($result2);	
	
	require('Library/Close_Conexion.php');	
?>