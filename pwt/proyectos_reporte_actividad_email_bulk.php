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
	$vfrom_date=$_REQUEST["vfrom_date"];
	$vto_date=$_REQUEST["vto_date"];
	$costcode=$_REQUEST["costcode"];
	$timesheet=$_REQUEST["timesheet"];

?>
	<input id="btn_send_email" type="button" value="----------------Send schedule email to everyone separately Except jobs with number >899 " onclick="Proyectos_Repoprte_Actividad_email_bulk_send();" />
	<form id="Form_Proyecto_Pedidos_Email_Send">
		<input type="hidden" name="vfrom_date" id="vfrom_date" value="<?php echo $vfrom_date;?>" />
		<input type="hidden" name="vto_date" id="vto_date" value="<?php echo $vto_date;?>" />
        <input type="hidden" name="costcode" id="costcode" value="<?php echo $costcode;?>" />
		<input type="hidden" name="timesheet" id="timesheet" value="<?php echo $timesheet;?>" />        
        
		<table>
			<tr>
				<td><b>Subject:</b></td>
				<td><input type="text" id="Subject" name="Subject" value="Schedule for :"   size="50" /></td>
			</tr>
            <tr>
				<td height="41"><b>Note:</b></td>
			  <td><textarea name="Note" cols="80" id="Note">Notes:</textarea></td>
			</tr>

			<!--<tr>

				<td><b>To:</b></td>

				<td><input type="text" id="To" name="To" value="<?php echo $email;?>"  size="30"/></td>

			</tr>

			<tr>

				<td><b>Cc:</b></td>

				<td><input type="text" id="Cc" name="Cc" value="<?php echo $email_pwt;?>"   size="30" /></td>

			</tr>-->
		</table>
	</form>    
	<div id="Res_envio">
	<textarea name="wysiwyg" id="wysiwyg" rows="30" cols="110">	
	</textarea>	
	</div>
	<div id="Div_Reporte_Email" style="display:none">
<?php
			

	function encabezado($f1,$f2)
	{	
		$f1t=FormatDateTime($f1, 8);
		$f2t=FormatDateTime($f2, 8);
		$titt="// Schedule for ".$f1t;
		if ($f1<>$f2)
		{ 
			$titt="Schedule from ".$f1t." to ".$f2t;
		}
		//echo $titt;
		//echo "<p><h3>Schedule for </h3> <b>from:".$f1." to:".$f2."</b></p>";
		echo "<p><h3>  </h3> <b>".$titt."</b></p>";		
	}
	function encabezado2()
	{
		echo "<b>Employees Off:: </b>";
		echo " ";
	}

	function encabezado3()
	{
		echo "<b>Jobs Coming Up::</b>";
	}			

	function per_sin_act($f1,$f2,$pbd)
			//DESCRIPCION:PERSONAL SIN ACTIVIDAD
			{
				if($f1==$f2)
				{	
					encabezado2();
					//echo "<p> $f1, $f2 ";	
					$sql = "SELECT p.* FROM personal p WHERE  p.Emp_ID=6 AND (p.Aux5 ='F' OR p.Aux5='FB'OR p.Aux5 is NULL) AND (p.Empleado_ID NOT IN (SELECT p1.Empleado_ID FROM personal p1 
					INNER JOIN actividad_personal ap ON ap.Empleado_ID=p1.Empleado_ID 
					INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID 
					WHERE a.Fecha='".$f1."')) ORDER BY p.Cargo,p.Nick_Name ";
					//echo $sql;

					$result2=$pbd->ejecutar($sql);	

					if(mysqli_num_rows($result2)>0) 
					{
						$bandera=1;
						$bandera_2=1;
						$num=1;	
						while($row=mysqli_fetch_array($result2))
						{
							// DETALLE
//"<p>".$row2['Codigo']." / ",$row2['Nombre']." / ".$Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code." / ".$row2['Fecha_Inicio']."</p>"

							//********************************************************************
							$nickt=$num.":".$row['Nick_Name'];
							$num++;
							$auxt=$row['Aux1'];
							if ($auxt==NULL)
							{$nickt=$nickt." ";}
							else
							{ 
								//$nickt=$nickt." ".$row['Aux1'];
							}
							
							if ($auxt==NULL)
							{
								echo $nickt.", ";
							}
							
							else
							{ 
								//echo "<p>".$nickt."</p>";
								echo $nickt.",";
							}						
						}
					}
				}
			}
			//************************************************************************************************

	function pro_ult_sem($pbd)
			//*********************************************
			//DESCRIPCION: pro_ult_sem PRO_ YECTOS QUE SE VAN HA EJECUTAR LAS DOS ULT_ IMAS SEM_ ANA
			//********************************************

			{	

				encabezado3();					

				$fecha1= date('Y-m-d');

				$fecha2= date('Y-m-d', strtotime('+365 day'));

				$vfrom_date=$_REQUEST["vfrom_date"];

				$vdia=substr($vfrom_date,3,2);

				$vmes=substr($vfrom_date,0,2);

				$vano=substr($vfrom_date,8,2);

				$af1="20".$vano."-".$vmes."-" .$vdia;
				$conta=0;
				
				//echo $af1."  af1 ".$fecha1." Fecha1"."<br>";

				$sql="select * from proyectos  where Estatus_ID=2 and Fecha_Inicio> '2020-01-01' ORDER BY Fecha_Inicio asc";
				// and fecha_inicio<='$fecha2'";
				//echo $sql;
				$result2=$pbd->ejecutar($sql);	
				if(mysqli_num_rows($result2)>0) 		 
				{		
					while($row2=mysqli_fetch_array($result2))
					{	
						//********************************************************************

						// DETALLE	

						$Estado = $row2["Estado"];	
						$Ciudad = $row2["Ciudad"];	
						$Zip_Code = $row2["Zip_Code"];			
						$Calle = $row2["Calle"];
						$Numero=$row2["Numero"];
						$fecini=$row2["Fecha_Inicio"];
						$fecfin=$row2["Fecha_Fin"];
						$vdia=substr($fecini,8,2);
						$vmes=substr($fecini,5,2);
						$vano=substr($fecini,0,4);
						$fecini=$vmes."-" .$vdia."-".$vano;
						$Fechat=FormatDateTime($row2['Fecha_Inicio'],8);
						$Fechaf=FormatDateTime($row2['Fecha_Fin'],8);
						$conta++;
						echo "<p>".$conta.": Start Date:".$Fechat." End Date:".$Fechaf." // ".$row2['Nombre']." / ".$Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code."  Job#:".$row2['Codigo']."</p>";

					}

				}

			}

