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

	$consulta = "SELECT co.* FROM conduce co WHERE co.Agent_ID=".$_SESSION["EntityID"]." AND co.Fecha_Baja IS NULL AND Conduce_Movil NOT IN (31,32,33,35,37,42,42,44,48,49,58,59,62,65,68,69,71,77,78,82,83,85,89,87,89,92,93,95,98,100,109,111,112,116,120,126,143,145,149,152,155,171,173,174,175,182,193,195,198,200) 					
					ORDER BY  Conduce_Movil";
	//echo $strSQL;
	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{
		$movil=$row2["Conduce_Movil"];
		$Conduce_ID=$row2["Conduce_ID"];
		$Cond_ID=$row2["Cond_ID"];	
		
		//$sql = "insert into deuda (Fecha_Registro,Tipo_Deuda_ID,Monto,Acuenta,Fecha_Deuda,Deuda_Cond_ID) values (NOW(),1,0,0,'2017-03-20 00:00:00',".$Cond_ID.")";
		$sql = "insert into deuda (Fecha_Registro,Tipo_Deuda_ID,Monto,Acuenta,Fecha_Deuda,Deuda_Cond_ID) values (NOW(),1,0,0,'2017-04-02 00:00:00',".$Cond_ID.")";
		echo $movil."--".$sql."<br>";
		//$res1=$bd->ejecutar($sql);			
	}		
	mysqli_free_result($result2);	
		
	require('Library/Close_Conexion.php');	
?>