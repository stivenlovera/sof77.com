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
	
	$Fecha_Inicio_Proyecto=ConvertDateToMysqlFormat($Fecha_Inicio_Proyecto);
	$Fecha_Fin_Proyecto=ConvertDateToMysqlFormat($Fecha_Fin_Proyecto);
	
	$strSQL = "INSERT INTO proyectos (Emp_ID, Nombre, Tipo_ID, Estatus_ID, Estado, Ciudad, Zip_Code, Calle, Numero, Fecha_Inicio, Fecha_Fin, Horas, Precio, Project_Manager_ID, Coordinador_Obra_ID, Foreman_ID, Coordinador_ID, Manager_ID ) ";	
	$strSQL = $strSQL . " values (".$Emp_ID.",'" . $Nombre . "'," . $Tipo_ID. "," . $Estatus_ID. ",'" . $Estado. "','" . $Ciudad . "','" . $Zip_Code. "','" . $Calle. "','" . $Numero . "','" . $Fecha_Inicio_Proyecto. "', '". $Fecha_Fin_Proyecto. "', '".$Horas. "','" . $Precio . "', " . $Project_Manager_ID. ", " . $Coordinador_Obra_ID. ", " . $Foreman_ID. ", " . $Cordinador_ID. ", " . $Manager_ID. ")";		
  
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		if ($Numero_Etapas>0)
		{
			echo "Saved"; 	
			$consulta = "SELECT max(Pro_ID) as Pro_ID FROM proyectos"; 	 
			$result=$bd->ejecutar($consulta); 
			if (($row = mysqli_fetch_array($result) ))							
			{		
				$Pro_ID = $row["Pro_ID"];	
			}
			mysqli_free_result($result);	
			
			$consulta = "SELECT DATEDIFF('".$Fecha_Fin_Proyecto."', '".$Fecha_Inicio_Proyecto."') as dias";			 
			//echo $consulta;
			$result=$bd->ejecutar($consulta); 
			if (($row = mysqli_fetch_array($result) ))							
			{			
				$total_dias = $row["dias"]+1;				
			}
			mysqli_free_result($result);				

			$Dias_por_Etapa=round($total_dias/$Numero_Etapas);
			$Horas_Etapa= round($Horas/$Numero_Etapas);
			$Porcentaje_Esfuerzo=round(100/$Numero_Etapas);			
			
			//echo "$total_dias *** $Dias_por_Etapa  ***  $Horas_Etapa  **  $Porcentaje_Esfuerzo  ** $Horas_Dia  ***   $Empleados_Diarios ";
			$i=1;
			$Fecha_Inicio_Etapa=$Fecha_Inicio_Proyecto;
			while ($i<=$Numero_Etapas)
			{
				if ($i<$Numero_Etapas)
				{					
					$consulta = "SELECT DATE_ADD('".$Fecha_Inicio_Etapa."', INTERVAL ".($Dias_por_Etapa-1)." DAY) AS Fecha_Fin_Etapa, DATE_ADD('".$Fecha_Inicio_Etapa."', INTERVAL ".($Dias_por_Etapa)." DAY) AS Fecha_Inicio_Nueva_Etapa  ";				 
					//echo $consulta."<bR>";
					$result=$bd->ejecutar($consulta); 
					if (($row = mysqli_fetch_array($result) ))							
					{							
						$Fecha_Fin_Etapa = $row["Fecha_Fin_Etapa"];		
						$Fecha_Inicio_Nueva_Etapa = $row["Fecha_Inicio_Nueva_Etapa"];			
					}
					mysqli_free_result($result);					
				}
				else  // La ultima Etapa
				{
					$Fecha_Fin_Etapa = $Fecha_Fin_Proyecto; 
					$Porcentaje_Esfuerzo=100-($Porcentaje_Esfuerzo*($Numero_Etapas-1));
					$Horas_Etapa=$Horas-($Horas_Etapa*($Numero_Etapas-1));						
				}	
				
				$total_dias_habiles = Dias_Habiles($Fecha_Inicio_Etapa,$Fecha_Fin_Etapa, $bd);							
				//echo "<bR>$Fecha_Inicio_Etapa***$Fecha_Fin_Etapa***$total_dias_habiles";
				$Horas_Dia = round($Horas_Etapa/$total_dias_habiles);					
				$Empleados_Diarios = round($Horas_Dia/8);
					
				$strSQL = "INSERT INTO etapas (Pro_ID, Nombre, Porcentaje_Esfuerzo, Fecha_Inicio, Fecha_Fin, Empleados_Diarios, Horas, Dias_Habiles) ";	
				$strSQL = $strSQL . " values (".$Pro_ID.",'Etapa " . $i . "',".$Porcentaje_Esfuerzo.",'" . $Fecha_Inicio_Etapa. "','" . $Fecha_Fin_Etapa. "','" . $Empleados_Diarios. "','" . $Horas_Etapa. "'," . $total_dias_habiles . ")";		
				//echo $strSQL."<br>";				
				$res1=$bd->ejecutar($strSQL); 
				
				$consulta = "SELECT max(Etapas_ID) as Etapas_ID FROM etapas"; 	 
				$result=$bd->ejecutar($consulta); 
				if (($row = mysqli_fetch_array($result) ))							
				{		
					$Etapas_ID = $row["Etapas_ID"];	
				}
				mysqli_free_result($result);	
								
//*************************				
				$consulta = "SELECT DATEDIFF('".$Fecha_Fin_Etapa."', '".$Fecha_Inicio_Etapa."') as dias";	
				//echo $consulta."<br>";		 
				$result3=$bd->ejecutar($consulta); 
		
				if (($row3 = mysqli_fetch_array($result3) ))							
				{			
					$Dias_por_Etapa = $row3["dias"]+1;
					$Horas_Dia = ($Horas_Etapa/$total_dias_habiles);					
					$empleados_dia=($Horas_Dia/8);					
					
					$diasTrans=0; // dias transcurridos  
					  
					while($diasTrans<$Dias_por_Etapa)  
					{   
						$consulta = "SELECT DATE_ADD('".$Fecha_Inicio_Etapa."', INTERVAL ".($diasTrans)." DAY) AS Fecha_Nuevo_Dia";				 
						//echo $consulta."<bR>";
						$result4=$bd->ejecutar($consulta); 
						if (($row4 = mysqli_fetch_array($result4) ))							
						{			
							$Fecha_Nuevo_Dia = $row4["Fecha_Nuevo_Dia"];							
							
							if ( Es_Dia_Habil($Fecha_Nuevo_Dia, $bd) )
							{
								$strSQL = "INSERT INTO etapa_dia_trabajo (Etapas_ID, Fecha, Numero_Epleados, Horas_Dia, Es_Habil) ";	
								$strSQL = $strSQL . " values (".$Etapas_ID.",'" . $Fecha_Nuevo_Dia . "',".$empleados_dia.",'".$Horas_Dia."', 1)";		
								//echo $strSQL."<br>";				
								$res1=$bd->ejecutar($strSQL); 
							}
							else
							{
								$strSQL = "INSERT INTO etapa_dia_trabajo (Etapas_ID, Fecha, Numero_Epleados, Horas_Dia, Es_Habil) ";	
								$strSQL = $strSQL . " values (".$Etapas_ID.",'" . $Fecha_Nuevo_Dia . "',0,0, 0)";		
								//echo $strSQL."<br>";				
								$res1=$bd->ejecutar($strSQL); 
							}
						}
						mysqli_free_result($result4);		
						
						$diasTrans++;  
					}  
				}
				mysqli_free_result($result3);
				
				$consulta = "SELECT * FROM etapa_dia_trabajo WHERE Etapas_ID=". $Etapas_ID . " ORDER BY Fecha "; 	
				//echo  $consulta;
				$result33=$bd->ejecutar($consulta); 
				$arrastre=0;			
				$ii=1;
				while (($row33 = mysqli_fetch_array($result33) ))							
				{		
					$Etapa_Dia_ID = $row33["Etapa_Dia_ID"];
					$Es_Habil = $row33["Es_Habil"];
					if  ($Es_Habil)
					{
						$Numero_Epleados = $row33["Numero_Epleados"]+ $arrastre;										 
						$arrastre = ( $Numero_Epleados - floor($Numero_Epleados) ) ;	
						
						//echo $Numero_Epleados."***".$arrastre."***".($Numero_Epleados % 1)."<br>";				
						
						if ($ii<$total_dias_habiles)
							$Numero_Epleados = floor($Numero_Epleados);					
						else
							$Numero_Epleados = ceil($Numero_Epleados);					
			
						$strSQL = "UPDATE etapa_dia_trabajo SET Numero_Epleados='" . $Numero_Epleados . "', Horas_Dia='" . ($Numero_Epleados*8) ."'";	
						$strSQL = $strSQL . " WHERE Etapa_Dia_ID=".$Etapa_Dia_ID;		
						//echo $strSQL."<br>";				
						$res1=$bd->ejecutar($strSQL); 	
						$ii++;
					}
				}
				mysqli_free_result($result33);			
//************************************************				
				
				$Fecha_Inicio_Etapa =$Fecha_Inicio_Nueva_Etapa; 				
				$i++;
			}					
			echo "<img src='images/spacer.gif' onload='Empresas_Proyectos_Etapas($Pro_ID);' />"; 
		}
	}
	else
	{
		echo "ERROR";
	}
	
	require('Library/Close_Conexion.php');	
?>