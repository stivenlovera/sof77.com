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
		         					  
	foreach($_POST as $nombre_campo => $valor)
	{
	   	
	   	if  ( !empty($valor )  )
			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";			
		else
			$asignacion = "\$" . $nombre_campo . "='';";			
			
	   	eval($asignacion);
	} 	
	$Fecha_Inicio_Etapa=ConvertDateToMysqlFormat($Fecha_Inicio_Etapa);
	$Fecha_Fin_Etapa=ConvertDateToMysqlFormat($Fecha_Fin_Etapa);
	$Note=$Note." SDate ".$Fecha_Inicio_Etapa." End ".$Fecha_Fin_Etapa;
	$Note=$Note." T.Hrs.:".$Horas;
	//echo $Note."  Nota";

if ($Nombre=="Add" || $Nombre=="No SDate" || $Nombre=="No EDate") 		
/// add ini
{
	$consulta = "SELECT * FROM etapas WHERE Pro_ID=".$Pro_ID." AND ( (Fecha_Inicio BETWEEN '".$Fecha_Inicio_Etapa."' AND '".$Fecha_Fin_Etapa."') OR (Fecha_Fin BETWEEN  '".$Fecha_Inicio_Etapa."' AND '".$Fecha_Fin_Etapa."') ) AND Etapas_ID!=".$Etapas_ID; 
	//echo $consulta."<br>";
	$contador=0;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	if (($row2 = mysqli_fetch_array($result2) ))							
	{		
		echo "ERROR Fechas incluidas en otras etapas ";
	?>
		<img src='images/icon_recargar.gif' onclick='Empresas_Proyectos_Etapas_Lista(<?php echo $Pro_ID; ?>);' />
	<?php
	}
	else
	{	
		$Horas_Etapa=$Horas;	
		$total_dias_habiles = Dias_Habiles($Fecha_Inicio_Etapa,$Fecha_Fin_Etapa, $bd);							
		//echo "<bR>$Fecha_Inicio_Etapa***$Fecha_Fin_Etapa***$total_dias_habiles";
		$Horas_Dia = round($Horas_Etapa/$total_dias_habiles);					
		$Empleados_Diarios = round($Horas_Dia/8);
		$strSQL = "INSERT INTO etapas (Pro_ID, Nombre, Porcentaje_Esfuerzo, Fecha_Inicio, Fecha_Fin, Empleados_Diarios, Horas, Dias_Habiles, Note) ";	
		$strSQL = $strSQL . " values (".$Pro_ID.",'" . $Nombre . "','" . $Porcentaje_Esfuerzo. "','" . $Fecha_Inicio_Etapa. "','" . $Fecha_Fin_Etapa. "','" . $Empleados_Diarios. "','" . $Horas . "'," . $total_dias_habiles .",'".$Note. "')";		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);  		
		if ($res1)
		{		
			echo "Saved"; 	
			echo "<img src='images/spacer.gif' onload='Empresas_Proyectos_Etapas_Lista($Pro_ID);' />"; 
		}
		else
		{
			echo "ERROR";	
		?>
			<img src='images/icon_recargar.gif' onclick='Empresas_Proyectos_Etapas_Lista(<?php echo $Pro_ID; ?>);' />
		<?php
		}

	}

}
////////////// add end
else
{

	$consulta = "DELETE FROM etapas WHERE Pro_ID=".$Pro_ID; 
	//echo $consulta."<br>";
	$contador=0;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	if (($row2 = mysqli_fetch_array($result2) ))							
	{		
		echo " NO RECORDS DELETED ";
	}
	else
	{	
		
		//Stages:1st. 20 % days= 10% hours / 2nd. 60% days=80% hours / 3rd.20% days=10% hours
		$datediff = strtotime($Fecha_Fin_Etapa)- strtotime($Fecha_Inicio_Etapa);
//$diff = strtotime($date2) - strtotime($date1); 
		$totdias=round($datediff / (60 * 60 * 24));
		
		
   // echo date('Y-m-d', strtotime($date. ' + 5 days'));
		
			
		$f1x=$Fecha_Inicio_Etapa;
		$dias20p=round($totdias*.2);
		$f2x=date('Y-m-d', strtotime($f1x. ' + '.$dias20p.' days'));
		$horasf1=round($Horas*0.1);
		
		
		$dias60p=round($totdias*.6);
		$f3x=date('Y-m-d', strtotime($f2x. ' + 1 days'));
		$horasf3=round($Horas*0.8);
		$f4x=date('Y-m-d', strtotime($f3x. ' + '.$dias60p.' days'));
		
		
		
		$f5x=date('Y-m-d', strtotime($f4x. ' + 1 days'));
		$horasf5=round($Horas*0.1);
		$f6x=$Fecha_Fin_Etapa;
		
/////////// record 		
		$Nombre="1st.stage:(".$totdias." Total Days in the job)";
		//.$dias20p."  20pdias ".$f2x." F2 / ";
		//$f2x=$Fecha_Inicio_Etapa+(($totdias*.2)*60*60*24);
		//$f3x=$f2x;
		
		$Horas_Etapa=$horasf1;
		$Fecha_Inicio_Etapa=$f1x;
		$Fecha_Fin_Etapa=$f2x;
		

		//$Horas_Etapa=$Horas;	
		$total_dias_habiles = Dias_Habiles($Fecha_Inicio_Etapa,$Fecha_Fin_Etapa, $bd);							
		//echo "<bR>$Fecha_Inicio_Etapa***$Fecha_Fin_Etapa***$total_dias_habiles";
		$Horas_Dia = round($Horas_Etapa/$total_dias_habiles);					
		$Empleados_Diarios = round($Horas_Dia/8);
		
		$strSQL = "INSERT INTO etapas (Pro_ID, Nombre, Porcentaje_Esfuerzo, Fecha_Inicio, Fecha_Fin, Empleados_Diarios, Horas, Dias_Habiles, Note) ";	
		$strSQL = $strSQL . " values (".$Pro_ID.",'" . $Nombre . "','" . $Porcentaje_Esfuerzo. "','" . $Fecha_Inicio_Etapa. "','" . $Fecha_Fin_Etapa. "','" . $Empleados_Diarios. "','" . $Horas_Etapa . "'," . $total_dias_habiles .",'".$Note. "')";		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL); 
		
		if ($res1)
		{		
			echo "Saved"; 	
			 
		}
		else
		{
			echo "ERROR";	
		}
		
///end record		

/////////// record 		
		$Nombre="2nd.stage:(".$totdias." Total Days in the job)";
		//.$dias60p."  60pdias ".$f4x." F4 / ";
		//$f2x=$Fecha_Inicio_Etapa+(($totdias*.2)*60*60*24);
		//$f3x=$f2x;
		
		$Horas_Etapa=$horasf3;
		$Fecha_Inicio_Etapa=$f3x;
		$Fecha_Fin_Etapa=$f4x;
		

		//$Horas_Etapa=$Horas;	
		$total_dias_habiles = Dias_Habiles($Fecha_Inicio_Etapa,$Fecha_Fin_Etapa, $bd);							
		//echo "<bR>$Fecha_Inicio_Etapa***$Fecha_Fin_Etapa***$total_dias_habiles";
		$Horas_Dia = round($Horas_Etapa/$total_dias_habiles);					
		$Empleados_Diarios = round($Horas_Dia/8);
		
		$strSQL = "INSERT INTO etapas (Pro_ID, Nombre, Porcentaje_Esfuerzo, Fecha_Inicio, Fecha_Fin, Empleados_Diarios, Horas, Dias_Habiles, Note) ";	
		$strSQL = $strSQL . " values (".$Pro_ID.",'" . $Nombre . "','" . $Porcentaje_Esfuerzo. "','" . $Fecha_Inicio_Etapa. "','" . $Fecha_Fin_Etapa. "','" . $Empleados_Diarios. "','" . $Horas_Etapa . "'," . $total_dias_habiles .",'".$Note. "')";		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL); 
		
		if ($res1)
		{		
			echo "Saved"; 	
			 
		}
		else
		{
			echo "ERROR";	
		}
		
