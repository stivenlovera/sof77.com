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
	
	$consulta = "SELECT a.*, Actividad_Nombre FROM actividades a INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID WHERE Actividad_ID=".$Actividad_ID;		
	//echo $consulta."<br>";
	$contador=0;	 	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	
	if (($row2 = mysqli_fetch_array($result2) ))							
	{			
		$Tipo_Actividad_ID = $row2["Tipo_Actividad_ID"];
		$Actividad_Nombre = $row2["Actividad_Nombre"];
		$Descripcion  = $row2["Descripcion"];	
		$Hora = $row2["Hora"];
		$Aux1 = $row2["Aux1"];	
		$Aux2 = $row2["Aux2"];
		$Aux3 = $row2["Aux3"];
		
		$Fecha_Schedule=ConvertDateToMysqlFormat($Fecha_Schedule);	
		
		$strSQL = "INSERT INTO actividades (Pro_ID, Fecha, Tipo_Actividad_ID, Descripcion, Hora, Aux1, Aux2, Aux3) ";	
		$strSQL = $strSQL . " values (".$Pro_ID.", '" . $Fecha_Schedule . "','" . $Tipo_Actividad_ID . "','" . $Descripcion. "', '" . $Hora. "','" . $Aux1. "', '" . $Aux2. "', '" . $Aux3. "')";		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL); 
		if ($res1)
		{			
			$consulta = "SELECT MAX(Actividad_ID) AS Actividad_ID FROM actividades";					
			$result22=$bd->ejecutar($consulta); 	
			while (($row2 = mysqli_fetch_array($result22) ))							
			{	
				$New_Actividad_ID =  $row2["Actividad_ID"];
			}
			mysqli_free_result($result22);
			
			///// 
			$consulta= "INSERT INTO
    report_daily_detalle(actividad_id,fecha,detalle,question,empleado_id,estado)
VALUES (".$New_Actividad_ID.",'2021-01-01','','',0,'pending')";
			$result22=$bd->ejecutar($consulta); 	
			$consulta="";
			
			///////
			
			$consulta = "SELECT * FROM actividad_personal WHERE Actividad_ID=".$Actividad_ID;
			//echo $strSQL."<br>";					
			$result22=$bd->ejecutar($consulta); 	
			while (($row2 = mysqli_fetch_array($result22) ))							
			{	
				$Empleado_ID = $row2["Empleado_ID"];
					
				$strSQL = "INSERT INTO actividad_personal (Empleado_ID, Actividad_ID) ";	
				$strSQL = $strSQL . " values (" . $Empleado_ID . ", " . $New_Actividad_ID . ")";
				//echo $strSQL."<br>";
				$res1=$bd->ejecutar($strSQL); 
				
				////// insert into registro_diario and registro diario actividad
					$Actividad_ID=$New_Actividad_ID;
					$Fecha=$Fecha_Schedule;
					$strSQL = "INSERT INTO registro_diario (Empleado_ID, Actividad_ID,Pro_ID,Fecha) ";	
					$strSQL = $strSQL . " values (" . $Empleado_ID . ", " . $Actividad_ID . ",".$Pro_ID.",'".$Fecha. "')";		
				//echo $strSQL."<br>";				
				$res1=$bd->ejecutar($strSQL);  	
				
				
					$consulta = "SELECT Reg_ID FROM registro_diario WHERE Actividad_ID=".$Actividad_ID." AND	Empleado_ID=".$Empleado_ID." AND Pro_ID=".$Pro_ID." AND	Fecha ='".$Fecha."'";			
					$result2=$bd->ejecutar($consulta); 	
					while (($row2 = mysqli_fetch_array($result2) ))							
					{	
						$Reg_ID = $row2["Reg_ID"];	
					}
					mysqli_free_result($result2);
				
				
					$strSQL = "INSERT INTO registro_diario_actividad (Reg_ID) ";	
					$strSQL = $strSQL . " values (" . $Reg_ID.")";		
					$res1=$bd->ejecutar($strSQL);  			
					mysqli_free_result($res1);					
		///end ////// insert into registro_diario and registro diario actividad
				 			
			}
			mysqli_free_result($result22);
			
			echo "Re Shdeluning Proccess"; 	
			echo "<img src='images/spacer.gif' onload='reporte_cronograma_actividades_lista();' />";

		}
		else
			echo "ERROR";
	}
	else
	{
		echo "ERROR";
	}
	
	//include ('Update_info.php');
	
	
	mysqli_free_result($result2);
	//include ('Update_info.php');
	require('Library/Close_Conexion.php');	
	
?>
