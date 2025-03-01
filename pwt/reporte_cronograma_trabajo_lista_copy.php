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
	
	//tomo el nombre del mes que hay que imprimir
	$nombre_mes = dame_nombre_mes($mes);
	$ultimo_dia = ultimoDia($mes,$ano);
	
	//construyo la tabla general
	echo '<table class="tablacalendario" cellspacing="0" cellpadding="2" border="1" id="tabletwo">';
	echo '<thead>';
	echo '<tr><th></th><th colspan="'.$ultimo_dia.'" class="tit">';
	//tabla para mostrar el mes el año y los controles para pasar al mes anterior y siguiente
	echo '<table width="100%" cellspacing="2" cellpadding="2" border="0"><thead><tr><th class="messiguiente">';
	//calculo el mes y ano del mes anterior
	$mes_anterior = $mes - 1;
	$ano_anterior = $ano;
	if ($mes_anterior==0){
		$ano_anterior--;
		$mes_anterior=12;
	}
	echo '<a href="#" onclick="reporte_cronograma_trabajo_lista_2('.$mes_anterior.','.$ano_anterior.');"><span>&lt;&lt;</span></a></th>';
	   echo '<th class="titmesano" >' . $nombre_mes . " " . $ano . '</th>';
	   echo '<th class="mesanterior">';
	//calculo el mes y ano del mes siguiente
	$mes_siguiente = $mes + 1;
	$ano_siguiente = $ano;
	if ($mes_siguiente==13){
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
		switch ($j) {
			case 0:
				echo "<th width='14%' class='diasemana'><span>L</span></th>";
				break;
			case 1:
				echo "<th width='14%' class='diasemana'><span>M</span></th>";
				break;
			case 2:
				echo "<th width='14%' class='diasemana'><span>M</span></th>";
				break;
			case 3:
				echo "<th width='14%' class='diasemana'><span>J</span></th>";
				break;
			case 4:
				echo "<th width='14%' class='diasemana'><span>V</span></th>";
				break;
			case 5:
				echo "<th width='14%' class='diasemana'><span>S</span></th>";
				break;
			case 6:
				echo "<th width='14%' class='diasemana'><span>D</span></th>";
				break;
		}
		$i++;
		$j++;
		if ($j==7)
			$j=0;			
	}
	echo "</tr>";
	
	//recorro todos los demás días hasta el final del mes
	echo '<tr><th></th>';		
	$numero_dia = 0;
	while ($dia_actual <= $ultimo_dia){
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
		$dia_actual++;
		$numero_dia++;		
		//si es el uñtimo de la semana, me pongo al principio de la semana y escribo el </tr>
		if ($numero_dia == 7){
			$numero_dia = 0;
			//****echo "</tr>";
		}
	}	
	echo "</tr>";
	echo '</thead>';	
	echo '<tbody>';	
	//**************  Relleno 
	$consulta = "SELECT p.*, e. Nombre as Nombre_Etapa, e.Fecha_Inicio as fecha_inicio_etapa, e.Fecha_Fin as fecha_fin_etapa ,e.Empleados_Diarios,
					e.Fecha_Inicio<DATE_FORMAT('".$ano."-".$mes."-01','%Y-%m-%d') as inicio_antes,
					DATEDIFF(e.Fecha_Inicio, DATE_FORMAT('".$ano."-".$mes."-01','%Y-%m-%d')) as dias_despues,
					DATEDIFF(e.Fecha_Fin, e.Fecha_Inicio) as dias_total,
					DATEDIFF(DATE_FORMAT('".$ano."-".$mes."-".$ultimo_dia."','%Y-%m-%d'), e.Fecha_Fin) as dias_antes, 
					ed.Es_Habil, ed.Fecha, ed.Horas_Dia, ed.Numero_Epleados, ed.Etapa_Dia_ID
					FROM proyectos p INNER JOIN etapas e ON p.Pro_ID=e.Pro_ID
				    INNER JOIN etapa_dia_trabajo ed ON e.Etapas_ID=ed.Etapas_ID
					WHERE DATE_FORMAT(e.Fecha_Inicio,'%m-%Y')=DATE_FORMAT('".$ano."-".$mes."-01','%m-%Y')
							OR DATE_FORMAT(e.Fecha_Fin,'%m-%Y')=DATE_FORMAT('".$ano."-".$mes."-01','%m-%Y')				
					ORDER BY p.Nombre, ed.fecha"; 	 			
	$contador=1;
	$total_movil=0;	
	$dias_mes=1;
	//echo $consulta;
	//echo "<tr>";
	$result=$bd->ejecutar($consulta); 	
	$Pro_ID_ant=-15; 	
	$etapa=1;
	$dia_del_mes=1;	
	$empresas=0;	
	while (($row = mysqli_fetch_array($result) ))							
	{		
		$Nombre = $row["Nombre"];
		$Pro_ID = $row["Pro_ID"];
		$Nombre_Etapa = $row["Nombre_Etapa"];
		$Fecha_inicio_etapa = $row["fecha_inicio_etapa"];
		$Fecha_fin_etapa = $row["fecha_fin_etapa"];
		$Empleados_Diarios = $row["Empleados_Diarios"];
		$dias_despues= $row["dias_despues"];
		$dias_antes= $row["dias_antes"];
		$dias_total= $row["dias_total"];
		
		//$Etapa_Dia_ID= $row["Etapa_Dia_ID"];
		//$Es_Habil= $row["Es_Habil"];
		//$Fecha= $row["Fecha"];
		//$Horas_Dia= $row["Horas_Dia"];
		//$Numero_Epleados= ceil($row["Numero_Epleados"]);
		
		$Etapa_Dia_ID= 0;
		$Es_Habil= true;
		$Numero_Epleados= ceil($row["Numero_Epleados"]);
		
		
		if ($Pro_ID!=$Pro_ID_ant)
		{
			if ($empresas>0)	
			{
				while ($dia_del_mes<=$ultimo_dia) 
				{
					echo "<td>&nbsp;</td>";	
					$dia_del_mes++;
				}
				echo "</tr>";
			}
			
			echo "<tr><td>$Nombre</td>";
			$dia_del_mes=1;	
			$empresas++;				
		}			
		if ($etapa==1)	
		{
			$i=0;				
			while (($i<$dias_despues) && ($dia_del_mes<=$ultimo_dia) )
			{
				echo "<td></td>";	
				$i++;
				$dia_del_mes++;
			}	
		}		
		
		if ($Es_Habil)
		{
			$sql = "SELECT * FROM actividades WHERE Etapa_Dia_ID=".$Etapa_Dia_ID;														
			$result55=$bd->ejecutar($sql); 		 
			if ( $row55 = mysqli_fetch_array($result55) )							
			{								
				$Estilo="style='background-color:#66CCFF'";
			}
			else
			{
				$Estilo="";
			}
			mysqli_free_result($result55);
				
			echo "<td align='center' $Estilo ><a href='#' onclick='Actividad_Nueva($Etapa_Dia_ID);'>$Numero_Epleados</a></td>";	
			$total_dia[$dia_del_mes-1]=$total_dia[$dia_del_mes-1]+$Numero_Epleados;
		}
		else
		{
			echo "<td align='center'><a href='#' onclick='Actividad_Nueva($Etapa_Dia_ID);'>---</a></td>";	
		}
		$dia_del_mes++;			
		
		/*$i=0;
		while ( $dia_del_mes<=$ultimo_dia )
		{
			echo "<td>$Empleados_Diarios</td>";	
			$i++;
			$dia_del_mes++;
		}*/				
		//echo "<td>$Nombre_Etapa</td><td>$Fecha_inicio_etapa</td><td>$Fecha_fin_etapa</td><td>$dias_despues</td><td>$dias_antes</td>";	
		$Pro_ID_ant=$Pro_ID;	
		$etapa++;			
	}		
	mysqli_free_result($result);	
	//**************  Relleno
		
	$consulta = "SELECT p.Nombre as Job, p.Codigo, e.* FROM etapas e INNER JOIN proyecto p ON e.Pro_ID=p.Pro_ID WHERE Pro_ID=".$Pro_ID." ORDER BY Fecha_Inicio"; 	 
	$result=$bd->ejecutar($consulta); 
	while (($row = mysqli_fetch_array($result) ))							
	{		
		$Job = $row["Job"];	
		$Codigo = $row["Codigo"];	
		$Fecha_Inicio_Etapa = $row["Fecha_Inicio"];	
		$Fecha_Fin_Etapa = $row["Fecha_Fin"];	
		$Horas = $row["Horas"];	
		$Dias_Habiles = $row["Dias_Habiles	"];	
		echo "<tr><td>$Codigo-$Job</td>";			
		//*************************	INICIO RECORREMOS TODOS LOS DIAS DE UNA ETAPA			
		$consulta = "SELECT DATEDIFF('".$Fecha_Fin_Etapa."', '".$Fecha_Inicio_Etapa."') as dias";	
		//echo $consulta."<br>";		 
		$result3=$bd->ejecutar($consulta); 
	
		if (($row3 = mysqli_fetch_array($result3) ))							
		{			
			$Dias_por_Etapa = $row3["dias"]+1;		
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
						$Horas_Dia = $Horas/$Dias_Habiles;
						$empleados_dia= floor(($Horas_Dia/8));
						echo "<td>$empleados_dia</td>";					
						$Horas=$Horas-($empleados_dia*8);						
					}
					else
					{					
						echo "<td> - </td>";	
					}
				}
				mysqli_free_result($result4);			
				$diasTrans++;  
			}  
		}
		mysqli_free_result($result3);
		echo "</tr>";
		//*************************	FIN RECORREMOS TODOS LOS DIAS DE UNA ETAPA				
	}
	mysqli_free_result($result);	
		
	echo '</tbody>';
	echo '<tfoot><td>Total Daily</td>';
	$i=0;
	while ( $i<$ultimo_dia )
	{
		echo "<th align='center'>$total_dia[$i]</th>";	
		$i++;
	}
	echo '</tfoot>';		
	echo "</table>";
?>
	<img src="images/spacer.gif" onload="$('#tabletwo').columnHover({eachCell:true, hoverClass:'betterhover'});" >