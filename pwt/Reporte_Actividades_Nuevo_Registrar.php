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

	

	$Fecha_Actividad=ConvertDateToMysqlFormat($Fecha_Actividad);	

	

	$strSQL = "INSERT INTO actividades (Pro_ID, Fecha, Tipo_Actividad_ID, Descripcion, Hora, Aux1, Aux2, Aux3, Color) ";	

	$strSQL = $strSQL . " values (".$Pro_ID.", '" . $Fecha_Actividad . "','" . $Tipo_Actividad_ID . "','" . $Descripcion. "', '" . $Hora. "','" . $Aux1. "', '" . $Aux2. "', '" . $Aux3. "', '" . $color. "')";		

	//echo $strSQL."<br>";				

	$res1=$bd->ejecutar($strSQL);
	
	
	
	
		
	

		//$Area_ID=1;

		//$value="-/";

		//$strSQL = "INSERT INTO dayli_task (Pro_ID, Area_ID, Descp1, Fecha) ";	

		//$strSQL = $strSQL . " values (".$Pro_ID.",".$Area_ID.", '" .$value. "', '" . $Fecha_Actividad. "')";				

		//echo $strSQL."<br>";				

		//$res1=$bd->ejecutar($strSQL); 

	

	 		

	if ($res1)

	{
		
		///// 
			$consulta = "SELECT MAX(Actividad_ID) AS Actividad_ID FROM actividades";					
			$result22=$bd->ejecutar($consulta); 	
			while (($row2 = mysqli_fetch_array($result22) ))							
			{	
				$New_Actividad_ID =  $row2["Actividad_ID"];
			}
			mysqli_free_result($result22);
			$consulta= "INSERT INTO
    report_daily_detalle(actividad_id,fecha,detalle,question,empleado_id,estado)
VALUES (".$New_Actividad_ID.",'2021-01-01','','',0,'pending')";
			$result22=$bd->ejecutar($consulta); 	
			$consulta="";
			
	///////
		echo "Saved"; 	

		echo "<img src='images/spacer.gif' onload='reporte_cronograma_actividades_lista();' />"; 

	}

	else

		echo "ERROR";



	

	require('Library/Close_Conexion.php');	

?>