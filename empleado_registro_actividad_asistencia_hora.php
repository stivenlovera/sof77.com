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
	$Tipo=$_GET["Tipo"];
	$Reg_ID=$_GET["Reg_ID"];
	$P=$_GET["P"];
	$R=$_GET["R"];
	$RU=$_GET["RU"];
	$Date_Work=$_SESSION["Date_Work"];		
	
	if ($R==$RU)
	{
		if ($Tipo=="In")
		{
			$strSQL = "INSERT INTO registro_diario (Empleado_ID, Hora_Ingreso, Fecha, Pro_ID) ";	
			$strSQL = $strSQL . " values (".$Empleado_ID.",UTC_TIME(), '".$Date_Work."',".$_SESSION["Pro_ID"].")";	
			$result2=$bd->ejecutar($strSQL); 
			//echo $strSQL;
			if ($result2)
			{
				echo "Registro de Ingreso Satisfactorio.";
				
				$consulta = "SELECT Reg_ID, ADDTIME(Hora_Ingreso, '-04:00:00.000') as Hora_Ingreso FROM registro_diario WHERE Empleado_ID=".$Empleado_ID." AND '".$Date_Work."'=Fecha ";	
				//echo $consulta;	
				$result77=$bd->ejecutar($consulta); 
				if (($row2 = mysqli_fetch_array($result77) ))							
				{				
					$Hora_Ingreso=$row2["Hora_Ingreso"];
					$Reg_ID=$row2["Reg_ID"];
					echo "<img src='images/spacer.gif' onload='$(\"#Div_Hora_IN_".$Empleado_ID."\").html(\"".$Hora_Ingreso."\");' />";
				}
				mysqli_free_result($result77);								
			}
			else
				echo "Error en Registro";
		}
		else
		{
			if ($Tipo=="Out")
			{
				$strSQL = "UPDATE registro_diario SET Hora_Salida=UTC_TIME() WHERE Reg_ID=".$Reg_ID;	
				$res1=$bd->ejecutar($strSQL);  		
			
				if ($res1)
				{
					echo "Registro sw Salida Satisfactorio";
					
					$consulta = "SELECT Hora_Salida FROM registro_diario WHERE Empleado_ID=".$Empleado_ID." AND '".$Date_Work."'=Fecha ";
					//echo $consulta;			
					$result77=$bd->ejecutar($consulta); 
					if (($row2 = mysqli_fetch_array($result77) ))							
					{				
						$Hora_Salida=$row2["Hora_Salida"];
						echo "<img src='images/spacer.gif' onload='$(\"#Div_Hora_OUT_".$Empleado_ID."\").html(\"".$Hora_Salida."\");' />";
					}
					mysqli_free_result($result77);								
				}			
			}
		}
?>
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
<?php		
	}
	else
	{
		echo "Respuesa Incorrecta";
	}	

	require('Library/Close_Conexion.php');	
?>
