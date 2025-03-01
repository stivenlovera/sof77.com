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
				         					  
	$Task_Master_ID=$_GET['Task_Master_ID'];	
	
	/*$consulta = "SELECT * FROM task_master WHERE Task_Master_ID=".$Task_Master_ID;	
	$result2=$bd->ejecutar($consulta); 	
	if (($row2 = mysqli_fetch_array($result2) ))							
	{
		echo "Not is possible delete. Task has other  information";	
	}
	else
	{*/
		$strSQL = "DELETE FROM task_master WHERE Task_Master_ID=".$Task_Master_ID;	
				
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);  		
		if ($res1)
		{
			echo "Deleted"; 	
			echo "<img src='images/spacer.gif' onload='Task_Master_Lista();' />"; 
		}
		else
			echo "ERROR";
	/*}
	mysqli_free_result($result2);	*/
	
	require('Library/Close_Conexion.php');	
?>