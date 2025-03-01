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
				         					  
	
	$Actividad_ID=$_POST['Actividad_ID'];


	$strSQL = "delete t1,t2 from registro_diario_actividad t1 inner JOIN registro_diario t2 WHERE t1.Reg_ID=t2.Reg_ID and t2.Actividad_Id=". $Actividad_ID;			
//	echo $strSQL."<br>";
	$res1=$bd->ejecutar($strSQL);  		

	
	$strSQL = "DELETE FROM actividad_personal WHERE Actividad_ID=". $Actividad_ID;			
//	echo $strSQL."<br>";
	$res1=$bd->ejecutar($strSQL);  		


	$strSQL = "DELETE FROM actividades WHERE Actividad_ID=". $Actividad_ID;			
//	echo $strSQL."<br>";
	$res1=$bd->ejecutar($strSQL);  		
	if ($res1)
	{
		///
	$strSQL = "DELETE FROM report_daily_detalle WHERE actividad_id=" . $Actividad_ID ;		
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL); 
		
		echo "Record DELETED"; 	
		echo "<img src='images/spacer.gif' onload='reporte_cronograma_actividades_lista();' />"; 
	}
	else
		echo "ERROR";

	
	require('Library/Close_Conexion.php');	
?>