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

	

	$strSQL = "UPDATE actividades SET Tipo_Actividad_ID=" . $Tipo_Actividad_ID . ", Fecha='" . $Fecha_Actividad ."', Descripcion='" . $Descripcion . "',Hora='" . $Hora. "',Aux1='" . $Aux1. "', Aux2='" . $Aux2. "', Aux3='" . $Aux3. "', Aux4='" . $Aux4. "', Color='" . $color. "' ";	

	$strSQL = $strSQL . " WHERE Actividad_ID=" . $Actividad_ID ;		

	//echo $strSQL."<br>";				

	$res1=$bd->ejecutar($strSQL);
	  		
$strSQL = "UPDATE registro_diario SET Fecha='" . $Fecha_Actividad ."' ";	

	$strSQL = $strSQL . " WHERE Actividad_ID=" . $Actividad_ID ;
	//echo $strSQL."<br>";				

	$res1=$bd->ejecutar($strSQL);


	if ($res1)

	{		

		echo "Saved"; 	

		echo "<img src='images/spacer.gif' onload='reporte_cronograma_actividades_lista();' />"; 

	}

	else

		echo "ERROR";	

	

	require('Library/Close_Conexion.php');	

?>