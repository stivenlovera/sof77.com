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
	
	$mes = $_GET["nuevo_mes"];
	$ano = $_GET["nuevo_ano"];
	$workers=0;
	
	function redondeado ($numero, $decimales) 
	{
   		$factor = pow(10, $decimales);
   		return (round($numero*$factor)/$factor); 
	} 
	
	//tomo el nombre del mes que hay que imprimir
	$nombre_mes = dame_nombre_mes($mes);
	$ultimo_dia = ultimoDia($mes,$ano);
	$ultimo_diames=$ultimo_dia;
	//echo "ultimo:$ultimo_dia<bR>";
	//construyo la tabla general
	echo '<table class="tablacalendario" cellspacing="0" cellpadding="2" border="1" id="tabletwo">';
	echo '<thead>';
	echo '<tr><th></th><th colspan="'.$ultimo_dia.'" class="tit">';
	//tabla para mostrar el mes el año y los controles para pasar al mes anterior y siguiente
	echo '<table width="100%" cellspacing="2" cellpadding="2" border="0"><thead><tr><th class="messiguiente">';
	//calculo el mes y ano del mes anterior
	$mes_anterior = $mes - 1;
	$ano_anterior = $ano;
	if ($mes_anterior==0)
	{
		$ano_anterior--;
		$mes_anterior=12;
	}
	echo '<a href="#" onclick="reporte_cronograma_trabajo_lista_2('.$mes_anterior.','.$ano_anterior.');"><span>&lt;&lt;</span></a></th>';
	   echo '<th class="titmesano" >' . $nombre_mes . " " . $ano . '</th>';
	   echo '<th class="mesanterior">';
	//calculo el mes y ano del mes siguiente
	$mes_siguiente = $mes + 1;
	$ano_siguiente = $ano;
	if ($mes_siguiente==13)
	{
		$ano_siguiente++;
		$mes_siguiente=1;
	}
	echo '<a href="#" onclick="reporte_cronograma_trabajo_lista_2('.$mes_siguiente.','.$ano_siguiente.');"><span>&gt;&gt;</span></a></th>';
	//finalizo la tabla de cabecera
	echo '</tr></thead></table>';
	echo '</th></tr>';
	//fila con todos los días de la semana
	echo '	<tr><th></th>';	
	
	//Variable para llevar la cuenta del dia actual
	$dia_actual = 1;
	
	//calculo el numero del dia de la semana del primer dia
	$numero_dia = calcula_numero_dia_semana(1,$mes,$ano);
	//echo "Numero del dia de demana del primer: $numero_dia <br>";	
	//calculo el último dia del mes	
	
	$i=0;
	$j=$numero_dia;
	while ($i<$ultimo_dia)
	{
		$numero_dia = calcula_numero_dia_semana($i,$mes,$ano);
		switch ($j) 
		{
			case 0:
				echo "<th width='14%' class='diasemana'><span>M</span></th>";
				break;
			case 1:
				echo "<th width='14%' class='diasemana'><span>T</span></th>";
				break;
			case 2:
				echo "<th width='14%' class='diasemana'><span>W</span></th>";
				break;
			case 3:
				echo "<th width='14%' class='diasemana'><span>T</span></th>";
				break;
			case 4:
				echo "<th width='14%' class='diasemana'><span>F</span></th>";
				break;
			case 5:
				echo "<th width='14%' class='diasemana'><span>S</span></th>";
				break;
			case 6:
				echo "<th width='14%' class='diasemana'><span>S</span></th>";
				break;
		}
		$i++;
		$j++;
		if ($j==7)
			$j=0;			
	}
	echo "</tr>";
	
	//************************ RECORREMOS todos los demás días hasta el final del mes
	echo '<tr><th></th>';		
	$numero_dia = 0;
	while ($dia_actual <= $ultimo_dia)
	{
		//si estamos a principio de la semana escribo el <TR>
		if ($numero_dia == 0)
		{
			//***********echo "<tr>";
		}
		
		$dia_actual_aux=$dia_actual;		
		if ($dia_actual<10)
			$dia_actual_aux='0'.$dia_actual;
		
		$mes_aux=$mes;	
		if ($mes<10)
			$mes_aux='0'.$mes;		
			
		echo '<th class="diavalido"><span><a href="#" onclick="Actividad_del_Dia(\'20'.$ano.'-'.$mes_aux.'-'.$dia_actual_aux.'\');">' . $dia_actual . '</a></span></th>';
		
		$total_dia[$dia_actual-1]=0;
		$totalactdia[$dia_actual-1]=0;
		$dia_actual++;
		$numero_dia++;		
		//si es el uñtimo de la semana, me pongo al principio de la semana y escribo el </tr>
		if ($numero_dia == 7)
		{
			$numero_dia = 0;
			//****echo "</tr>";
		}
	}	
	echo "</tr>";
	echo '</thead>';	
	echo '<tbody>';	
	//**************  Relleno 
	
	
	$consulta = "SELECT p.Pro_ID,p.Nombre, e.Etapas_ID, e. Nombre as Nombre_Etapa,  e.Fecha_Inicio AS Fecha_Inicio_Etapa, e.Fecha_Fin AS Fecha_Fin_Etapa,e.Note as Note, 
					DATEDIFF(p.Fecha_Fin, p.Fecha_Inicio)+1 AS Dias_Proyecto,
					e.Horas AS Horas_Etapa,
					DATEDIFF(e.Fecha_Fin, e.Fecha_Inicio)+1 AS Dias_Etapa		
					FROM proyectos p LEFT JOIN etapas e ON p.Pro_ID=e.Pro_ID
					WHERE 
							(								
								('".$ano."-".$mes."-01 00:00:00' BETWEEN  e.Fecha_Inicio AND e.Fecha_Fin) OR
								('".$ano."-".$mes."-31 23:59:59' BETWEEN e.Fecha_Inicio AND e.Fecha_Fin) OR        
								(e.Fecha_Inicio BETWEEN '".$ano."-".$mes."-01 00:00:00' AND '".$ano."-".$mes."-31 23:59:59')
							)
							AND
							(
								e.Fecha_Inicio<e.Fecha_Fin
							) OR (EXISTS (SELECT a.Pro_ID,a.Fecha from actividades a where a.Pro_ID=p.Pro_ID and a.Fecha BETWEEN '".$ano."-".$mes."-01 00:00:00' AND '".$ano."-".$mes."-31 23:59:59') ) AND ( Estatus_ID<5)
							
					ORDER BY p.Nombre,  e.Fecha_Inicio, e.Orden "; 
					
								 			
	$contador=1;
	$total_movil=0;	
	$dias_mes=1;
	echo $consulta."<br>";
	//echo "<tr>";
	$result=$bd->ejecutar($consulta); 	
	$Pro_ID_ant=-15; 	
	$etapa=1;
	$dia_del_mes=1;	
	$empresas=0;	
	$contajob=1;
	$ban_noetapa=0;
	while (($row = mysqli_fetch_array($result) ))							
	{		
		$Nombre = $row["Nombre"];
		$Pro_ID = $row["Pro_ID"];
		$Pro_IDact=$Pro_ID;
		$Nombreact=$Nombre;
		$Etapas_ID = $row["Etapas_ID"];
		$Nombre_Etapa = $row["Nombre_Etapa"];
		$Horas_Etapa = $row["Horas_Etapa"];			
		$Dias_Etapa = ceil($row["Dias_Etapa"]);	
		$Fecha_Inicio_Etapa = $row["Fecha_Inicio_Etapa"];
		$Fecha_Fin_Etapa = $row["Fecha_Fin_Etapa"];
		$Note=$row["Note"];
		$Dias_Habiles_Etapa=Dias_Habiles($Fecha_Inicio_Etapa, $Fecha_Fin_Etapa, $bd);
		$ban_noetapa=0;
		
		//==========================
		if ($Fecha_Inicio_Etapa=='')
		{
				$ban_noetapa=1;
				$dia_del_mes=1;
				$Nombre=$contajob.".- ".$Nombre;
				$contajob++;			
				echo "<tr><td>$Nombre</td>";
				
		while ($dia_del_mes<=$ultimo_diames) 
				{
			
					$dia_actual_aux=$dia_del_mes;		
					if ($dia_actual<10)
						$dia_actual_aux='0'.$dia_del_mes;
									
					$Fecha_Nuevo_Dia= $ano."-".$mes."-".$dia_del_mes;	
					
					$Estilo="";	
										
					//if ($Fecha_Inicio_Etapa=='')
					if (1<3)
						{
							////////071419
							
						
							$workers=0;		
						
						
							$sql = "SELECT COUNT(*) AS Workers FROM actividad_personal ap JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID WHERE a.Fecha='".$Fecha_Nuevo_Dia."' AND a.Pro_ID=".$Pro_ID;
							//echo $sql." actividades:".$Nombre."<br>";
							$result59=$bd->ejecutar($sql);
				   			 while($row59=mysqli_fetch_array($result59)) 		 
							{
								$workers=$row59["Workers"];
							}
							if ($workers>0)
							 {
								$Empleadosx="NoSch/Act.".$workers;
								$Estilo="style='background-color:#CC9933'";
								$totalactdia[$dia_del_mes-1]=$totalactdia[$dia_del_mes-1]+$workers;
								if ($dia_del_mes==1)
								echo $Pro_ID." ant:".$Pro_ID_ant." ".$workers." no sch"." ".$totalactdia[$dia_del_mes-1]."  ".$Nombreact."<br>";
								$workers=0;
								
							 }
							 else
							 	$Empleadosx="=-=";
							echo "<td align='center' $Estilo ><a href='#' onclick='Actividad_Nueva(\"$Fecha_Nuevo_Dia\", $Pro_ID);'>$Empleadosx</a></td>";	
							////071419
							mysqli_free_result($result59);
						}
					 else 
					 {			
					
						echo "<td align='center' $Estilo ><a href='#' onclick='Actividad_Nueva(\"$Fecha_Nuevo_Dia\", $Pro_ID);'>-(=)-</a></td>";		
					 }
					$dia_del_mes++;
				}	
				echo "</tr>";
		}
		
		
		//========================
		
		
		//echo $Pro_ID." 1: ".$Nombre."<br>";
			
		if ($ban_noetapa==0)
		{
		
		if ($Note<>"")
			$Nombre=$Nombre."(".$Note.")";
		//echo $Dias_Habiles_Etapa."**".$Fecha_Inicio_Etapa."**".$Fecha_Fin_Etapa."<br>";	
		
		if ($Pro_ID!=$Pro_ID_ant)
		{
			
			if ($empresas>0)	
			{		
				
				while ($dia_del_mes<=$ultimo_dia) 
				{
			
					$dia_actual_aux=$dia_del_mes;		
					if ($dia_actual<10)
						$dia_actual_aux='0'.$dia_del_mes;
									
					$Fecha_Nuevo_Dia= $ano."-".$mes."-".$dia_del_mes;	
					
					$Estilo="";	
										
					//[[[[[[[[[[[[[[[[[[[
							$workers=0;		
						
						
							$sql = "SELECT COUNT(*) AS Workers FROM actividad_personal ap JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID WHERE a.Fecha='".$Fecha_Nuevo_Dia."' AND a.Pro_ID=".$Pro_ID_ant;
							//echo $sql." actividades:".$Nombre."<br>";
							$result59=$bd->ejecutar($sql);
				   			 while($row59=mysqli_fetch_array($result59)) 		 
							{
								$workers=$row59["Workers"];
							}
							if ($workers>0)
							 {
								$Empleadosx="NoSch/Act.".$workers;
								$Estilo="style='background-color:#CC9933'";
								$totalactdia[$dia_del_mes-1]=$totalactdia[$dia_del_mes-1]+$workers;
								//if ($dia_del_mes==1)
								//echo $Pro_ID." ant:".$Pro_ID_ant." ".$workers." no sch"." ".$totalactdia[$dia_del_mes-1]."  ".$Nombre."<br>";
								$workers=0;
								
							 }
							 else
							 	$Empleadosx="-()-";
							echo "<td align='center' $Estilo ><a href='#' onclick='Actividad_Nueva(\"$Fecha_Nuevo_Dia\", $Pro_ID_ant);'>$Empleadosx</a></td>";	
							////071419
							mysqli_free_result($result59);
					
					//]]]]]]]]]]]]]]]]]]]]]]
	
					 
					$dia_del_mes++;
				}	
				echo "</tr>";
			}
			$Nombre=$contajob.".- ".$Nombre;
			$contajob++;			
			echo "<tr><td>$Nombre</td>";
			$dia_del_mes=1;	
			//$i=0;
			$empresas++;	
			$etapa=1;			
		}			
		
				
		if ($etapa==1)	
		{
						
				
			//$Fecha_Inicio_Etapa = $row["Fecha_Inicio"];
			$consulta = "SELECT '".$Fecha_Inicio_Etapa."' Fecha_Inicio, ";
			$consulta = $consulta . " DATE_ADD('".$Fecha_Inicio_Etapa."', INTERVAL 1 DAY) < DATE_FORMAT('".$ano."-".$mes."-01','%Y-%m-%d') as inicio_antes, ";
			$consulta = $consulta . " DATEDIFF('".$Fecha_Inicio_Etapa."', DATE_FORMAT('".$ano."-".$mes."-01','%Y-%m-%d')) as dias_despues, ";							
			$consulta = $consulta . " DATEDIFF(DATE_FORMAT('".$ano."-".$mes."-".$ultimo_dia."','%Y-%m-%d'), DATE_ADD('".$Fecha_Inicio_Etapa."', INTERVAL 1 DAY)) as dias_antes ";
			$consulta = $consulta . " FROM etapas WHERE Etapas_ID=".$Etapas_ID;				
			//echo $consulta;
		}
		else
					
		{	
		
				
					
			$consulta = "SELECT '".$Fecha_Inicio_Etapa."' Fecha_Inicio, 
							DATE_ADD('".$Fecha_Inicio_Etapa."', INTERVAL 1 DAY) < DATE_FORMAT('".$ano."-".$mes."-01','%Y-%m-%d') as inicio_antes,
							(DATEDIFF('".$Fecha_Inicio_Etapa."', '".$Fecha_fin_etapa_ante."' )-1) as dias_despues,							
							DATEDIFF(DATE_FORMAT('".$ano."-".$mes."-".$ultimo_dia."','%Y-%m-%d'), DATE_ADD('".$Fecha_Inicio_Etapa."', INTERVAL 1 DAY)) as dias_antes 		
							FROM etapas WHERE Etapas_ID=".$Etapas_ID;				
							
	
		}	
		
		//echo $consulta."<br>";
			$dias_despues= 1;
			$dias_antes= 50;
			
		
			
			
		$result33=$bd->ejecutar($consulta); 	
		if ($result33)
		{
		while (($row33 = mysqli_fetch_array($result33) ))							
		{
			$Fecha_Inicio_Etapa = $row33["Fecha_Inicio"];
			//$Fecha_fin_etapa = $row33["Fecha_Fin_Etapa"];
			$dias_despues= $row33["dias_despues"];
			$dias_antes= $row33["dias_antes"];
		}	
		mysqli_free_result($result33);
		}
					
		$dias_total= $Dias_Etapa;
		//$Horas_Dia = $Horas_Etapa/$Dias_Etapa;
		$Horas_Dia = $Horas_Etapa/$Dias_Habiles_Etapa;		
		$Empleados_Diarios = redondeado ( ($Horas_Dia/8),2);
		
	
		$Numero_Epleados= $Empleados_Diarios;			
		
		$mes_aux=$mes;	
		if ($mes<10)
			$mes_aux='0'.$mes;	
		
		/*if ($etapa==1)	
		{*/
			$i=0;				
			//echo "$dias_despues *** $dia_del_mes<bR>";
			while (($i<$dias_despues) && ($dia_del_mes<=$ultimo_dia) )
			{
				$dia_actual_aux=$dia_del_mes;		
				if ($dia_actual<10)
					$dia_actual_aux='0'.$dia_del_mes;
								
				$Fecha_Nuevo_Dia= $ano."-".$mes."-".$dia_del_mes;	
				$Estilo="";
				
				/*$sql = "SELECT * FROM actividades WHERE Fecha='".$Fecha_Nuevo_Dia."' AND Pro_ID=".$Pro_ID;														
				$result55=$bd->ejecutar($sql); 		 
				if ( $row55 = mysqli_fetch_array($result55) )							
				{								
					$Estilo="style='background-color:#66CCFF'";
					
		
				}
				else
				{
					$Estilo="";
				}
				mysqli_free_result($result55);	*/	
				
				//ppppppppppppppppppppp
				$workers=0;		
						
						
							$sql = "SELECT COUNT(*) AS Workers FROM actividad_personal ap JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID WHERE a.Fecha='".$Fecha_Nuevo_Dia."' AND a.Pro_ID=".$Pro_ID;
							//echo $sql." actividades:".$Nombre."<br>";
							$result59=$bd->ejecutar($sql);
				   			 while($row59=mysqli_fetch_array($result59)) 		 
							{
								$workers=$row59["Workers"];
							}
							if ($workers>0)
							 {
								$Empleadosx="NoSch/Act<.".$workers;
								$Estilo="style='background-color:#CC9933'";
								$totalactdia[$dia_del_mes-1]=$totalactdia[$dia_del_mes-1]+$workers;
								//if ($dia_del_mes==1)
								//echo $Pro_ID." ant:".$Pro_ID_ant." ".$workers." no sch"." ".$totalactdia[$dia_del_mes-1]."  ".$Nombre."<br>";
								$workers=0;
								
							 }
							 else
							 	$Empleadosx="-<-";
							echo "<td align='center' $Estilo ><a href='#' onclick='Actividad_Nueva(\"$Fecha_Nuevo_Dia\", $Pro_ID_ant);'>$Empleadosx</a></td>";	
							////071419
							mysqli_free_result($result59);
				
				
				///pppppppppppppppp
				
				
					
				//echo "<td align='center' $Estilo ><a href='#' onclick='Actividad_Nueva(\"$Fecha_Nuevo_Dia\", $Pro_ID);'>$Empleados</a></td>";					
			//	echo "<td align='center' $Estilo ><a href='#' onclick='Actividad_Nueva(\"$Fecha_Nuevo_Dia\", $Pro_ID);'>--</a></td>";	
				
				$i++;
				$dia_del_mes++;
			}	
								
		
		//echo "$dias_antes *** $dias_total *** $Horas_Etapa *** $Horas_Dia *** $Empleados_Diarios *** $ultimo_dia *** $dia_del_mes<br>";
		$i=0;
		$j=0;
		
		
		
		
		while (   ($j<$dias_total) && ($i<$ultimo_dia)  &&  ($dia_del_mes<=$ultimo_dia)   )
		{		
			$dia_actual_aux=$dia_del_mes;				
			if ($dia_del_mes<10)
				$dia_actual_aux='0'.$dia_del_mes;
							
			$Fecha_Nuevo_Dia= '20'.$ano."-".$mes_aux."-".$dia_actual_aux;	
			
			if ($dias_despues>=0)
			{
				
				$sql = "SELECT * FROM actividades WHERE Fecha='".$Fecha_Nuevo_Dia."' AND Pro_ID=".$Pro_ID;														
				$result55=$bd->ejecutar($sql); 		 
				if ( $row55 = mysqli_fetch_array($result55) )							
				{
					$Estilo="style='background-color:#66CCFF'";						
					$workers=0;		
					
					/////////mmmm
					$sql = "SELECT COUNT(*) AS Workers FROM actividad_personal ap JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID WHERE a.Fecha='".$Fecha_Nuevo_Dia."' AND a.Pro_ID=".$Pro_IDact;
					//echo $sql."<br>";
					$result55=$bd->ejecutar($sql);
				    while($row55=mysqli_fetch_array($result55)) 		 
					{
					$workers=$row55["Workers"];
					}
					////////mmmm 
				}
				else
				{
					$Estilo="";
				}
				mysqli_free_result($result55);
						
				if (Es_Dia_Habil($Fecha_Nuevo_Dia, $bd))
				{
					$Empleados=$Empleados_Diarios."/Act.".$workers;
					$totalactdia[$dia_del_mes-1]=$totalactdia[$dia_del_mes-1]+$workers;
					//if ($dia_del_mes==1)
					//echo $Pro_ID." ant:".$Pro_ID_ant." ".$workers." in ch"." ".$totalactdia[$dia_del_mes-1]."  ".$Nombre."<br>";
					$workers=0;
					$Estiloori=$Estilo;
					if ($Nombre_Etapa=="No SDate" || $Nombre_Etapa=="No EDate")
					{

	
						$Estilo="style='background-color:#f11e3a' ";
						if ($Nombre_Etapa=="No SDate")
								$Empleados="?SDate ".$Empleados;
						if ($Nombre_Etapa=="No EDate")
								$Empleados="?EDate ".$Empleados;
					}
					else
					{
						$Estilo=$Estiloori;
					
					}
					echo "<td align='center' $Estilo ><a href='#' onclick='Actividad_Nueva(\"$Fecha_Nuevo_Dia\", $Pro_ID);'>$Empleados</a></td>";	
					$Estilo=$Estiloori;
					
//					echo "<td align='center' $Estilo ><a href='#' onclick='Actividad_Nueva(\"$Fecha_Nuevo_Dia\", $Pro_ID);'>$Empleados_Diarios</a></td>";	
				
					
					
					
					
					//$j++;		
					$total_dia[$dia_del_mes-1]=$total_dia[$dia_del_mes-1]+$Numero_Epleados;	
					
					$workers=0;
				}
				else
				{
					if ($workers>0)
					{
						$Empleados="0/Act.".$workers;
						$totalactdia[$dia_del_mes-1]=$totalactdia[$dia_del_mes-1]+$workers;
						
						
						
					}
					  else
					  	$Empleados="---";
					echo "<td align='center' $Estilo ><a href='#' onclick='Actividad_Nueva(\"$Fecha_Nuevo_Dia\", $Pro_ID);'>$Empleados</a></td>";
						
	
				}				
			
				/*if ($Nombre=="test4")
				echo "$i $dia_del_mes $ultimo_dia<bR>";*/
				
				$j++;	
				$dia_del_mes++;				
				$i++;	
				$workers=0;
			}
			else
			{
				$j++;	
				$dias_despues++;
			}
										
		}	
		
		$Pro_ID_ant=$Pro_ID;	
		$Fecha_fin_etapa_ante = $Fecha_Nuevo_Dia;
		$etapa++;
		$workers=0;			
		}
	}		
	mysqli_free_result($result);	
	//**************  Relleno 
	//echo $dia_del_mes."***".$ultimo_dia;
	echo " Man Power Projection by Month";
	while ($dia_del_mes<=$ultimo_dia) 
	{
		$dia_actual_aux=$dia_del_mes;		
		if ($dia_actual<10)
			$dia_actual_aux='0'.$dia_del_mes;
						
		$Fecha_Nuevo_Dia= $ano."-".$mes."-".$dia_del_mes;	
		$Estilo="";
		/*$sql = "SELECT * FROM actividades WHERE Fecha='".$Fecha_Nuevo_Dia."' AND Pro_ID=".$Pro_ID;														
		//echo $sql."<bR>";
		$result55=$bd->ejecutar($sql); 		 
		if ( $row55 = mysqli_fetch_array($result55) )							
		{								
			$Estilo="style='background-color:#66CCFF'";
		}
		else
		{
			$Estilo="";
		}
		mysqli_free_result($result55);	*/		
		
		echo "<td align='center' $Estilo ><a href='#' onclick='Actividad_Nueva(\"$Fecha_Nuevo_Dia\", $Pro_ID);'>-**-</a></td>";			
		$dia_del_mes++;
	}	
	echo "</tr>";	
		
	echo '</tbody>';
	echo '<tfoot><td>Total Daily</td>';
	$i=0;
	while ( $i<$ultimo_dia )
	{
		$totalprint=$total_dia[$i]."/Act.".$totalactdia[$i];
		echo "<td align='center'><b>$totalprint</b></td>";	
		$i++;
	}
	echo '</tfoot>';		
	echo "</table>";
?>
	<img src="images/spacer.gif" onload="$('#tabletwo').columnHover({eachCell:true, hoverClass:'betterhover'});" >