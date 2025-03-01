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
		
		$strSQL = "UPDATE etapas SET Nombre='".$Nombre."', Porcentaje_Esfuerzo='".$Porcentaje_Esfuerzo."', Fecha_Inicio='".$Fecha_Inicio_Etapa."', Fecha_Fin='".$Fecha_Fin_Etapa."', Empleados_Diarios='".$Empleados_Diarios."', Horas='".$Horas."', Dias_Habiles='".$total_dias_habiles."' WHERE Etapas_ID=".$Etapas_ID;	
		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);  		
		if ($res1)
		{		
			echo "Saved"; 	
			echo "<img src='images/spacer.gif' onload='Empresas_Proyectos_Etapas_Lista($Pro_ID);$(\"#span_bnt_save\").hide();
			$(\"#span_bnt_New\").show();' />"; 			
		}
		else
		{
			echo "ERROR";	
		?>
			<img src='images/icon_recargar.gif' onclick='Empresas_Proyectos_Etapas_Lista(<?php echo $Pro_ID; ?>);' />
		<?php
		}	
	}
	
	require('Library/Close_Conexion.php');	
?>