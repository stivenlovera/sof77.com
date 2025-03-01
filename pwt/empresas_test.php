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
	
	$consulta = "SELECT *, DATEDIFF(Fecha_Fin, Fecha_Inicio) as dias FROM proyectos";			 
	$result=$bd->ejecutar($consulta); 
	if (($row = mysqli_fetch_array($result) ))							
	{			
		$Fecha_Inicio = $row["Fecha_Inicio"];
		$Fecha_Fin = $row["Fecha_Fin"];
		$total_dias = $row["dias"]+1;
		$diasHabiles = Dias_Habiles($Fecha_Inicio, $Fecha_Fin, $bd);
	}
	mysqli_free_result($result);			
   
    echo "<br /><br /><b>Fecha_Inicial:".$Fecha_Inicio."</b>";	
    echo "<br /><br /><b>Fecha_Fin:".$Fecha_Fin."</b>";	
    echo "<br /><br /><b>Total Dias:".$total_dias."</b>";			
	echo "<br /><br /><b>Dias Habiles:".$diasHabiles."</b>";			
	
	require('Library/Close_Conexion.php');	
?>