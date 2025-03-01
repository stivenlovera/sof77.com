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
	$Porcentaje=$PerCom;
	$strSQL = "UPDATE dayli_report_task SET Horas='".$Horas."', Nota_Horas='".$Nota_Horas."', Porcentaje='".$Porcentaje."', Nota_Porcentaje='".$Nota_Porcentaje."', Numero='".$Numero."', Nota_Numero='".$Nota_Numero."', Aux1='".$Aux1."', Aux1_Nota='".$Aux1_Nota."', Aux2='".$Aux2."', Aux2_Nota='".$Aux2_Nota."', Aux3='".$Aux3."', Aux3_Nota='".$Aux3_Nota."', MatUse='".$MatUse."' WHERE Dayli_ID=".$Dayli_ID;	
	
			
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		if ($PerCom>0)
			{
			$strSQL = "UPDATE task SET  PorcentajeRec='".$PerCom."' WHERE Task_ID=".$Task_ID;	
			
	echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);
			}
		
		echo "Saved"; 	
		echo "<img src='images/spacer.gif' onload='Dayli_Report_Piso_Area_Task_Expandir(".$Task_ID.",".$Actividad_ID.");' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>