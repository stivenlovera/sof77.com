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
					
	$Subject=$_POST['Subject'];
	$Note=$_POST['Note'];
	
	$vfrom_date=$_POST["vfrom_date"];
	$vto_date=$_POST["vto_date"];
	$costcode=$_POST["costcode"];
	$timesheet=$_POST["timesheet"];
	//echo "Sending remainder email to complete cost codes:".$costcode."<br>";
	//exit ();
	$cadena="HOLa XXXXXXXXXXXXXXXXXXXXXX";
	
	$To="mario.olmos@precisionwall.com";
	$Cc="mario.olmos@precisionwall.com";
	$ToShedule="mario.olmos@precisionwall.com";
	//$Cc="cristian.frias.s@gmail.com";
	//$Contenido=$_POST['Contenido'];			
 		
	function enviar_email($Contenido,$Subject,$To,$Cc)
	{
		$cuerpo = '
		<html> 
			<head> 
			   <title>Order</title> 
			</head> 
			<body>'.$Contenido.'</body>
		</html>';
		
		$headers  = "MIME-Version: 1.0\r\n";  
		//$headers .= "From: info@precisionwall.com\n"; 
		$headers .= "From: mario.olmos@precisionwall.com\n"; 		
		$headers .= "Reply-To: mario.olmos@precisionwall.com\n";
		$Cc=$Cc.","."molmos@precisionwall.com";
		$headers .= "Bcc: ".$Cc."\n";  		
		$headers .= "X-Priority: 3\n"; 
		// alta importancia 		$headers .= "X-Priority: 1\n"; 
		$headers .= "X-Mailer: DT Formmail".'VERSION'."\n";       
		$headers .= "Content-Type: text/html;\n\tcharset=\"iso-8859-1\"\n";      
		
		$destinatario = $ToShedule.",".$To; 
		$asunto = $Subject; 
		    				  
		mail($destinatario, $asunto, $cuerpo, $headers);
		echo "Sent Email,() ";
//		echo "<h2>sent Email</h2>";		
	//echo $cuerpo;
	}
	
	function encabezado($f1,$f2)
	{	
		$f1t=FormatDateTime($f1, 8);
		$f2t=FormatDateTime($f2, 8);
		$titt="Schedule for ".$f1t;
		if ($f1<>$f2)
		{ 
			$titt="Schedule from ".$f1t." to ".$f2t;
		}
		//echo $titt;
		//echo "<p><h3>Schedule for </h3> <b>from:".$f1." to:".$f2."</b></p>";
		return "<p><h3>  </h3> <b>".$titt."</b></p>";		
	}
	function encabezado2()
	{
		return "<b>Employees Off-: </b> ";
	}

	function encabezado3()
	{
		return "<b>Jobs Coming Up:</b>";
	}			

	function per_sin_act($f1,$f2,$pbd)
	//DESCRIPCION:PERSONAL SIN ACTIVIDAD
	{
		$cadena="";
		
		if($f1==$f2)
		{	
			$cadena=$cadena.encabezado2();
			//echo "<p> $f1, $f2 ";	
			$sql = "SELECT p.* FROM personal p WHERE  p.Emp_ID=6 AND (p.Aux5 ='F' OR p.Aux5 is NULL) AND (p.Empleado_ID NOT IN (SELECT p1.Empleado_ID FROM personal p1 
			INNER JOIN actividad_personal ap ON ap.Empleado_ID=p1.Empleado_ID 
			INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID 
			WHERE a.Fecha='".$f1."')) ORDER BY p.Cargo,p.Nick_Name ";
			//echo $sql;

			$result2=$pbd->ejecutar($sql);
			if(mysqli_num_rows($result2)>0) 
			{
				$bandera=1;
				$bandera_2=1;	
				$conta=1;
				while($row=mysqli_fetch_array($result2))
				{					
					//********************************************************************
					$nickt=$conta.":".$row['Nick_Name'];
					$auxt=$row['Aux1'];
					$conta++;
					if ($auxt==NULL)
					{
						$nickt=$nickt." ";
					}
					else
					{ 
						$nickt=$nickt." ".$row['Aux1'];
					}
					
					if ($auxt==NULL)
					{
						$cadena=$cadena.$nickt.", ";
					}
					else
					{ 
						$cadena=$cadena."<p>".$nickt."</p>";
					}						
				}
			}
		}
		return $cadena;
	}
	//************************************************************************************************

	function pro_ult_sem($pbd)
	//*********************************************
	//DESCRIPCION: pro_ult_sem PRO_ YECTOS QUE SE VAN HA EJECUTAR LAS DOS ULT_ IMAS SEM_ ANA
	//********************************************
	{	
		$cadena="";
		encabezado3();
		$fecha1= date('Y-m-d');
		$fecha2= date('Y-m-d', strtotime('+365 day'));
		$vfrom_date=$_POST["vfrom_date"];
		$vdia=substr($vfrom_date,3,2);
		$vmes=substr($vfrom_date,0,2);
		$vano=substr($vfrom_date,8,2);
		$af1="20".$vano."-".$vmes."-" .$vdia;
		$sql="select * from proyectos  where Fecha_Inicio>'$af1' ORDER BY Fecha_Inicio asc";
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
				$vdia=substr($fecini,8,2);
				$vmes=substr($fecini,5,2);
				$vano=substr($fecini,0,4);
				$fecini=$vmes."-" .$vdia."-".$vano;
				$Fechat=FormatDateTime($row2['Fecha_Inicio'],8);
				$cadena=$cadena."<p>"." Start Date:".$Fechat." //".$row2['Nombre']." / ".$Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code."  Job#:".$row2['Codigo']."</p>";
			}
		}
		return $cadena;
	}