///end record		

/////////// record 		
		$Nombre="3rd.stage:(".$totdias." Total Days in the job)";
		//.$dias20p."  20pdias ".$f6x." F6 / ";
		//$f2x=$Fecha_Inicio_Etapa+(($totdias*.2)*60*60*24);
		//$f3x=$f2x;
		
		$Horas_Etapa=$horasf5;
		$Fecha_Inicio_Etapa=$f5x;
		$Fecha_Fin_Etapa=$f6x;
		

		//$Horas_Etapa=$Horas;	
		$total_dias_habiles = Dias_Habiles($Fecha_Inicio_Etapa,$Fecha_Fin_Etapa, $bd);							
		//echo "<bR>$Fecha_Inicio_Etapa***$Fecha_Fin_Etapa***$total_dias_habiles";
		$Horas_Dia = round($Horas_Etapa/$total_dias_habiles);					
		$Empleados_Diarios = round($Horas_Dia/8);
		
		$strSQL = "INSERT INTO etapas (Pro_ID, Nombre, Porcentaje_Esfuerzo, Fecha_Inicio, Fecha_Fin, Empleados_Diarios, Horas, Dias_Habiles,Note) ";	
		$strSQL = $strSQL . " values (".$Pro_ID.",'" . $Nombre . "','" . $Porcentaje_Esfuerzo. "','" . $Fecha_Inicio_Etapa. "','" . $Fecha_Fin_Etapa. "','" . $Empleados_Diarios. "','" . $Horas_Etapa . "'," . $total_dias_habiles .",'".$Note. "')";		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL); 
		
		if ($res1)
		{		
			echo "Saved"; 	
			 
		}
		else
		{
			echo "ERROR";	
		}
		
///end record		
}
		
		if ($res1)
		{		
			echo "Saved"; 	
			echo "<img src='images/spacer.gif' onload='Empresas_Proyectos_Etapas_Lista($Pro_ID);' />"; 
		}
		else
		{
			echo "ERROR";	
		?>
			<img src='images/icon_recargar.gif' onclick='Empresas_Proyectos_Etapas_Lista(<?php echo $Pro_ID; ?>);' />
		<?php
		}
	}
	mysqli_free_result($result2);	
	
	require('Library/Close_Conexion.php');	
?>