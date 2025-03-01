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
	
	$Empleado_ID=$_SESSION["Empleado_ID"];		
	$vfrom_date=$_GET["vfrom_date"];
	$vto_date=$_GET["vto_date"];
	$Nick_Name=$_GET["Nick_Name"];	
	$Estilo="";
	
	$vdia=substr($vfrom_date,3,2);
	$vmes=substr($vfrom_date,0,2);
	$vano=substr($vfrom_date,8,2);
	$af1="20".$vano."-".$vmes."-".$vdia;	

	$vdia=substr($vto_date,3,2);
	$vmes=substr($vto_date,0,2);
	$vano=substr($vto_date,8,2);
	$af2="20".$vano."-".$vmes."-".$vdia;
		
	
?> 
<table border="1" cellpadding="0" cellspacing="0" id="mitabla" width="100%">
	<tr align="center">
		<td>Nro. Employe</td><td>Employe</td><td>Nro. Trabajo</td><td>Nombre Trabajo</td><td>Codigo Coste</td>
        <td>Fecha</td><td>Hour Contract</td><td>Hour TM</td><td>Hour In</td><td>Foto S/N</td><td>Hour Out</td>
	</tr>
	
	<?php
		$sql = "SELECT *, p.Nombre AS Nombre_Empleado, pr.Codigo, pr.Nombre AS Proyecto, ADDTIME(Hora_Ingreso, '-04:00:00.000') AS Hora_Ingreso, ADDTIME(Hora_Salida, '-04:00:00.000') AS Hora_Salida,  TIMEDIFF(Hora_Salida,Hora_Ingreso) AS Horas ";
		$sql = $sql . " FROM registro_diario rd INNER JOIN registro_diario_actividad rda ON rd.Reg_ID=rda.Reg_ID AND rd.Fecha BETWEEN '".$af1."' AND '".$af2."' ";
		$sql = $sql . " INNER JOIN task t ON rda.Task_ID=t.Task_ID ";
		$sql = $sql . " INNER JOIN area_control a ON t.Area_ID=a.Area_ID ";
		$sql = $sql . " INNER JOIN floor f ON f.Floor_ID=a.Floor_ID ";
		$sql = $sql . " INNER JOIN edificios e ON e.Edificio_ID=f.Edificio_ID ";
		$sql = $sql . " INNER JOIN personal p ON p.Empleado_ID=rd.Empleado_ID ";		
		if ($Nick_Name!="")	
			$sql = $sql . " AND p.Nick_Name like '%$Nick_Name%' ";	
		
		$sql = $sql . " INNER JOIN proyectos pr ON t.Pro_ID=pr.Pro_ID ";			
		$sql = $sql . " ORDER BY p.Apellido_Paterno, p.Apellido_Materno, p.Nombre ";			
		
		//echo $sql."<br>";													
		$result77=$bd->ejecutar($sql); 		
		$RDA_ID=-1;
		$Fila=1;
		$Empleado_ID = "";
		
		$Empleado_ID_Ant = -77;
		$Total_Horas_Contract=0;
		$Total_Horas_TM=0;
		
		while (($row77 = mysqli_fetch_array($result77) ))	
		{
			
			$Aux1=$row77["Aux1"];
			$Codigo=$row77["Codigo"];
			$Proyecto=$row77["Proyecto"];
			
			$Task_ID=$row77["Task_ID"];
			$Area_ID=$row77["Area_ID"];
			$Floor_ID=$row77["Floor_ID"];
			$Edificio_ID=$row77["Edificio_ID"];		
			$Fecha=$row77["Fecha"];		
			$Horas_Contract=$row77["Horas_Contract"];
			$Horas_TM=$row77["Horas_TM"];
			$Detalles=$row77["Detalles"];
			$RDA_ID=$row77["RDA_ID"];
			$Nombre_Empleado=$row77["Nombre_Empleado"];
			$Apellido_Paterno=$row77["Apellido_Paterno"];
			$Apellido_Materno=$row77["Apellido_Materno"];
			$Empleado_ID=$row77["Empleado_ID"];
			
			$Hora_Ingreso=$row77["Hora_Ingreso"];
			$Hora_Salida=$row77["Hora_Salida"];
			$Verificado_Foreman=$row77["Verificado_Foreman"];
			$Reg_ID=$row77["Reg_ID"];
			$Foto_Ingreso=$row77["Foto_Ingreso"];
			$Foto_Salida=$row77["Foto_Salida"];
			
			$Horas_aux=$row["Horas"];
			
			if ($Empleado_ID_Ant ==-77)
				$Empleado_ID_Ant = $Empleado_ID;
			
			
			$array = split(":", $Horas_aux);
			
			if ( $array[1]<31 )
				$Horas=$array[0]+0.5;
			else
				$Horas=$array[0]+1;	
			
			
			$Empleados_ID = $Empleados_ID . $Empleado_ID . ",";
						
			$_SESSION["RDA_ID"]=$RDA_ID;
			
			$estado_foreman="";
			if ( ($Verificado_Foreman=="1") || ($Verificado_Foreman==true))
			{
				//echo $Verificado_Foreman."<br>";
				$estado_foreman="checked='checked'";
			}		
			
			if (($Hora_Ingreso=="-04:00:00")	|| ($Hora_Ingreso=="00:00:00"))						
				$Hora_Ingreso="";
				
			if (($Hora_Salida=="-04:00:00")	|| ($Hora_Salida=="00:00:00"))								
				$Hora_Salida="";
			
			$Se_Saco_Foto="S";		
			if (is_null($Foto_Ingreso))								
				$Se_Saco_Foto="N";	
				
				
			if ($Empleado_ID_Ant!=	$Empleado_ID)
			{
				echo "<tr><td colspan=6 border=0>TOTAL</td><td>".$Total_Horas_Contract."</td><td>".$Total_Horas_TM."</td>";
				echo "</table><br>";
				
				$Total_Horas_Contract=0;
				$Total_Horas_TM=0;
				
				echo "<table border='1' cellpadding='0' cellspacing='0' id='mitabla' width='100%'>
					<tr align='center'>
						<td>Nro. Employe</td><td>Employe</td><td>Nro. Trabajo</td><td>Nombre Trabajo</td><td>Codigo Coste</td>
						<td>Fecha</td><td>Hour Contract</td><td>Hour TM</td><td>Hour In</td><td>Foto S/N</td><td>Hour Out</td>
					</tr>";
					
			}
	?>
	
			<tr>
				<td><?php echo $Aux1; ?></td>
				<td><?php echo $Nombre_Empleado. " ".$Apellido_Paterno. " ".$Apellido_Materno; ?></td>
                <td><?php echo $Codigo; ?></td>
                <td><?php echo $Proyecto; ?></td>				
				<td >							 
					<?php		
							$sql = "select Edificio_ID, Nombre FROM edificios WHERE Edificio_ID=".$Edificio_ID;														
							$result=$bd->ejecutar($sql); 		
							if (($row = mysqli_fetch_array($result) ))	
							{	
								$Edificio=$row["Nombre"];
							}
							mysqli_free_result($result);	
							
							$sql = "select Floor_ID, Nombre FROM floor WHERE Floor_ID=".$Floor_ID;														
							$result=$bd->ejecutar($sql); 		
							if (($row = mysqli_fetch_array($result) ))	
							{	
								$Piso=$row["Nombre"];								
							}
							mysqli_free_result($result);	
							
							$sql = "select Area_ID, Nombre FROM area_control WHERE Area_ID=".$Area_ID;														
							$result=$bd->ejecutar($sql); 		
							if (($row = mysqli_fetch_array($result) ))	
							{	
								$Area=$row["Nombre"];								
							}
							mysqli_free_result($result);
							
							$sql = "select Task_ID, Nombre FROM area_control WHERE Task_ID=".$Task_ID;														
							$result=$bd->ejecutar($sql); 		
							if (($row = mysqli_fetch_array($result) ))	
							{	
								$Tarea=$row["Nombre"];								
							}
							mysqli_free_result($result);
							
							echo $Edificio."-".$Piso."-".$Area."-".$Tarea;					
					?>									
                </td>
                <td><?php echo $Fecha; ?></td>	                    		
				<td ><?php echo $Horas_Contract; ?></td>		
				<td ><?php echo $Horas_TM; ?></td>				
                <td><?php echo $Hora_Ingreso; ?></td>
                <td align="center"><?php echo $Se_Saco_Foto; ?></td>
				<td><?php echo $Hora_Salida; ?></td>				
			</tr>
	<?php
			$Empleado_ID_Ant=	$Empleado_ID;
			$Total_Horas_Contract=$Total_Horas_Contract+$Horas_Contract;
			$Total_Horas_TM=$Total_Horas_TM+$Horas_TM;
			$Fila++;
			
		}
		mysqli_free_result($result77);		
	?>
</table>

<div id="Tabla_Lista_Actividades"></div>

<!--<img src="images/spacer.gif" onload="empleado_registro_actividad_lista(<?php echo $Reg_ID; ?>);" />	-->
 
<div id="Div_Actividad_Personal_Information"></div>
	
<?php
	

	require('Library/Close_Conexion.php');	

?>