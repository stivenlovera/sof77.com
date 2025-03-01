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



	



	$Proyecto=ConvertDateToMysqlFormat($_GET['Proyecto']);



	$Pro_ID=ConvertDateToMysqlFormat($_GET['Pro_ID']);



	$From_Date=ConvertDateToMysqlFormat($_GET['From_Date']);



	$To_Date=ConvertDateToMysqlFormat($_GET['To_Date']);	



////

	//$consulta = "UPDATE actividad_personal, actividades SET actividad_personal.Note='8' WHERE actividad_personal.Actividad_ID=actividades.Actividad_ID AND ((actividades.Fecha>='".$From_Date."' AND actividades.Fecha<='".$To_Date."')"; 

	

//	AND actividad_personal.HContract=0 AND actividad_personal.HTM=0)";

	

	$consulta = "UPDATE actividad_personal INNER JOIN actividades ON actividad_personal.Actividad_ID=actividades.Actividad_ID SET actividad_personal.HContract=8, actividad_personal.Note='G.H.S.UP' WHERE  (actividades.Fecha>='".$From_Date."' AND actividades.Fecha<='".$To_Date."') AND (actividad_personal.HContract=0 OR actividad_personal.HContract IS Null OR actividad_personal.HContract=' ' ) AND (actividad_personal.HTM=0 OR actividad_personal.HTM IS Null OR actividad_personal.HTM=' ' ) AND (actividad_personal.Note IS Null OR actividad_personal.Note=' ') AND actividades.Tipo_Actividad_ID<3"; 

		

	

		



	//echo $consulta."<br>";

	echo "Done: set up 8 hours From :  ".$From_Date."   to :".$To_Date."  at all activities";

	  	 	  	  

	$result2=$bd->ejecutar($consulta); 	



		require('Library/Close_Conexion.php');	



?>