//************************************************************************************************
// para saltar envio email 
$evita=0;
if ($evita==0)
{
			$cadena="";
			$vdia=substr($vfrom_date,3,2);
			$vmes=substr($vfrom_date,0,2);
			$vano=substr($vfrom_date,8,2);
			$af1="20".$vano."-".$vmes."-" .$vdia;
			$vdia=substr($vto_date,3,2);
			$vmes=substr($vto_date,0,2);
			$vano=substr($vto_date,8,2);
			$af2="20".$vano."-".$vmes."-" .$vdia;
			$To="";
			$Cc="";
			$sql = "select	proyectos.codigo, proyectos.Emp_ID, proyectos.nombre,proyectos.calle,proyectos.ciudad,proyectos.estado,proyectos.zip_code,
			proyectos.coordinador_obra_id,proyectos.Foreman_ID,proyectos.Lead_ID,proyectos.Coordinador_ID,proyectos.Estatus_ID,actividades.Aux1,actividades.Aux2,
			actividades.Aux3,actividades.Aux4,	actividades.Fecha,actividades.hora,actividades.descripcion,actividades.actividad_id,	
			tipo_actividad.actividad_nombre,empresas.Codigo from tipo_actividad inner join 
			(actividades inner join proyectos on actividades.pro_id=proyectos.pro_id) on tipo_actividad.tipo_actividad_id=actividades.tipo_actividad_id inner join empresas on proyectos.Emp_ID=empresas.Emp_ID
			where actividades.fecha between '$af1' and '$af2' order by fecha,nombre,hora";		

			$result=$bd->ejecutar($sql);
		  	// titulo del reporte
			$cadena=$cadena.encabezado($af1,$af2);	

			if(mysqli_num_rows($result)>0) 
			{	
				$bandera=1;	
				$bandera_2=1;
				while($row=mysqli_fetch_array($result))
				{	
					///*****************************************************
					//*BUSQUEDA DE PERSONAL DEL PROYECTO
					$sql="select personal.nombre,personal.Nick_Name, personal.email  from personal inner join 
					(actividad_personal inner join actividades on actividad_personal.actividad_id=actividades.actividad_id)
					on personal.empleado_id=actividad_personal.empleado_id where actividades.actividad_id=".$row["actividad_id"].  " ORDER BY personal.Cargo,personal.Nick_Name";
					//echo $sql;
					//exit;
					$result2=$bd->ejecutar($sql);
					$vempleados="";	
					$vempleados_email_foreman="";
					$vempleados_email_super="";	

					if(mysqli_num_rows($result2)>0)
					{
						$vempleados="";
						$vempleados_emails="";
						while($row2=mysqli_fetch_array($result2))
						{	
							if($vempleados=="")
							{
								$vempleados=$row2["Nick_Name"];
								$vempleados_emails=$row2["email"];
								//$vempleados_emails="cristian.frias.s@gmail.com";
							}
							else
							{
								$vempleados=$vempleados.",".$row2["Nick_Name"];
								$vempleados_emails=$vempleados_emails.",".$row2["email"];
								//$vempleados_emails=$vempleados_emails.",cristian.frias.s@gmail.com";
							}
						}
					}					

					$sql2="select * from personal where Empleado_ID=".$row['coordinador_obra_id'];
					$result3=$bd->ejecutar($sql2);	
					if(mysqli_num_rows($result3)>0) 
					{
					  $row3=mysqli_fetch_array($result3);
					  $vcontacto=$row3['Nombre']." ".$row3['Apellido_Paterno']." ".$row3['Apellido_Materno']." ".$row3['Celular'];
					}		

					$sql2="select * from personal where Empleado_ID=".$row['Foreman_ID'];
					//echo $sql2."<br>";
					$result3=$bd->ejecutar($sql2);	
					if(mysqli_num_rows($result3)>0) 
					{
					  $row3=mysqli_fetch_array($result3);
					  $pwtforeman=$row3['Nick_Name'].'  '.$row3['Celular'];
					  $vempleados_email_foreman=$row3["email"];
					 // echo $vempleados_email_foreman."fore <br>";
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
					//echo $sql2."<br>";
					$result3=$bd->ejecutar($sql2);	
					$pwtsuper=" ";

					if(mysqli_num_rows($result3)>0) 	
					{
					  $row3=mysqli_fetch_array($result3);
					  $pwtsuper=$row3['Nick_Name'];
					  $vempleados_email_super=$row3["email"];
					}
					//********************************************************************
					// DETALLE
					//********************************************************************

					$vfrom_date=$_POST["vfrom_date"];	
					$vto_date=$_POST["vto_date"];	
					$Fechat=" ";	
					$Aux22=" ";	
					$Estatus="";	
					if ($vfrom_date<>$vto_date)	
					{	
						$Fechat=FormatDateTime($row['Fecha'],8)."/";		
						$Aux22="-/".$row['Aux1']."/".$row['Aux2']."/".$row['Aux3']."/".$row['Aux4']."/";		
						$Estatus=$row['Estatus_ID']." (3=in proces 2=P.list 5=done 4=closed)/";		
					}
					
					$To=$vempleados_emails;
					if ($vempleados_email_foreman!="")
						$To=$To.",".$vempleados_email_foreman;
					//echo $To." to  <br>";
					 
					
					//$Cc=$vempleados_email_foreman;
					//.",".$vempleados_email_super;
					if ($row['actividad_nombre']<>'Meeting')
					{
						$Cont_Temp=$Note."<br>".encabezado($af1,$af2).$Estatus.$Fechat." (".$row['Codigo'].") ".$row['codigo']." ".$row['nombre']." Add:".$row['calle'].",".$row['ciudad'].",".$row['estado'].",".$row['zip_code']." Contac:".$vcontacto."/PWT-Super:".$pwtsuper.",PWT-Foreman:".$pwtforeman." / ".( date("g:i a", strtotime($row['hora'])) )."  /".$vempleados." / ".$row['actividad_nombre']." ".$row['descripcion'].$Aux22;//."%%%".$vempleados_emails."<br><br><br>";
						
						$cadena=$cadena.$Note."<br>".encabezado($af1,$af2).$Estatus.$Fechat." (".$row['Codigo'].") ".$row['codigo']." ".$row['nombre']." Add:".$row['calle'].",".$row['ciudad'].",".$row['estado'].",".$row['zip_code']." Contac:".$vcontacto."/PWT-Super:".$pwtsuper.",PWT-Foreman:".$pwtforeman." / ".( date("g:i a", strtotime($row['hora'])) )."  /".$vempleados." / ".$row['actividad_nombre']." ".$row['descripcion'].$Aux22;//"%%%".$vempleados_emails."<br>".$Cc."<br><br>";
												
						$Subjectaux=$Subject;	
						$Subject=$Subject." - ".$row['nombre'];
						//echo " Llego ANTES del ELSE: ".$cadena."<br>";
						$numjob=substr($row['codigo'],0,3);
						//echo $row['codigo']."//".$row['nombre']." /=";
						//echo $numjob."rrrr  <br>";
						if ($numjob<999)
							enviar_email($Cont_Temp,$Subject,$To,$Cc);
						$Subject=$Subjectaux;						
						
					}
					else
					{
						$Cont_Temp=$Note."<br>".encabezado($af1,$af2)."*".$Fechat." (".$row['Codigo'].") ".$row['codigo']." ".$row['nombre']." Add:".$row['calle'].",".$row['ciudad'].",".$row['estado'].",".$row['zip_code']." Contac:".$vcontacto." ;/PWT:".$pwtsuper.",".$pwtforeman." ;/ ".( date("g:i a", strtotime($row['hora'])) )."  /".$vempleados." / ".$row['actividad_nombre']." ".$row['descripcion'].$Aux22."<br><br><br>";
						
						$cadena=$cadena.$Note."<br>".encabezado($af1,$af2)."*".$Fechat." (".$row['Codigo'].") ".$row['codigo']." ".$row['nombre']." Add:".$row['calle'].",".$row['ciudad'].",".$row['estado'].",".$row['zip_code']." Contac:".$vcontacto." ;/PWT:".$pwtsuper.",".$pwtforeman." ;/ ".( date("g:i a", strtotime($row['hora'])) )."  /".$vempleados." /* ".$row['actividad_nombre']." ".$row['descripcion'].$Aux22;//."%%%".$vempleados_emails."<br>".$Cc."<br><br>";
						$Subjectaux=$Subject;	
						$Subject=$Subject." - ".$row['nombre'];
						//echo " Llego despues del Else ".$cadena."<br>";
						$numjob=substr($row['Codigo'],0,3);
						//echo $numjob."tttttt<br>";
						if ($numjob<999)
								enviar_email($Cont_Temp,$Subject,$To,$Cc);
						$Subject=$Subjectaux;	
					}
				}	
			}			
			$cadena=$cadena."<p>";	
			$cadena=$cadena.per_sin_act($af1,$af2,$bd);
			$cadena=$cadena."<p>";	
			$cadena=$cadena.pro_ult_sem($bd);
			//echo $cadena;

// find evita send emails 
}

	
	//echo " llego a Proyectos_Repoprte_Actividad_email_bulk_send";
	if ($costcode=="Y")
		include ('Proyectos_Reporte_CostCode_email_send.php');
	if ($timesheet=="Y")
		if  ($vfrom_date==$vto_date)
				include ('Proyectos_Reporte_TimeSheet_email_send.php');
		else
			echo "To send the timesheets the dates needs to be the same->From:".$vfrom_date." To date:".$vto_date."<br>";



	
	require('Library/Close_Conexion.php');	
?>
	<!--<img src="images/spacer.gif" onload="$('#btn_send_email').attr('disabled','disabled');" />-->
	
        
   