//************************************************************************************************

			$vdia=substr($vfrom_date,3,2);
			$vmes=substr($vfrom_date,0,2);
			$vano=substr($vfrom_date,8,2);
			$af1="20".$vano."-".$vmes."-" .$vdia;
			$vdia=substr($vto_date,3,2);
			$vmes=substr($vto_date,0,2);
			$vano=substr($vto_date,8,2);
			$af2="20".$vano."-".$vmes."-" .$vdia;

			$sql = "select	proyectos.codigo, proyectos.Emp_ID, 

			proyectos.nombre,

			proyectos.calle,

			proyectos.ciudad,

			proyectos.estado,

			proyectos.zip_code,

			proyectos.coordinador_obra_id,

			proyectos.Foreman_ID,
			proyectos.Lead_ID,

			proyectos.Coordinador_ID,

			proyectos.Estatus_ID,

			actividades.Aux1,

			actividades.Aux2,

			actividades.Aux3,

			actividades.Aux4,	

			actividades.Fecha,

			actividades.hora,

			actividades.descripcion,

			actividades.actividad_id,	

			tipo_actividad.actividad_nombre,

			empresas.Codigo 

			from tipo_actividad inner join 

			(actividades inner join proyectos on actividades.pro_id=proyectos.pro_id) on tipo_actividad.tipo_actividad_id=actividades.tipo_actividad_id inner join empresas on proyectos.Emp_ID=empresas.Emp_ID

			where actividades.fecha between '$af1' and '$af2' order by fecha,nombre,hora";

			 //Coordinador_ID DESC,

