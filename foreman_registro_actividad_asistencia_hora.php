<?php	 		

	session_name("Administrador");
	session_start();
	
	//include ("address.php");
	include ("hora.php");
	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	
		
	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');		
	
			         					  	
/*//  
	function hora_va(&$fecha,&$horas)
	{
	$utctime=gmdate("H:i:s",time());
	$horas = date('H:i:s', strtotime ($utctime.' -300 minutes'));
	//echo "//".$horas."//";
	$f1=date('d/m/Y', '03/11/2018');		
	$f2=date('d/m/Y', '10/03/2019');
//	echo $f1."///--/".$f2;
	if ($fecha > $f1 && $fecha < $f2)
				{
					$horas = date('H:i:s', strtotime ($utctime.' -300 minutes'));
	//echo "//".$horas."//";
				}
	}
			
///*/
	$Empleado_ID=$_GET["Empleado_ID"];
	$Usuario_Pass=$_SESSION["PassAcc"];
	$Actividad_ID=$_SESSION["Actividad_ID"];
	$Tipo=$_GET["Tipo"];
	$Reg_ID=$_GET["Reg_ID"];
	$P=$_GET["P"];
	$R=$_GET["R"];
	$RU=$_GET["RU"];
	$Latitud=$_GET["Latitud"];
	$Longitud=$_GET["Longitud"];
	$Date_Work=$_SESSION["Date_Work"];		
	$Date_Hoy= date('Y-m-d');
	$Hora_Real =gmdate("H:i:s",time());
	hora_actual($Date_Work,$Hora_Real);
	
	//echo "forregactasihor Hora_Real:".$Hora_Real."Date:".$Date_Work." Tipo:".$Tipo;

	if ($R==$RU)
	{
		if ($Tipo=="In")
		{			
			$consulta = "SELECT * FROM registro_diario WHERE Empleado_ID=".$Empleado_ID." AND '".$Date_Work."'=Fecha "." AND '".$Actividad_ID."'=Actividad_ID";		
			$result2=$bd->ejecutar($consulta); 
			//echo "1st:".$consulta."<br>"; 			
			if ($row2 = mysqli_fetch_array($result2) )							
			{	
				$Reg_ID=$row2["Reg_ID"];
				hora_actual($Date_Work,$Hora_Real);
				$strSQL = "UPDATE registro_diario SET Hora_Ingreso='".$Hora_Real."', Clave_Digitada_In='".$RU."', Pregunta_IN='".$P."', Latitud_Ingreso='".$Latitud."', Longitud_Ingreso='".$Longitud."',Fecha_Hingreso='".$Date_Hoy."',Usuario_Pass='".$Usuario_Pass."' WHERE Reg_ID=".$Reg_ID." AND '".$Actividad_ID."'=Actividad_ID";
				//echo "FORREGACTASISHOR:".$strSQL."<br>".$Actividad_ID;	
				//exit();
				$res1=$bd->ejecutar($strSQL);  		
				if ($res1)
				{
					echo "Check In done! <br>";
					echo  "Take yourself a picture and upload <br>";
					$consulta = "SELECT Reg_ID, Hora_Ingreso FROM registro_diario WHERE Empleado_ID=".$Empleado_ID." AND '".$Date_Work."'=Fecha "." AND '".$Actividad_ID."'=Actividad_ID";	
					//echo "FORREGACTASISHOR 2:". $consulta;	
					$result77=$bd->ejecutar($consulta); 
					
					if (($row2 = mysqli_fetch_array($result77) ))							
					{				
						$Hora_Ingreso=$row2["Hora_Ingreso"];
						$Reg_ID=$row2["Reg_ID"];
						echo "<img src='images/spacer.gif' onload='$(\"#Div_Hora_IN_".$Empleado_ID."\").html(\"".$Hora_Ingreso."\");' />";
					}
					mysqli_free_result($result77);		
				}
				mysqli_free_result($result2);				
			}
			else
			{
				
				$strSQL = "INSERT INTO registro_diario (Empleado_ID, Hora_Ingreso, Fecha,Clave_Digitada_In,Pregunta_IN,Latitud_Ingreso,Longitud_Ingreso, Pro_ID,Actividad_ID,Fecha_Hingreso) ";	
				//$strSQL = $strSQL . " values (".$Empleado_ID.",CURTIME(), CURDATE())";	
		$strSQL = $strSQL . " values (".$Empleado_ID.",'".$Hora_Real."', '".$Date_Work."','".$RU."','".$P."','".$Latitud."','".$Longitud."',".$_SESSION["Pro_ID"].",".$Actividad_ID.",'".$Date_Hoy."')";
		
		
		//		$strSQL = $strSQL . " values (".$Empleado_ID.",ADDTIME(UTC_TIME(),".$Hora_Real."), '".$Date_Work."','".$RU."','".$P."','".$Latitud."','".$Longitud."',".$_SESSION["Pro_ID"].",".$Actividad_ID.")";
				//echo "Your are at:".$Latitud.",".$Longitud."<br>";
				//echo "   //FORREGACTASISHOR 3:".$strSQL;				
				$result2=$bd->ejecutar($strSQL); 
				
				if ($result2)
				{
					echo "Check In OK ! <br>";
					echo  "Take yourself a picture and upload <br>";
					
					$consulta = "SELECT Reg_ID, Hora_Ingreso AS Hora_Ingreso FROM registro_diario WHERE Empleado_ID=".$Empleado_ID." AND '".$Date_Work."'=Fecha "." AND '".$Actividad_ID."'=Actividad_ID";	
					//echo "FORREGACTASISHOR 4:". $consulta;	
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
			
		}
		else
		{
			if ($Tipo=="Out")
			{
				
				
				$Hora_Salida=$_SESSION["Hora_Salida"];	
				hora_actual($fecha1,$horaact);
				$hora10 = date('H:i:s', strtotime ($Hora_Salida.' +10 minutes'));
				//echo "Hora act".$hora_actual."hora +10".$horaact;
				if ($horaact > $hora10 || $Hora_Salida="00:00:00" )
				{
				   //echo "Entro en el update ";
				$strSQL = "UPDATE registro_diario SET Hora_Salida='".$Hora_Real."', Clave_Digitada_Out='".$RU."', Pregunta_Out='".$P."' , Latitud_Salida='".$Latitud."', Longitud_Salida='".$Longitud."',Fecha_Hsalida='".$Date_Hoy."',Usuario_Pass='".$Usuario_Pass."' WHERE Reg_ID=".$Reg_ID." AND '".$Actividad_ID."'=Actividad_ID";
				//echo $strSQL;	
				$res1=$bd->ejecutar($strSQL); 
				$Hora_Salida=$Hora_Real;
				echo "<img src='images/spacer.gif' onload='$(\"#Div_Hora_OUT_".$Empleado_ID."\").html(\"".$Hora_Salida."\");' />";
				}
				   else
				   {
					 echo "YOU ALREADY CHECK OUT!";
					   }
				
				
				//echo "Your are at:".$Latitud.",".$Longitud."<br>";
								
				//echo "  //FORREGACTASISHOR 4.1:". $strSQL;
				/*$address= getaddress($Latitud,$Longitud);
				if($address)
				  {
				    echo $address;
				  }
				  else
				  {
				    echo "Not found address";
				  } */

				if ($res1)
				{
					echo "Check Out Succesful <br>";
					echo "Take yoursel a picture and upload <br>";
					
					$consulta = "SELECT Hora_Salida AS Hora_Salida  FROM registro_diario WHERE Empleado_ID=".$Empleado_ID." AND '".$Date_Work."'=Fecha "." AND '".$Actividad_ID."'=Actividad_ID";
					//echo "FORREGACTASISHOR 5:".$consulta;			
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
					<!--<div class="webcam-origin" style="margin-top:1em;-moz-border-radius:12px; background-color:#ddd;width:360px;text-align:center;height:260px;padding-top:15px;margin-bottom:1em;">			
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
					<input type="text" id="Foto" name="Foto" />		
				</td>
				<td>		
					<div class="webcam-target" style="margin-top:1em;-moz-border-radius:12px; background-color:#ddd;width:360px;text-align:center;height:260px;padding-top:15px;;">
					   <canvas  id="canvas" width="320" height="240"></canvas>
					</div>	
				</td>
			</tr>
		</table>
		<img src="images/spacer.gif" onload="initCanvas(320,240);" />-->
        <div id="div_asistencia_reg">
            <form enctype="multipart/form-data" id="formuploadajax" method="post">            
                
                <input  type="file" id="archivo1" name="archivo1" title="Take Pic"  accept="image/*" capture="camera" style="display:none;" />
                <img src="images/camara.png" width="90" height="90" onclick="document.getElementById('archivo1').click();document.getElementById('mensaje').style.display = 'block';" ><br>            
                
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
	else
	{
		echo "Incorrect Answer";
	}	

	require('Library/Close_Conexion.php');	
?>


