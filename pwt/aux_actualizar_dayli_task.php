<?php	 		
	require('Library/Open_Conexion.php');	
	require('Library/funciones.php');	

	echo date('h:i:s:u')."***********<br>";	
	$consulta = "SELECT * FROM dayli_task_copy";
	$result=$bd->ejecutar($consulta); 	
	while (($row = mysqli_fetch_array($result) ))							
	{	
		$Task_ID = $row["Task_ID"];
		$Fecha = $row["Fecha"];		
		$sql = "UPDATE dayli_task SET Fecha='".$Fecha."' WHERE Task_ID=".$Task_ID;														
		echo $sql."<br>";
		$res1=$bd->ejecutar($sql);  
	}	
	mysqli_free_result($result);
	echo date('h:i:s:u')."***********<br>";	

	require('Library/Close_Conexion.php');	
?>