//echo $sql;

			$result=$bd->ejecutar($sql);
		  	// titulo del reporte
			encabezado($af1,$af2);	

			if(mysqli_num_rows($result)>0) 
			{	
				$bandera=1;	
				$bandera_2=1;
				$conta=1;
				while($row=mysqli_fetch_array($result))
				{	
					///*****************************************************
					//*BUSQUEDA DE PERSONAL DEL PROYECTO
					$sql="select personal.nombre,personal.Nick_Name  from personal inner join 
					(actividad_personal inner join actividades on actividad_personal.actividad_id=actividades.actividad_id)
					on personal.empleado_id=actividad_personal.empleado_id where actividades.actividad_id=".$row["actividad_id"].  " ORDER BY personal.Cargo,personal.Nick_Name";
					$result2=$bd->ejecutar($sql);
					$vempleados="";		

					if(mysqli_num_rows($result2)>0)
					{
						$vempleados="";
						$contemp=1;
						while($row2=mysqli_fetch_array($result2))
						{	
							if($vempleados=="")
							{
								$vempleados=$contemp.":".$row2["Nick_Name"];
							}
							else
							{
								$vempleados=$vempleados.", ".$contemp.":".$row2["Nick_Name"];
							}
							$contemp++;
						}
						
					}					

					$sql2="select * from personal where Empleado_ID=".$row['coordinador_obra_id'];
					$result3=$bd->ejecutar($sql2);	
					if(mysqli_num_rows($result3)>0) 
					{
					  $row3=mysqli_fetch_array($result3);
					  $vcontacto=$row3['Nombre']." ".$row3['Apellido_Paterno']." ".$row3['Apellido_Materno']." ".$row3['Celular'];
					  $vcontacto="/";
					}		

					$sql2="select * from personal where Empleado_ID=".$row['Foreman_ID'];
					$result3=$bd->ejecutar($sql2);	
					if(mysqli_num_rows($result3)>0) 
					{
					  $row3=mysqli_fetch_array($result3);
					  $pwtforeman="Foreman:".$row3['Nick_Name'].'  '.$row3['Celular'];
					}
					if ($row['Lead_ID'] > 0)
						{
						$sql2="select * from personal where Empleado_ID=".$row['Lead_ID'];
						$result3=$bd->ejecutar($sql2);	
						if(mysqli_num_rows($result3)>0) 
						{
						  $row3=mysqli_fetch_array($result3);
						  $pwtlead="Lead:".$row3['Nick_Name'].'  '.$row3['Celular'];
						  $pwtforeman=$pwtforeman." or ".$pwtlead;
						}
						}
					 else
					 	$pwtlead=0;
										
					$sql2="select * from personal where Empleado_ID=".$row['Coordinador_ID'];
					$result3=$bd->ejecutar($sql2);	
					$pwtsuper=" ";

					if(mysqli_num_rows($result3)>0) 	
					{
					  $row3=mysqli_fetch_array($result3);
					  $pwtsuper=$row3['Nick_Name'];
					}
					//********************************************************************
					// DETALLE
					//********************************************************************

						$vfrom_date=$_REQUEST["vfrom_date"];	
						$vto_date=$_REQUEST["vto_date"];	
						$Fechat=" ";	
						$Aux22=" ";	
						$Estatus="";	
						if ($vfrom_date<>$vto_date)	
						{	
							$Fechat=FormatDateTime($row['Fecha'],8)."/";		
							$Aux22="-/".$row['Aux1']."/".$row['Aux2']."/".$row['Aux3']."/".$row['Aux4']."/";		
							$Estatus=$row['Estatus_ID']." (3=in proces 2=P.list 5=done 4=closed)/";		
						}
						
						$numjob=substr($row['codigo'],0,3);
						$contax=$conta;
						if ($numjob>799)
							$conta='-';
						
						if ($numjob>999)
							{
							$nombreaux=substr($row['nombre'],12,40);
							echo "- ".$nombreaux.": ".$vempleados."<br><br>";
							}
						else
							if ($row['actividad_nombre']<>'Meeting')
								echo $conta.": ".$Estatus.$Fechat." (".$row['Codigo'].") ".$row['codigo']." ".$row['nombre']." Add:".$row['calle'].",".$row['ciudad'].",".$row['estado'].",".$row['zip_code']." GC-Contact:".$vcontacto."/PWT-Super:".$pwtsuper.",PWT ".$pwtforeman." / ".( date("g:i a", strtotime($row['hora'])) )."  /".$vempleados." / ".$row['actividad_nombre']." ".$row['descripcion'].$Aux22."<br><br><br>";
							else
								echo $conta.":*".$Fechat." (".$row['Codigo'].") ".$row['codigo']." ".$row['nombre']." Add:".$row['calle'].",".$row['ciudad'].",".$row['estado'].",".$row['zip_code']." GC-Contact:".$vcontacto." ;/PWT-Super:".$pwtsuper.", PWT ".$pwtforeman." ;/ ".( date("g:i a", strtotime($row['hora'])) )."  /".$vempleados." / ".$row['actividad_nombre']." ".$row['descripcion'].$Aux22."<br><br><br>";
							
						$conta=$contax;						
							
						$conta++;

					}	
			}
			echo "<p>";	
			per_sin_act($af1,$af2,$bd);
			echo "<p>";	
			pro_ult_sem($bd);
?>	
	</div>
	<img src='images/spacer.gif' onload='Proyectos_Reporte_Actividad_Copiar();' />	

<?php	

	require('Library/Close_Conexion.php');

?>